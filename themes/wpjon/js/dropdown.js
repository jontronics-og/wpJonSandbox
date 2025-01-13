// Select all necessary elements
const mobileMenu = document.querySelector(".wpj-mobile-menu"),
      menuToggle = document.querySelector(".wpj-mobile-menu-toggle"),
      closeButton = document.querySelector(".close-menu"),
      hamburgerLines = document.querySelector(".hamburger-lines"),
      body = document.body;

// Function to open menu
function openMenu() {
    mobileMenu.classList.add("active");
    body.classList.add("menu-open");
    body.style.overflow = "hidden"; // Prevent background scrolling
}

// Function to close menu
function closeMenu() {
    mobileMenu.classList.remove("active");
    body.classList.remove("menu-open");
    body.style.overflow = ""; // Restore scrolling
}

// Add click event listeners
if (menuToggle) {
    menuToggle.addEventListener("click", openMenu);
}

if (closeButton) {
    closeButton.addEventListener("click", closeMenu);
}

// Close menu when clicking outside
document.addEventListener("click", (e) => {
    if (mobileMenu && mobileMenu.classList.contains("active")) {
        // Check if click is outside the mobile menu content
        if (!e.target.closest(".wpj-mobile-menu-content") && 
            !e.target.closest(".wpj-mobile-menu-toggle")) {
            closeMenu();
        }
    }
});

// Handle escape key
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && mobileMenu && mobileMenu.classList.contains("active")) {
        closeMenu();
    }
});

// Prevent clicks inside menu from bubbling to document
if (mobileMenu) {
    mobileMenu.addEventListener("click", (e) => {
        if (e.target.closest(".wpj-mobile-menu-content")) {
            e.stopPropagation();
        }
    });
}

// Handle mobile menu links
const mobileMenuLinks = document.querySelectorAll(".wpj-mobile-nav-links a");
mobileMenuLinks.forEach(link => {
    link.addEventListener("click", () => {
        closeMenu();
    });
});

// Handle resize events
let resizeTimer;
window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        if (window.innerWidth > 768) { // Adjust breakpoint as needed
            closeMenu();
        }
    }, 250);
});