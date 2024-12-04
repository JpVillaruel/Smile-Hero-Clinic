<div class="search__container">
  <input type="text" id="searchInput" placeholder="Search here...">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M20 11C20 15.97 15.97 20 11 20C6.03 20 2 15.97 2 11C2 6.03 6.03 2 11 2" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M18.9299 20.6898C19.4599 22.2898 20.6699 22.4498 21.5999 21.0498C22.4499 19.7698 21.8899 18.7198 20.3499 18.7198C19.2099 18.7098 18.5699 19.5998 18.9299 20.6898Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M14 5H20" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M14 8H17" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</div>

<script>
  // search
  document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('.appointment-row');
    const noAppointmentMessage = document.querySelector('.no-appointment-message');
    let hasMatches = false;

    rows.forEach(row => {
        let name = row.querySelector('.patient-name').textContent.toLowerCase()
        let email = row.querySelector('.patient-email').textContent.toLowerCase()
        let date = row.querySelector('.patient-cell.date').textContent
        let time = row.querySelector('.patient-cell.time')?.textContent
        let phone = row.querySelector('.patient-cell.phone').textContent
        let doctor = row.querySelector('.patient-cell.doctor').textContent.toLowerCase()

        if (name.includes(query) || 
            email.includes(query) || 
            date.includes(query) || 
            time?.includes(query) || 
            doctor?.includes(query) || 
            phone.includes(query)) {
            row.style.display = ''
            hasMatches = true;
        } else {
            row.style.display = 'none'
        }
    })

    noAppointmentMessage.style.display = hasMatches ? 'none' : ''
  })
</script>