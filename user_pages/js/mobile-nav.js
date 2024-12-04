const menuBtn = document.getElementById('menuBtn')
const asideBar = document.getElementById('asideBar')

menuBtn.addEventListener('click', () => {
  asideBar.style.display = 'flex'
  const closeBtn = document?.getElementById('closeBtn')

  closeBtn.addEventListener('click', () => {
    asideBar.style.display = 'none'
  })
})
