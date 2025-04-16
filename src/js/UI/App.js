import { chooseLang } from './language.js';
import { toggleTheme } from './UI.js';

export default class App {
    constructor() {
      this.init();
    }
  
    init() {
      console.log('UI app initialized ✨');
      // Future setup here:
      // - Theme toggle
      chooseLang();
      toggleTheme();
      // - Language picker
      // - Responsive nav
      // - Fetch onboarding data, etc.
    }
  }
  