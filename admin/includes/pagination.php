<?php
function renderPagination($currentPage, $totalPages) {
    if ($totalPages <= 1) return; // No pagination needed if there is only one page

    echo '<div class="pagination">
            <div class="container">';

    // Previous button
    if ($currentPage > 1) {
        echo '<a href="?page=' . ($currentPage - 1) . '" class="button icon">
                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M20.0163 8.00655L12.0098 16.0131L20.0163 24.0197" stroke="#1D72F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>';
    }

    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = $i == $currentPage ? 'active-page' : '';
        echo '<a href="?page=' . $i . '" class="button ' . $activeClass . '">' . $i . '</a>';
    }

    // Next button
    if ($currentPage < $totalPages) {
        echo '<a href="?page=' . ($currentPage + 1) . '" class="button icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.036 8.00655L20.0426 16.0131L12.036 24.0197" stroke="#1D72F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>';
    }

    echo '</div>
    </div>';
}
