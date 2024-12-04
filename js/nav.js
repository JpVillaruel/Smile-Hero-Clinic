const menuBtn = document.getElementById('menuBtn')
const closeBtn = document.getElementById('closeBtn')
const mobileNav = document.querySelector('.mobile-nav-container')

menuBtn.addEventListener('click', (e) => {
  mobileNav.classList.toggle('visible')
})

closeBtn.addEventListener('click', (e) => {
  mobileNav.classList.remove('visible')
})
