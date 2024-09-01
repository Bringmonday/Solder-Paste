<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Register' ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/custom.css'); ?>">
    <link rel="icon" href="<?= base_url('assets/images/avi2.png'); ?>" type="image/png">
</head>
<body class="hold-transition login-page" style="background-color: #ffffff;">
    <?= $this->renderSection('content') ?>
    <!-- jQuery -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>

    <style>
        .btn-block{
            padding: 2px;
        }
    </style>
</body>
</html>
