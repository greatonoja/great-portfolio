// js/main.js
document.addEventListener('DOMContentLoaded', () => {
  // nav toggle
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.nav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      nav.classList.toggle('open');
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', !expanded);
    });
  }

  // active nav item by pathname
  const links = document.querySelectorAll('.nav a');
  links.forEach(a => {
    if (a.href === location.href || a.href === location.pathname || a.href === location.href.split('/').pop()) {
      a.classList.add('active');
    }
  });

  // set footer year
  const years = document.querySelectorAll('#year, #year-footer, #year-skills, #year-projects, #year-services, #year-testimonials, #year-contact');
  years.forEach(el => el.textContent = new Date().getFullYear());
});
