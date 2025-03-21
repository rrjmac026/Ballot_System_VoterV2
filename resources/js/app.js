import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Dark mode functionality
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
} else {
    document.documentElement.classList.remove('dark')
}

function updateThemeToggle() {
    const isDark = document.documentElement.classList.contains('dark');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');
    const text = document.getElementById('theme-toggle-text');

    darkIcon.classList.toggle('hidden', isDark);
    lightIcon.classList.toggle('hidden', !isDark);
    text.textContent = isDark ? 'Light Mode' : 'Dark Mode';
}

document.getElementById('theme-toggle')?.addEventListener('click', function(e) {
    e.preventDefault();
    
    // Toggle dark class
    document.documentElement.classList.toggle('dark');
    
    // Update localStorage
    if (document.documentElement.classList.contains('dark')) {
        localStorage.theme = 'dark';
    } else {
        localStorage.theme = 'light';
    }
    
    updateThemeToggle();
});

// Initial update
updateThemeToggle();
