<?= $this->extend('layout/admnoffprod'); ?>

<?= $this->section('title'); ?>
Proses Office Produksi
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Proses Office Produksi</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Existing Monitoring System Solder Paste Section -->
                <div class="col-md-8">
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
                            <?= form_open('user/save_timeoffprod_search_key', ['id' => 'form_timeoffprod']) ?>
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
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('scrap')">Scrap</button>
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('returnsp')">Return</button>
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('openusing')">Open</button>
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('handover')">Handover</button>
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('mixing')">Mixing</button>
                                <button type="button" class="btn btn-rs float-right" onclick="saveTimestamp('conditioning')">Conditioning</button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <div class="card-body card-sr">
                            <h4>Today's Solder Paste Entries</h4>
                            <div class="table-responsive table-fixed-header">
                            <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Incoming</th>
                                            <th>Conditioning</th>
                                            <th>Mixing</th>
                                            <th>Handover</th>
                                            <th>Open</th>
                                            <th>Return</th>
                                            <th>Scrap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($today_entries_offprod)): ?>
                                            <?php foreach ($today_entries_offprod as $entry): ?>
                                                <tr>
                                                    <td><?= $entry['id']; ?></td>
                                                    <td><?= $entry['lot_number']; ?></td>
                                                    <td><?= $entry['incoming']; ?></td>
                                                    <td><?= $entry['conditioning']; ?></td>
                                                    <td><?= $entry['mixing']; ?></td>
                                                    <td><?= $entry['handover']; ?></td>
                                                    <td><?= $entry['openusing']; ?></td>
                                                    <td><?= $entry['returnsp']; ?></td>
                                                    <td><?= $entry['scrap']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9">No entries for today.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Solder Paste Open</h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive-open table-fixed-header">
                                <table id="solder-paste-table-open" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Open</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($today_entries_offopen)): ?>
                                            <?php foreach ($today_entries_offopen as $entry): ?>
                                                <tr data-openusing="<?= esc($entry['openusing']); ?>">
                                                    <td><?= esc($entry['id']); ?></td>
                                                    <td><?= esc($entry['lot_number']); ?></td>
                                                    <td><?= esc($entry['openusing']); ?></td>
                                                    <td class="status"></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr class="no-entries">
                                                <td colspan="4">No entries for today.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <p class="card-description">
                                <span class="darkorange-color">Kuning</span> <b>menunjukkan solder paste sudah dibuka melebihi 6 jam</b>
                            </p>
                            <p class="card-description">
                                <span class="red-color">Merah</span> <b>menunjukkan solder paste sudah dibuka melebihi 8 jam</b>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notifications Conditioning</h3>
                        </div>
                        <div class="card-body">
                            <ul id="notif-cond" class="list-unstyled"></ul>
                            <div class="no-notification text-center mt-3">No new notifications</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notifications Using</h3>
                        </div>
                        <div class="card-body">
                            <ul id="notif-using" class="list-unstyled"></ul>
                            <div class="no-notification-us text-center mt-3">No new notifications</div>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-scr" style="margin: 0 0 20px 10px" onclick="window.location.href='<?= base_url('admnoffprod/xacti_aji_offprod'); ?>'">Send To External</button>
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
    document.addEventListener("DOMContentLoaded", function() {
        function updateRowColors() {
            const rows = document.querySelectorAll('#solder-paste-table-open tbody tr');
            const currentTime = new Date();

            rows.forEach(row => {
                const openusing = new Date(row.getAttribute('data-openusing'));
                
                let timeDiff = (currentTime - openusing) / 60000; 
                let rowClass = 'default-color'; 
                let statusText = '';
                
                if (timeDiff > 2) { // aktual waktu 8 jam = 480 menit
                    rowClass = 'table-danger';
                    statusText = 'Melebihi 8 jam';
                } else if (timeDiff > 1) { // aktual waktu 6 jam = 360 menit
                    rowClass = 'table-warning';
                    statusText = 'Melebihi 6 jam';
                } else {
                    statusText = 'Open';
                }

                row.className = rowClass;
                row.querySelector('.status').textContent = statusText;
            });
        }

        updateRowColors();
        setInterval(updateRowColors, 30000);
    });
</script>

