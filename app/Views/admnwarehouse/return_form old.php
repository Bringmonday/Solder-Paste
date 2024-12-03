<?= $this->extend('layout/admnwarehouse') ?>

<?= $this->section('title') ?>
Return Form
<?= $this->endSection() ?>

<?= $this->section('content_header') ?>
<h1>Return Form</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content">
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Solder Paste</h3>
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

                            <div class="form-group">
                                <label for="lot_number">Lot Number</label>
                                <input type="text" class="form-control" id="lot_number" name="lot_number" placeholder="Enter Lot Number" autocomplete="off" oninput="handleBarcodeScan(this.value)">
                                <input type="hidden" id="id" name="id">
                                <div id="lot_number_results"></div> 
                            </div>

                            <div class="btn-submit-reset">
                                <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                                <button type="button" class="btn btn-primary btn-submit" onclick="submitForm()">Submit</button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <h4>Tabel Return</h4>
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Lot Number</th>
                                        <th>Return</th>
                                    </tr>
                                </thead>
                                <tbody id="temp-data">
                                    <?php foreach ($today_entries_rtn as $row): ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['lot_number'] ?></td>
                                            <td><?= $row['returnsp'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
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
    $(document).ready(function() {
        $('#lot_number').on('input', function() {
            var searchValue = $(this).val().trim();
            if (searchValue.length >= 2) {
                $.ajax({
                    url: "<?php echo base_url('user/search_keys_lot_number'); ?>",
                    type: 'GET',
                    dataType: 'json',
                    data: { q: searchValue },
                    success: function(response) {
                        displaySearchResults(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                    }
                });
            } else {
                $('#lot_number_results').empty();
            }
        });

        function displaySearchResults(results) {
            var html = '<ul class="list-group">';
            for (var i = 0; i < results.length; i++) {
                html += '<li class="list-group-item">' + results[i].lot_number + '</li>';
            }
            html += '</ul>';
            $('#lot_number_results').html(html);
        }

        $(document).on('click', '#lot_number_results .list-group-item', function() {
            var selectedKey = $(this).text();
            $('#lot_number').val(selectedKey);
            $('#lot_number_results').empty();
        });

        loadReturnData();
    });

    function submitForm() {
        var lot_number = $('#lot_number').val();
        var id = $('#id').val();

        $.ajax({
            type: 'POST',
            url: '<?= site_url('user/update_lot_number') ?>', 
            dataType: 'json',
            data: {
                lot_number: lot_number,
                id: id
            },
            success: function(response) {
                if (response.status == 'success') {
                    alert('Solder Paste Berhasil di Return.');
                    resetFields();
                    loadReturnData();
                    
                    // Redirect ke halaman return_form
                    window.location.href = '<?= site_url('admnwarehouse/return_form') ?>';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + ' - ' + error);
            }
        });
    }


    // Fungsi untuk mereset field form
    function resetFields() {
        $('#lot_number').val('');
        $('#id').val('');
        $('#lot_number_results').empty();
        $('#lot_number').focus();
    }

    function loadReturnData() {
        $.ajax({
            url: "<?php echo base_url('user/display_return_data'); ?>",
            type: 'GET',
            dataType: 'html',
            success: function(response) {
                $('#temp-data').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("lot_number").focus();
    });
</script>

<style>

    #lot_number_results {
        max-height: 200px;
        overflow-y: auto; 
    } 

    .card-body {
        font-size: 15px; 
    }

    .btn-submit-reset {
        display: flex;
        justify-content: space-between;
    }

    .btn-submit-reset .btn {
        min-width: 50px; /* Menambahkan lebar minimum pada tombol */
    }

    .btn-submit-reset .btn-submit {
        margin-left: auto; /* Menempatkan tombol submit di pojok kanan */
    }

</style>

<?= $this->endSection() ?>
