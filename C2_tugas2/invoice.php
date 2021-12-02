<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "transaction_jualbeliritel_c2";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}
$id_invoice = $_GET['id_invoice'];
$id_produk        = "";
$Qty             = "";
$nama_produk             = "";
$harga_produk     = "";
$jumlah = "";
$nama_pegawai   = "";
$tanggal_transaksi = "";
$jenis_pembayaran  = "";
$sukses     = "";
$error      = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

                        $sql1   = "select id_invoice,pegawai.nama_pegawai, tanggal_transaksi, jenis_pembayaran from transaksi inner join pegawai on transaksi.id_pegawai = pegawai.id_pegawai where id_invoice = '$id_invoice'";
                        $q1     = mysqli_query($koneksi, $sql1);
                        while ($r1 = mysqli_fetch_array($q1)) {
                            $id_invoice = $r1["id_invoice"];
                            $nama_pegawai =    $r1["nama_pegawai"];
                            $tanggal_transaksi =    $r1["tanggal_transaksi"];
                            $jenis_pembayaran =    $r1["jenis_pembayaran"];
                        }    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Nota Terpilih</title>
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
<a href=transaksi_contoh.php><button type="button" class="btn btn-primary">Buat Transaksi Baru</button></a>
<body>
<div class="mx-auto">
    <div class="card">
            <div class="card-header text-white bg-secondary">
                Invoice Belanja
            </div>
            <div class="card-body">
            <form action="" method="POST">
                <table class="table">
                    <thead>
                    <div >
                            ID Invoice : <?php echo $id_invoice; ?>
                        </div>
                        <div>
                            Tanggal Transaksi: (<?php echo $tanggal_transaksi; ?>)
                        </div>
                        <div>
                            Nama Pegawai : <?php echo $nama_pegawai; ?>
                        </div>
                        <div>
                            Jenis Pembayaran : <?php echo $jenis_pembayaran; ?>
                        </div>
                        <tr>
                            
                            <th scope="col-12">ID Produk</th>
                            <th scope="col-12">Nama Produk</th>
                            <th scope="col-12">Harga Barang</th>
                            <th scope="col-12">Jumlah Produk</th>
                            <th scope="col-12">Total</th>
                            
                        </tr>
                        <div class="col-12">
                        
                    </div>   
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select detailinvoice.id_invoice,produk.id_produk,produk.nama_produk,detailinvoice.Qty,produk.harga_produk,detailinvoice.Qty * produk.harga_produk as jumlah from detailinvoice inner join produk on detailinvoice.id_produk = produk.id_produk where id_invoice = '$id_invoice'";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            
                            $id_produk     = $r2['id_produk'];
                            $nama_produk = $r2['nama_produk'];
                            $harga_produk = $r2['harga_produk'];
                            $Qty = $r2['Qty'];
                            $jumlah = $r2['jumlah'];
                            $sql3   = "update detailinvoice set jumlah = '$jumlah' where id_invoice = '$id_invoice' and id_produk = '$id_produk'";
                            $q3 = mysqli_query($koneksi, $sql3)
                        ?>
                            <tr >
                                
                                <td scope="col-12"><?php echo $id_produk ?></td>
                                <td scope="col-12"><?php echo $nama_produk ?></td>
                                <td scope="col-12"><?php echo $harga_produk ?></td>
                                <td scope="col-12"><?php echo $Qty ?></td>
                                <td scope="col-12"><?php echo $jumlah ?></td>
                                
                                
                                <td scope="col-12">
                                                
                                </td>
                            </tr>
                        <?php
                        }
                        $sqsum = "select sum(jumlah) as subtotal from detailinvoice where id_invoice = '$id_invoice'";
                        $qsum = mysqli_query($koneksi, $sqsum);
                        while ($rsum = mysqli_fetch_array($qsum)) {
                            $subtotal = $rsum['subtotal'];
                        ?>
                    </tbody>  
                </table>
                <div>
                    <h5>Sub Total = Rp <?php echo $subtotal  ?></h5>
                    <h5> Terimakasih Telah Berbelanja </h5>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>