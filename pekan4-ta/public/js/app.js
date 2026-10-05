document.querySelector('form')?.addEventListener('submit', (event) => {
    const button = event.target.querySelector('button[type="submit"]');
    button.disabled = true;
    button.textContent = 'Mengirim...';
});