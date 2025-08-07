<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin | Perpustakaan SMPN 02 Klakah</title>
    <link rel="icon" href="<?php echo e(asset('AdminLTE-3.2.0/dist/img/smp2.png')); ?>" type="image/png" />
    <style>
        #user-dropdown-menu a,
        #user-dropdown-menu button {
            display: flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        #user-dropdown-menu a:hover,
        #user-dropdown-menu button:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
    body {
    background-color: #343a40;
    }

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')); ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/dist/css/adminlte.min.css')); ?>">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
    
    <!-- Custom Notification Styles -->
    <style>
        /* Notification Dropdown Styles */
        .notification-container {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .notification-item {
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        
        .notification-item:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
        }
        
        .notification-item.unread {
            border-left-color: #007bff;
            background-color: #f8f9fc;
        }
        
        .notification-item.unread::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background-color: #007bff;
            border-radius: 50%;
        }
        
        .notification-item.read {
            border-left-color: #6c757d;
            opacity: 0.8;
        }
        
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .notification-icon.harian {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .notification-icon.tahunan {
            background: linear-gradient(135deg, #17a2b8, #6f42c1);
            color: white;
        }
        
        .notification-content {
            flex: 1;
            min-width: 0;
        }
        
        .notification-title {
            font-weight: 600;
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 2px;
        }
        
        .notification-message {
            font-size: 12px;
            color: #6c757d;
            line-height: 1.4;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .notification-time {
            font-size: 11px;
            color: #adb5bd;
            font-style: italic;
        }
        
        .notification-actions {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .notification-item:hover .notification-actions {
            opacity: 1;
        }
        
        /* Badge animation */
        .navbar-badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* Scrollbar styling */
        .notification-container::-webkit-scrollbar {
            width: 4px;
        }
        
        .notification-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .notification-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }
        
        .notification-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
    <!-- Custom Notification Styles -->
    <style>
        /* Notification Dropdown Styles */
        .notification-container {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .notification-item {
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            padding: 12px 16px !important;
            margin-bottom: 1px;
            border-bottom: 1px solid #e9ecef !important;
        }
        
        .notification-item:hover {
            background-color: #f8f9fa !important;
            transform: translateX(2px);
        }
        
        .notification-item.unread {
            border-left-color: #007bff !important;
            background-color: #f8f9fc !important;
        }
        
        .notification-item.unread::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background-color: #007bff;
            border-radius: 50%;
        }
        
        .notification-item.read {
            border-left-color: #6c757d !important;
            opacity: 0.8;
        }
        
        .notification-icon {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 16px !important;
            margin-right: 12px !important;
            flex-shrink: 0 !important;
        }
        
        .notification-icon.harian {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
            color: white !important;
        }
        
        .notification-icon.tahunan {
            background: linear-gradient(135deg, #17a2b8, #6f42c1) !important;
            color: white !important;
        }
        
        .notification-content {
            flex: 1 !important;
            min-width: 0 !important;
        }
        
        .notification-title {
            font-weight: 600 !important;
            font-size: 14px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
        }
        
        .notification-message {
            font-size: 12px !important;
            color: #6c757d !important;
            line-height: 1.4 !important;
            margin-bottom: 4px !important;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .notification-time {
            font-size: 11px !important;
            color: #adb5bd !important;
            font-style: italic !important;
        }
        
        .notification-actions {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .notification-item:hover .notification-actions {
            opacity: 1;
        }
        
        /* Badge animation */
        .navbar-badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* Scrollbar styling */
        .notification-container::-webkit-scrollbar {
            width: 4px;
        }
        
        .notification-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .notification-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }
        
        .notification-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #notificationDropdownMenu {
                width: 300px !important;
                right: -50px;
            }
        }

        /* Force display styles */
        #notificationItems .notification-item {
            display: block !important;
        }
        
        #notificationItems .d-flex {
            display: flex !important;
        }
        
        #notificationItems .align-items-start {
            align-items: flex-start !important;
        }
        
        #notificationItems .flex-grow-1 {
            flex-grow: 1 !important;
        }
    </style>
</head>

