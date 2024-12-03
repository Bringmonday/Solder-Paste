<?= $this->extend('layout/admnproduksi') ?>

<?= $this->section('title') ?>
Scrap Old
<?= $this->endSection() ?>

<?= $this->section('content_header') ?>
<h1>Scrap</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content">
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title" style="margin-top: 15px">Tabel Scrap</h3>
                            <a href="<?= site_url('user/export_to_excel') ?>" style="float: right; margin-top: 5px;" class="btn btn-primary mb-3 ">Download Excel</a>
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
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Unik Code</th>
                                            <th class="text-center">Lot Number</th>
                                            <th class="text-center">Handover</th>
                                            <th class="text-center">Scrap</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="temp-data">
                                        <?php foreach ($today_entries_rtn as $row): ?>
                                            <tr>
                                                <td class="text-center"><?= $row['id'] ?></td>
                                                <td class="text-center"><?= $row['lot_number'] ?></td>
                                                <td class="text-center"><?= $row['handover'] ?></td>
                                                <td class="text-center"><?= $row['scrap'] ? $row['scrap'] : '-' ?></td>
                                                <td class="text-center">
                                                    <form action="<?= site_url('user/received_prod') ?>" method="post">
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
    .btn-primary {
        padding: 5px;
    }

</style>

<?= $this->endSection() ?>
