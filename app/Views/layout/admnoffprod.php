<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>
    <!-- Include Bootstrap CSS and AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
    <!-- Additional CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets/dist/css/custom.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="<?= base_url('assets/images/avi2.png'); ?>" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.js"></script>
    
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars text-dark"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link">Solder Paste Monitoring</span>
                </li>
            </ul>
            
            
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Dropdown Menu -->
                <!-- <li class="nav-item dropdown">
                    <a href="<?php echo base_url('admnoffprod/processing_form_offprod'); ?>" class="nav-link" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <span id="notification-icon" class="label label-warning" style="display: none;"><i class="fa fa-exclamation-circle"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown">
                        <li class="dropdown-header"><b>Notifications</b></li>
                        <li>
                            <ul class="menu" id="notification-list">
                                
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user text-dark"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="<?= base_url('admnoffprod/profileoffprod'); ?>" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('logout'); ?>" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-gray elevation-4">
            <!-- Brand Logo -->
            <span class="brand-link centered-image-link">
                <img id="brand-image" src="<?= base_url('assets/images/AVI.png'); ?>" style="width: 150px;">
                <img id="brand-text" src="<?= base_url('assets/images/AVI.png'); ?>" style="display: none; width: 60px;"></img>
            </span>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <span class="d-block text-dark"><b>Departement Produksi</b></span>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?= base_url('admnoffprod/dashboardoffprod'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tv"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <!-- <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>
                                    Operations
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a> -->
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('admnoffprod/offprod_form'); ?>" class="nav-link">
                                        <i class="fas fa-qrcode nav-icon"></i>
                                        <p>Incoming</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admnoffprod/processing_form_offprod'); ?>" class="nav-link">
                                        <i class="fas fa-sync-alt nav-icon"></i>
                                        <p>Proses</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admnoffprod/returnoffprod_form'); ?>" class="nav-link">
                                        <i class="fas fa-truck-loading nav-icon"></i>
                                        <p>Return</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?= $this->renderSection('content_header'); ?></h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <?= $this->renderSection('content'); ?>
            </section>
        </div>
        
        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Production Departement</b>
            </div>
            <strong>Astra Visteon Indonesia &copy; 2024</a>.</strong>
        </footer>
    </div>

    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>

<script>
    $(document).ready(function() {
        function fetchNotifications() {
            $.ajax({
                url: '<?= site_url('user/getNotificationsOffProd'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.length > 0) {
                        $('#notification-icon').show();
                        $('#notification-list').empty();
                        response.forEach(function(notification) {
                            $('#notification-list').append(
                                '<li><a href="processing_form_offprod"> Solder Paste Conditioning - ' + notification.lot_number + ' - ' + notification.id + '</a></li>'
                            );
                        });
                    } else {
                        $('#notification-icon').hide();
                        $('#notification-list').empty();
                    }
                }
            });
        }

        fetchNotifications();

        setInterval(fetchNotifications, 30000); 
    });
</script>

<script>
    $(document).ready(function() {
        $('[data-widget="pushmenu"]').on('click', function() {
            $('#brand-image').toggle();
            $('#brand-text').toggle();
        });
    });
</script>

<style>

    .content-header {
        padding: 5px;    
        margin-bottom: -20px;
    }

    #notification-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
        max-height: 200px;
        overflow-y: hidden;
    }

    #notification-list:hover {
        overflow-y: auto;
    }

    #notification-list li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    #notification-list li a {
        display: flex;
        align-items: center;
        color: #333;
        text-decoration: none;
    }

    #notification-list li a:hover {
        background-color: #f1f1f1;
    }

    #notification-list li a i {
        margin-right: 10px;
    }

    #notification-icon {
        position: relative;
        top: -10px;
        right: 5px;
        font-size: 9px;
        background-color: #0011ff;
        color: #fff;
        padding: 2px 5px;
        border-radius: 50%;
    }

    .fa-bell {
        position: relative;
    }

    .fa-bell .label {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: #ffcc00;
        color: #fff;
        font-size: 10px;
        padding: 2px 5px;
        border-radius: 50%;
    }

    .info {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .centered-image-link {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    }

    .centered-image-link img {
    margin: auto;
    }

    .sidebar-light-gray {
    background-color: whitesmoke !important; 
    color: #000000;
    }

    .navbar-light {
        position: sticky; 
        top: 0;
        background-color: #ffff;
        z-index: 999;
    }

    @media (max-width: 768px) {
    .table-fixed-header {
        max-height: 300px;
    }

    .search-box {
        width: 100%;
        font-size: 12px;
    }

    .card-body-rs {
        max-height: 280px;
    }

    .col-sm-2 {
        width: 100%;
        margin-bottom: 1rem;
    }
    }

    @media (max-width: 576px) {
    .table {
        font-size: 10px;
    }

    .card-body-rs, .card-body {
        max-height: 200px;
    }

    .search-box {
        width: 100%;
        font-size: 10px;
    }

    .col-sm-2 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    }
    
</style>
    
</body>
</html>
