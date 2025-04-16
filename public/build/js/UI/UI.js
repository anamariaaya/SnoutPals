import {themeToggle} from './selectors.js';

export function toggleTheme() {
    window.addEventListener('DOMContentLoaded', () => {
        // Add a class that enables transitions **after** the first paint
        setTimeout(() => {
          document.body.classList.add('theme-transition');
        }, 100);
      });

      
    // 1️⃣ Get saved theme OR use system preference
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const defaultTheme = savedTheme || (systemPrefersDark ? 'dark' : 'light');

    // 2️⃣ Apply theme
    document.body.dataset.theme = defaultTheme;
    themeToggle.style.backgroundPosition = defaultTheme === 'dark' ? 'left' : 'right';

    // 3️⃣ Handle toggle click
    themeToggle.addEventListener('click', () => {
        const currentTheme = document.body.dataset.theme;
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        document.body.dataset.theme = newTheme;
        localStorage.setItem('theme', newTheme);
        themeToggle.style.backgroundPosition = newTheme === 'dark' ? 'left' : 'right';
    });
}
