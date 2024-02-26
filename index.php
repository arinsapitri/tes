<?php

include 'config/koneksi.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>
    
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
      </div>
      <a href="register.php" class="btn btn-outline-primary m-1">Daftar</a>
      <a href="login.php" class="btn btn-outline-success m-1">Masuk</a>
    </div>
  </div>
</nav>
<div class="container mt-2">
  <div class="row">
    <?php 
  $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON 
  foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid");
while($data = mysqli_fetch_array($query)){
?>
          <div class="col-md-3">
          <a type="button" data-bs-toggle="modal"
            data-bs-target="#komentar<?php echo $data['fotoid']?>">
            
          <div class="card mb-2">
            <img src="assets/img/<?php echo $data['lokasifile'] ?>" 
            class="card-img-top" title="<?php echo $data['judulfoto'] ?>" style="height: 12rem;" > 
                <div class="card-footer text-center">

                    <?php
                    $fotoid = $data['fotoid'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'
                    ");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                    <a href="login.php?fotoid=<?php echo $data['fotoid'] ?>"
                    type="submit" name="batalsuka"><i class="fa fa-heart"></i></a>
                    
                    <?php }else{ ?>
                      <a href="login.php?fotoid=<?php echo $data['fotoid'] ?>"
                    type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
                      <?php }
                    
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($like). 'suka';
                    ?>

                   <a href="#" type="button" data-bs-toggle="modal"
                    data-bs-target="#komentar<?php echo $data['fotoid']?>"><i class="fa-regular fa-comment"></i></a>
                    <?php
                    $jmlhkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($jmlhkomen).' komentar';
                    ?>
           </div>
           </div>
                </a>
            <!-- Modal -->
            <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-8">
                      <img src="assets/img/<?php echo $data['lokasifile'] ?>" 
                        class="card-img-top" title="<?php echo $data['judulfoto'] ?>"> 
                      </div>
                      <div class="col-md-4">
                        <div class="m-2">
                          <div class="overflow-auto">
                            <div class="sticky-top">
                              <strong><?php echo $data['judulfoto'] ?></strong> <br>
                              <span class="badge bg-secondary"><?php echo $data['namalengkap'] ?></span>
                              <span class="badge bg-secondary"><?php echo $data['tanggalunggah'] ?></span>
                              <span class="badge bg-primary"><?php echo $data['namaalbum'] ?></span>
                            </div>
                            <hr>
                           <p align="left">
                            <?php echo $data['deskripsifoto'] ?>
                            </p>
                            <hr>
                            <?php
                            $fotoid = $data['fotoid'];
                            $komentar = mysqli_query($koneksi, "SELECT * FROM komentarfoto INNER JOIN user 
                            ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                            while($row = mysqli_fetch_array($komentar)){
                            ?>
                            <p align="left">
                              <strong><?php echo $row['namalengkap'] ?></strong>
                              <?php echo $row['isikomentar'] ?>
                            </p>
                           <?php } ?>
                            <hr>
                            <div class="sticky-bottom">
                              <form action="login.php" method="POST">
                                <div class="input-group">
                                  <input type="hidden" name="fotoid" value="<?php echo $data['fotoid'] ?>">
                                  <input type="text" name="isikomentar" class="form-control" placeholder="Tambah Komentar">
                                <div class="input-group-prepend">
                                  <button  type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                                </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            </div>
              <?php } ?>
       </div>
    </div>
                  


<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&coppy; UKK RPL 2024 | Ravi Aditya</p>
</footer>

<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>