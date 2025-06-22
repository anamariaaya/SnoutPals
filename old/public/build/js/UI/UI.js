import {actionsPets, actionsVets, menuBtn, menuBtnIcon, nav, themeToggle, waveBtnPet, waveBtnVet} from './selectors.js';

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

export function menuResponsive() {
    menuBtn.addEventListener('click', () => {
        nav.classList.toggle('nav-open');
        menuBtnIcon.classList.toggle('fa-bars');
        menuBtnIcon.classList.toggle('fa-xmark');
    });
}


export function bannerWave() {
    waveBtnPet.addEventListener('click', () => {
        waveBtnVet.classList.remove('banner-box--open');
        waveBtnPet.classList.toggle('banner-box--open');
        actionsPets.classList.toggle('active');
        actionsVets.classList.remove('active');
    });

    waveBtnVet.addEventListener('click', () => {
        waveBtnPet.classList.remove('banner-box--open');
        waveBtnVet.classList.toggle('banner-box--open');
        actionsVets.classList.toggle('active');
        actionsPets.classList.remove('active');
    });
}
