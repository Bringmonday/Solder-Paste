<?= $this->extend('layout/admnwarehouse'); ?>

<?= $this->section('title'); ?>
Solder Paste External
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Solder Paste External</h1>
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
                            <h3 class="card-title">Proses</h3>
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
                            <?= form_open('user/save_timewarehouse_external', ['id' => 'form_timewarehouse']) ?>
                            <div class="form-group">
                                <p class="card-description">
                                    <span class="black-color">Hitam</span><b> menunjukkan Lot | <span class="red-color-hg">Merah</span> menunjukkan ID</b>
                                </p>
                                <label for="search_key">Input 3 angka ID</label>
                                <input type="text" name="search_key" id="search_key" class="form-control" autocomplete="off" required placeholder="Input 3 angka ID Solder Paste" oninput="debouncedHandleBarcodeScan(this.value)" >
                                <div id="search_results"></div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('scrap')">To External</button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <div class="card-body card-sr">
                            <h4>Today's Solder Paste Entries</h4>
                            <div class="table-responsive table-fixed-header">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Scrap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($today_entries_wrhs)): ?>
                                            <?php foreach ($today_entries_wrhs as $entry): ?>
                                                <tr>
                                                    <td><?= $entry['id']; ?></td>
                                                    <td><?= $entry['lot_number']; ?></td>
                                                    <td><?= $entry['scrap']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6">No entries for today.</td>
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
    function saveTimestamp(column) {
    var SearchKey = document.getElementById('search_key').value;
    if (SearchKey) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('user/save_timewarehouse_external'); ?>'; 

        var SearchKeyField = document.createElement('input');
        SearchKeyField.type = 'hidden';
        SearchKeyField.name = 'search_key';
        SearchKeyField.value = SearchKey;
        form.appendChild(SearchKeyField);

        var columnField = document.createElement('input');
        columnField.type = 'hidden';
        columnField.name = 'column';
        columnField.value = column;
        form.appendChild(columnField);

        var timestampField = document.createElement('input');
        timestampField.type = 'hidden';
        timestampField.name = column;
        timestampField.value = new Date().toISOString().slice(0, 19).replace('T', ' ');
        form.appendChild(timestampField);

        document.body.appendChild(form);

        console.log('Data yang dikirim:', SearchKey, column, timestampField.value);

        form.submit();

        var buttons = document.querySelectorAll('button');
        buttons.forEach(function(button) {
            if (button.textContent.trim().toLowerCase() === column.toLowerCase()) {
                button.disabled = true;
            }
        });
    } else {
        Swal.fire({
            title: 'Data Belum diisi',
            text: 'Tolong input data terlebih dahulu.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}



    function checkTimestamps(SearchKey) {
        if (SearchKey) {
            $.ajax({
                url: '<?= base_url('user/check_timestamps'); ?>', 
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({ search_key: SearchKey }),
                success: function(data) {
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat memeriksa timestamp.'); 
                }
            });
        }
    }

    function resetFields() {
        $('#search_key').val('');
        $('#search_key').focus();
    }

    $(document).ready(function() {
        var SearchKey = $('#search_key').val();
        if (SearchKey) {
            checkTimestamps(SearchKey);
        }

        $('#search_key').on('input', function() {
            checkTimestamps($(this).val());
        });
    });

    $(document).ready(function() {
        $('#search_key').focus();
    });
</script>

<script>
    let debounceTimeout;

    function debounce(func, delay) {
        return function(...args) {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    function handleBarcodeScan(value) {
        if (value.length >= 2) {
            $.ajax({
                url: '<?= base_url('user/search_key_ext'); ?>',
                type: 'GET',
                data: { term: value },
                dataType: 'json',
                success: function(data) {
                    displaySearchResults(data);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan:', error);
                }
            });
        } else {
            $('#search_results').empty();
        }
    }

    const debouncedHandleBarcodeScan = debounce(handleBarcodeScan, 500);

    function displaySearchResults(data) {
        var resultsContainer = $('#search_results');
        resultsContainer.empty();
        
        if (data.length > 0) {
            var list = $('<ul class="search-results-list"></ul>');
            $.each(data, function(index, item) {
                var lotNumber = item.lot_number;
                var id = item.id;
                var styledSearchKey = styleSearchKey(lotNumber, id);
                
                $('<li></li>').html(styledSearchKey).on('click', function() {
                    $('#search_key').val(lotNumber + id);
                    $('#search_results').empty();
                }).appendTo(list);
            });
            resultsContainer.append(list);
        } else {
            resultsContainer.append('<p>No results found.</p>');
        }
    }

    function styleSearchKey(lotNumber, id) {
        return '<span style="font-weight: bold; color: black;">' + lotNumber + '</span><span style="font-weight: bold; color: red;">' + id + '</span>';
    }
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

    .btn-scr { 
        background-color: #f5911f;
        color: #fff;
        padding: 5px;
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
