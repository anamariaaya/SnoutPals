import { languageBtn, languageDropdown, languagePicker } from './selectors.js';

export function chooseLang(){    
    //Mostrar el select de idioma
    languageBtn.onmouseover = function(){
        languageDropdown.classList.remove('no-display');
    };
    languageDropdown.onmouseout = function(){
        languageDropdown.classList.add('no-display');
    };

    languageBtn.onfocus = () => languageDropdown.classList.remove('no-display');
    languageBtn.onblur = () => languageDropdown.classList.add('no-display');


    languagePicker.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const lang = e.target.value;
            // Create a URL object based on the current location
            const currentUrl = new URL(window.location);
            // Access the URL's search parameters
            const searchParams = currentUrl.searchParams;
            // Set or update the 'lang' parameter
            searchParams.set('lang', lang);
            // Update the search property of the main URL
            currentUrl.search = searchParams.toString();
            // Redirect to the new URL
            window.location.href = currentUrl.href;
        });
    });


    document.addEventListener('click', (e) => {
        if (!languageDropdown.contains(e.target) && e.target !== languageBtn) {
          languageDropdown.classList.add('no-display');
        }
      });

      
    document.addEventListener('keydown', (e) => {
        const isVisible = !languageDropdown.classList.contains('no-display');
        
        if (e.key === 'Escape' && isVisible) {
            languageDropdown.classList.add('no-display');
        }
    });
    
    
}