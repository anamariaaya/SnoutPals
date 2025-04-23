import { showMessage } from '../base/alerts.js'; // optional if you want to display feedback nicely
import { confirmPassword, email, form, lastname, name, password } from './selectors.js';

export function validateRegisterForm() {

    function validateField(field, type = 'text') {
        const value = field.value.trim();
        const form = field.closest('form');

        if (!value) {
            showMessage('error', `${field.name} is required.`, form);
            return false;
        }

        if (type === 'text' && /\d/.test(value)) {
            showMessage('error', `${field.name} should not contain numbers.`, form);
            return false;
        }

        if (type === 'email' && !/^\S+@\S+\.\S+$/.test(value)) {
            showMessage('error', 'Invalid email address.', form);
            return false;
        }

        if (type === 'password' && value.length < 6) {
            showMessage('error', 'Password must be at least 6 characters.', form);
            return false;
        }

        return true;
    }

    name.addEventListener('blur', () => validateField(name, 'text'));
    lastname.addEventListener('blur', () => validateField(lastname, 'text'));
    email.addEventListener('blur', () => validateField(email, 'email'));
    password.addEventListener('blur', () => validateField(password, 'password'));

    confirmPassword.addEventListener('blur', () => {
        const form = confirmPassword.closest('form');
        if (confirmPassword.value !== password.value) {
            showMessage('error', 'Passwords do not match.', form);
        }
    });

    console.log('Form is valid! Submit via fetch() or axios...');
}



export function registerHandler() {

  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const name = form.name.value.trim();
    const lastname = form.lastname.value.trim();
    const email = form.email.value.trim();
    const password = form.password.value;
    const confirmPassword = form['confirm-password'].value;

    if (password !== confirmPassword) {
      showMessage('Passwords do not match', 'error'); // or alert()
      return;
    }

    const formData = {
      name,
      lastname,
      email,
      password
    };

    try {
      const res = await fetch('/api/auth/register.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      });

      const data = await res.json();

      if (!res.ok) {
        throw new Error(data.message || 'Something went wrong.');
      }

      showMessage('Account created successfully!', 'success'); // or redirect
      form.reset();
      // optionally: window.location.href = '/login';

    } catch (err) {
      showMessage(err.message, 'error');
    }
  });
}
