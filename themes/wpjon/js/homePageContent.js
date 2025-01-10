// document.addEventListener('DOMContentLoaded', () => {
//     const allowedDomains = [
//         'wpjonsandbox.local',
//         'wpjon.wpenginepowered.com',
//         'wpjonstg.wpenginepowered.com'
//     ];
    
//     const currentDomain = window.location.hostname;
//     const WORDPRESS_URL = `http://${currentDomain}`;
    
//     if (!allowedDomains.includes(currentDomain)) return;
    
//     async function fetchPosts() {
//         try {
//             const response = await fetch(`${WORDPRESS_URL}/wp-json/wp/v2/posts?_embed&per_page=100`);
//             return await response.json();
//         } catch (error) {
//             return [];
//         }
//     }
 
//     function createCards(posts) {
//         const cardGrid = document.getElementById('card-grid');
//         cardGrid.innerHTML = '';
        
//         posts.forEach(post => {
//             if (!post._embedded?.['wp:term']) return;
 
//             const card = document.createElement('div');
//             card.className = 'content-card';
//             const categories = post._embedded['wp:term'][0];
            
//             if (categories?.length) {
//                 const categoryName = categories[0].name;
//                 const categoryId = categories[0].id.toString();
                
//                 card.innerHTML = `
//                     <div class="icon ${getCategoryColor(categoryId)}">${categoryName}</div>
//                     <p class="card-text">${post.title.rendered}</p>
//                 `;
                
//                 card.dataset.categoryId = categoryId;
//                 cardGrid.appendChild(card);
//             }
//         });
//     }
 
//     function getCategoryColor(categoryId) {
//         switch(categoryId) {
//             case '7': return 'pink';   
//             case '9': return 'green';  
//             case '8': return 'blue';   
//             default: return 'pink';
//         }
//     }
 
//     document.querySelectorAll('.tag').forEach(tag => {
//         tag.addEventListener('click', () => {
//             const selectedCategoryId = tag.dataset.categoryId;
//             filterCards(selectedCategoryId);
//             document.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
//             tag.classList.add('active');
//         });
//     });
 
//     function filterCards(categoryId) {
//         const cards = document.querySelectorAll('.content-card');
        
//         cards.forEach(card => {
//             card.style.opacity = '0';
//             setTimeout(() => {
//                 const cardCategoryId = card.dataset.categoryId;
//                 if (categoryId === '10' || cardCategoryId === categoryId) {
//                     card.classList.remove('hidden');
//                     card.style.opacity = '1';
//                 } else {
//                     card.classList.add('hidden');
//                 }
//             }, 300);
//         });
//     }
 
//     fetchPosts().then(createCards);
//  });


// homepageContent.js
document.addEventListener('DOMContentLoaded', () => {
    const allowedDomains = [
        'wpjonsandbox.local',
        'wpjon.wpenginepowered.com',
        'wpjonstg.wpenginepowered.com'
    ];
    
    const currentDomain = window.location.hostname;
    const WORDPRESS_URL = `http://${currentDomain}`;
    const ITEMS_PER_PAGE = 8;
    let currentPage = 1;
    let allPosts = [];
    let originalPosts = [];
    
    if (!allowedDomains.includes(currentDomain)) return;
    
    async function fetchPosts() {
        try {
            const response = await fetch(`${WORDPRESS_URL}/wp-json/wp/v2/posts?_embed&per_page=100`);
            originalPosts = await response.json();
            allPosts = originalPosts;
            return getPagePosts(1);
        } catch (error) {
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
        cardGrid.parentNode.insertBefore(paginationContainer, cardGrid.nextSibling);
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
        cardGrid.innerHTML = '';
        
        posts.forEach((post, index) => {
            if (!post._embedded?.['wp:term']) return;
    
            const card = document.createElement('div');
            card.className = 'content-card opacity-0 translate-y-8';
            const categories = post._embedded['wp:term'][0];
            
            if (categories?.length) {
                const categoryName = categories[0].name;
                const categoryId = categories[0].id.toString();
                
                card.innerHTML = `
    <a href="${post.link}" class="card-link">
        <div class="icon ${getCategoryColor(categoryId)}">${categoryName}</div>
        <p class="card-text">${post.title.rendered}</p>
        <div class="read-more">
            <span class="wave-text">
                ${Array.from('Read More →').map((char, index) => 
                    `<span class="wave-letter" style="--i: ${index}">${char === ' ' ? '&nbsp;' : char}</span>`
                ).join('')}
            </span>
        </div>
    </a>
`;
                
                card.dataset.categoryId = categoryId;
                cardGrid.appendChild(card);
            }
        });
    }
 
    function getCategoryColor(categoryId) {
        switch(categoryId) {
            case '7': return 'pink';   
            case '9': return 'green';  
            case '8': return 'blue';   
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
 
    document.querySelectorAll('.tag').forEach(tag => {
        tag.addEventListener('click', () => {
            const selectedCategoryId = tag.dataset.categoryId;
            filterCards(selectedCategoryId);
            document.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
            tag.classList.add('active');
        });
    });
 
    function filterCards(categoryId) {
        currentPage = 1;
        
        if (categoryId === '10') {
            allPosts = originalPosts;
        } else {
            allPosts = originalPosts.filter(post => {
                const postCategory = post._embedded['wp:term'][0][0];
                return postCategory.id.toString() === categoryId;
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
 
    fetchPosts().then(posts => {
        createCards(posts);
        createPagination();
        observeCards();
        initWaveLetters();
    });
 });


 


















