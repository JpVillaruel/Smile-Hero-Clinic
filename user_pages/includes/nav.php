<nav class="account__header user-header">
  <a href="homepage.php">
    <img src="../assets/logo-blue-bg.svg" alt="">
  </a>

  <bu class="header__content">
    <div class="header__date">Monday 9:34 AM | September 9, 2024</div>
    <button class="header__button button--appointment">
      <a href="../user_pages/appointment_form_page.php">
        Set an appointment
      </a>  
    </button>

    <button class="menu-btn" id="menuBtn">☰</button>
  </div>
</nav>

<script>
  function getCurrentDateTime() {
    const date = new Date()
    const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
    const months = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ]

    // get current day, month, date and year
    const dayOfWeek = daysOfWeek[date.getDay()]
    const month = months[date.getMonth()]
    const day = date.getDate()
    const year = date.getFullYear()

    let hours = date.getHours()
    let minutes = date.getMinutes().toString().padStart(2, '0')

    const period = hours >= 12 ? 'PM':'AM'
    hours = hours % 12 || 12

    return document.querySelector('.header__date').innerText = `${dayOfWeek} ${hours}:${minutes} ${period} | ${month} ${day}, ${year}`
  }

  setInterval(getCurrentDateTime, 1000)
</script>