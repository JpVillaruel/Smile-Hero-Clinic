<nav class="navbar" style="z-index: 1">
  <!-- Logo and Title -->
  <div class="navbar__brand">
    <!-- logo -->
    <svg
      width="44"
      height="44"
      viewBox="0 0 44 44"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <rect width="44" height="44" rx="22" fill="#1D72F2" />
      <g clip-path="url(#clip0_246_1826)">
        <path
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M16 10C19.3137 10 22 12.6863 22 16V10H28C31.3137 10 34 12.6863 34 16C34 19.3137 31.3137 22 28 22C31.3137 22 34 24.6863 34 28C34 29.6454 33.3377 31.1361 32.2651 32.22L32.2427 32.2427L32.2227 32.2625C31.1385 33.3366 29.6468 34 28 34C26.3645 34 24.8817 33.3456 23.7994 32.2843C23.7854 32.2705 23.7713 32.2566 23.7573 32.2427C23.7442 32.2295 23.7311 32.2163 23.7181 32.2031C22.6554 31.1205 22 29.6368 22 28C22 31.3137 19.3137 34 16 34C12.6863 34 10 31.3137 10 28V22H16C12.6863 22 10 19.3137 10 16C10 12.6863 12.6863 10 16 10ZM20.8 16C20.8 18.651 18.651 20.8 16 20.8V11.2C18.651 11.2 20.8 13.349 20.8 16ZM32.8 28C32.8 25.349 30.651 23.2 28 23.2C25.349 23.2 23.2 25.349 23.2 28H32.8ZM11.2 23.2V28C11.2 30.651 13.349 32.8 16 32.8C18.651 32.8 20.8 30.651 20.8 28V23.2H11.2ZM23.2 20.8V11.2H28C30.651 11.2 32.8 13.349 32.8 16C32.8 18.651 30.651 20.8 28 20.8H23.2Z"
          fill="white"
        />
      </g>
      <defs>
        <clipPath id="clip0_246_1826">
          <rect
            width="24"
            height="24"
            fill="white"
            transform="translate(10 10)"
          />
        </clipPath>
      </defs>
    </svg>
    <!-- end of logo -->

    <h1 class="navbar__title">Smile Hero Clinic</h1>
  </div>

  <!-- Date and Time -->
  <div class="navbar__datetime">
    <!-- Date -->
    <div class="navbar__date">
      <p class="currentDate">September 16, 2024</p>
      <!-- calendar icon -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M8 2V5" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M16 2V5" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M3.5 9.09009H20.5" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M15.6947 13.7H15.7037" stroke="#616161" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M15.6947 16.7H15.7037" stroke="#616161" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M11.9955 13.7H12.0045" stroke="#616161" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M11.9955 16.7H12.0045" stroke="#616161" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M8.29431 13.7H8.30329" stroke="#616161" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M8.29431 16.7H8.30329" stroke="#616161" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <!-- end of calendar icon -->
    </div>
    <hr>
    <!-- Time -->
    <div class="navbar__time">
      <div id="timeEl" class="navbar__time-numbers">
        <p>02</p>
        <p>59</p>
      </div>
      <div class="navbar__ampm">
        <p class="navbar__ampm--first">p</p>
        <p class="navbar__ampm--second">m</p>
      </div>
    </div>
  </div>

  <!-- New Appointment Button -->
  <button class="btn btn--primary">
    <a href="./new-appointment.php">
      Create New Appointment
      <!-- new appointment icon -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.56 18V13" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M12 15.5H7" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M8 2V5" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M16 2V5" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M15.81 3.41992C19.15 3.53992 20.84 4.76992 20.94 9.46992L21.07 15.6399C21.15 19.7599 20.2 21.8299 15.2 21.9399L9.20002 22.0599C4.20002 22.1599 3.16002 20.1199 3.08002 16.0099L2.94002 9.82992C2.84002 5.12992 4.49002 3.82992 7.81002 3.57992L15.81 3.41992Z" stroke="#616161" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <!-- new appointment icon -->
     </a> 
  </button>

  <!-- Settings, Logout, and Profile -->
  <div class="navbar__actions">
    <!-- Logout Button -->
    <button class="btn btn--icon">
      <a href="#">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.89999 7.55999C9.20999 3.95999 11.06 2.48999 15.11 2.48999H15.24C19.71 2.48999 21.5 4.27999 21.5 8.74999V15.27C21.5 19.74 19.71 21.53 15.24 21.53H15.11C11.09 21.53 9.23999 20.08 8.90999 16.54" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M15 12H3.62" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M5.85 8.6499L2.5 11.9999L5.85 15.3499" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </button>
    <!-- Settings Button -->
    <button class="btn btn--icon">
      <a href="#">
        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3.5 9.11011V14.8801C3.5 17.0001 3.5 17.0001 5.5 18.3501L11 21.5301C11.83 22.0101 13.18 22.0101 14 21.5301L19.5 18.3501C21.5 17.0001 21.5 17.0001 21.5 14.8901V9.11011C21.5 7.00011 21.5 7.00011 19.5 5.65011L14 2.47011C13.18 1.99011 11.83 1.99011 11 2.47011L5.5 5.65011C3.5 7.00011 3.5 7.00011 3.5 9.11011Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12.5 15C14.1569 15 15.5 13.6569 15.5 12C15.5 10.3431 14.1569 9 12.5 9C10.8431 9 9.5 10.3431 9.5 12C9.5 13.6569 10.8431 15 12.5 15Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </button>
    <!-- Profile Image -->
    <div class="profile">
      <svg width="25" height="24" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M258.9 48C141.92 46.42 46.42 141.92 48 258.9c1.56 112.19 92.91 203.54 205.1 205.1 117 1.6 212.48-93.9 210.88-210.88C462.44 140.91 371.09 49.56 258.9 48zm126.42 327.25a4 4 0 01-6.14-.32 124.27 124.27 0 00-32.35-29.59C321.37 329 289.11 320 256 320s-65.37 9-90.83 25.34a124.24 124.24 0 00-32.35 29.58 4 4 0 01-6.14.32A175.32 175.32 0 0180 259c-1.63-97.31 78.22-178.76 175.57-179S432 158.81 432 256a175.32 175.32 0 01-46.68 119.25z"/><path d="M256 144c-19.72 0-37.55 7.39-50.22 20.82s-19 32-17.57 51.93C191.11 256 221.52 288 256 288s64.83-32 67.79-71.24c1.48-19.74-4.8-38.14-17.68-51.82C293.39 151.44 275.59 144 256 144z"/></svg>
    </div>
  </div>
</nav>

<script>
  function getCurrentDateAndTime() {
    const date = new Date()
    const months = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ]

    const month = months[date.getMonth()]
    const day = date.getDate()
    const year = date.getFullYear()

    let hours = date.getHours()
    let minutes = date.getMinutes().toString().padStart(2, '0')

    const period = hours >= 12 ? 'P' : 'A'
    hours = hours % 12 || 12
    hours = hours < 10 ? hours.toString().padStart(2, '0') : hours

    document.querySelector('.currentDate').innerText = `${month} ${day}, ${year}`
    document.querySelector('#timeEl p:nth-child(1)').innerText = `${hours}`
    document.querySelector('#timeEl p:nth-child(2)').innerText = `${minutes}`
    document.querySelector('.navbar__ampm--first').innerText = `${period}`
  }

  setInterval(getCurrentDateAndTime, 1000)
</script>
