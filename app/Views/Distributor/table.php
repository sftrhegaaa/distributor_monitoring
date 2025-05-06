<!DOCTYPE html>
<html>

<head>
    <title>Data Distributor</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

</head>

<body>
    <div class="container mt-5">
        <h3>Master Distributor</h3>
        <!-- Filter Region -->
        <div class="mb-3">
            <label for="region-filter" class="form-label">Filter by Region</label>
            <select id="region-filter" class="form-select">
                <option value="">-- Pilih Region --</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['kode_region'] ?>"><?= $region['nama_region'] ?> (<?= $region['area'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">

            <a href="<?= base_url('distributor/create/') ?>" class="btn btn-primary btn-sm">Add</a>
        </div>
        <div id="filtered-count" class="my-2 fw-bold text-primary"></div>


        <table id="distributorTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Region</th>
                    <th>Distributor</th>
                    <th>Alamat</th>
                    <th>Area</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>


    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        Detail Distributor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Kode Distributor:</strong> <span id="detail-kode-distributor"></span></p>
                    <p><strong>Nama Distributor:</strong> <span id="detail-nama-distributor"></span></p>
                    <p><strong>Region:</strong> <span id="detail-kode-region"></span></p>
                    <p><strong>Nama Region:</strong> <span id="detail-nama-region"></span></p>
                    <p><strong>Area:</strong> <span id="detail-area"></span></p>
                    <p><strong>Owner:</strong> <span id="detail-nama-owner"></span></p>
                    <p><strong>Alamat:</strong> <span id="detail-alamat"></span></p>

                    <div id="detail-territories" style="display: none;">
                        <hr>
                        <h6>Territory:</h6>
                        <ul id="territory-list"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Detail -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- JS dependencies for buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#distributorTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('distributor/data') ?>",
                    data: function (d) {
                        d.region_filter = $('#region-filter').val(); // Tambahkan parameter custom
                    },
                },
                order: [[0, 'asc']],
                dom: 'Bfrtip', // Tambahkan dom untuk tombol
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export ke Excel',
                        className: 'btn btn-success',
                        title: 'Data Distributor'
                    }
                ],
                columns: [
                    { title: "Region" },
                    { title: "Nama Distributor" },
                    { title: "Alamat" },
                    { title: "Area" },
                    { title: "Aksi", orderable: false, searchable: false }
                ]
            });

            
            // Menangkap event xhr untuk mendapatkan jumlah filtered data
            table.on('xhr', function (e, settings, json) {
                if (json && typeof json.recordsFiltered !== 'undefined') {
                    $('#filtered-count').text('Jumlah data setelah filter: ' + json.recordsFiltered);
                }
            });
            // Reload saat filter berubah
            $('#region-filter').on('change', function () {
                table.ajax.reload();

            });
        });
        function modelDetail(ini) {
            var kodeDistributor = $(ini).data('kode-distributor');

            // Clear previous data
            $('#detail-kode-distributor').text('');
            $('#detail-nama-distributor').text('');
            $('#detail-kode-region').text('');
            $('#detail-nama-region').text('');
            $('#detail-area').text('');
            $('#detail-nama-owner').text('');
            $('#detail-alamat').text('');
            $('#territory-list').empty();
            $('#detail-territories').hide();

            // Fetch data via AJAX
            $.ajax({
                url: "<?= base_url('distributor/detail'); ?>", // Endpoint untuk mengambil detail
                type: "GET",
                data: { kode_distributor: kodeDistributor },
                success: function (response) {
                    // Populate modal with data
                    $('#detail-kode-distributor').text(response.data.kode_distributor);
                    $('#detail-nama-distributor').text(response.data.nama_distributor);
                    $('#detail-kode-region').text(response.data.kode_region);
                    $('#detail-nama-region').text(response.data.nama_region);
                    $('#detail-area').text(response.data.area);
                    $('#detail-nama-owner').text(response.data.nama_owner);
                    $('#detail-alamat').text(response.data.alamat);

                    // Populate territories if available
                    if (response.data.territories && response.data.territories.length > 0) {
                        response.data.territories.forEach(function (territory) {
                            $('#territory-list').append('<li>' + territory.kode_territory + '-' + territory.nama_territory + '</li>');
                        });
                        $('#detail-territories').show();
                    }
                    $('#detailModal').modal('show'); // Show the modal
                },
                error: function () {
                    alert('Gagal mengambil data distributor.');
                }
            });
        }
    </script>
</body>

</html>