document.addEventListener('DOMContentLoaded', function () {
  // Munculkan elemen saat digulir (Reveal-on-scroll)
  var elemenMuncul = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && elemenMuncul.length) {
    var pengamat = new IntersectionObserver(function (entri) {
      entri.forEach(function (item) {
        if (item.isIntersecting) {
          item.target.classList.add('visible');
          pengamat.unobserve(item.target);
        }
      });
    }, { threshold: 0.12 });
    elemenMuncul.forEach(function (el) { pengamat.observe(el); });
  } else {
    // Jika browser tidak mendukung IntersectionObserver, langsung tampilkan semua
    elemenMuncul.forEach(function (el) { el.classList.add('visible'); });
  }

  // Tutup menu navigasi mobile setelah tautan diklik
  var tautanNav = document.querySelector('.nav-links');
  if (tautanNav) {
    tautanNav.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') tautanNav.classList.remove('open');
    });
  }

  // Toggle sidebar admin (mode mobile)
  var sidebar = document.querySelector('.admin-sidebar');
  var tombolToggle = document.querySelector('.sidebar-toggle');
  if (sidebar && tombolToggle) {
    tombolToggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
  }
});
