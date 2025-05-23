<?php
/**
 * Reusable Footer Component
 * Uses Bootstrap 5 classes with minimal custom CSS
 */
?>

<footer class="footer-section bg-dark text-white py-5">
  <div class="container">
    <div class="row">
      <!-- Column 1: Company Info -->
      <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
        <div class="text-center text-md-start">
          <img src="/images/sortoutInnovation-icon/Sortout innovation.jpg" alt="Sortout Innovation" class="img-fluid mb-3" style="max-width: 180px;">
          <p>Empowering businesses with top-notch solutions in digital, IT, and business services.</p>
        </div>
      </div>

      <!-- Column 2: Quick Links -->
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h5 class="mb-3 text-light">Quick Links</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="/" class="text-decoration-none link-light">Home</a></li>
          <li class="mb-2"><a href="/pages/about-page/about.html" class="text-decoration-none link-light">About Us</a></li>
          <li class="mb-2"><a href="/pages/contact-page/contact-page.html" class="text-decoration-none link-light">Contact</a></li>
          <li class="mb-2"><a href="/pages/career.html" class="text-decoration-none link-light">Careers</a></li>
          <li class="mb-2"><a href="/pages/our-services-page/service.html" class="text-decoration-none link-light">Services</a></li>
          <li class="mb-2"><a href="/blog/index.php" class="text-decoration-none link-light">Blog</a></li>
          <li class="mb-2"><a href="/auth/register.php" class="text-decoration-none link-light">Register</a></li>
          <li class="mb-2"><a href="/modal_agency.php" class="text-decoration-none link-light">Talent</a></li>
        </ul>
      </div>

      <!-- Column 3: Our Services -->
      <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
        <h5 class="mb-3 text-light">Our Services</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="/pages/services/socialMediaInfluencers.html" class="text-decoration-none link-light">Digital Marketing</a></li>
          <li class="mb-2"><a href="/pages/services/itServices.html" class="text-decoration-none link-light">IT Support</a></li>
          <li class="mb-2"><a href="/pages/services/caServices.html" class="text-decoration-none link-light">CA Services</a></li>
          <li class="mb-2"><a href="/pages/services/hrServices.html" class="text-decoration-none link-light">HR Services</a></li>
          <li class="mb-2"><a href="/pages/services/courierServices.html" class="text-decoration-none link-light">Courier Services</a></li>
          <li class="mb-2"><a href="/pages/services/shipping.html" class="text-decoration-none link-light">Shipping & Fulfillment</a></li>
          <li class="mb-2"><a href="/pages/services/event-managementServices.html" class="text-decoration-none link-light">Event Management</a></li>
          <li class="mb-2"><a href="/pages/services/designAndCreative.html" class="text-decoration-none link-light">Web & App Development</a></li>
        </ul>
      </div>

      <!-- Column 4: Contact Info -->
      <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
        <h5 class="mb-3 text-light">Contact Us</h5>
        <ul class="list-unstyled">
          <li class="mb-2">
            <i class="fas fa-phone me-2 text-danger"></i>
            <a href="tel:+919818559036" class="text-decoration-none link-light">+91 9818559036</a>
          </li>
          <li class="mb-2">
            <i class="fas fa-envelope me-2 text-danger"></i>
            <a href="mailto:info@sortoutinnovation.com" class="text-decoration-none link-light">info@sortoutinnovation.com</a>
          </li>
          <li class="mb-2">
            <i class="fas fa-map-marker-alt me-2 text-danger"></i> 
            <span>Spaze i-Tech Park, Gurugram, India</span>
          </li>
        </ul>
      </div>

      <!-- Column 5: Social Media -->
      <div class="col-lg-2 col-md-6">
        <h5 class="mb-3 text-light">Follow Us</h5>
        <div class="social-icons d-flex gap-2">
          <a href="https://www.facebook.com/profile.php?id=61556452066209" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://youtu.be/tw-xk-Pb-zA?si=QMTwuvhEuTegpqDr" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
            <i class="fab fa-youtube"></i>
          </a>
          <a href="https://www.linkedin.com/company/sortout-innovation/" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="https://www.instagram.com/sortout_innovation" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
            <i class="fab fa-instagram"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Copyright & Legal Links -->
    <div class="mt-4 pt-3 border-top border-secondary">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <p class="mb-md-0">&copy; 2025 Sortout Innovation. All Rights Reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="/privacy-policy" class="text-decoration-none link-light">Privacy Policy</a></li>
            <li class="list-inline-item ms-3"><a href="/terms" class="text-decoration-none link-light">Terms & Conditions</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Floating Social Media Bar -->
<div class="floating-social-bar d-none d-md-block">
  <a href="https://www.facebook.com/profile.php?id=61556452066209" target="_blank" rel="noopener" 
     class="btn btn-danger btn-sm rounded-circle mb-2">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a href="https://www.instagram.com/sortout_innovation" target="_blank" rel="noopener" 
     class="btn btn-danger btn-sm rounded-circle mb-2">
    <i class="fab fa-instagram"></i>
  </a>
  <a href="https://www.linkedin.com/company/sortout-innovation/" target="_blank" rel="noopener" 
     class="btn btn-danger btn-sm rounded-circle mb-2">
    <i class="fab fa-linkedin-in"></i>
  </a>
  <a href="https://youtu.be/tw-xk-Pb-zA?si=QMTwuvhEuTegpqDr" target="_blank" rel="noopener" 
     class="btn btn-danger btn-sm rounded-circle mb-2">
    <i class="fab fa-youtube"></i>
  </a>
</div>

<!-- Floating WhatsApp Button -->
<div class="position-fixed bottom-0 end-0 m-4 z-index-1000">
  <a href="https://wa.me/919818559036" target="_blank" rel="noopener" 
     class="btn btn-success rounded-pill shadow d-flex align-items-center">
    <i class="fab fa-whatsapp me-2 fs-5"></i>
    <span>Contact Us</span>
  </a>
</div>

<style>
/* Minimal custom CSS for floating elements */
.floating-social-bar {
  position: fixed;
  left: 15px;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1000;
  display: flex;
  flex-direction: column;
}

/* Make footer links interactive */
.footer-section a {
  transition: color 0.3s ease;
}

.footer-section a:hover {
  color: #d10000 !important;
}
</style> 