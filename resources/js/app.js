/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

document.addEventListener('DOMContentLoaded', function () {
    window.Echo.channel('newsletters')
        .listen('.NewsletterCreated', (data) => {
            console.log('Received data:', data);
            // Append new newsletter data to the list
            const newsletterList = document.getElementById('newsletter-list');
            const newItem = document.createElement('li');
            newItem.innerHTML = `<strong>${data.newsletter.title}</strong>: ${data.newsletter.content}`;
            newsletterList.appendChild(newItem);
        });
});