<script>
    function saveTimestamp(column) {
    var SearchKey = document.getElementById('search_key').value;
    if (SearchKey) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('user/save_timeoffprod_search_key'); ?>'; 

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
        alert('Please enter the search key first.');
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
                url: '<?= base_url('user/search_key_offprod'); ?>',
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


<script>
    $(document).ready(function() {
        function checkPendingNotifications() {
            var now = new Date();
            var currentHour = now.getHours();

            if (currentHour >= 7 && currentHour < 19) {
                $.ajax({
                    url: '<?= site_url('user/checkPendingNotifications'); ?>', 
                    dataType: 'json',
                    success: function(data) {
                        var notificationList = '';

                        data.forEach(function(item) {
                            notificationList += '<div class="notification-box">' +
                                '<span class="notification-text">' + item.lot_number + ' - ' + item.id + ' : Solder Paste sudah melewati batas waktu 2 jam proses conditioning</span>' +
                                '</div>';
                        });

                        if (notificationList !== '') {
                            $('#notif-cond').html(notificationList);
                            localStorage.setItem('pendingNotifications', 'true');
                        } else {
                            $('#notif-cond').html('<div class="no-notification">No new notifications</div>');
                            localStorage.setItem('pendingNotifications', 'false');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
                        $('#notif-cond').html('<div class="no-notification">Error fetching notifications</div>');
                        localStorage.setItem('pendingNotifications', 'false');
                    }
                });
            } else {
                $('#notif-cond').html('<div class="no-notification">No new notifications</div>');
                localStorage.setItem('pendingNotifications', 'false');
            }
        }

        // Check Overdue Notifications
        function checkOverdueNotifications() {
            var now = new Date();
            var currentHour = now.getHours();

            if (currentHour >= 7 && currentHour < 19) {
                $.ajax({
                    url: '<?= site_url('user/checkOverdueNotifications'); ?>', 
                    dataType: 'json',
                    success: function(data) {
                        var notificationList = '';

                        data.forEach(function(item) {
                            notificationList += '<div class="notification-box-us">' +
                                '<span class="notification-text-us">' + item.lot_number + ' - ' + item.id + ' : Solder Paste sudah dibuka melewati dari batas waktu 8 jam!!!</span>' +
                                '</div>';
                        });

                        if (notificationList !== '') {
                            $('#notif-using').html(notificationList);
                            localStorage.setItem('OverdueNotifications', 'true');
                        } else {
                            $('#notif-using').html('<div class="no-notification-us">No new notifications</div>');
                            localStorage.setItem('OverdueNotifications', 'false');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
                        $('#notif-using').html('<div class="no-notification-us">Error fetching notifications</div>');
                        localStorage.setItem('OverdueNotifications', 'false');
                    }
                });
            } else {
                $('#notif-using').html('<div class="no-notification-us">No new notifications</div>');
                localStorage.setItem('OverdueNotifications', 'false');
            }
        }

        // Initial checks
        checkPendingNotifications();
        checkOverdueNotifications();

        // Set intervals
        setInterval(checkPendingNotifications, 30000);
        setInterval(checkOverdueNotifications, 30000);

        // Auto-focus on input field
        $('#lot_number').focus();
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

    #notif-cond, #notif-using {
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

    .notification-box-us {
        background-color: red;
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

    .no-notification, .no-notification-us {
        display: none;
    }

    .table-responsive-open {
        font-size: 75%;
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 330px;
        margin-bottom: 10px;
    }

    .table-responsive-open:hover {
        overflow-y: auto;
    }

    .table-responsive {
    font-size: 70%;
    overflow-y: hidden;
    overflow-x: hidden;
    max-height: 202px;
    display: block;
    }

    .table-responsive:hover {
        overflow-y: auto;
    }

    .table-responsive table {
        width: 100%;
        table-layout: fixed; 
        border-collapse: collapse;
    }

    .table-responsive th, 
    .table-responsive td {
        text-align: left;
        padding: 8px;
        word-wrap: break-word; 
        border: 1px solid #ddd; 
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
        z-index: 99;
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

    .btn-scr { 
        background-color: #f5911f;
        color: #fff;
        padding: 5px;
    }

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
    }

    .btn-rs:hover {
        background-color: #014f80;
        color: #fff;
    }

    .default-color {
        color: black; 
        font-weight: bold;
    }
    .table-warning {
        font-weight: bold;
    }
    .table-danger {
        font-weight: bold;
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

    .darkorange-color {
        color: #E4A11B;
        font-weight: bold;
    }

    .no-entries {
        color: black; 
    }
    
    .card-description {
        font-size: 12px;
        color: #555;
        padding: 0px; 
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
        font-size: 12px;
        margin-top: 2px;
    }

    .btn-default {
        font-size: 12px;
    }
}

</style>
<?= $this->endSection(); ?>
