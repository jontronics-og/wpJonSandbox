// Add this to your theme's js file or enqueue it separately
function initSmoothScroll() {
    document.querySelectorAll('.table-of-contents a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').slice(1);
            const target = document.getElementById(targetId);
            
            if (target) {
                const headerOffset = 100; // Adjust this value based on your fixed header height
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// If using as a separate file, wrap in DOMContentLoaded
document.addEventListener('DOMContentLoaded', initSmoothScroll);