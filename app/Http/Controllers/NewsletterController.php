<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Events\NewsletterCreated; // Make sure this matches your event namespace

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::all();
        $deletedNewsletters = Newsletter::onlyTrashed()->get();
        
        return view('newsletters.index', compact('newsletters', 'deletedNewsletters'));
    }

    public function create()
    {
        return view('newsletters.create');
    }

    public function store(Request $request)
    {
        $newsletter = new Newsletter();
        $newsletter->title = $request->title;
        $newsletter->content = $request->content;
        $newsletter->save();
    
        // Dispatch event after storing
        broadcast(new NewsletterCreated($newsletter))->toOthers();
    
        return redirect()->route('newsletters.index')->with('success', 'Newsletter created successfully.');
    }

    public function edit(Newsletter $newsletter)
    {
        return view('newsletters.edit', compact('newsletter'));
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $newsletter->title = $request->title;
        $newsletter->content = $request->content;
        $newsletter->save();

        // Dispatch event after updating
        

        return redirect()->route('newsletters.index');
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->deleted_at = now();
        $newsletter->save();

        // Dispatch event after soft deleting
        

        return redirect()->route('newsletters.index');
    }

    public function recover($id)
{
    $newsletter = Newsletter::withTrashed()->find($id);
    $newsletter->restore();

    return redirect()->route('newsletters.index')->with('recovered', 'Newsletter recovered successfully.');
}
public function showAll()
{
    $newsletters = Newsletter::all();
    return view('newsletters.show', compact('newsletters'));
}
}
