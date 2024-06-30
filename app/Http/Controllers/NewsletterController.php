<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Events\NewsletterCreated;
use App\Events\NewsletterUpdated;
use App\Events\NewsletterDeleted;
use Illuminate\Support\Facades\Storage;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::orderBy('created_at', 'desc')->get();
        $deletedNewsletters = Newsletter::onlyTrashed()->get();
        
        return view('newsletters.index', compact('newsletters', 'deletedNewsletters'));
    }

    public function create()
    {
        return view('newsletters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $newsletter = new Newsletter();
        $newsletter->title = $request->title;
        $newsletter->content = $request->content;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/newsletters');
            $newsletter->image_url = Storage::url($path);
        }

        $newsletter->save();

        broadcast(new NewsletterCreated($newsletter))->toOthers();

        return redirect()->route('newsletters.index')->with('success', 'Newsletter created successfully.');
    }

    public function edit(Newsletter $newsletter)
    {
        return view('newsletters.edit', compact('newsletter'));
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $newsletter->title = $request->title;
        $newsletter->content = $request->content;

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($newsletter->image_url) {
                Storage::delete(str_replace('/storage/', 'public/', $newsletter->image_url));
            }

            $path = $request->file('image')->store('public/newsletters');
            $newsletter->image_url = Storage::url($path);
        }

        $newsletter->save();

        broadcast(new NewsletterUpdated($newsletter))->toOthers();

        return redirect()->route('newsletters.index')->with('success', 'Newsletter updated successfully.');
    }

    public function destroy(Newsletter $newsletter)
    {
        // Delete the image if it exists
        if ($newsletter->image_url) {
            Storage::delete(str_replace('/storage/', 'public/', $newsletter->image_url));
        }

        $newsletter->delete();

        broadcast(new NewsletterDeleted($newsletter))->toOthers();

        return redirect()->route('newsletters.index')->with('success', 'Newsletter deleted successfully.');
    }

    public function recover($id)
    {
        $newsletter = Newsletter::withTrashed()->find($id);
        $newsletter->restore();

        return redirect()->route('newsletters.index')->with('recovered', 'Newsletter recovered successfully.');
    }

    public function showAll()
    {
        $newsletters = Newsletter::orderBy('created_at', 'desc')->get();
        return view('newsletters.show', compact('newsletters'));
    }
}
