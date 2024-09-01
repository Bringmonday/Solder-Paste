<?= $this->extend('layout/register_header'); ?>

<?= $this->section('content'); ?>

<div class="login-box">
    <div class="login-logo">
        <img src="<?= base_url('assets/images/AVI.png'); ?>" alt="AVI Logo" style="max-width: 70%; margin-bottom: 10px;">
    </div>
    <div class="card bg-white">
        <div class="card-body login-card-body">
            <p class="login-box-msg"><strong>Register</strong></p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p><?= esc($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('registerMe') ?>" method="post" autocomplete="off">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Full Name" id="name" name="name" value="<?= old('name') ?>" required autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="<?= old('email') ?>" required autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
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
                <div class="input-group mb-3">
                    <input type="number" class="form-control" placeholder="Mobile" id="mobile" name="mobile" value="<?= old('mobile') ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" id="roleId" name="roleId" required>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['roleId'] ?>"><?= $role['role'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-8">
                        <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-rs btn-block">Register</button>
                    </div>
                    <div class="col-8" style="margin-top: 10px">
                        <a href="<?= base_url('login') ?>" class="text-center">Already have an account?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleNewPassword = document.getElementById('toggleNewPassword');
        
        toggleNewPassword.addEventListener('click', function () {
            const newPasswordInput = document.getElementById('currentPassword');
            if (newPasswordInput.type === 'password') {
                newPasswordInput.type = 'text';
                toggleNewPassword.querySelector('i').classList.remove('fa-eye');
                toggleNewPassword.querySelector('i').classList.add('fa-eye-slash');
            } else {
                newPasswordInput.type = 'password';
                toggleNewPassword.querySelector('i').classList.remove('fa-eye-slash');
                toggleNewPassword.querySelector('i').classList.add('fa-eye');
            }
        });
    });

    function resetFields() {
        $('#name').val('');
        $('#email').val('');
        $('#currentPassword').val('');
        $('#mobile').val('');
        $('#roleId').val('');
        $('#name').focus();
    }
</script>

<style>

    .col-4 {
        padding: 0 17px; 
    }

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
        height: 35px;
        padding: 10px;
        font-size: 16px; 
        border-radius: 4px;
    }

    .btn-rs:hover {
        background-color: #025f99;
        color: #fff;
    }

</style>

<?= $this->endSection(); ?>
