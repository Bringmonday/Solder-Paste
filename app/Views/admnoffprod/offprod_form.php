<!-- File: app/Views/admnwarehouse/warehouse_form.php -->
<?= $this->extend('layout/admnoffprod'); ?>

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
                    <div class="card">
                        <div class="card-header card-padding">
                            <h3 class="card-title">Solder Paste</h3>
                        </div>
                        <div class="card-body">            
                            <!-- Form start -->
                            <form id="formOffprod">
                                <div class="form-group">
                                    <label for="lot_number">Lot Number</label>
                                    <input type="text" class="form-control" id="lot_number" name="lot_number" placeholder="Enter Lot Number" autocomplete="off" oninput="handleBarcodeScan(this.value)"> 
                                </div>
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" id="id" name="id" placeholder="Enter ID" autocomplete="off" maxlength="3" pattern="\d{1,3}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);">
                                </div>
                                <!-- Box footer with submit button -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-success float-right" style="margin-left: 5px" onclick="submitData()">Submit</button>
                                    <button type="button" class="btn btn-rs float-right" onclick="addTempEntry()">Add</button>
                                    <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                                </div>
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            </form>
                        </div>
                        <div class="card-body">
                            <h4>Temporary Data</h4>
                            <button onclick="resetTempEntries()" class="btn btn-outline-danger mb-2">Reset Table</button>
                            <div class="table-container">
                                <table class="table table-bordered">
                                    <thead class="thead-rs">
                                        <tr>
                                            <th>ID</th>
                                            <th>Lot Number</th>
                                            <th>Incoming</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="temp-data">
                                        
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
        }, 500);
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
        if (tempData.length >= 20) {
            Swal.fire({
                title: 'Limit Add Data',
                text: 'Hanya dapat add data sebanyak 20 data.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;  
        }

        var lot_number = document.getElementById('lot_number').value.trim();
        var id = document.getElementById('id').value.trim();

        if (lot_number !== '' && id !== '') {
            var search_key = lot_number + id;  

            fetch('<?= base_url('user/check_data_exists'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
                },
                body: JSON.stringify({ lot_number: lot_number, id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    Swal.fire({
                        title: 'Data sudah ada',
                        text: 'Lot Number dan ID sudah ada di database.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else {
                    var entry = {
                        lot_number: lot_number,
                        id: id,
                        search_key: search_key,  
                        incoming: getCurrentDateTime()
                    };

                    tempData.push(entry);
                    renderTempData();
                    saveTempDataToLocalStorage();
                    resetFields();
                    document.getElementById('lot_number').focus();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal memeriksa data di database.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
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


    function submitData() {
        if (tempData.length === 0) {
            Swal.fire({
                title: 'Tidak Ada Data',
                text: 'Tolong input Lot Number atau ID terlebih dahulu.',
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then(() => {
                document.getElementById('lot_number').focus();
            });
            return;
        }

        fetch('<?= base_url('user/save_temp_dataoff'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
            },
            body: JSON.stringify({ tempData: tempData })
        })
        .then(response => response.json())
        .then(data => {
            if (data.existingData && data.existingData.length > 0) {
                let existingMessage = 'Lot Number dan ID berikut sudah ada dalam database \n';
                data.existingData.forEach(item => {
                    existingMessage += `. Data : ${item.lot_number}-${item.id}\n`;
                });
                Swal.fire({
                    title: 'Data sudah ada',
                    text: existingMessage,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Success',
                    text: 'Data berhasil disimpan!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });

                tempData = [];
                saveTempDataToLocalStorage();
                renderTempData();
                document.getElementById('lot_number').focus();
            }
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

        tempData.forEach(function (entry, index) {
            if (entry.incoming.slice(0, 10) === today) {
                tempHtml += '<tr>';
                tempHtml += '<td>' + entry.id + '</td>';
                tempHtml += '<td>' + entry.lot_number + '</td>';
                tempHtml += '<td>' + entry.incoming + '</td>';
                tempHtml += '<td><button onclick="deleteTempEntry(' + index + ')" class="btn btn-danger btn-sm">Delete</button></td>';
                tempHtml += '</tr>';
            }
        });

        document.getElementById('temp-data').innerHTML = tempHtml;
    }

    function deleteTempEntry(index) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus dari tabel sementara!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                tempData.splice(index, 1);
                saveTempDataToLocalStorage();
                renderTempData();
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
            }
        });
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
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Seluruh data sementara akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                tempData = [];
                localStorage.removeItem('tempData');
                renderTempData();
                document.getElementById('lot_number').focus();
                Swal.fire(
                    'Berhasil!',
                    'Tabel telah direset.',
                    'success'
                );
            }
        });
    }
</script>

<style>
    .thead-rs {
        background-color: #f5911f;
        color: #000;
    }

    .card-header {
        background-color: #0069aa;
        color: #fff;

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

<?= $this->endSection(); ?>
