<?= $this->extend('layout/admnproduksi'); ?>

<?= $this->section('title'); ?>
Proses Produksi
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Proses Produksi</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Existing Monitoring System Solder Paste Section -->
                <div class="col-md-5">
                    <div class="card ">
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
                            <?= form_open('user/save_timeproduksi_search_key', ['id' => 'form_timeproduksi']) ?>
                            <div class="form-group">
                            <p class="card-description">
                                <span class="black-color">Hitam</span><b> menunjukkan Lot | <span class="red-color-hg">Merah</span> menunjukkan ID</b>
                            </p>
                                <label for="search_key">Input 3 Angka ID</label>
                                <input type="text" name="search_key" id="search_key" class="form-control" autocomplete="off" required placeholder="Input 3 Angka ID Solder Paste" oninput="debouncedHandleBarcodeScan(this.value)" maxlength="3" pattern="\d{1,3}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);">
                                <div id="search_results"></div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('scrap')">Scrap</button>
                                <button type="button" style="margin-left: 5px;" class="btn btn-rs float-right" onclick="saveTimestamp('returnsp')">Return</button>
                                <button type="button" class="btn btn-rs float-right" onclick="saveTimestamp('openusing')">Open</button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <div class="card-body card-sr">
                            <h4>Today's Solder Paste Entries</h4>
                            <div class="table-responsive table-fixed-header">
                                <table id="solder-paste-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Open</th>
                                            <th>Return</th>
                                            <th>Scrap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($today_entries_prod)): ?>
                                        <?php foreach ($today_entries_prod as $entry): ?>
                                            <tr>
                                                <td><?= $entry['id']; ?></td>
                                                <td><?= $entry['lot_number']; ?></td>
                                                <td><?= $entry['openusing']; ?></td>
                                                <td><?= $entry['returnsp']; ?></td>
                                                <td><?= $entry['scrap']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr class="no-entries">
                                            <td colspan="5">No entries for today.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                <div class="card card-new">
    <div class="card-header">
        <h3 class="card-title">Tabel Solder Paste Open</h3>
    </div>
    
    <div class="card-body">
        <input type="text" id="search-id" class="form-control mb-3" placeholder="Search by ID" />
        
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
                    <?php if (!empty($today_entries_open)): ?>
                        <?php foreach ($today_entries_open as $entry): ?>
                            <tr data-openusing="<?= esc($entry['openusing']); ?>" data-id="<?= esc($entry['id']); ?>">
                                <td><?= esc($entry['id']); ?></td>
                                <td><?= esc($entry['lot_number']); ?></td>
                                <td><?= esc($entry['openusing']); ?></td>
                                <td class="status"></td>
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
        
        <p class="card-description">
            <span class="darkorange-color">Kuning</span> <b>menunjukkan solder paste sudah dibuka melebihi 6 jam</b>
        </p>
        <p class="card-description">
            <span class="red-color">Merah</span> <b>menunjukkan solder paste sudah dibuka melebihi 8 jam</b>
        </p>
    </div>
