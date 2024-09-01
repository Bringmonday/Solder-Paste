<!-- File: app/Views/admnwarehouse/warehouse_form.php -->
<?= $this->extend('layout/admnwarehouse'); ?>

<?= $this->section('title'); ?>
Incoming
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Incoming</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Solder Paste</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display flashdata messages -->
                            <?php if (session()->has('success')): ?>
                                <div class="alert alert-success">
                                    <?= session('success') ?>
                                </div>
                            <?php endif ?>

                            <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session('error') ?>
                                </div>
                            <?php endif ?>
                            
                            <!-- Form start -->
                            <form id="formWarehouse">
                                <div class="form-group">
                                    <label for="lot_number">Lot Number</label>
                                    <input type="text" class="form-control" id="lot_number" name="lot_number" placeholder="Enter Lot Number" autocomplete="off" oninput="handleBarcodeScan(this.value)"> 
                                    <div id="search_results"></div>
                                </div>
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" id="id" name="id" placeholder="Enter Code" autocomplete="off" maxlength="3" pattern="\d{1,3}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);">
                                </div>
                                <!-- Box footer with submit button -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-success float-right" style="margin-left: 5px" onclick="submitData()">Submit</button>
                                    <button type="button" class="btn btn-primary float-right" onclick="addTempEntry()">Add</button>
                                    <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                                </div>
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            </form>
                        </div>
                        <div class="card-body">
                            <h4>Temporary Data</h4>
                            <button onclick="resetTempEntries()" class="btn btn-danger mb-2">Reset Table</button>
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Lot Number</th>
                                        <th>Incoming</th>
                                    </tr>
                                </thead>
                                <tbody id="temp-data">
                                    <!-- Temporary data will be displayed here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    let tempData = [];

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('lot_number').focus();
        loadTempDataFromLocalStorage();
        renderTempData();
    });

    var barcodeScanTimeout;

    function handleBarcodeScan(barcodeValue) {
        clearTimeout(barcodeScanTimeout);
        document.getElementById('lot_number').value = barcodeValue;
        barcodeScanTimeout = setTimeout(function() {
            document.getElementById('id').focus();
        }, 10000);
    }

    document.addEventListener('keydown', function (e) {
        var lotNumberInput = document.getElementById('lot_number');
        if (e.key === 'Enter' && lotNumberInput.value.trim() !== '') {
            clearTimeout(barcodeScanTimeout);
            document.getElementById('id').focus();
        }
    });

    function resetFields() {
        document.getElementById('lot_number').value = '';
        document.getElementById('id').value = '';
        document.getElementById('lot_number').focus();
    }

    function addTempEntry() {
        var lot_number = document.getElementById('lot_number').value.trim();
        var id = document.getElementById('id').value.trim();

        if (lot_number !== '' && id !== '') {
            // Add entry directly without checking for duplicates
            var entry = {
                lot_number: lot_number,
                id: id,
                incoming: getCurrentDateTime()
            };

            tempData.push(entry);
            renderTempData();
            saveTempDataToLocalStorage();
            resetFields();
            document.getElementById('lot_number').focus();
        } else {
            alert('Tolong input Lot Number atau ID terlebih dahulu.');
            document.getElementById('lot_number').focus();
        }
    }

    function submitData() {
        if (tempData.length === 0) {
            alert('Tolong input Lot Number atau ID terlebih dahulu.');
            document.getElementById('lot_number').focus();
            return;
        }

        fetch('<?= base_url('user/save_temp_data'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
            },
            body: JSON.stringify({ tempData: tempData })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            tempData = []; 
            saveTempDataToLocalStorage();
            renderTempData();
            document.getElementById('lot_number').focus();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to save data.');
        });
    }

    function saveTempDataToLocalStorage() {
        localStorage.setItem('tempData', JSON.stringify(tempData));
        console.log('Data saved to localStorage:', tempData);
    }

    function loadTempDataFromLocalStorage() {
        var data = localStorage.getItem('tempData');
        if (data) {
            tempData = JSON.parse(data);
            console.log('Data loaded from localStorage:', tempData);
            renderTempData();
        } else {
            console.log('No data found in localStorage');
        }
    }

    function renderTempData() {
        var tempHtml = '';
        var today = new Date().toISOString().slice(0, 10);

        tempData.forEach(function (entry) {
            if (entry.incoming.slice(0, 10) === today) {
                tempHtml += '<tr>';
                tempHtml += '<td>' + entry.id + '</td>';
                tempHtml += '<td>' + entry.lot_number + '</td>';
                tempHtml += '<td>' + entry.incoming + '</td>';
                tempHtml += '</tr>';
            }
        });

        document.getElementById('temp-data').innerHTML = tempHtml;
    }

    function getCurrentDateTime() {
        var now = new Date();
        var year = now.getFullYear();
        var month = ('0' + (now.getMonth() + 1)).slice(-2);
        var day = ('0' + now.getDate()).slice(-2);
        var hours = ('0' + now.getHours()).slice(-2);
        var minutes = ('0' + now.getMinutes()).slice(-2);
        var seconds = ('0' + now.getSeconds()).slice(-2);
        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    }

    function resetTempEntries() {
        tempData = [];
        localStorage.removeItem('tempData');
        renderTempData();
        document.getElementById('lot_number').focus();
    }
</script>

<script>
    function handleBarcodeScan(value) {
        if (value.length >= 2) {
            $.ajax({
                url: '<?= base_url('user/search_key_incoming'); ?>',
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

    function displaySearchResults(data) {
        var resultsContainer = $('#search_results');
        resultsContainer.empty();
        
        if (data.length > 0) {
            var list = $('<ul class="search-results-list"></ul>');
            $.each(data, function(index, item) {
                $('<li></li>').text(item.lot_number).on('click', function() {
                    $('#lot_number').val(item.lot_number);
                    $('#search_results').empty();
                }).appendTo(list);
            });
            resultsContainer.append(list);
        } else {
            resultsContainer.append('<p>No results found.</p>');
        }
    }

    $(document).ready(function() {
        $('#lot_number').on('input', function() {
            handleBarcodeScan($(this).val());
        });
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
        font-size: 12.5px;
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 390px;
    }

    .table-responsive:hover {
        overflow-y: auto;
    }
    
    .table-fixed-header thead th {
        position: sticky;
        top: 0;
        background-color: #d3d3d3;
        z-index: 999;
    }

    @media (max-width: 600px) {
        .notification-box {
            max-width: 100%;
        }
    }
</style>

<?= $this->endSection(); ?>
