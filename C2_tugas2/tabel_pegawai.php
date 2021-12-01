<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "transaction_jualbeliritel_c2";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Tidak bisa terkoneksi ke database");
}
$id_pegawai = "";
$nama_pegawai = "";
$notlp_Pegawai = "";

$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id_pegawai         = $_GET['id_pegawai'];
    $sql1       = "delete from pegawai where id_pegawai = '$id_pegawai'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}



if($op == 'edit'){
    $id_pegawai = $_GET['id_pegawai'];
    $sql1      = "select * from pegawai where id_pegawai = '$id_pegawai'";
    $q1        = mysqli_query($koneksi,$sql1);
    $r1        = mysqli_fetch_array($q1);
    $nama_pegawai = $r1['nama_pegawai'];
    $notlp_Pegawai = $r1['notlp_Pegawai'];

    if($id_pegawai == "" ){
        $error = "Data tidak ditemukan";
    }
}



if (isset($_POST['simpan'])) { 
    $id_pegawai         = $_POST['id_pegawai'];
    $nama_pegawai       = $_POST['nama_pegawai'];
    $notlp_Pegawai      = $_POST['notlp_Pegawai'];

    if ($id_pegawai && $nama_pegawai && $notlp_Pegawai) {
        if ($op == 'edit') { 
            $sql1       = "update pegawai set id_pegawai = '$id_pegawai',nama_pegawai ='$nama_pegawai',notlp_Pegawai = '$notlp_Pegawai' where id_pegawai = '$id_pegawai'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { 
            $sql1   = "insert into pegawai(id_pegawai,nama_pegawai,notlp_Pegawai) values ('$id_pegawai','$nama_pegawai','$notlp_Pegawai')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    }else {
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
    <title>Data Pegawai Ritel</title>
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
                Create / Edit Pegawai
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:1;url=tabel_pegawai.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:1;url=tabel_pegawai.php");
                }
                ?>
                <form action="" method="POST">
                    

                    <div class="mb-3 row">
                        <label for="id_pegawai" class="col-sm-2 col-form-label">ID Pegawai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" value="<?php echo $nama_pegawai ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="notlp_Pegawai" class="col-sm-2 col-form-label">Nomor Telepon Pegawai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="notlp_Pegawai" value="<?php echo $notlp_Pegawai?>">
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
                Data Pegawai Ritel
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Pegawai</th>
                            <th scope="col">Nama Pegawai</th>
                            <th scope="col">Nomor Telepon Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from pegawai order by id_pegawai";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id_pegawai        = $r2['id_pegawai'];
                            $nama_pegawai       = $r2['nama_pegawai'];
                            $notlp_Pegawai     = $r2['notlp_Pegawai'];
                        ?>
                            <tr>
                                <td scope="row"><?php echo $id_pegawai ?></td>
                                <td scope="row"><?php echo $nama_pegawai ?></td>
                                <td scope="row"><?php echo $notlp_Pegawai ?></td>
                                <td scope="row">
                                    <a href="tabel_pegawai.php?op=edit&id_pegawai=<?php echo $id_pegawai ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="tabel_pegawai.php?op=delete&id_pegawai=<?php echo $id_pegawai?>" onclick="return confirm('Delete Confirmation')"><button type="button" class="btn btn-danger">Delete</button></a>            
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