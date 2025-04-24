// base/alerts.js

export function showMessage(type = 'info', message = '', container = document.body) {
    const alert = document.createElement('div');
    alert.classList.add('alert');

    // Add safe class name
    if (['success', 'error', 'info', 'warning'].includes(type)) {
        alert.classList.add(`alert--${type}`);
    }

    alert.textContent = message;

    const existing = container.querySelector('.alert');
    if (existing) existing.remove();

    container.prepend(alert);

    setTimeout(() => {
        alert.remove();
    }, 4000);
}

