<?php
// Check if session is available and start it if possible
if (function_exists('session_start')) {
session_start();
} else {
    // If session is not available, create a simple message storage
    if (!isset($GLOBALS['messages'])) {
        $GLOBALS['messages'] = [];
    }
}

require './includes/db_connect.php';

// ✅ Store success message (if any)
$message = "";
if (function_exists('session_start')) {
$message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
unset($_SESSION['message']); // Clear the session message after displaying
} else {
    $message = isset($GLOBALS['messages']['success']) ? $GLOBALS['messages']['success'] : "";
    unset($GLOBALS['messages']['success']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <link rel="icon" type="image/png" href="/images/sortoutInnovation-icon/sortout-innovation-only-s.gif" />
    <title>Employee Registration - Sortout Innovation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/registration.css">
    
    <style>
        /* Critical navbar visibility fix */
        .navbar .navbar-nav { display: flex !important; }
        .navbar .nav-item { display: block !important; }
        .navbar .nav-link { display: block !important; color: #333 !important; }
        .navbar .navbar-collapse { display: block !important; }
        @media (min-width: 992px) {
            .navbar .navbar-collapse { display: flex !important; }
            .navbar .navbar-nav { flex-direction: row !important; }
        }
        @media (max-width: 991.98px) {
            .navbar .navbar-collapse { display: none !important; }
            .navbar .navbar-collapse.show { display: block !important; }
        }
        
        /* Page specific styles */
        .employee-form-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            padding: 1rem 0;
        }
        
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(239, 68, 68, 0.2);
            backdrop-filter: blur(10px);
            margin: 0 auto;
        }
        
        .form-header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem 1rem;
            text-align: center;
        }
        
        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .employee-form-container {
                padding: 0.5rem;
            }
            
            .form-card {
                border-radius: 15px;
                margin: 0;
            }
            
            .form-header {
                padding: 1rem;
                border-radius: 15px 15px 0 0;
            }
            
            .form-header h1 {
                font-size: 1.75rem !important;
            }
            
            .form-header .w-20 {
                width: 4rem !important;
                height: 4rem !important;
            }
            
            .form-header .w-20 i {
                font-size: 1.5rem !important;
            }
            
            .p-8 {
                padding: 1rem !important;
            }
            
            .space-y-8 > * + * {
                margin-top: 1.5rem !important;
            }
            
            .bg-gray-50, .bg-red-50 {
                padding: 1rem !important;
                border-radius: 1rem !important;
            }
            
            .grid-cols-1.md\:grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
            
            .gap-6 {
                gap: 1rem !important;
            }
            
            .text-lg {
                font-size: 1rem !important;
            }
            
            .px-4.py-3 {
                padding: 0.75rem !important;
            }
            
            .rounded-xl {
                border-radius: 0.75rem !important;
            }
            
            .min-h-\[120px\] {
                min-height: 100px !important;
            }
            
            /* Submit button mobile styles */
            .px-8.py-4 {
                padding: 1rem !important;
            }
            
            .text-lg {
                font-size: 1rem !important;
            }
            
            /* Modal mobile styles */
            #successMessage .max-w-md {
                max-width: 90vw !important;
                margin: 1rem !important;
            }
            
            /* City dropdown mobile styles */
            #cityDropdown {
                max-height: 200px !important;
            }
            
            .city-option {
                padding: 0.75rem !important;
            }
            
            /* File input mobile styles */
            .border-2.border-dashed {
                padding: 1rem !important;
            }
            
            .file\:py-2.file\:px-4 {
                font-size: 0.875rem !important;
            }
            
            /* Resume error mobile styles */
            #resumeError {
                font-size: 0.75rem !important;
                padding: 0.5rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .employee-form-container {
                padding: 0.25rem;
            }
            
            .form-header h1 {
                font-size: 1.5rem !important;
            }
            
            .form-header p {
                font-size: 0.875rem !important;
            }
            
            .p-8 {
                padding: 0.75rem !important;
            }
            
            .bg-gray-50, .bg-red-50 {
                padding: 0.75rem !important;
            }
            
            .px-4.py-3 {
                padding: 0.5rem !important;
            }
            
            .text-sm {
                font-size: 0.75rem !important;
            }
            
            #successMessage .p-8 {
                padding: 1.5rem !important;
            }
            
            #successMessage .text-2xl {
                font-size: 1.25rem !important;
            }
            
            /* Very small screen adjustments */
            select[multiple] {
                font-size: 0.875rem !important;
            }
            
                         .form-group label {
                 font-size: 0.875rem !important;
                 margin-bottom: 0.5rem !important;
             }
             
             /* Touch-friendly improvements */
             input, select, textarea {
                 -webkit-appearance: none;
                 -moz-appearance: none;
                 appearance: none;
                 font-size: 16px !important; /* Prevents zoom on iOS */
             }
             
             button {
                 -webkit-tap-highlight-color: transparent;
                 touch-action: manipulation;
             }
             
             /* Better touch targets */
             .city-option, button, input[type="file"] {
                 min-height: 44px !important;
             }
             
             /* Improve file input on mobile */
             input[type="file"] {
                 padding: 1rem !important;
                 border: 2px dashed #e5e7eb !important;
                 background: #f9fafb !important;
                 text-align: center !important;
             }
             
             /* Better modal positioning */
             #successMessage {
                 padding: 1rem !important;
                 align-items: flex-start !important;
                 padding-top: 2rem !important;
             }
         }
    </style>
