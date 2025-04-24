
import { showMessage } from '../base/alerts.js';
import { t } from '../base/functions.js';
import { form } from '../UI/selectors.js';

export function validateRegisterForm() {

    // const lang = await readLang();
    // const alerts = await readJSON();
    const name = form.querySelector('#name');
    const lastname = form.querySelector('#lastname');
    const email = form.querySelector('#email');
    const password = form.querySelector('#password');
    const confirmPassword = form.querySelector('#confirmPassword');

    async function validateField(field, type = 'text') {
        const value = field.value.trim();
        const form = field.closest('form');
        const fieldName = field.name;

        if (!value) {
          const message = await t('input', fieldName) || await t('input', 'generic');
          showMessage('error', message , form);
           return false;
        }

        if (type === 'text' && /\d/.test(value)) {
            const message = await t('input', 'text-not-numbers');
            showMessage('error', message, form);
            return false;
        }

        if (type === 'email' && !/^\S+@\S+\.\S+$/.test(value)) {
            const message = await t('input', 'invalid-email');
            showMessage('error', message, form);
            return false;
        }

        if (type === 'password') {
            if (value.length < 8) {
              const message = await t('input', 'password-length');
              showMessage('error', message, form);
              return false;
            }
          
            const hasUppercase = /[A-Z]/.test(value);
            const hasLowercase = /[a-z]/.test(value);
            const hasNumber = /[0-9]/.test(value);
          
            if (!hasUppercase || !hasLowercase || !hasNumber) {
              const message = await t('input', 'password-weak');
              showMessage('error', message, form);
              return false;
            }
        }

        return true;
    }

    name.addEventListener('blur', () => validateField(name, 'text'));
    lastname.addEventListener('blur', () => validateField(lastname, 'text'));
    email.addEventListener('blur', () => validateField(email, 'email'));
    password.addEventListener('blur', () => validateField(password, 'password'));
    confirmPassword.addEventListener('blur', () => validateField(confirmPassword, 'password'));

    confirmPassword.addEventListener('blur', async () => {
        const form = confirmPassword.closest('form');
        if (confirmPassword.value !== password.value) {
            const message = await t('input', 'passwords-not-match');
            showMessage('error', message, form);
        }
    });

    registerHandler();
}



export function registerHandler() {

  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const name = form.name.value.trim();
    const lastname = form.lastname.value.trim();
    const email = form.email.value.trim();
    const password = form.password.value;
    const confirmPassword = form.confirmPassword.value;
    const honeypot = form.honeypot.value; // Honeypot field


    if (password !== confirmPassword) {
        const message = await t('input', 'passwords-not-match');
        showMessage('error', message, form);
      return;
    }

    const formData = {
        name,
        lastname,
        email,
        password,
        confirmPassword,
        honeypot
    };
    console.log(formData);

    try {
        const role = new URLSearchParams(window.location.search).get('role');

        if (!role || (role !== '2' && role !== '3')) {
          showMessage('Invalid role detected.', 'error');
          return;
        }
        
        const res = await fetch(`/api/auth/register?role=${role}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(formData)
        });
        
        const text = await res.text(); // get raw response
        console.log('Raw response:', text);

         // Detect HTML error response
        if (text.startsWith('<')) {
            showMessage('error', await t('server', 'unexpected-error'), form);
            return;
        }

        let data;
        try {
        data = JSON.parse(text);
        } catch (parseError) {
            showMessage('error', await t('server', 'unexpected-error'), form);
            return;
        }

        if (!res.ok || data.status !== 'success') {
            const message = data.message || await t('server', 'registratrion-failed');
            showMessage('error', message, form);
            return;
        }

        // ✳️ Show error if response is not ok
        if (!res.ok || data.status !== 'success') {
        const message = data.message || await t('server', 'registratrion-failed');
        showMessage('error', message, form);
        return;
        }

        // ✅ Success
        showMessage('success', data.message || await t('server', 'user-created'), form);
        form.reset();
        setTimeout(() => {
            window.location.href = '/account-created'; 
        }, 650);
       

    } catch (err) {
        showMessage('error', err.message, form);
    }
  });
}
