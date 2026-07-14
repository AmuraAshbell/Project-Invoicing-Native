(() => {
  'use strict';

  // Fade-in saat halaman pertama kali dimuat
  const revealPage = () => {
    requestAnimationFrame(() => {
      document.body.classList.add('page-loaded');
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', revealPage);
  } else {
    revealPage();
  }

  // Fade-out sebelum berpindah ke halaman login/register, lalu navigasi
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a[data-auth-transition]').forEach((link) => {
      link.addEventListener('click', function (event) {
        const href = this.getAttribute('href');
        if (!href || href.startsWith('#')) return;

        event.preventDefault();
        document.body.classList.remove('page-loaded');
        document.body.classList.add('page-fade-out');

        setTimeout(() => {
          window.location.href = href;
        }, 320);
      });
    });
  });
})();
