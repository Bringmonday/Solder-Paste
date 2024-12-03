<?= $this->extend('layout/login_header'); ?>

<?= $this->section('content'); ?>
<body class="hold-transition login-page" style="background-color: #ffffff;">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= base_url('assets/images/AVI.png'); ?>" alt="AVI Logo" style="max-width: 70%; margin-bottom: 10px;">
        </div>
        <div class="card bg-white login-card-body">
            <p class="login-box-msg"><strong>Sign In</strong></p>

            <form action="<?= site_url('loginMe') ?>" method="post" autocomplete="off">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" name="name" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" id="currentPassword" name="password" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-default" id="toggleNewPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="<?= base_url('register') ?>">Register</a>
            </p>
        </div>
    </div>
<?= $this->endSection(); ?>
