// Dynamic Year
const yearEl = document.getElementById('year');
if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
}

// Scroll Intersection Observer for subtle reveals
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