</div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Solder Paste Handover</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form Pencarian -->
                            <div class="mb-3">
                                <input type="text" id="search-id" class="form-control" placeholder="Search by ID">
                            </div>
                            <div class="table-responsive-exp table-fixed-header">
                                <table id="solder-paste-table-expired" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Handover</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($today_entries_exp)): ?>
                                            <?php foreach ($today_entries_exp as $entry): ?>
                                                <tr datax-handover="<?= esc($entry['handover']); ?>" data-id="<?= esc($entry['id']); ?>">  
                                                    <td><?= esc($entry['id']); ?></td>
                                                    <td><?= esc($entry['lot_number']); ?></td>
                                                    <td><?= esc($entry['handover']); ?></td>
                                                    <td class="status">Normal</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">No entries for today.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fungsi lama yang menampilkan handover dan openusing -->
                    <!-- <div class="card mt-3"?>
                        <div class="card-header">
                            <h3 class="card-title">Solder Paste Out Off Time</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-exp table-fixed-header">
                                <table id="solder-paste-table-expired" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Handover</th>
                                            <th>Open</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($today_entries_exp)): ?>
                                            <?php foreach ($today_entries_exp as $entry): ?>
                                                <tr datax-handover="<?= esc($entry['handover']); ?>" datax-openusing="<?= esc($entry['openusing']); ?>">  
                                                    <td><?= esc($entry['id']); ?></td>
                                                    <td><?= esc($entry['lot_number']); ?></td>
                                                    <td><?= esc($entry['handover']); ?></td>
                                                    <td><?= esc($entry['openusing']); ?></td>
                                                    <td class="status"></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">No entries for today.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->

                </div>

                <div class="col-md-3">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Notifications</h3>
                        </div>
                        <div class="card-body">
                            <ul id="notif-cond" class="list-unstyled">
                                
                            </ul>
                            <div class="no-notification text-center mt-3">No new notifications</div>
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

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateRowColors() {
            const rows = document.querySelectorAll('#solder-paste-table-open tbody tr');
            const currentTime = new Date();

            rows.forEach(row => {
                const openusing = new Date(row.getAttribute('data-openusing'));
                
                let timeDiff = (currentTime - openusing) / 60000; 
                let rowClass = 'default-color'; 
                let statusText = '';
                
                if (timeDiff > 480) { // aktual waktu 8 jam = 480 menit
                    rowClass = 'table-danger';
                    statusText = 'Melebihi 8 jam';
                } else if (timeDiff > 360) { // aktual waktu 6 jam = 360 menit
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
</script> -->

<!-- fungsi baru untuk priority solder paste lebih dari 8 jam -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Function to filter rows based on search
        const searchInput = document.getElementById("search-id");

        searchInput.addEventListener("input", function () {
            const searchValue = searchInput.value.trim();
            const rows = Array.from(document.querySelectorAll('#solder-paste-table-open tbody tr'));

            rows.forEach(row => {
                const id = row.getAttribute("data-id");
                if (id && id.startsWith(searchValue)) {
                    row.style.display = "";  // Show matching row
                } else {
                    row.style.display = "none";  // Hide non-matching row
                }
            });
        });

        function updateRowColorsAndSort() {
            const rows = Array.from(document.querySelectorAll('#solder-paste-table-open tbody tr'));
            const currentTime = new Date();

            rows.forEach(row => {
                const openusing = new Date(row.getAttribute('data-openusing'));
                let timeDiff = (currentTime - openusing) / 60000; // Convert to minutes
                let rowClass = 'default-color';
                let statusText = '';
                let priority = 3; // Default priority for sorting

                if (timeDiff > 480) { // More than 8 hours
                    rowClass = 'table-danger';
                    statusText = 'Melebihi 8 jam';
                    priority = 1; // Highest priority
                } else if (timeDiff > 360) { // More than 6 hours
                    rowClass = 'table-warning';
                    statusText = 'Melebihi 6 jam';
                    priority = 2;
                } else {
                    statusText = 'Open';
                }

                row.className = rowClass;
                row.querySelector('.status').textContent = statusText;
                row.setAttribute('data-priority', priority); // Set priority for sorting
            });

            const sortedRows = rows.sort((a, b) => {
                return a.getAttribute('data-priority') - b.getAttribute('data-priority');
            });

            const tbody = document.querySelector('#solder-paste-table-open tbody');
            tbody.innerHTML = ''; // Clear existing rows
            sortedRows.forEach(row => tbody.appendChild(row)); // Append sorted rows
        }

        updateRowColorsAndSort();
        setInterval(updateRowColorsAndSort, 30000); // Update every 30 seconds
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function fetchUpdatedData() {
            fetch('<?= base_url("user/fetch_updated_solder_paste_exp") ?>')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#solder-paste-table-expired tbody');
                    tbody.innerHTML = ''; 

                    if (data.length > 0) {
                        data.forEach(entry => {
                            const row = document.createElement('tr');
                            row.setAttribute('datax-handover', entry.handover);
                            row.setAttribute('data-id', entry.id); 

                            row.innerHTML = `
                                <td><b>${entry.id}</td>
                                <td><b>${entry.lot_number}</td>
                                <td><b>${entry.handover}</td>
                                <td class="status"><b>Normal</td>
                            `;

                            tbody.appendChild(row);
                        });
                    } else {
                        const noDataRow = document.createElement('tr');
                        noDataRow.innerHTML = '<td colspan="5">No entries for today.</td>';
                        tbody.appendChild(noDataRow);
                    }
                })
                .catch(error => console.error('Error fetching updated data:', error));
        }

        document.getElementById('search-id').addEventListener('input', function () {
            const searchValue = this.value.trim();
            const rows = document.querySelectorAll('#solder-paste-table-expired tbody tr');

            rows.forEach(row => {
                const id = row.getAttribute('data-id').substring(0, 3);
                if (id.startsWith(searchValue)) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none';
                }
            });
        });

        fetchUpdatedData();
        setInterval(fetchUpdatedData, 30000);
    });
</script>


