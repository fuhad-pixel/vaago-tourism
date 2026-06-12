/**
 * Global Custom Toast System
 */
function showToast(type, title, message) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `custom-toast toast-${type}`;
    
    // Determine Icon based on type
    let iconClass = 'fa-solid fa-circle-info';
    if (type === 'success') iconClass = 'fa-solid fa-check';
    if (type === 'error') iconClass = 'fa-solid fa-xmark';

    toast.innerHTML = `
        <div class="toast-icon"><i class="${iconClass}"></i></div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close"><i class="fa-solid fa-xmark"></i></button>
    `;

    container.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);

    // Setup remove functionality
    const removeToast = () => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 400); // Wait for transition
    };

    // Close button event
    toast.querySelector('.toast-close').addEventListener('click', removeToast);

    // Auto dismiss after 4 seconds
    setTimeout(removeToast, 4000);
}
