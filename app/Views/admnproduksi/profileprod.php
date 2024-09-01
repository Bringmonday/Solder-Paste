<?= $this->extend('layout/admnproduksi'); ?>

<?= $this->section('title'); ?>
Profile Produksi
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Profile</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body text-center">
                    <img src="<?= base_url('assets/images/avatar.png'); ?>" alt="Profile Logo" class="profile-img" style="width: 150px;">
                    <div class="profile-info card-body-rs">
                        <p><strong>Nama :</strong> <?= esc($user['name']); ?></p>
                        <p><strong>Email :</strong> <?= esc($user['email']); ?></p>
                        <p><strong>Mobile :</strong> <?= esc($user['mobile']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ganti Password</h5>
                </div>
                    <?= form_open('admnproduksi/updatePasswordprod'); ?>
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                    <?php endif; ?>
                <div class="card-body card-pw">            
                        <div class="form-group">
                            <label for="currentPassword">Password Lama</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword" value="<?= old('currentPassword'); ?>" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default" id="toggleCurrentPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newPassword">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="newPassword" name="newPassword" value="<?= old('newPassword'); ?>" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default" id="toggleNewPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-rs" style="float: right">Submit</button>
                        <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
    const toggleNewPassword = document.getElementById('toggleNewPassword');
    
    toggleCurrentPassword.addEventListener('click', function () {
        const currentPasswordInput = document.getElementById('currentPassword');
        if (currentPasswordInput.type === 'password') {
            currentPasswordInput.type = 'text';
            toggleCurrentPassword.querySelector('i').classList.remove('fa-eye');
            toggleCurrentPassword.querySelector('i').classList.add('fa-eye-slash');
        } else {
            currentPasswordInput.type = 'password';
            toggleCurrentPassword.querySelector('i').classList.remove('fa-eye-slash');
            toggleCurrentPassword.querySelector('i').classList.add('fa-eye');
        }
    });

    toggleNewPassword.addEventListener('click', function () {
        const newPasswordInput = document.getElementById('newPassword');
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

    if (document.querySelector('.alert-danger')) {
        resetFields();
    }
});

function resetFields() {
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('currentPassword').focus();
}
</script>

<style>
    .card-body {
        max-height: 400px;
    }
    
    .card-header {
        background-color: #0069aa;
        color: #fff;
    }

    .card-pw {
        height: 300px;
    }

    .text-center {
        height: 346px;
    }

    .alert {
        margin-bottom: 20px;
    }

    .profile-img {
        width: 200px;
        margin-bottom: 6px;
    }

    .profile-info {
        background-color: #ffffff;
        border: 2px solid #000000;
        padding: 20px; 
        border-radius: 5px; 
    }

    .profile-info p {
        margin: 10px 0; 
    }

    .input-group-append .btn {
        border-radius: 0;
    }

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
    }

    .btn-rs:hover {
        background-color: #025f99;
        color: #fff;
    }

    .container {
        padding-top: 15px;
    }

    @media (min-width: 768px) and (max-width: 1024px) {
    .table {
        font-size: 10px; 
    }

    .table-fixed-header {
        max-height: 400px; /* tinggi tabel pada tablet */
    }

    .card-body {
        max-height: 400px; /* tinggi card body */
    }

    .card-body-rs {
        padding: 10px;
        font-size: 16px;
    }

    .table th, .table td {
        padding: 8px; 
    }

    .table th, .table td {
        word-wrap: break-word;
    }

    .search-container {
        margin: 10px 0;
    }

    .search-box {
        width: 100%;
        font-size: 14px;
    }

    .center-card-title {
        font-size: 14px; 
    }
    

    }
</style>

<?= $this->endSection(); ?>
