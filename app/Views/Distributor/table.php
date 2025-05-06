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
    <table id="distributorTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Region</th>
                <th>Distributor</th>
                <th>Alamat</th>
                <th>Area</th>
            </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- JS dependencies for buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function() {
    $('#distributorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= base_url('distributor/data') ?>",
        order: [[0, 'asc']],
        dom: 'Bfrtip', // Tambahkan dom untuk tombol
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export ke Excel',
                className: 'btn btn-success',
                title: 'Data Distributor'
            }
        ]
    });
});
</script>
</body>
</html>
