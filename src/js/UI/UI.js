import {themeToggle} from './selectors.js';

export function toggleTheme() {
    const currentTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

    themeToggle.style.backgroundPosition = currentTheme === 'dark' ? 'left' : 'right';

    themeToggle.addEventListener('click', () => {
            const newTheme = document.body.dataset.theme === 'dark' ? 'light' : 'dark';
            document.body.dataset.theme = newTheme;
            localStorage.setItem('theme', newTheme);

            themeToggle.style.backgroundPosition = newTheme === 'dark' ? 'left' : 'right';
        }
    );

}