</head>
<body>
    <?php 
    // Set navbar parameters for employee registration page
    $currentPage = 'talent';
    $showCreateProfile = false; // Hide create profile button since this is the form
    include 'components/navbar/navbar.php'; 
    ?>

    <!-- ✅ Success Message Modal -->
    <div id="successMessage" 
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]" style="display: none !important; transition: all 0.4s ease-out;">
        <div id="successModalContent" class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform" style="transform: scale(0.95); opacity: 0; transition: all 0.4s ease-out;">
            <div class="text-center">
                <!-- Success Icon -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-5xl text-green-500"></i>
                </div>

                <!-- Success Message -->
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Registration Successful!</h3>
                <p class="text-gray-600 mb-3">Thank you for registering with us. Our HR team will review your application and contact you soon.</p>
                
                <!-- Status Timeline -->
                <div class="flex items-center justify-center mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div class="h-1 w-12 bg-gray-300"></div>
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div class="h-1 w-12 bg-gray-300"></div>
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Status Labels -->
                <div class="grid grid-cols-3 gap-4 text-xs text-gray-500 mb-6">
                    <div>Submitted</div>
                    <div>Under Review</div>
                    <div>Approved</div>
                </div>
                
                <!-- Action Button -->
                <button onclick="closeSuccessMessage()" 
                        class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors duration-200 w-full">
                    Got it!
                </button>
            </div>
        </div>
    </div>

    <!-- Employee Registration Form -->
    <div class="employee-form-container">
        <div class="container mx-auto px-2 sm:px-4">
            <div class="max-w-4xl mx-auto w-full">
                <div class="form-card">
                    <!-- Form Header -->
                    <div class="form-header">
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-briefcase text-white text-3xl"></i>
                        </div>
                        <h1 class="text-3xl font-bold mb-2">Employee Registration</h1>
                        <p class="text-red-100">Join our professional network and advance your career</p>
                    </div>

                    <!-- Form Content -->
                    <div class="p-8">
                        <form id="employeeRegistrationForm" method="POST" action="admin/add_client.php" enctype="multipart/form-data" class="space-y-8">
                            <!-- Hidden field to indicate this is an employee form -->
                            <input type="hidden" name="professional" value="Employee">

                            <!-- Basic Information Section -->
                            <div class="bg-gray-50 rounded-2xl p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-user text-red-500 mr-2"></i>
                                    Basic Information
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-id-card text-gray-400 mr-1"></i>
                                            Full Name *
                                        </label>
                                        <input type="text" id="name" name="name" required 
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm"
                                               placeholder="Enter your full name">
                                    </div>

                                    <!-- Age -->
                                    <div class="form-group">
                                        <label for="age" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-birthday-cake text-gray-400 mr-1"></i>
                                            Age *
                                        </label>
                                        <input type="number" id="age" name="age" required min="18" 
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm"
                                               placeholder="Enter your age">
                                    </div>

                                    <!-- Phone -->
                                    <div class="form-group">
                                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-phone text-gray-400 mr-1"></i>
                                            Phone Number *
                                        </label>
                                        <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}" 
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm"
                                               placeholder="Enter 10-digit phone number">
                                    </div>

                                    <!-- Gender -->
                                    <div class="form-group">
                                        <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-venus-mars text-gray-400 mr-1"></i>
                                            Gender *
                                        </label>
                                        <select id="gender" name="gender" required 
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information -->
                            <div class="bg-red-50 rounded-2xl p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                    Location Information
                                </h3>
                                
                                <!-- City -->
                                <div class="form-group">
                                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-city text-gray-400 mr-1"></i>
                                        City *
                                    </label>
                                    <div class="relative">
                                                                                    <input type="text" 
                                               id="city" 
                                               name="city" 
                                               required 
                                               autocomplete="off"
                                               placeholder="Type your city name (minimum 3 characters)..."
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm">
                                        
                                        <!-- Loading indicator -->
                                        <div id="cityLoading" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                                        </div>
                                        
                                        <!-- Dropdown for city suggestions -->
                                        <div id="cityDropdown" 
                                             class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-xl shadow-lg max-h-60 overflow-y-auto hidden">
                                            <!-- City options will be populated dynamically -->
                                        </div>
                                    </div>
                                    <div id="cityError" class="mt-2 text-sm text-red-600 hidden">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span id="cityErrorText"></span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 bg-white p-2 rounded-lg">
                                        <i class="fas fa-info-circle text-red-500 mr-1"></i>
                                        Start typing to search for cities or enter your city manually
                                    </p>
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="bg-red-50 rounded-2xl p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-briefcase text-red-500 mr-2"></i>
                                    Professional Information
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-user-tie text-gray-400 mr-1"></i>
                                            Role *
                                        </label>
                                        <select id="role" name="role" required
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm">
                                            <option value="">Select Role</option>
                                            <option value="General Manager (GM)">General Manager (GM)</option>
                                            <option value="Business Development Manager (BDM)">Business Development Manager (BDM)</option>
                                            <option value="Project Manager">Project Manager</option>
                                            <option value="Human Resources Manager (HR Manager)">Human Resources Manager (HR Manager)</option>
                                            <option value="Talent Acquisition Manager">Talent Acquisition Manager</option>
                                            <option value="Recruitment Specialist">Recruitment Specialist</option>
                                            <option value="Sales Manager">Sales Manager</option>
                                            <option value="Marketing Manager">Marketing Manager</option>
                                            <option value="Digital Marketing Manager">Digital Marketing Manager</option>
                                            <option value="Social Media Manager">Social Media Manager</option>
                                            <option value="Brand Manager">Brand Manager</option>
                                            <option value="Public Relations Manager">Public Relations Manager</option>
                                            <option value="Content Marketing Manager">Content Marketing Manager</option>
                                            <option value="Financial Analyst">Financial Analyst</option>
                                            <option value="Investment Banker">Investment Banker</option>
                                            <option value="Chartered Accountant (CA)">Chartered Accountant (CA)</option>
                                            <option value="Risk Manager">Risk Manager</option>
                                            <option value="Wealth Manager">Wealth Manager</option>
                                            <option value="Software Engineer">Software Engineer</option>
                                            <option value="Data Scientist">Data Scientist</option>
                                            <option value="Cloud Architect">Cloud Architect</option>
                                            <option value="Cyber Security Analyst">Cyber Security Analyst</option>
                                            <option value="AI & Machine Learning Engineer">AI & Machine Learning Engineer</option>
                                            <option value="IT Manager">IT Manager</option>
                                            <option value="Web Developer">Web Developer</option>
                                            <option value="UI/UX Designer">UI/UX Designer</option>
                                            <option value="Product Manager">Product Manager</option>
                                            <option value="Operations Manager">Operations Manager</option>
                                            <option value="Supply Chain Manager">Supply Chain Manager</option>
                                            <option value="Logistics Manager">Logistics Manager</option>
                                            <option value="Quality Assurance Manager">Quality Assurance Manager</option>
                                            <option value="Compliance Manager">Compliance Manager</option>
                                            <option value="Legal Advisor">Legal Advisor</option>
                                            <option value="Corporate Lawyer">Corporate Lawyer</option>
                                            <option value="Judge/Magistrate">Judge/Magistrate</option>
                                            <option value="Doctor">Doctor</option>
                                            <option value="Pharmacist">Pharmacist</option>
                                            <option value="Physiotherapist">Physiotherapist</option>
                                            <option value="Dietitian/Nutritionist">Dietitian/Nutritionist</option>
                                            <option value="Psychologist">Psychologist</option>
                                            <option value="Civil Engineer">Civil Engineer</option>
                                            <option value="Mechanical Engineer">Mechanical Engineer</option>
                                            <option value="Electrical Engineer">Electrical Engineer</option>
                                            <option value="Robotics Engineer">Robotics Engineer</option>
                                            <option value="Aerospace Engineer">Aerospace Engineer</option>
                                            <option value="Professor/Lecturer">Professor/Lecturer</option>
                                            <option value="School Principal">School Principal</option>
                                            <option value="Corporate Trainer">Corporate Trainer</option>
                                            <option value="Educational Consultant">Educational Consultant</option>
                                            <option value="Film Director">Film Director</option>
                                            <option value="Actor/Actress">Actor/Actress</option>
                                            <option value="Content Creator">Content Creator</option>
                                            <option value="Journalist">Journalist</option>
                                            <option value="Video Editor">Video Editor</option>
                                            <option value="Photographer">Photographer</option>
                                            <option value="Event Planner">Event Planner</option>
                                            <option value="Interior Designer">Interior Designer</option>
                                            <option value="Fashion Designer">Fashion Designer</option>
                                            <option value="Graphic Designer">Graphic Designer</option>
                                            <option value="Customer Support Executive">Customer Support Executive</option>
                                            <option value="Telecaller">Telecaller</option>
                                            <option value="Office Administrator">Office Administrator</option>
                                            <option value="Executive Assistant">Executive Assistant</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="experience" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-clock text-gray-400 mr-1"></i>
                                            Years of Experience
                                        </label>
                                        <input type="number" id="experience" name="experience" min="0" 
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm"
                                               placeholder="Enter years of experience">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-6 mt-6">
                                    <div class="form-group">
                                        <label for="current_salary" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-rupee-sign text-gray-400 mr-1"></i>
                                            Current Salary (₹)
                                        </label>
                                        <input type="text" id="current_salary" name="current_salary" placeholder="e.g. 50000" 
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm">
                                        <p class="mt-2 text-sm text-gray-500 bg-white p-2 rounded-lg">
                                            <i class="fas fa-info-circle text-red-500 mr-1"></i>
                                            Enter your current monthly salary in INR
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Resume Upload Section -->
                            <div class="bg-red-50 rounded-2xl p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-file-upload text-red-500 mr-2"></i>
                                    Resume Upload
                                </h3>

                                <!-- Resume Upload Field -->
                                <div class="form-group">
                                    <label for="resume" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-file-pdf text-gray-400 mr-1"></i>
                                        Resume/CV *
                                    </label>
                                    <div class="relative">
                                        <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required
                                               class="w-full px-4 py-3 rounded-xl border-2 border-dashed border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white
                                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold 
                                                      file:bg-gradient-to-r file:from-red-500 file:to-red-600 file:text-white 
                                                      hover:file:from-red-600 hover:file:to-red-700 file:transition-all file:duration-200">
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 bg-white p-2 rounded-lg">
                                        <i class="fas fa-info-circle text-red-500 mr-1"></i>
                                        Please upload your resume in PDF, DOC, or DOCX format (max 5MB)
                                    </p>
                                    <div id="resumeError" class="mt-2 text-sm text-red-600 hidden bg-red-50 p-2 rounded-lg"></div>
                                </div>
                            </div>

                            <!-- Profile Image -->
                            <div class="bg-red-50 rounded-2xl p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-camera text-red-500 mr-2"></i>
                                    Profile Image
                                </h3>
                                <div class="form-group">
                                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-camera text-gray-400 mr-1"></i>
                                        Profile Image *
                                    </label>
                                    <div class="relative">
                                        <input type="file" id="image" name="image" accept="image/*" required
                                               class="w-full px-4 py-3 rounded-xl border-2 border-dashed border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white
                                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold 
                                                      file:bg-gradient-to-r file:from-red-500 file:to-red-600 file:text-white 
                                                      hover:file:from-red-600 hover:file:to-red-700 file:transition-all file:duration-200">
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 bg-white p-2 rounded-lg">
                                        <i class="fas fa-info-circle text-red-500 mr-1"></i>
                                        Please upload a clear profile picture (9:16 aspect ratio recommended)
                                    </p>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="bg-red-50 rounded-2xl p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-red-500 mr-2"></i>
                                    Additional Information
                                </h3>
                                
                                <!-- Languages -->
                                <div class="form-group">
                                    <label for="languages" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-language text-gray-400 mr-1"></i>
                                        Languages Known *
                                    </label>
                                    <select id="languages" name="languages[]" multiple required 
                                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 bg-white shadow-sm min-h-[120px]">
                                        <option value="English">English</option>
                                        <option value="Hindi">Hindi</option>
                                        <option value="Bengali">Bengali</option>
                                        <option value="Telugu">Telugu</option>
                                        <option value="Tamil">Tamil</option>
                                        <option value="Marathi">Marathi</option>
                                        <option value="Gujarati">Gujarati</option>
                                        <option value="Kannada">Kannada</option>
                                        <option value="Malayalam">Malayalam</option>
                                        <option value="Punjabi">Punjabi</option>
                                    </select>
                                    <p class="mt-2 text-sm text-gray-500 bg-white p-2 rounded-lg">
                                        <i class="fas fa-info-circle text-red-500 mr-1"></i>
                                        Hold Ctrl/Cmd to select multiple languages
                                    </p>
                                </div>
                            </div>

                            <!-- Submit Button Section -->
                            <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-2xl p-6 mt-8">
                                <div class="form-group">
                                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        <span>Submit Registration</span>
                                        <div class="loading-spinner ml-2 hidden">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const employeeForm = document.getElementById('employeeRegistrationForm');
        
        if (employeeForm) {
            let isSubmitting = false;
            
            employeeForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (isSubmitting) {
                    console.log('Form is already being submitted, ignoring...');
                    return false;
                }
                
                // Validate required fields
                const requiredFields = ['name', 'age', 'phone', 'gender', 'city', 'role', 'resume', 'image'];
                let isValid = true;
                
                for (const fieldName of requiredFields) {
                    const field = document.querySelector(`[name="${fieldName}"]`);
                    if (!field || (field.type === 'file' && field.files.length === 0) || (!field.value && field.type !== 'file')) {
                        isValid = false;
                        if (field) {
                            field.focus();
                            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        alert(`Please fill in the required field: ${fieldName}`);
                        break;
                    }
                }
                
                if (!isValid) {
                    return false;
                }
                
                // Set submitting flag
                isSubmitting = true;
                
                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                const buttonText = submitButton.querySelector('span');
                const loadingSpinner = submitButton.querySelector('.loading-spinner');
                
                submitButton.disabled = true;
                buttonText.textContent = 'Submitting...';
                if (loadingSpinner) {
                    loadingSpinner.classList.remove('hidden');
                }
                
                // Create FormData object for AJAX submission
                const formData = new FormData(this);
                
                try {
                    const response = await fetch('admin/add_client.php', {
                        method: 'POST',
                        body: formData
                    });

                    let result;
                    if (response.ok && response.status === 200) {
                        const text = await response.text();
                        if (!text || text.trim() === '') {
                            result = { status: 'success' };
                        } else {
                            try {
                                result = JSON.parse(text);
                            } catch (e) {
                                result = { status: 'error', message: 'Unknown server error' };
                            }
                        }
                    } else {
                        result = { status: 'error', message: 'Server error: ' + response.status };
                    }
                    
                    console.log('Submission result:', result);

                    if (result.status === 'success') {
                        // Show success message
                        const successMessage = document.getElementById('successMessage');
                        if (successMessage) {
                            console.log('Showing success message modal');
                            successMessage.style.display = 'flex';
                            successMessage.style.opacity = '0';
                            document.body.classList.add('modal-open');
                            
                            setTimeout(() => {
                                const modalContent = document.getElementById('successModalContent');
                                if (modalContent && successMessage) {
                                    modalContent.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                                    successMessage.style.transition = 'all 0.4s ease-out';
                                    
                                    modalContent.style.transform = 'scale(1)';
                                    modalContent.style.opacity = '1';
                                    successMessage.style.opacity = '1';
                                }
                            }, 50);
                        }

                        // Reset the form
                        this.reset();
                    } else {
                        alert(result.message || 'Error submitting form. Please try again.');
                    }
                } catch (error) {
                    console.error('Form submission error:', error);
                    alert('Error submitting form. Please try again.');
                } finally {
                    isSubmitting = false;
                    submitButton.disabled = false;
                    buttonText.textContent = 'Submit Registration';
                    if (loadingSpinner) {
                        loadingSpinner.classList.add('hidden');
                    }
                }
                
                return false;
            });
        }
        
        // Mobile keyboard and scroll handling
        function handleMobileKeyboard() {
            // Prevent viewport zoom on input focus for iOS
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    // Scroll element into view with offset for mobile keyboards
                    setTimeout(() => {
                        const rect = this.getBoundingClientRect();
                        const isInViewport = rect.top >= 0 && rect.bottom <= window.innerHeight;
                        
                        if (!isInViewport) {
                            this.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'center',
                                inline: 'nearest'
                            });
                        }
                    }, 300); // Wait for keyboard animation
                });
                
                // Handle mobile select dropdowns
                if (input.tagName === 'SELECT' && input.hasAttribute('multiple')) {
                    input.addEventListener('touchstart', function(e) {
                        // Improve touch handling for multi-select
                        e.stopPropagation();
                    });
                }
            });
            
            // Handle orientation changes
            window.addEventListener('orientationchange', function() {
                setTimeout(() => {
                    // Re-adjust viewport after orientation change
                    window.scrollTo(0, window.scrollY + 1);
                    window.scrollTo(0, window.scrollY - 1);
                }, 500);
            });
            
            // Improve file input handling on mobile
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const fileName = this.files[0]?.name;
                    if (fileName) {
                        // Show file name on mobile
                        const label = this.previousElementSibling || this.parentElement.querySelector('label');
                        if (label) {
                            const originalText = label.textContent;
                            label.innerHTML = `${originalText} <span style="color: #059669; font-size: 0.875rem;">(${fileName})</span>`;
                        }
                    }
                });
            });
        }
        
        // Initialize mobile enhancements
        if (window.innerWidth <= 768) {
            handleMobileKeyboard();
        }
        
        // Function to close success message
        window.closeSuccessMessage = function() {
            const successMessage = document.getElementById('successMessage');
            const modalContent = document.getElementById('successModalContent');
            if (successMessage && modalContent) {
                modalContent.style.transform = 'scale(0.85)';
                modalContent.style.opacity = '0';
                modalContent.style.transition = 'all 0.4s cubic-bezier(0.4, 0.0, 0.2, 1)';
                
                successMessage.style.transition = 'all 0.4s ease-out';
                successMessage.style.opacity = '0';
                
                setTimeout(() => {
                    successMessage.style.display = 'none';
                    successMessage.style.opacity = '';
                    modalContent.style.transition = '';
                    document.body.classList.remove('modal-open');
                }, 400);
            }
        }
    });
    </script>

    <!-- City Search Script -->
    <script>
    // Dynamic City Search using GeoDB Cities API (same as original)
    document.addEventListener('DOMContentLoaded', function() {
        const cityInput = document.getElementById('city');
        const cityDropdown = document.getElementById('cityDropdown');
        const cityLoading = document.getElementById('cityLoading');
        const cityError = document.getElementById('cityError');
        const cityErrorText = document.getElementById('cityErrorText');
        
        if (!cityInput || !cityDropdown || !cityLoading) {
            console.log('City search elements not found');
            return;
        }
        
        // API configuration
        const API_KEY = '47947e74c2mshca12d801e45fd20p1266f6jsn338754475961';
        const API_HOST = 'wft-geo-db.p.rapidapi.com';
        const API_URL = 'https://wft-geo-db.p.rapidapi.com/v1/geo/cities';
        
        let debounceTimer;
        let currentRequest;
        let isApiWorking = true;
        let rateLimitHit = false;
        let cooldownUntil = 0;
        let requestCount = 0;
        let lastMinuteReset = Date.now();
        
        const MAX_REQUESTS_PER_MINUTE = 3;
        const RATE_LIMIT_COOLDOWN = 180000;
        const DEBOUNCE_DELAY = 800;
        
        function showError(message) {
            if (cityError && cityErrorText) {
                cityErrorText.textContent = message;
                cityError.classList.remove('hidden');
                setTimeout(() => {
                    hideError();
                }, 5000);
            }
        }
        
        function hideError() {
            if (cityError) {
                cityError.classList.add('hidden');
            }
        }
        
        function checkRateLimit() {
            const now = Date.now();
            
            if (rateLimitHit && now < cooldownUntil) {
                const remainingMinutes = Math.ceil((cooldownUntil - now) / 60000);
                showError(`City search is temporarily limited. Please try again in ${remainingMinutes} minute(s) or type manually.`);
                return false;
            }
            
            if (rateLimitHit && now >= cooldownUntil) {
                rateLimitHit = false;
                requestCount = 0;
                lastMinuteReset = now;
            }
            
            if (now - lastMinuteReset >= 60000) {
                requestCount = 0;
                lastMinuteReset = now;
            }
            
            if (requestCount >= MAX_REQUESTS_PER_MINUTE) {
                rateLimitHit = true;
                cooldownUntil = now + RATE_LIMIT_COOLDOWN;
                showError('Too many city searches. Please wait a few minutes or type your city manually.');
                return false;
            }
            
            return true;
        }
        
        async function searchCities(query) {
            if (query.length < 2) {
                hideCityDropdown();
                hideError();
                return;
            }
            
            if (!isApiWorking) {
                return;
            }
            
            if (!checkRateLimit()) {
                hideCityDropdown();
                return;
            }
            
            if (currentRequest) {
                currentRequest.abort();
            }
            
            requestCount++;
            showLoading();
            hideError();
            
            try {
                const controller = new AbortController();
                currentRequest = controller;
                
                const url = `${API_URL}?countryIds=IN&namePrefix=${encodeURIComponent(query)}&limit=10`;
                
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-RapidAPI-Key': API_KEY,
                        'X-RapidAPI-Host': API_HOST
                    },
                    signal: controller.signal
                });
                
                if (!response.ok) {
                    throw new Error(`Server returned ${response.status}`);
                }
                
                const data = await response.json();
                
                if (controller.signal.aborted) {
                    return;
                }
                
                hideLoading();
                displayCities(data.data || []);
                
            } catch (error) {
                hideLoading();
                
                if (error.name === 'AbortError') {
                    return;
                }
                
                console.error('Error fetching cities:', error);
                
                if (error.message.includes('429')) {
                    rateLimitHit = true;
                    cooldownUntil = Date.now() + RATE_LIMIT_COOLDOWN;
                    showError('City search limit reached. Please wait a few minutes or type your city manually.');
                } else if (error.message.includes('500') || error.message.includes('502') || error.message.includes('503')) {
                    showError('City search service is temporarily down. Please type your city manually.');
                } else if (error.message.includes('403') || error.message.includes('401')) {
                    isApiWorking = false;
                    showError('City search is unavailable. Please type your city manually.');
                } else {
                    showError('Unable to search cities. Please check your internet connection or type manually.');
                }
                
                hideCityDropdown();
            }
        }
        
        function displayCities(cities) {
            if (cities.length === 0) {
                const currentValue = cityInput.value.trim();
                cityDropdown.innerHTML = `
                    <div class="px-4 py-3 text-sm text-gray-500 border-b border-gray-100">
                        <i class="fas fa-search mr-2"></i>
                        No cities found for "${currentValue}". 
                        <span class="text-red-600">You can continue typing your city name manually.</span>
                    </div>
                `;
                showCityDropdown();
                return;
            }
            
            let html = '';
            
            const currentValue = cityInput.value.trim();
            if (currentValue.length >= 2) {
                html += `
                    <div class="city-option px-4 py-3 cursor-pointer hover:bg-red-50 border-b border-gray-100 transition-colors duration-200 bg-red-25" 
                         data-city="${currentValue}" 
                         data-manual="true">
                        <div class="flex items-center">
                            <i class="fas fa-edit text-red-500 mr-3"></i>
                            <div>
                                <div class="font-medium text-red-900">Use "${currentValue}"</div>
                                <div class="text-sm text-red-600">Enter manually</div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            cities.forEach(city => {
                const cityName = city.name;
                const region = city.region ? `, ${city.region}` : '';
                const country = city.country ? `, ${city.country}` : '';
                
                html += `
                    <div class="city-option px-4 py-3 cursor-pointer hover:bg-gray-50 border-b border-gray-100 transition-colors duration-200" 
                         data-city="${cityName}">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 mr-3"></i>
                            <div>
                                <div class="font-medium text-gray-900">${cityName}</div>
                                ${region ? `<div class="text-sm text-gray-500">${region.substring(2)}${country}</div>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            cityDropdown.innerHTML = html;
            showCityDropdown();
            
            const cityOptions = cityDropdown.querySelectorAll('.city-option');
            cityOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const cityName = this.getAttribute('data-city');
                    selectCity(cityName);
                });
            });
        }
        
        function selectCity(cityName) {
            cityInput.value = cityName;
            hideCityDropdown();
            cityInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
        
        function showLoading() {
            cityLoading.classList.remove('hidden');
        }
        
        function hideLoading() {
            cityLoading.classList.add('hidden');
        }
        
        function showCityDropdown() {
            cityDropdown.classList.remove('hidden');
        }
        
        function hideCityDropdown() {
            cityDropdown.classList.add('hidden');
        }
        
        function debouncedSearch(query) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchCities(query);
            }, DEBOUNCE_DELAY);
        }
        
        cityInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            hideError();
            
            if (query.length >= 3 && isApiWorking && !rateLimitHit) {
                debouncedSearch(query);
            } else if (query.length < 2) {
                hideCityDropdown();
            } else if (query.length >= 2 && (rateLimitHit || !isApiWorking)) {
                displayCities([]);
            }
        });
        
        cityInput.addEventListener('focus', function(e) {
            const query = e.target.value.trim();
            hideError();
            
            if (query.length >= 3 && isApiWorking && !rateLimitHit) {
                debouncedSearch(query);
            } else if (query.length >= 2 && (rateLimitHit || !isApiWorking)) {
                displayCities([]);
            }
        });
        
        cityInput.addEventListener('blur', function(e) {
            const value = e.target.value.trim();
            if (value.length >= 2) {
                hideError();
            }
            setTimeout(() => {
                hideCityDropdown();
            }, 200);
        });
        
        document.addEventListener('click', function(e) {
            if (!cityInput.contains(e.target) && !cityDropdown.contains(e.target)) {
                hideCityDropdown();
            }
        });
    });
    </script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 