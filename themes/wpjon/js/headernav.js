document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.wpj-header');
    const menuToggle = document.querySelector('.wpj-mobile-menu-toggle');
    const closeMenuBtn = document.querySelector('.close-menu');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        lastScroll = currentScroll;
    });

    menuToggle.addEventListener('click', () => {
        document.body.classList.add('menu-open');
    });

    closeMenuBtn.addEventListener('click', () => {
        document.body.classList.remove('menu-open');
    });
});