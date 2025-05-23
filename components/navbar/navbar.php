<?php
/**
 * Reusable Navbar Component
 * Uses Bootstrap 5 classes with minimal custom CSS
 */
?>

<!-- Bootstrap Navbar with optimized CSS -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <img src="/images/sortoutInnovation-icon/sortout-innovation-only-s.gif" alt="Sortout Innovation" height="45">
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
                    <a class="nav-link px-3 <?php echo ($currentPage == 'home') ? 'active fw-bold' : ''; ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($currentPage == 'about') ? 'active fw-bold' : ''; ?>" href="/pages/about-page/about.html">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 <?php echo ($currentPage == 'career') ? 'active fw-bold' : ''; ?>" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Career
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/employee-job/index.php">Employee Jobs</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/admin/artist-v2/public/index.php">Artist Jobs</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($currentPage == 'talent') ? 'active fw-bold' : ''; ?>" href="/modal_agency.php">Find Talent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($currentPage == 'services') ? 'active fw-bold' : ''; ?>" href="/pages/our-services-page/service.html">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($currentPage == 'contact') ? 'active fw-bold' : ''; ?>" href="/pages/contact-page/contact-page.html">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($currentPage == 'blog') ? 'active fw-bold' : ''; ?>" href="/blog/index.php">Blog</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Small amount of required custom CSS (minimized) -->
<style>
/* Active link style with red underline - only custom styling we need */
.nav-link.active {
    position: relative;
    color: #d10000 !important;
}

.nav-link.active::after {
    content: '';
    position: absolute;
    width: calc(100% - 1.5rem);
    height: 2px;
    bottom: 0;
    left: 50%;
    background: #d10000;
    transform: translateX(-50%);
    border-radius: 2px;
}

/* Hover effect for nav links */
.nav-link:hover {
    color: #d10000 !important;
}

/* Small spacer for fixed navbar */
body {
    padding-top: 76px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add shadow on scroll
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow');
        } else {
            navbar.classList.remove('shadow');
        }
    });
});
</script> 