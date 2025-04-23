import { chooseLang } from './language.js';
import { validateRegisterForm } from './register.js';
import { waveBtnPet } from './selectors.js';
import { toggleTheme, menuResponsive, bannerWave } from './UI.js';

export default class App {
    constructor() {
      this.init();
    }
  
    init() {
      // Future setup here:
      chooseLang();
      toggleTheme();
      menuResponsive();
      if(waveBtnPet && waveBtnPet){
              bannerWave();
      }
      validateRegisterForm();
      // - Language picker
      // - Responsive nav
      // - Fetch onboarding data, etc.
    }
  }
  