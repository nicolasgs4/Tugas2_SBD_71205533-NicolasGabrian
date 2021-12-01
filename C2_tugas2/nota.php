<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "transaction_jualbeliritel_c2";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}
$id_invoice          ="";



if (isset($_POST['simpan'])) {
    $id_invoice   = $_POST['id_invoice'];
    if ($id_invoice) {
        ?>
        <meta http-equiv='refresh' content='0; URL=invoice.php?id_invoice=<?php echo $id_invoice ?>'>
        <?php
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pemilihan Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="mx-auto">
    <div class="card">
        <div class="card-header text-white bg-secondary">
                Tampilkan Nota Per ID Invoice
        </div>
        <div class="card-body">
            <form action="" method="POST">
            <div class="mb-3 row">
                  <label for="id_invoice" class="col-sm-2 col-form-label">ID Invoice</label>
                  <div class="col-sm-10">
                        <select name="id_invoice" id="id_invoice" class="form-control" required>
                        <option value="">- Pilih ID Invoice -</option>
                        <?php
                        $sql_id_invoice = mysqli_query($koneksi, "SELECT id_invoice FROM transaksi") or die (mysqli_error($koneksi));
                        while($id_invoice = mysqli_fetch_array($sql_id_invoice)) {
                           echo '<option value ="'.$id_invoice ['id_invoice'].'" > '.$id_invoice['id_invoice']. '</option>';
                        } ?>
                        </select>
                  </div>
                </div>
                <div class="col-12">
                        <input type="submit" name="simpan" value="Select" class="btn btn-primary" />
                        
                        <a href=tabel_detailinvoice.php><button type="button" class="btn btn-primary"><-- Kembali</button></a>
                </div>
            </div>
        </div>
                    </div>
</body>