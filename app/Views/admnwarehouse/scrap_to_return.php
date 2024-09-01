<?= $this->extend('layout/admnwarehouse'); ?>

<?= $this->section('title'); ?>
Proses Warehouse
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Proses Scrap Return</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Existing Monitoring System Solder Paste Section -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Scrap To Return</h3>
                        </div>
                        <!-- Display flashdata messages -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form start -->
                        <div class="card-body card-rs">
                            <?= form_open('user/save_timewarehouse_scrap_to_return', ['id' => 'form_timewarehouse']) ?>
                            <div class="form-group">
                                <label for="lot_number">Lot Number</label>
                                <input type="text" name="lot_number" id="lot_number" class="form-control" autocomplete="off" required placeholder="Input Lot Number" oninput="debouncedHandleBarcodeScan(this.value)">
                            </div>
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" name="id" id="id" class="form-control" autocomplete="off" required placeholder="Input ID">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                                <button type="submit" class="btn btn-rs float-right" style="margin-right: 5px">Submit</button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <div class="card-body card-sr">
                            <h4>Tabel Informasi</h4>
                            <div class="table-responsive table-fixed-header">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Scrap</th>
                                            <th>Return</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($today_entries_scrap)): ?>
                                            <?php foreach ($today_entries_scrap as $entry): ?>
                                                <tr>
                                                    <td><?= $entry['id']; ?></td>
                                                    <td><?= $entry['lot_number']; ?></td>
                                                    <td><?= $entry['scrap']; ?></td>
                                                    <td><?= $entry['returnsp']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4">No entries for today.</td>
                                            </tr>
                                        <?php endif; ?>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load Quagga JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script>
    function focusOnSearchKey() {
        document.getElementById('lot_number').focus();
    }

    window.onload = focusOnSearchKey;

    function resetFields() {
        document.getElementById('lot_number').value = '';
        focusOnSearchKey(); 
    }

    document.querySelector('.btn-default').addEventListener('click', function() {
        resetFields();
    });
</script>



<style>
    #search_results {
        margin-top: 10px;
        max-height: 150px;
        overflow-y: auto; 
    }

    .search-results-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .search-results-list li {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    .search-results-list li:hover {
        background-color: #f1f1f1;
    }

    #search_results p {
        color: #666;
        font-style: italic;
    }

    #notif-cond {
        max-height: 450px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .notification-box {
        background-color: darkorange;
        color: white;
        width: 100%;
        box-sizing: border-box;
        padding: 20px;
        margin: 10px 0;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }

    .no-notification {
        display: none;
    }

    .table-responsive {
        font-size: 12.2px;
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 390px;
    }

    .table-responsive:hover {
        overflow-y: auto;
    }

    .table-fixed-header tbody {
    background-color: whitesmoke;
    }
    
    .table-fixed-header thead th {
        position: sticky;
        top: 0;
        background-color: #f5911f;
        color: #000;
        text-align: center;
        z-index: 999;
    }

    .card-header {
        background-color: #0069aa;
        color: #fff;
    }

    .card-rs {
        padding: 20px 20px 0 20px;
    }

    .card-sr {
        padding: 0 20px 20px 20px;
    }

    .content {
        padding-top: 8px;
    }

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
    }

    .btn-rs:hover {
        background-color: #014f80;
        color: #fff;
    }

    .card-description {
        font-size: 12px;
        color: #555;
        padding: 0px; 
    }

    .red-color {
        color: #DC4C64;
        font-weight: bold;
    }

    .red-color-hg {
        color: #fff;
        background-color: #DC4C64;
        font-weight: bold;
        padding: 5px;
    }

    .black-color {
        color: #fff;
        background-color: #000;
        font-weight: bold;
        padding: 5px;
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

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
        padding: 5px;
    }
}
</style>
<?= $this->endSection(); ?>
