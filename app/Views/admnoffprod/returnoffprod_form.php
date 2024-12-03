<?= $this->extend('layout/admnoffprod') ?>

<?= $this->section('title') ?>
Return
<?= $this->endSection() ?>

<?= $this->section('content_header') ?>
<h1>Return</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content">
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="margin-top: 15px">Tabel Return</h3>
                            <a href="<?= site_url('user/export_to_excel') ?>" style="float: right; margin-top: 5px;" class="btn btn-rs mb-3 ">Download Excel</a>
                            <i class='fas fa-file-excel'style="float: right; margin-top: 15px;"></i>
                        </div>
                        <div class="card-body">
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
                            <div class="table-responsive table-fixed-header"></div>
                                <table class="table table-bordered">
                                    <thead class="thead-rs">
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Lot Number</th>
                                            <th class="text-center">Return</th>
                                            <th class="text-center">Incoming</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="temp-data">
                                        <?php foreach ($today_entries_rtn as $row): ?>
                                            <tr>
                                                <td class="text-center"><?= $row['id'] ?></td>
                                                <td class="text-center"><?= $row['lot_number'] ?></td>
                                                <td class="text-center"><?= $row['returnsp'] ?></td>
                                                <td class="text-center"><?= $row['incoming'] ? $row['incoming'] : '-' ?></td>
                                                <td class="text-center">
                                                    <form action="<?= site_url('user/receivedoffprod') ?>" method="post">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="lot_number" value="<?= $row['lot_number'] ?>">
                                                        <button type="submit" class="btn btn-success btn-sm">Received</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    <div>
                        <button type="button" class="btn btn-scr" style="margin-top: 10px" onclick="window.location.href='<?= base_url('admnoffprod/scrap_to_return_offprod'); ?>'">Edit Status</button>
                    </div>
            </div>
        </div>
    </section>
</div>

<style>
    #lot_number_results {
        max-height: 200px;
        overflow-y: auto; 
    } 

    .card-header {
        padding: 5px 15px ; 
        font-size: 16px;
        background-color: #0069aa;
        color: #fff;
    }

    .card-header .card-title {
        margin: 0; 
    }
    
    .card-header .btn {
        margin: 0 3px; 
    }

    .card-body {
        font-size: 15px; 
        overflow-y: hidden;
        max-height: 400px; 
    }

    .card-body:hover {
        overflow-y: auto;
    }

    .btn-submit-reset {
        display: flex;
        justify-content: space-between;
    }

    .btn-submit-reset .btn {
        min-width: 50px;
    }

    .btn-submit-reset .btn-submit {
        margin-left: auto; 
    }

    .btn-scr { 
        background-color: #f5911f;
        color: #fff;
        padding: 5px;
    }

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
        padding: 5px;
    }

    .btn-rs:hover {
        background-color: #025f99;
        color: #fff;
    }

    .content {
        padding-top: 8px;
    }

    .table-responsive {
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 400px;
    }

    .table-responsive:hover {
        overflow-y: auto;
    }

    .text-center {
    text-align: center;
    }

    .thead-rs {
        background-color: #f5911f;
        color: #000;
    }

    @media (min-width: 768px) and (max-width: 1024px) {
    .table {
        font-size: 10px; 
    }

    .table-fixed-header {
        max-height: 400px; /* tinggi tabel pada tablet */
    }

    .card-body, .card-body-rs {
        max-height: 400px; /* tinggi card body */
    }

    .card-body-rs {
        padding: 10px;
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

<?= $this->endSection() ?>
