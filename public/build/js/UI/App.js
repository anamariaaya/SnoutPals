import { chooseLang } from './language.js';
import { toggleTheme } from './UI.js';

export default class App {
    constructor() {
      this.init();
    }
  
    init() {
      chooseLang();
      toggleTheme();

      // - Responsive nav
      // - Fetch onboarding data, etc.
    }
  }

  