<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="<?php echo e(asset('AdminLTE-3.2.0/dist/img/smp2.png')); ?>"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="https://smpn2klakah-lmj.sch.id/" class="brand-link">
                <img src="<?php echo e(asset('AdminLTE-3.2.0/dist/img/smp2.png')); ?>" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SMPN 02 KLAKAH</span>
            </a>

            <!-- Sidebar -->
            <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php echo $__env->yieldContent('contents'); ?>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024-2025 Perpustakaan <a href="https://smpn2klakah-lmj.sch.id/">SMPN 02 Klakah</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 2.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js')); ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- overlayScrollbars -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/dist/js/adminlte.js')); ?>"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/jquery-mousewheel/jquery.mousewheel.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/raphael/raphael.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/jquery-mapael/jquery.mapael.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/jquery-mapael/maps/usa_states.min.js')); ?>"></script>
    <!-- ChartJS -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/chart.js/Chart.min.js')); ?>"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/dist/js/demo.js')); ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/dist/js/pages/dashboard2.js')); ?>"></script>

    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('user-dropdown-menu');
            dropdown.classList.toggle('d-none');
        }

        // Optional: Klik luar dropdown tutup
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('user-dropdown-menu');
            const trigger = dropdown.previousElementSibling;
            if (!trigger.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('d-none');
            }
        });

        // Integrated Notification System using jQuery
        $(document).ready(function() {
            console.log('Initializing integrated notification system...');
            
            // Initialize notification system with delay to ensure DOM is ready
            setTimeout(function() {
                initializeNotifications();
            }, 500);
            
            // Auto refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
            
            // Load notifications when dropdown is clicked
            $(document).on('click', '#notificationDropdown', function(e) {
                e.preventDefault();
                loadNotifications();
            });
            
            // Mark all as read
            $(document).on('click', '#markAllReadBtn', function(e) {
                e.preventDefault();
                markAllAsRead();
            });
            
            // Clear all notifications
            $(document).on('click', '#clearAllBtn', function(e) {
                e.preventDefault();
                if (confirm('Yakin ingin menghapus semua notifikasi?')) {
                    clearAllNotifications();
                }
            });
            
            // Handle notification item click
            $(document).on('click', '.notification-item', function(e) {
                if ($(e.target).closest('.notification-actions').length) {
                    return; // Don't navigate if clicking actions
                }
                
                const notificationId = $(this).data('id');
                if (notificationId) {
                    window.location.href = `/notifications/${notificationId}/read`;
                }
            });
            
            // Handle delete notification
            $(document).on('click', '.delete-notification', function(e) {
                e.stopPropagation();
                const notificationId = $(this).data('id');
                
                if (confirm('Hapus notifikasi ini?')) {
                    deleteNotification(notificationId);
                }
            });
        });

        function initializeNotifications() {
            console.log('Initializing notifications...');
            loadNotifications();
        }

        function loadNotifications() {
            console.log('Loading notifications...');
            showNotificationLoading();
            
            $.ajax({
                url: '/notifications',
                type: 'GET',
                timeout: 10000,
                success: function(response) {
                    console.log('Notifications loaded successfully:', response);
                    hideNotificationLoading();
                    updateNotificationUI(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading notifications:', status, error);
                    hideNotificationLoading();
                    showNotificationError();
                }
            });
        }

        function updateNotificationUI(data) {
            console.log('Updating notification UI with data:', data);
            const notifications = data.notifications || [];
            const unreadCount = data.unread_count || 0;
            
            // Update badge
            updateNotificationBadge(unreadCount);
            
            // Update header
            const headerText = notifications.length === 0 ? 'Tidak ada notifikasi' : `${notifications.length} Notifikasi`;
            $('#notificationHeader').text(headerText);
            $('#notificationTime').text(new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            }));
            
            // Update notification items
            if (notifications.length === 0) {
                showEmptyState();
            } else {
                showNotificationItems(notifications);
            }
            
            console.log('Notification UI updated successfully');
        }

        function updateNotificationBadge(count) {
            const badge = $('#notificationCount');
            if (count > 0) {
                badge.text(count > 99 ? '99+' : count).show();
                badge.removeClass('badge-secondary').addClass('badge-warning');
            } else {
                badge.hide();
            }
        }

        function showNotificationItems(notifications) {
            console.log('Showing notification items:', notifications.length);
            $('#notificationEmpty').hide();
            $('#notificationLoading').hide();
            
            const container = $('#notificationItems');
            container.empty().show();
            
            if (notifications.length === 0) {
                showEmptyState();
                return;
            }
            
            notifications.forEach(function(notification, index) {
                console.log(`Creating notification item ${index + 1}:`, notification);
                const item = createNotificationItem(notification);
                container.append(item);
            });
            
            // Force apply styles after DOM insertion
            setTimeout(function() {
                container.find('.notification-item').each(function() {
                    const $item = $(this);
                    
                    // Ensure all classes and styles are properly applied
                    $item.addClass('notification-item');
                    $item.find('.notification-icon').addClass('notification-icon');
                    $item.find('.notification-content').addClass('notification-content');
                    
                    // Force CSS recalculation
                    $item[0].offsetHeight;
                });
                
                console.log('Notification styles forced and applied');
            }, 100);
            
            console.log('All notification items created and appended');
        }

        function createNotificationItem(notification) {
            const isRead = notification.is_read || false;
            const type = notification.type || 'peminjaman_harian';
            const iconClass = type === 'peminjaman_harian' ? 'harian' : 'tahunan';
            const icon = type === 'peminjaman_harian' ? 'fas fa-calendar-day' : 'fas fa-calendar-alt';
            const title = notification.title || 'Notifikasi';
            const message = notification.message || 'Tidak ada pesan';
            const timeText = timeAgo(notification.created_at);
            
            // Create jQuery element instead of HTML string for better style application
            const $item = $('<div></div>')
                .addClass('notification-item')
                .addClass(isRead ? 'read' : 'unread')
                .attr('data-id', notification.id);
            
            const $content = $(`
                <div class="d-flex align-items-start">
                    <div class="notification-icon ${iconClass}">
                        <i class="${icon}"></i>
                    </div>
                    <div class="notification-content flex-grow-1">
                        <div class="notification-title">${title}</div>
                        <div class="notification-message">${message}</div>
                        <div class="notification-time">${timeText}</div>
                    </div>
                    <div class="notification-actions ml-2 d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-danger delete-notification" data-id="${notification.id}" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `);
            
            $item.append($content);
            
            console.log('Created notification item element for:', notification.id);
            return $item;
        }

        function showNotificationLoading() {
            console.log('Showing notification loading...');
            $('#notificationLoading').show();
            $('#notificationItems').hide();
            $('#notificationEmpty').hide();
        }

        function hideNotificationLoading() {
            console.log('Hiding notification loading...');
            $('#notificationLoading').hide();
            $('#notificationItems').show();
        }

        function showEmptyState() {
            console.log('Showing empty state...');
            $('#notificationItems').hide();
            $('#notificationEmpty').show();
        }

        function showNotificationError() {
            $('#notificationItems').html(`
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p class="mb-0">Gagal memuat notifikasi</p>
                    <small>Silakan coba lagi nanti</small>
                </div>
            `).show();
        }

        function markAllAsRead() {
            $.ajax({
                url: '/notifications/mark-all-read',
                type: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        loadNotifications();
                        showToast('success', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'Gagal menandai semua notifikasi');
                }
            });
        }

        function clearAllNotifications() {
            $.ajax({
                url: '/notifications/clear-all',
                type: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        loadNotifications();
                        showToast('success', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'Gagal menghapus semua notifikasi');
                }
            });
        }

        function deleteNotification(notificationId) {
            $.ajax({
                url: `/notifications/${notificationId}`,
                type: 'DELETE',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        loadNotifications();
                        showToast('success', response.message);
                    }
                },
                error: function() {
                    showToast('error', 'Gagal menghapus notifikasi');
                }
            });
        }

        function timeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) return 'Baru saja';
            if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' menit yang lalu';
            if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' jam yang lalu';
            if (diffInSeconds < 2592000) return Math.floor(diffInSeconds / 86400) + ' hari yang lalu';
            
            return date.toLocaleDateString('id-ID');
        }

        function showToast(type, message) {
            // Remove existing toasts
            $('.toast-notification').remove();
            
            // Create new toast
            const toast = $(`
                <div class="toast-notification ${type}" style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: ${type === 'success' ? '#28a745' : '#dc3545'}; color: white; padding: 12px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-2"></i>
                        <span>${message}</span>
                        <button type="button" class="btn btn-sm text-white ml-auto p-0" onclick="$(this).parent().parent().fadeOut()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `);
            
            $('body').append(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.fadeOut();
            }, 5000);
        }
    </script>
    <!-- Modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')); ?>">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/dist/css/adminlte.min.css')); ?>">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css')); ?>">

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('Edit Profile')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo e(__('Close')); ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>

                
                <div class="card card-secondary card-outline mb-4">
                    <div class="card-body">
                        <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>

                
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <?php echo e(__('Close')); ?>

                </button>
            </div>
        </div>
    </div>
</div>


</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/layouts/app.blade.php ENDPATH**/ ?>