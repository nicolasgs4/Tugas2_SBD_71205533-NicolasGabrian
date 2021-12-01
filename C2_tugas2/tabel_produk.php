<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "transaction_jualbeliritel_c2";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Tidak bisa terkoneksi ke database");
}
$id_produk      = "";
$nama_produk    = "";
$jenis_produk   = "";
$harga_produk   = "";
$stock_produk   = "";

$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id_produk         = $_GET['id_produk'];
    $sql1       = "delete from produk where id_produk = '$id_produk'";
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
    $id_produk = $_GET['id_produk'];
    $sql1      = "select * from produk where id_produk = '$id_produk'";
    $q1        = mysqli_query($koneksi,$sql1);
    $r1        = mysqli_fetch_array($q1);
    $nama_produk = $r1['nama_produk'];
    $jenis_produk = $r1['jenis_produk'];
    $harga_produk = $r1['harga_produk'];
    $stock_produk = $r1['stock_produk'];

    if($nama_produk == "" ){
        $error = "Data tidak ditemukan";
    }
}



if (isset($_POST['simpan'])) { 
    $id_produk        = $_POST['id_produk'];
    $nama_produk       = $_POST['nama_produk'];
    $jenis_produk     = $_POST['jenis_produk'];
    $harga_produk   = $_POST['harga_produk'];
    $stock_produk   = $_POST['stock_produk'];

    if ($id_produk && $nama_produk && $jenis_produk && $harga_produk && $stock_produk) {
        if ($op == 'edit') { 
            $sql1       = "update produk set id_produk = '$id_produk',nama_produk ='$nama_produk',jenis_produk = '$jenis_produk',harga_produk='$harga_produk',stock_produk = '$stock_produk' where id_produk = '$id_produk'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { 
            $sql1   = "insert into produk(id_produk,nama_produk,jenis_produk,harga_produk,stock_produk) values ('$id_produk','$nama_produk','$jenis_produk','$harga_produk','$stock_produk')";
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
    <title>Data Ritel Jual-Beli</title>
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
    <a href=menu_admin.php><button type="button" class="btn btn-primary"><-- Kembali</button></a>
    <a href=main_menu.php><button type="button" class="btn btn-primary">Menu Utama</button></a> 

        <div class="card">
            <div class="card-header">
                Create / Edit Data Produk
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:1;url=tabel_produk.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:1;url=tabel_produk.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="id_produk" class="col-sm-2 col-form-label">ID Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_produk" name="id_produk" value="<?php echo $id_produk ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_produl" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $nama_produk ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="harga_produk" class="col-sm-2 col-form-label">Harga Produk (dalam Rupiah)</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="harga_produk" name="harga_produk" value="<?php echo $harga_produk ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="stock_produk" class="col-sm-2 col-form-label">Stock Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="stock_produk" name="stock_produk" value="<?php echo $stock_produk ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jenis_produk" class="col-sm-2 col-form-label">Jenis Produk</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis_produk" id="jenis_produk">
                                <option value="">- Pilih Jenis Produk -</option>
                                <option value="Makanan" <?php if ($jenis_produk == "Makanan") echo "selected" ?>>Makanan</option>
                                <option value="Minuman" <?php if ($jenis_produk == "Minuman") echo "selected" ?>>Minuman</option>
                                <option value="Barang" <?php if ($jenis_produk == "Barang") echo "selected" ?>>Barang</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Ritel
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Produk</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Jenis Produk</th>
                            <th scope="col">Harga Produk</th>
                            <th scope="col">Stock Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from produk order by id_produk";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id_produk        = $r2['id_produk'];
                            $nama_produk       = $r2['nama_produk'];
                            $jenis_produk     = $r2['jenis_produk'];
                            $harga_produk   = $r2['harga_produk'];
                            $stock_produk   = $r2['stock_produk'];

                        ?>
                            <tr>
                                
                                <td scope="row"><?php echo $id_produk ?></td>
                                <td scope="row"><?php echo $nama_produk ?></td>
                                <td scope="row"><?php echo $jenis_produk ?></td>
                                <td scope="row"><?php echo $harga_produk ?></td>
                                <td scope="row"><?php echo $stock_produk ?></td>
                                <td scope="row">
                                    <a href="tabel_produk.php?op=edit&id_produk=<?php echo $id_produk ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="tabel_produk.php?op=delete&id_produk=<?php echo $id_produk?>" onclick="return confirm('Delete Confirmation')"><button type="button" class="btn btn-danger">Delete</button></a>            
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