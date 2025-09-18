<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Momo Restaurant</title>

    <!-- Modern CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- Dropify CSS for file uploads -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">

    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- Custom Modern Styles -->
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #00d4aa;
            --warning-color: #f093fb;
            --danger-color: #ff6b6b;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --sidebar-width: 280px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Modern Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .sidebar-header h3 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header h3 {
            font-size: 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu .menu-item {
            margin: 5px 15px;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-menu .menu-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu .menu-link:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu .menu-link.active {
            background: linear-gradient(135deg, var(--success-color), var(--primary-color));
            color: white;
            box-shadow: 0 5px 15px rgba(0, 212, 170, 0.3);
        }

        .sidebar-menu .menu-icon {
            width: 24px;
            margin-right: 15px;
            text-align: center;
            font-size: 1.2rem;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed+.main-content {
            margin-left: 80px;
        }

        /* Modern Topbar */
        .topbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: var(--light-color);
            transform: scale(1.1);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .preview-toggle {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .preview-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* Content Area */
        .content-wrapper {
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            min-height: calc(100vh - var(--topbar-height));
        }

        /* Modern Cards */
        .modern-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .modern-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 20px 30px;
            font-weight: 600;
        }

        /* Live Preview Panel */
        .preview-panel {
            position: fixed;
            top: var(--topbar-height);
            right: -50%;
            width: 50%;
            height: calc(100vh - var(--topbar-height));
            background: white;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            z-index: 999;
            border-left: 1px solid rgba(0, 0, 0, 0.1);
        }

        .preview-panel.active {
            right: 0;
        }

        .preview-header {
            background: linear-gradient(135deg, var(--success-color), var(--primary-color));
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-content {
            height: calc(100% - 80px);
            overflow-y: auto;
            padding: 20px;
        }

        /* Modern Alerts */
        .modern-alert {
            border: none;
            border-radius: 15px;
            padding: 20px 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .modern-alert.alert-success {
            background: linear-gradient(135deg, var(--success-color), #00b894);
            color: white;
        }

        .modern-alert.alert-danger {
            background: linear-gradient(135deg, var(--danger-color), #e84393);
            color: white;
        }

        /* Modern Buttons */
        .btn-modern {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-modern:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }

        .btn-modern:hover:before {
            left: 100%;
        }

        /* Dropify Custom Styling */
        .dropify-wrapper {
            border-radius: 15px;
            border: 2px dashed var(--primary-color);
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .dropify-wrapper:hover {
            border-color: var(--secondary-color);
            background: #fff;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }

        .dropify-wrapper .dropify-message {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
            font-weight: 600;
        }

        .dropify-wrapper .dropify-message p {
            margin: 0;
            font-size: 16px;
        }

        .dropify-wrapper .dropify-preview .dropify-render img {
            border-radius: 10px;
        }

        .dropify-wrapper .dropify-clear {
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .dropify-wrapper .dropify-clear:hover {
            background: #ff5252;
            transform: scale(1.1);
        }

        .btn-primary.btn-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-success.btn-modern {
            background: linear-gradient(135deg, var(--success-color), #00b894);
            box-shadow: 0 5px 15px rgba(0, 212, 170, 0.3);
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100px;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-header h3 {
                font-size: 0.9rem;
                writing-mode: vertical-rl;
                text-orientation: mixed;
            }

            .sidebar-menu .menu-link {
                flex-direction: column;
                padding: 15px 10px;
                text-align: center;
                min-height: 70px;
                justify-content: center;
            }

            .sidebar-menu .menu-icon {
                margin-right: 0;
                margin-bottom: 5px;
                font-size: 1.1rem;
            }

            .sidebar-menu .menu-text {
                font-size: 0.7rem;
                line-height: 1.2;
                word-break: break-word;
                display: block !important;
            }

            .preview-panel {
                width: 100%;
                right: -100%;
            }

            .topbar {
                padding: 0 15px;
            }

            .content-wrapper {
                padding: 15px;
            }

            /* Reduce animations on mobile */
            .sidebar-menu .menu-link:hover {
                transform: none;
            }

            .modern-card:hover {
                transform: none;
            }

            /* Mobile overlay for sidebar */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-utensils me-2"></i><span class="sidebar-text">Momo Admin</span></h3>
        </div>
        <nav class="sidebar-menu">
            <div class="menu-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.settings') }}"
                    class="menu-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog menu-icon"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.jumbotron') }}"
                    class="menu-link {{ request()->routeIs('admin.jumbotron') ? 'active' : '' }}">
                    <i class="fas fa-server menu-icon"></i>
                    <span class="menu-text">Jumbotron</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.about') }}"
                    class="menu-link {{ request()->routeIs('admin.about') ? 'active' : '' }}">
                    <i class="fas fa-folder-open menu-icon"></i>
                    <span class="menu-text">About</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.why_choose_us') }}"
                    class="menu-link {{ request()->routeIs('admin.why_choose_us') ? 'active' : '' }}">
                    <i class="fas fa-folder-open menu-icon"></i>
                    <span class="menu-text">Why Choose Us</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.customer_testimonials') }}"
                    class="menu-link {{ request()->routeIs('admin.customer_testimonials') ? 'active' : '' }}">
                    <i class="fas fa-folder-open menu-icon"></i>
                    <span class="menu-text">Customer Testimonials</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.specialOffers') }}"
                    class="menu-link {{ request()->routeIs('admin.specialOffers') ? 'active' : '' }}">
                    <i class="fas fa-fire menu-icon"></i>
                    <span class="menu-text">Special Offers</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.products') }}"
                    class="menu-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="fas fa-box menu-icon"></i>
                    <span class="menu-text">Products</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.products.create') }}" class="menu-link">
                    <i class="fas fa-plus menu-icon"></i>
                    <span class="menu-text">Add Product</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('home') }}" target="_blank" class="menu-link">
                    <i class="fas fa-external-link-alt menu-icon"></i>
                    <span class="menu-text">View Website</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="/api/products" target="_blank" class="menu-link">
                    <i class="fas fa-code menu-icon"></i>
                    <span class="menu-text">API Endpoint</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left d-flex align-items-center">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="ms-3 mb-0 text-dark">@yield('page-title', 'Admin Panel')</h4>
            </div>
            <div class="topbar-actions">
                <button class="btn preview-toggle" id="previewToggle">
                    <i class="fas fa-eye me-2"></i>Live Preview
                </button>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i
                                    class="fas fa-sign-out-alt me-2"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="modern-alert alert-success animate__animated animate__fadeInDown" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="modern-alert alert-danger animate__animated animate__fadeInDown" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            <div data-aos="fade-up">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Live Preview Panel -->
    <div class="preview-panel" id="previewPanel">
        <div class="preview-header">
            <h5><i class="fas fa-eye me-2"></i>Live Preview</h5>
            <button class="btn btn-sm btn-light" id="closePreview">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="preview-content">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Loading preview...</p>
            </div>
            <iframe id="previewFrame" src="{{ route('home') }}"
                style="width: 100%; height: 100%; border: none; display: none;"></iframe>
        </div>
    </div>

    <!-- Modern JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Dropify JS for file uploads -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <!-- Custom Admin JS -->
    <script>
        $(document).ready(function() {
            // Initialize AOS only on desktop for performance
            if (window.innerWidth > 768) {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out'
                });
            }

            // Improved Sidebar Toggle
            const isMobile = window.innerWidth <= 768;

            $('#sidebarToggle').click(function(e) {
                e.preventDefault();
                const sidebar = $('#sidebar');
                const overlay = $('#sidebarOverlay');

                if (isMobile) {
                    sidebar.toggleClass('active');
                    overlay.toggleClass('active');
                } else {
                    sidebar.toggleClass('collapsed');
                }
            });

            // Close mobile sidebar when clicking overlay
            $('#sidebarOverlay').click(function() {
                $('#sidebar').removeClass('active');
                $(this).removeClass('active');
            });

            // Close mobile sidebar when clicking menu item
            if (isMobile) {
                $('.menu-link').click(function() {
                    $('#sidebar').removeClass('active');
                    $('#sidebarOverlay').removeClass('active');
                });
            }

            // Optimized Preview Panel Toggle
            let previewLoaded = false;
            $('#previewToggle').click(function() {
                const panel = $('#previewPanel');
                const frame = $('#previewFrame');

                if (panel.hasClass('active')) {
                    panel.removeClass('active');
                } else {
                    panel.addClass('active');

                    if (!previewLoaded) {
                        setTimeout(function() {
                            frame.show();
                            $('.spinner-border').parent().hide();
                            frame.attr('src', frame.attr('src'));
                            previewLoaded = true;
                        }, 300);
                    }
                }
            });

            $('#closePreview').click(function() {
                $('#previewPanel').removeClass('active');
            });

            // Auto-hide alerts
            setTimeout(function() {
                $('.modern-alert').fadeOut('slow');
            }, 5000);

            // Optimized dropdown handling
            $('.dropdown-toggle').on('click', function(e) {
                e.stopPropagation();
                const $dropdown = $(this).next('.dropdown-menu');
                $('.dropdown-menu').not($dropdown).removeClass('show');
                $dropdown.toggleClass('show');
            });

            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // Reduce AJAX loading for mobile
            if (!isMobile) {
                $(document).ajaxStart(function() {
                    $('#loadingOverlay').fadeIn();
                }).ajaxStop(function() {
                    $('#loadingOverlay').fadeOut();
                });
            }

            // Optimized form confirmations
            $('form[data-confirm]').submit(function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: $(form).data('confirm') || 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#667eea',
                    cancelButtonColor: '#ff6b6b',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Refresh preview function
            $(document).on('productUpdated', function() {
                if (previewLoaded) {
                    const frame = $('#previewFrame');
                    if (frame.is(':visible')) {
                        frame.attr('src', frame.attr('src'));
                    }
                }
            });

            // Disable animations on mobile for performance
            if (!isMobile) {
                $('.modern-card').hover(
                    function() {
                        $(this).addClass('animate__animated animate__pulse');
                    },
                    function() {
                        $(this).removeClass('animate__animated animate__pulse');
                    }
                );
            }

            // Handle window resize
            $(window).resize(function() {
                if (window.innerWidth > 768) {
                    $('#sidebar').removeClass('active');
                    $('#sidebarOverlay').removeClass('active');
                }
            });
        });

        // Global function to show success message
        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: message,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }

        // Global function to show error message
        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message,
                confirmButtonColor: '#667eea'
            });
        }

        // Function to refresh preview
        function refreshPreview() {
            const frame = $('#previewFrame');
            if (frame.is(':visible')) {
                frame.attr('src', frame.attr('src'));
                showSuccess('Preview refreshed!');
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
