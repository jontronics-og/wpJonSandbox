document.addEventListener('DOMContentLoaded', function() {
    // Check if we arrived with a hash in the URL
    if (window.location.hash === '#latest-insights') {
        const element = document.getElementById('latest-insights');
        if (element) {
            setTimeout(() => {
                element.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        }
    }

    // Declare variables first
    const allowedDomains = [
        'wpjonsandbox.local',
        'wpjon.wpenginepowered.com', 
        'wpjonstg.wpenginepowered.com',
        'wpjon.info',
        'www.wpjon.info'
    ];
    
    const currentDomain = window.location.hostname;
    const WORDPRESS_URL = `${window.location.protocol}//${currentDomain}`;
    const ITEMS_PER_PAGE = 8;
    let currentPage = 1;
    let allPosts = [];
    let originalPosts = [];
    let selectedCategories = new Set();
    
    // Debug logging
    // console.log('Current Domain:', currentDomain);
    // console.log('WordPress URL:', WORDPRESS_URL);
    // console.log('API endpoint:', `${WORDPRESS_URL}/wp-json/wp/v2/posts?_embed&per_page=100`);
    
    // Check domain
    // if (!allowedDomains.includes(currentDomain)) {
    //     console.log('Domain not allowed:', currentDomain);
    //     return;
    // }
 
    async function fetchPosts() {
        try {
            const response = await fetch(`${WORDPRESS_URL}/wp-json/wp/v2/posts?_embed&per_page=100`);
            originalPosts = await response.json();
            allPosts = originalPosts;
            return getPagePosts(1);
        } catch (error) {
            console.error('Fetch error:', error);
            return [];
        }
    }
 
    function getPagePosts(page) {
        const start = (page - 1) * ITEMS_PER_PAGE;
        const end = start + ITEMS_PER_PAGE;
        return allPosts.slice(start, end);
    }
 
    function createPagination() {
        const totalPages = Math.ceil(allPosts.length / ITEMS_PER_PAGE);
        if (totalPages <= 1) return;
 
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'pagination';
 
        if (currentPage > 1) {
            const prevButton = document.createElement('button');
            prevButton.textContent = 'Previous';
            prevButton.className = 'pagination-btn';
            prevButton.onclick = () => loadPage(currentPage - 1);
            paginationContainer.appendChild(prevButton);
        }
 
        if (currentPage < totalPages) {
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.className = 'pagination-btn';
            nextButton.onclick = () => loadPage(currentPage + 1);
            paginationContainer.appendChild(nextButton);
        }
 
        const cardGrid = document.getElementById('card-grid');
        if (cardGrid && cardGrid.parentNode) {
            cardGrid.parentNode.insertBefore(paginationContainer, cardGrid.nextSibling);
        }
    }
 
    function loadPage(page) {
        currentPage = page;
        const posts = getPagePosts(page);
        createCards(posts);
        document.querySelector('.pagination')?.remove();
        createPagination();
        observeCards();
        initWaveLetters();
    }
 
    function createCards(posts) {
        const cardGrid = document.getElementById('card-grid');
        if (!cardGrid) return;
        
        cardGrid.innerHTML = '';
        
        posts.forEach((post, index) => {
            if (!post._embedded?.['wp:term']) return;
    
            const card = document.createElement('div');
            card.className = 'content-card opacity-0 translate-y-8';
            const categories = post._embedded['wp:term'][0];
            
            if (categories?.length) {
                // Find the primary category (non-Apps)
                const primaryCat = categories.find(cat => cat.id !== 12);
                const appsCat = categories.find(cat => cat.id === 12);
                
                let categoryIcons = `<div class="category-row">`;
                if (primaryCat) {
                    categoryIcons += `<div class="icon ${getCategoryColor(primaryCat.id.toString())}">${primaryCat.name}</div>`;
                }
                if (appsCat) {
                    categoryIcons += `<div class="icon ${getCategoryColor('12')}">${appsCat.name}</div>`;
                }
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
                
                card.dataset.categoryId = primaryCat ? primaryCat.id.toString() : categories[0].id.toString();
                cardGrid.appendChild(card);
            }
        });
    }
 
    function getCategoryColor(categoryId) {
        switch(categoryId) {
            case '7': return 'pink';   // WordPress Development
            case '9': return 'green';  // UX/UI
            case '8': return 'blue';   // Technical SEO
            case '11': return 'red';   // WP-Dev: WP REST API
            case '12': return 'purple'; // Apps
            case '': return 'teal';
            case '': return 'red';
            case '': return 'indigo';
            case '': return 'yellow';
            case '': return 'rose';
            case '': return 'cyan';
            case '': return 'lime';
            default: return 'pink';
        }
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
 
    // Updated tag click event listener
    document.querySelectorAll('.tag').forEach(tag => {
        tag.addEventListener('click', () => {
            const selectedCategoryId = tag.dataset.categoryId;
            
            // Handle "All" category
            if (selectedCategoryId === '10') {
                selectedCategories.clear();
                document.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
                tag.classList.add('active');
            } else {
                // Remove "All" selection if it exists
                document.querySelector('[data-category-id="10"]').classList.remove('active');
                
                // Toggle category selection
                if (tag.classList.contains('active')) {
                    tag.classList.remove('active');
                    selectedCategories.delete(selectedCategoryId);
                } else {
                    tag.classList.add('active');
                    selectedCategories.add(selectedCategoryId);
                }
                
                // If no categories selected, activate "All"
                if (selectedCategories.size === 0) {
                    document.querySelector('[data-category-id="10"]').classList.add('active');
                }
            }
            
            filterCards();
        });
    });
 
   
    function filterCards() {
        currentPage = 1;
        
        if (selectedCategories.size === 0) {
            // Show all posts when no specific category is selected
            allPosts = originalPosts;
        } else {
            // Filter posts based on selected categories
            allPosts = originalPosts.filter(post => {
                const postCategories = post._embedded['wp:term'][0];
                const postCategoryIds = postCategories.map(cat => cat.id.toString());
                
                // If only Apps is selected, show all posts with Apps category
                if (selectedCategories.size === 1 && selectedCategories.has('12')) {
                    return postCategoryIds.includes('12');
                }
                
                // If Apps is selected along with other categories
                if (selectedCategories.has('12')) {
                    return postCategoryIds.includes('12') && 
                           Array.from(selectedCategories)
                               .filter(id => id !== '12')
                               .some(id => postCategoryIds.includes(id));
                }
                
                // Normal filtering for non-Apps categories
                return Array.from(selectedCategories).every(selectedCatId => 
                    postCategoryIds.includes(selectedCatId)
                );
            });
        }
        
        loadPage(1);
    }
 
    function initWaveLetters() {
        document.querySelectorAll('.wave-text').forEach(text => {
            text.querySelectorAll('.wave-letter').forEach((letter, index) => {
                letter.style.setProperty('--i', index);
            });
        });
    }
 
    // Initialize
    fetchPosts().then(posts => {
        console.log('Posts fetched:', posts);
        createCards(posts);
        createPagination();
        observeCards();
        initWaveLetters();
    }).catch(error => {
        console.error('Error initializing posts:', error);
    });
});