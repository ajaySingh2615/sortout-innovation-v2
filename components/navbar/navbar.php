<?php
/**
 * Reusable Navbar Component
 * Uses Bootstrap 5 classes with minimal custom CSS
 */
?>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap Navbar with modern styling -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="/images/sortoutInnovation-icon/sortout-innovation-only-s.gif" alt="Sortout Innovation" height="45" class="me-2">
            <span class="brand-text d-none d-sm-inline">Sortout Innovation</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark position-relative <?php echo ($currentPage == 'home') ? 'active fw-semibold bg-danger bg-opacity-10 text-danger' : 'fw-medium hover-effect'; ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark position-relative <?php echo ($currentPage == 'about') ? 'active fw-semibold bg-danger bg-opacity-10 text-danger' : 'fw-medium hover-effect'; ?>" href="/pages/about-page/about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 py-2 rounded-pill text-dark position-relative <?php echo ($currentPage == 'career') ? 'active fw-semibold bg-danger bg-opacity-10 text-danger' : 'fw-medium hover-effect'; ?>" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Career
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg rounded-4 mt-2">
                        <li>
                            <a class="dropdown-item rounded-3 fw-medium py-2 px-3" href="/employee-job/index.php">
                                <i class="fas fa-briefcase me-2 text-danger"></i>
                                Employee Jobs
                            </a>
                        </li>
                        <li><hr class="dropdown-divider mx-3 opacity-25"></li>
                        <li>
                            <a class="dropdown-item rounded-3 fw-medium py-2 px-3" href="/admin/artist-v2/public/index.php">
                                <i class="fas fa-palette me-2 text-danger"></i>
                                Artist Jobs
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark position-relative <?php echo ($currentPage == 'talent') ? 'active fw-semibold bg-danger bg-opacity-10 text-danger' : 'fw-medium hover-effect'; ?>" href="/modal_agency.php">Find Talent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark position-relative <?php echo ($currentPage == 'services') ? 'active fw-semibold bg-danger bg-opacity-10 text-danger' : 'fw-medium hover-effect'; ?>" href="/pages/our-services-page/service.html">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark position-relative <?php echo ($currentPage == 'contact') ? 'active fw-semibold bg-danger bg-opacity-10 text-danger' : 'fw-medium hover-effect'; ?>" href="/pages/contact-page/contact-page.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill text-dark position-relative <?php echo ($currentPage == 'blog') ? 'active fw-semibold bg-danger bg-opacity-10 text-danger' : 'fw-medium hover-effect'; ?>" href="/blog/index.php">Blog</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Modern navbar styling -->
<style>
/* Navbar base style */
.navbar {
    font-family: 'Montserrat', sans-serif;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.95) !important;
}

.navbar.scrolled {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
    background-color: rgba(255, 255, 255, 0.98) !important;
}

/* Brand styling */
.brand-text {
    font-weight: 600;
    background: linear-gradient(45deg, #d10000, #ff4444);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 1.2rem;
}

/* Nav links styling */
.nav-link {
    font-size: 0.95rem;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
}

/* Modern hover effect */
.hover-effect {
    transition: all 0.3s ease;
}

.hover-effect:hover {
    background-color: rgba(209, 0, 0, 0.08);
    color: #d10000 !important;
    transform: translateY(-1px);
}

/* Dropdown enhancements */
.dropdown-menu {
    border-radius: 1rem;
    margin-top: 0.5rem !important;
}

.dropdown-item {
    padding: 0.7rem 1.2rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    margin: 0.2rem;
}

.dropdown-item:hover {
    background-color: rgba(209, 0, 0, 0.08);
    color: #d10000;
    transform: translateX(3px);
}

.dropdown-item:active {
    background-color: rgba(209, 0, 0, 0.12);
    color: #d10000;
}

/* Navbar toggler animation */
.navbar-toggler {
    transition: transform 0.3s ease;
}

.navbar-toggler:hover {
    transform: scale(1.1);
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* Enhanced shadow effect */
.navbar.shadow-custom {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
}

/* Body spacing */
body {
    padding-top: 80px;
}

/* Mobile optimizations */
@media (max-width: 991.98px) {
    .navbar-collapse {
        background: rgba(255, 255, 255, 0.98);
        padding: 1rem;
        border-radius: 1rem;
        margin-top: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .navbar-nav {
        gap: 0.5rem !important;
    }
    
    .nav-item {
        width: 100%;
    }
    
    .nav-link {
        padding: 0.8rem 1.2rem !important;
    }
}

/* Enhanced dropdown styling */
@media (min-width: 992px) {
    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-menu {
        display: block !important;
        margin-top: 20px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        border-radius: 1rem;
    }

    .dropdown:hover .nav-link {
        background-color: rgba(209, 0, 0, 0.08);
        color: #d10000 !important;
    }
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

    adjustBodyPadding();
    window.addEventListener('resize', adjustBodyPadding);

    // Enhanced scroll behavior
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.add('shadow-custom', 'scrolled');
        } else {
            navbar.classList.remove('shadow-custom', 'scrolled');
        }

        // Smart navbar hide/show
        if (window.scrollY > lastScrollY && window.scrollY > 100) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        lastScrollY = window.scrollY;
    });
});
</script> 