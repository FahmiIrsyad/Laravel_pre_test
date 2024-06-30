require('./bootstrap');

// Ensure the DOM is fully loaded before attaching event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Attach listeners only if the specific element is present
    if (document.getElementById('newsletter-list')) {
        window.Echo.channel('newsletters')
            .listen('NewsletterCreated', (e) => {
                const newsletterList = document.getElementById('newsletter-list');
                const noNewslettersMessage = document.querySelector('#newsletter-list').previousElementSibling;

                // Remove the "No newsletters found" message if it exists
                if (noNewslettersMessage && noNewslettersMessage.tagName === 'LI' && noNewslettersMessage.textContent === 'No newsletters found.') {
                    noNewslettersMessage.remove();
                }

                // Check for existing entries to avoid duplicates
                const existingItems = Array.from(newsletterList.getElementsByTagName('li'));
                const isDuplicate = existingItems.some(item => item.querySelector('h5').textContent === e.newsletter.title);
                if (!isDuplicate) {
                    const li = document.createElement('li');
                    li.classList.add('newsletter-item');
                    li.innerHTML = `
                        <img src="${e.newsletter.image_url}" alt="Newsletter Image" class="img-thumbnail" width="150">
                        <div>
                            <h5>${e.newsletter.title}</h5>
                            <p>${e.newsletter.content}</p>
                            <div class="timestamp">${new Date(e.newsletter.created_at).toLocaleString()}</div>
                        </div>`;
                    newsletterList.prepend(li); // Prepend the new item
                }
            })
            .listen('NewsletterUpdated', (e) => {
                const newsletterList = document.getElementById('newsletter-list');
                const items = newsletterList.getElementsByTagName('li');
                for (let item of items) {
                    if (item.querySelector('h5').textContent === e.newsletter.title) {
                        item.querySelector('p').textContent = e.newsletter.content;
                        item.querySelector('.timestamp').textContent = new Date(e.newsletter.updated_at).toLocaleString();
                        if (e.newsletter.image_url) {
                            item
                            .querySelector('img').src = e.newsletter.image_url;
                        }
                    }
                }
            })
            .listen('NewsletterDeleted', (e) => {
                const newsletterList = document.getElementById('newsletter-list');
                const items = newsletterList.getElementsByTagName('li');
                for (let item of items) {
                    if (item.querySelector('h5').textContent === e.newsletter.title) {
                        newsletterList.removeChild(item);
                    }
                }

                // If the list is empty after deletion, show the "No newsletters found" message
                if (!newsletterList.hasChildNodes()) {
                    const noNewslettersMessage = document.createElement('li');
                    noNewslettersMessage.textContent = 'No newsletters found.';
                    newsletterList.appendChild(noNewslettersMessage);
                }
            });
    }
});
