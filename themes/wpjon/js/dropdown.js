

// Select the first HTML element with the class 'menu' and store it in the variable 'dropdown'.
// This is expected to be a <ul> element.
let dropdown = document.querySelector('.menu'); // <ul>

// Select the first HTML element with the class 'sub-menu' and store it in the variable 'submenu'.
// This is expected to be a child of <ul> or <li>, possibly containing links.
let submenu = document.querySelector('.sub-menu'); // <ul> <li> <a>

// Select the first HTML element with the class 'check-button' and store it in the variable 'buttonClick'.
// This is expected to be a button that will trigger the dropdown menu behavior.
let buttonClick = document.querySelector('.check-button'); // <button>

// Select the first HTML element with the class 'menu-icon' and store it in the variable 'hamburger'.
// This is expected to be an icon, such as a hamburger menu icon.
let hamburger = document.querySelector('.menu-icon'); // Icon element

// Add a click event listener to the 'buttonClick' element.
// When the button is clicked, the anonymous function (arrow function) will execute.
buttonClick.addEventListener('click', () => {
    // Toggle the class 'show-dropdown' on the 'dropdown' element.
    // If the class is already there, it will be removed; otherwise, it will be added.
    dropdown.classList.toggle('show-dropdown');

    // Check if 'submenu' exists (not null or undefined).
    if (submenu) {
        // If 'submenu' exists, toggle the class 'show-dropdown' on it as well.
        submenu.classList.toggle('show-dropdown');
    }

    // Toggle the class 'animate-button' on the 'hamburger' element.
    // This is likely used to animate the menu icon when the dropdown is toggled.
    hamburger.classList.toggle('animate-button');
});






