<!-- Fungsi lama yang menampilkan handover status normal
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function updateRowColors() {
            const rows = document.querySelectorAll('#solder-paste-table-expired tbody tr');
            const currentTime = new Date();

            rows.forEach(row => {
                const handoverAttr = row.getAttribute('datax-handover');

                let rowClass = 'default-color';
                let statusText = 'Normal';

                // if (handoverAttr) {
                //     const handoverTime = new Date(handoverAttr);
                //     const handoverDiff = (currentTime - handoverTime) / 60000; 

                //     if (handoverDiff > 2880) { // aktual waktu 2880 menit = 48 jam (2 hari)
                //         rowClass = 'table-danger';
                //         statusText = 'Out Off Time';
                //     }
                // }

                row.className = rowClass;
                row.querySelector('.status').textContent = statusText;
            });
        }

        updateRowColors();
        setInterval(updateRowColors, 30000); 
    });
</script> -->

<!-- Fungsi lama yang menampilkan handover dan openusing -->
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        function updateRowColors() {
            const rows = document.querySelectorAll('#solder-paste-table-expired tbody tr');
            const currentTime = new Date();

            rows.forEach(row => {
                const handoverAttr = row.getAttribute('datax-handover');
                const openusingAttr = row.getAttribute('datax-openusing');

                let rowClass = 'default-color';
                let statusText = 'Normal';

                if (openusingAttr) {
                    const openusingTime = new Date(openusingAttr);
                    const openusingDiff = (currentTime - openusingTime) / 60000; 

                    if (openusingDiff > 480) { // aktual waktu 8 jam (480 menit)
                        rowClass = 'table-danger';
                        statusText = 'Out Off Time';
                    }
                } else if (handoverAttr) {
                    const handoverTime = new Date(handoverAttr);
                    const handoverDiff = (currentTime - handoverTime) / 60000; 

                    if (handoverDiff > 2880) { // aktual waktu 2880 menit = 48 jam (2 hari)
                        rowClass = 'table-danger';
                        statusText = 'Out Off Time';
                    }
                }

                row.className = rowClass;
                row.querySelector('.status').textContent = statusText;
            });
        }

        updateRowColors();
        setInterval(updateRowColors, 30000); 
    });
</script> -->

<script>
    function saveTimestamp(column) {
    var SearchKey = document.getElementById('search_key').value;
    if (SearchKey) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('user/save_timeproduksi_search_key'); ?>'; 

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
                title: 'Input Tidak Lengkap',
                text: 'Tolong input Lot Number dan ID terlebih dahulu.',
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
                url: '<?= base_url('user/search_key_prod'); ?>',
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
                            notificationList += '<div class="notification-box">' +
                                '<span class="notification-text">' + item.lot_number + ' - ' + item.id + ' : Solder Paste sudah dibuka melewati dari batas waktu 8 jam!!!</span>' +
                                '</div>';
                        });

                        if (notificationList !== '') {
                            $('#notif-cond').html(notificationList);
                            localStorage.setItem('OverdueNotifications', 'true');
                        } else {
                            $('#notif-cond').html('<div class="no-notification">No new notifications</div>');
                            localStorage.setItem('OverdueNotifications', 'false');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
                        $('#notif-cond').html('<div class="no-notification">Error fetching notifications</div>');
                        localStorage.setItem('OverdueNotifications', 'false');
                    }
                });
            } else {
                $('#notif-cond').html('<div class="no-notification">No new notifications</div>');
                localStorage.setItem('OverdueNotifications', 'false');
            }
        }

        checkOverdueNotifications();
        setInterval(checkOverdueNotifications, 30000); 
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            var video = document.getElementById('video');
            video.srcObject = stream;
            video.play();
            Quagga.init({
                inputStream: {
                    constraints: {
                        width: 800,
                        height: 600,
                        facingMode: 'environment' // atau 'user' kamera depan
                    }
                },
                locator: {
                    patchSize: 'medium',
                    halfSample: true
                },
                decoder: {
                    readers: ['ean_reader', 'ean_8_reader'] // barcode types to scan
                }
            }, function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                console.log("Quagga initialized successfully");
                Quagga.start();
                Quagga.onDetected(function(result) {
                    var code = result.codeResult.code;
                    document.getElementById('lot_number').value = code;
                    Quagga.stop();
                });
            });
        })
        .catch(function(err) {
            console.log(err);
        });
    }
});
</script>

<style>
    .card-new {
        max-height: auto;
    }

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

    .no-notification {
        display: none;
    }

    .table-responsive {
        font-size: 62%;
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 390px;
    }

    .table-responsive-open {
        font-size: 75%;
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 240px;
        margin-bottom: 10px;
    }

    .table-responsive-open:hover {
        overflow-y: auto;
    }

    .table-responsive-exp {
        font-size: 55%;
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 240px;
        margin-bottom: 10px;
    }

    .table-responsive-exp:hover {
        overflow-y: auto;
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
