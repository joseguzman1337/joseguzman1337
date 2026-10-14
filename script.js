// Theme Toggle: Full Dark Mode Default with "Turn On Lights" control
(function initTheme() {
    const savedTheme = localStorage.getItem('jg_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', savedTheme);
})();

document.addEventListener('DOMContentLoaded', () => {
    // Dynamic Year
    const yearEl = document.getElementById('year');
    if (yearEl) {
        yearEl.textContent = new Date().getFullYear();
    }

    // Theme Switcher Button
    const themeBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const themeText = document.getElementById('theme-text');

    function updateButtonState(currentTheme) {
        if (!themeBtn) return;
        if (currentTheme === 'light') {
            themeBtn.setAttribute('aria-label', 'Turn Off Lights (Dark Mode)');
            if (themeIcon) themeIcon.textContent = '🌙';
            if (themeText) themeText.textContent = 'Lights Off';
        } else {
            themeBtn.setAttribute('aria-label', 'Turn On Lights (Light Mode)');
            if (themeIcon) themeIcon.textContent = '💡';
            if (themeText) themeText.textContent = 'Turn On Lights';
        }
    }

    const initialTheme = document.documentElement.getAttribute('data-theme') || 'dark';
    updateButtonState(initialTheme);

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            const activeTheme = document.documentElement.getAttribute('data-theme');
            const nextTheme = activeTheme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', nextTheme);
            localStorage.setItem('jg_theme', nextTheme);
            updateButtonState(nextTheme);
        });
    }

    // Scroll Intersection Observer for reveals
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.animate(
                    [
                        { opacity: 0, transform: 'translateY(20px)' },
                        { opacity: 1, transform: 'translateY(0)' }
                    ],
                    {
                        duration: 600,
                        easing: 'cubic-bezier(.16, 1, .3, 1)',
                        fill: 'both'
                    }
                );
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('.expertise-grid article, .projects a, .pipeline > div, .timeline-item').forEach((el) => {
            observer.observe(el);
        });
    }
});
