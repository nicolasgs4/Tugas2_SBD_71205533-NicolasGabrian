<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "transaction_jualbeliritel_c2";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}
$id_invoice           ="";
$id_pegawai           ="";
$tanggal_transaksi             = "";
$jenis_pembayaran     ="";

$sukses     = "";
$error      = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id_invoice   = $_GET['id_invoice'];
    $sql1       = "delete from transaksi where id_invoice = '$id_invoice'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id_invoice    = $_GET['id_invoice'];
    $sql1       = "select * from transaksi where id_invoice = '$id_invoice'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $id_pegawai = $r1['id_pegawai'];
    $tanggal_transaksi       = $r1['tanggal_transaksi'];
    $jenis_pembayaran        = $r1['jenis_pembayaran'];
    
    

    if ($id_invoice == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) {
    $id_invoice   = $_POST['id_invoice'];
    $id_pegawai        = $_POST['id_pegawai'];
    $tanggal_transaksi       = $_POST['tanggal_transaksi'];
    $jenis_pembayaran  = $_POST['jenis_pembayaran'];
    

    if ($id_invoice && $id_pegawai && $tanggal_transaksi && $jenis_pembayaran) {
        if ($op == 'edit') {
            $sql1       = "update transaksi set id_invoice = $id_invoice,tanggal_transaksi= $tanggal_transaksi, jenis_pembayaran = $jenis_pembayaran where id_invoice = '$id_invoice'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else {
            $sql1   = "insert into transaksi(id_invoice,id_pegawai,tanggal_transaksi,jenis_pembayaran) values ($id_invoice,$id_pegawai, '$tanggal_transaksi','$jenis_pembayaran')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
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
    <title>Tabel Tarsakasi</title>
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
            <div class="card-header">
                Tabel Transaksi

            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=transaksi_contoh.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=transaksi_contoh.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="id_invoice" class="col-sm-2 col-form-label">ID Invoice</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_invoice" name="id_invoice" value="<?php echo $id_invoice ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_pegawai" class="col-sm-2 col-form-label">ID Pegawai</label>
                        <div class="col-sm-10">
                            <select name="id_pegawai" id%="id_pegawai" class="form-control" required>
                                <option value="">- Pilih Pegawai -</option>
                                <?php
                                $sql_id_pegawai = mysqli_query($koneksi, "SELECT id_pegawai,nama_pegawai FROM pegawai") or die (mysqli_error($koneksi));
                                while($id_pegawai = mysqli_fetch_array($sql_id_pegawai)) {
                                echo '<option value ="'.$id_pegawai ['id_pegawai']. '" > '.$id_pegawai['id_pegawai']. '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_transaksi" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="<?php echo $tanggal_transaksi ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jenis_pembayaran" class="col-sm-2 col-form-label">Jenis Pembayaran</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis_pembayaran" id="jenis_pembayaran">
                                <option value="">- Pilih Jenis Pembayaran -</option>
                                <option value="Cash" <?php if ($jenis_pembayaran == "Cash") echo "selected" ?>>Cash</option>
                                <option value="Credit" <?php if ($jenis_pembayaran == "Credit") echo "selected" ?>>Credit</option>
                                <option value="Debit" <?php if ($jenis_pembayaran == "Debit") echo "selected" ?>>Debit</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        <a href="menu_user.php"><button type="button" class="btn btn-danger" class="float-right">Kembali</button></a>
                        <a href="tabel_detailinvoice.php"><button type="button" class="btn btn-warning" class="float-right">Masukkan Barang ke Keranjang --></button></a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Transaksi
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col-12">ID Invoice</th>
                            <th scope="col-12">ID Pegawai</th>
                            <th scope="col-12">Tanggal Transaksi</th>
                            <th scope="col-12">Jenis Pembayaran</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from transaksi order by id_invoice desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id_invoice         = $r2['id_invoice'];
                            $id_pegawai       = $r2['id_pegawai'];
                            $tanggal_transaksi      = $r2['tanggal_transaksi'];
                            $jenis_pembayaran = $r2['jenis_pembayaran'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $id_invoice ?></th>
                                <td scope="row"><?php echo $id_pegawai ?></td>
                                <td scope="row"><?php echo $tanggal_transaksi ?></td>
                                <td scope="row"><?php echo $jenis_pembayaran ?></td>
                                <td scope="row">
                                    <a href="transaksi_contoh.php?op=edit&id_invoice=<?php echo $id_invoice ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="transaksi_contoh.php?op=delete&id_invoice=<?php echo $id_invoice?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>