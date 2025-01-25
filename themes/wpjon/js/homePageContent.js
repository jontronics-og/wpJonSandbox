document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const WORDPRESS_URL = window.location.origin;
    const ITEMS_PER_PAGE = 8;
    let selectedCategories = new Set();

    async function fetchPosts() {
        try {
            let url = `${WORDPRESS_URL}/wp-json/wp/v2/posts?_embed&per_page=${ITEMS_PER_PAGE}`;
            
            // Add categories if any are selected
            if (selectedCategories.size > 0) {
                url += `&categories=${Array.from(selectedCategories).join(',')}`;
            }

            const response = await fetch(url);
            const posts = await response.json();
            return posts;
        } catch (error) {
            console.error('Error fetching posts:', error);
            return [];
        }
    }

    function createCards(posts) {
        const cardGrid = document.getElementById('card-grid');
        if (!cardGrid) return;
        
        cardGrid.innerHTML = '';
        
        posts.forEach(post => {
            const card = document.createElement('div');
            card.className = 'content-card opacity-0 translate-y-8';
            
            // Get categories from the _embedded data
            const categories = post._embedded['wp:term'][0];
            let categoryIcons = `<div class="category-row">`;
            
            categories.forEach(category => {
                categoryIcons += `<div class="icon ${getCategoryColor(category.id.toString())}">${category.name}</div>`;
            });
            categoryIcons += '</div>';
            
            card.innerHTML = `
                <a href="${post.link}" class="card-link">
                    ${categoryIcons}
                    <p class="card-text">${post.title.rendered}</p>
                    <div class="read-more">
                        <span class="wave-text">
                            ${Array.from('Read More →').map((char, i) => 
                                `<span class="wave-letter" style="--i: ${i}">${char === ' ' ? '&nbsp;' : char}</span>`
                            ).join('')}
                        </span>
                    </div>
                </a>`;
            
            cardGrid.appendChild(card);
        });

        observeCards();
        initWaveLetters();
    }

    function getCategoryColor(categoryId) {
        const colors = {
            '11': 'pink',    // WordPress Development
            '9': 'green',   // UX/UI
            '8': 'blue',    // Technical SEO
            '11': 'red',    // WP-Dev: WP REST API
            '12': 'purple', // Apps
            '13': 'orange', // WP-DEV: Wordpress Hooks
            '14': 'pink', // WP-DEV: Wp-Query

        };
        return colors[categoryId] || 'pink';
    }

    function observeCards() {
        const cards = document.querySelectorAll('.content-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }, index * 200);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => observer.observe(card));
    }

    function initWaveLetters() {
        document.querySelectorAll('.wave-text').forEach(text => {
            text.querySelectorAll('.wave-letter').forEach((letter, index) => {
                letter.style.setProperty('--i', index);
            });
        });
    }

    // Category click handler
    document.querySelectorAll('.tag').forEach(tag => {
        tag.addEventListener('click', async () => {
            const categoryId = tag.dataset.categoryId;
            
            // Handle "All" category
            if (categoryId === '10') {
                selectedCategories.clear();
                document.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
                tag.classList.add('active');
            } else {
                // Remove "All" selection
                document.querySelector('[data-category-id="10"]')?.classList.remove('active');
                
                // Toggle category selection
                if (tag.classList.contains('active')) {
                    tag.classList.remove('active');
                    selectedCategories.delete(categoryId);
                } else {
                    tag.classList.add('active');
                    selectedCategories.add(categoryId);
                }
                
                // If no categories selected, activate "All"
                if (selectedCategories.size === 0) {
                    document.querySelector('[data-category-id="10"]')?.classList.add('active');
                }
            }

            // Fetch and display posts
            const posts = await fetchPosts();
            createCards(posts);
        });
    });

    // Initialize
    fetchPosts().then(posts => {
        createCards(posts);
    });
});