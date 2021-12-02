<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "transaction_jualbeliritel_c2";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Tidak bisa terkoneksi ke database");
}
$id_invoice      = "";
$id_produk    = "";
$Qty   = "";


$sukses = "";
$error = "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id_invoice         = $_GET['id_invoice'];
    $sql1       = "delete from detailinvoice where id_invoice = '$id_invoice'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if($op == 'edit'){
    $id_invoice = $_GET['id_invoice'];
    $sql1      = "select * from detailinvoice where id_invoice = '$id_invoice'";
    $q1        = mysqli_query($koneksi,$sql1);
    $r1        = mysqli_fetch_array($q1);
    $id_produk = $r1['id_produk'];
    $Qty = $r1['Qty'];
    
    if($id_invoice == "" ){
        $error = "Data tidak ditemukan";
    }
}



if (isset($_POST['simpan'])) { 
    $id_invoice        = $_POST['id_invoice'];
    $id_produk       = $_POST['id_produk'];
    $Qty     = $_POST['Qty'];

    if ($id_invoice && $id_produk && $Qty) {
        $sql1   = "insert into detailinvoice (id_invoice, id_produk, Qty) Values ($id_invoice,$id_produk, $Qty)";
        $sqlup = "update detailinvoice set Qty = Qty + $Qty where id_invoice=$id_invoice and id_produk = $id_produk";
        $sqlsel = "select * from detailinvoice where id_produk = $id_produk";
        $kurang = "update produk set stock_produk = stock_produk - $Qty where id_produk = $id_produk";
        $qsel     = mysqli_query($koneksi, $sqlsel);
        $sel     = mysqli_fetch_array($qsel);
        if (empty($sel)) {
            $q1 = mysqli_query($koneksi,$sql1);
            if($q1) {
                $sukses     = "Berhasil memasukkan data baru";
                $q3 = mysqli_query($koneksi,$kurang);
            } else {
                $error      = "Gagal memasukkan data";
            }
        } else {
            $qup = mysqli_query($koneksi,$sqlup);
            $q3 = mysqli_query($koneksi,$kurang);
            $sukses     = "Berhasil menambahkan data";
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
    <title>Data Transaksi Ritel Jual-Beli</title>
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
    <a href=menu_user.php><button type="button" class="btn btn-primary"><-- Kembali</button></a>
    <a href=main_menu.php><button type="button" class="btn btn-primary">Menu Utama</button></a>

        <div class="card">
            <div class="card-header">
                Keranjang Belanja
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:1;url=tabel_detailinvoice.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:1;url=tabel_detailinvoice.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="id_invoice" class="col-sm-2 col-form-label">ID Invoice</label>
                        <div class="col-sm-10">
                        <select name="id_invoice" id%="id_invoice" class="form-control" required>
                                <option value="">- Pilih Invoice -</option>
                                <?php
                                $sql_id_invoice = mysqli_query($koneksi, "SELECT id_invoice FROM transaksi") or die (mysqli_error($koneksi));
                                while($id_invoice = mysqli_fetch_array($sql_id_invoice)) {
                                echo '<option value ="'.$id_invoice ['id_invoice']. '" > '.$id_invoice['id_invoice']. '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="id_produk" class="col-sm-2 col-form-label">ID Produk</label>
                        <div class="col-sm-10">
                        <select name="id_produk" id%="id_produk" class="form-control" required>
                                <option value="">- Pilih Produk -</option>
                                <?php
                                $sql_id_produk = mysqli_query($koneksi, "SELECT id_produk,nama_produk FROM produk") or die (mysqli_error($koneksi));
                                while($id_produk = mysqli_fetch_array($sql_id_produk)) {
                                echo '<option value ="'.$id_produk ['id_produk']. '" > '.$id_produk['id_produk'].' - '.$id_produk['nama_produk']. '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Qty" class="col-sm-5 col-form-label">Quantity</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="Qty" name="Qty" value="<?php echo $Qty ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        <a href=nota.php><button type="button" class="btn btn-primary">Cetak Nota</button></a>
                    </div>
                </form>
            </div>
        </div>



        
    </div>
</body>

</html>