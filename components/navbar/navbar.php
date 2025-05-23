<?php
/**
 * Reusable Navbar Component
 * Uses Bootstrap 5 classes with minimal custom CSS
 */
?>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap Navbar with optimized CSS -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <img src="/images/sortoutInnovation-icon/sortout-innovation-only-s.gif" alt="Sortout Innovation" height="50">
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark position-relative <?php echo ($currentPage == 'home') ? 'active fw-semibold border-bottom border-danger border-2' : 'fw-medium'; ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark position-relative <?php echo ($currentPage == 'about') ? 'active fw-semibold border-bottom border-danger border-2' : 'fw-medium'; ?>" href="/pages/about-page/about.html">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 text-dark position-relative <?php echo ($currentPage == 'career') ? 'active fw-semibold border-bottom border-danger border-2' : 'fw-medium'; ?>" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Career
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg">
                        <li>
                            <a class="dropdown-item fw-medium" href="/employee-job/index.php">Employee Jobs</a>
                        </li>
                        <li>
                            <a class="dropdown-item fw-medium" href="/admin/artist-v2/public/index.php">Artist Jobs</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark position-relative <?php echo ($currentPage == 'talent') ? 'active fw-semibold border-bottom border-danger border-2' : 'fw-medium'; ?>" href="/modal_agency.php">Find Talent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark position-relative <?php echo ($currentPage == 'services') ? 'active fw-semibold border-bottom border-danger border-2' : 'fw-medium'; ?>" href="/pages/our-services-page/service.html">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark position-relative <?php echo ($currentPage == 'contact') ? 'active fw-semibold border-bottom border-danger border-2' : 'fw-medium'; ?>" href="/pages/contact-page/contact-page.html">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-dark position-relative <?php echo ($currentPage == 'blog') ? 'active fw-semibold border-bottom border-danger border-2' : 'fw-medium'; ?>" href="/blog/index.php">Blog</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Small amount of required custom CSS (minimized) -->
<style>
/* Navbar base style */
.navbar {
    font-family: 'Montserrat', sans-serif;
    transition: padding 0.3s ease-in-out;
}

/* Nav links general style */
.nav-link {
    font-size: 0.95rem;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

/* Hover effect for nav links using Bootstrap classes */
.nav-link:not(.active):hover {
    transform: translateY(-2px);
    border-bottom: 2px solid #d10000 !important;
}

/* Dropdown menu styling */
.dropdown-menu {
    border-radius: 0.5rem;
    margin-top: 0.5rem !important;
}

.dropdown-item {
    padding: 0.6rem 1.2rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: rgba(209, 0, 0, 0.05);
    color: #d10000;
    transform: translateX(3px);
}

.dropdown-item:active {
     background-color: rgba(209, 0, 0, 0.1);
     color: #d10000;
}

/* Small spacer for fixed navbar - applied via JS now based on class */
body {
    padding-top: 80px;
}

/* Navbar shadow on scroll - handled by JS adding/removing .shadow */
.navbar.shadow {
     box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    let lastScrollY = window.scrollY;

    // Adjust body padding based on navbar height
    function adjustBodyPadding() {
        const navbarHeight = navbar.offsetHeight;
        document.body.style.paddingTop = navbarHeight + 'px';
    }

    adjustBodyPadding(); // Initial adjustment
    window.addEventListener('resize', adjustBodyPadding); // Adjust on resize

    // Scroll behavior for navbar
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow');
            navbar.style.paddingTop = '0.5rem';
            navbar.style.paddingBottom = '0.5rem';
        } else {
            navbar.classList.remove('shadow');
            navbar.style.paddingTop = '';
            navbar.style.paddingBottom = '';
        }

        // Hide navbar on scroll down, show on scroll up
        if (window.scrollY > lastScrollY && window.scrollY > 100) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        lastScrollY = window.scrollY;
    });
});
</script> 