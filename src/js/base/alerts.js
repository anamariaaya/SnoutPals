// base/alerts.js

export function showMessage(type, message, container) {
    const alert = document.createElement('div');
    alert.classList.add('alert', `alert--${type}`);
    alert.textContent = message;

    const existing = container.querySelector('.alert');
    if (existing) existing.remove();

    container.prepend(alert);

    // Auto-dismiss after 4s
    setTimeout(() => {
        alert.remove();
    }, 4000);
}
