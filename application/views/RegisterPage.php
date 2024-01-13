<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="admin template,html 5 admin template , admin , dashboard template, bootstrap 5 admin template, responsive admin template">
    <title>SIPK-POLMAN BABEL|Login
    </title>
    <!-- shortcut icon-->
    <link rel="icon" href="<?= base_url() ?>assets/images/logo/icon-logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/logo/icon-logo.png" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link href="<?= base_url() ?>assets/css/vendor/font-awesome.css" rel="stylesheet">
    <!-- themify icon-->
    <link href="<?= base_url() ?>assets/css/vendor/themify-icons.css" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="<?= base_url() ?>assets/css/vendor/simplebar.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="<?= base_url() ?>assets/css/vendor/bootstrap.css" rel="stylesheet">
    <!-- Custom css-->
    <link href="<?= base_url() ?>assets/css/style.css" id="customstyle" rel="stylesheet">
    <script src="<?= base_url('assets/') ?>js/plugins/sweetalert/sweetalert2.all.min.js"></script>

    <script src="<?= base_url() ?>assets/js/jquery-3.6.0.js"></script>
    <script src="<?= base_url('assets/') ?>js/custom.js?v=0.0.2"></script>

</head>

<body>
    <!-- Login Start-->
    <div class="auth-main">
        <div class="codex-authbox">
            <div class="auth-header">
                <div class="codex-brand"><a href="index.html"><img class="img-fluid light-logo" src="<?= base_url() ?>assets/images/logo/logo.png" alt=""><img class="img-fluid dark-logo" src="<?= base_url() ?>assets/images/logo/dark-logo.png" alt=""></a></div>
                <h3>Form Pendaftaran</h3>
            </div>
            <form id="registerForm" class="m-t" role="form">
                <!-- <h3 style="color: black;">Registrasi / Daftar</h3> -->
                <div class="form-group">
                    <label class="form-label">NIM</label>
                    <input type="text" placeholder="NIM" class="form-control" id="username" name="username" required="required" autocomplete="username">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" placeholder="Password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Re-Password</label>
                            <input type="password" placeholder="Password" class="form-control" id="repassword" name="repassword" autocomplete="new-password" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">e-Mail</label>
                        <div class="form-group">
                            <input type="email" placeholder="" class="form-control" id="email" name="email" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No Telepon</label>
                        <div class="form-group">
                            <input type="text" placeholder="" class="form-control" id="phone" name="phone" required="required">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input type="text" placeholder="Nama" class="form-control" id="nama" name="nama" required="required">
                </div>

                <div class="form-group">
                    <label class="form-label">Tahun Masuk</label>
                    <input type="text" placeholder="Tahun Masuk" min="1000" class="form-control" id="tahun_masuk" name="tahun_masuk" required="required">
                </div>
                <div class="form-group">
                    <label class="form-label">Prodi</label>
                    <option></option>
                    <select placeholder="Prodi" class="form-control" id="id_jurusan" name="id_jurusan" required="required">
                        <?php
                        foreach ($jurusan as $j) {
                            echo "<option value='" . $j['id_jurusan'] . "' >" . $j['nama_jurusan'] . " </option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- <div class="form-group">
                            <input type="text" placeholder="Asal Sekolah" class="form-control" id="id_jurusan" name="id_jurusan" required="required">
                        </div>

                        <div class="form-group">
                            <input type="text" placeholder="Nomor Ijazah SMA" class="form-control" id="no_ijazah_sma" name="no_ijazah_sma" required="required">
                        </div>


                        <div class="form-group">

                            <textarea rows="4" type="text" placeholder="Alamat" class="form-control" id="alamat" name="alamat" required="required"></textarea>
                        </div> -->

                <button type="submit" id="registerBtn" class="btn btn-primary block full-width m-b" data-loading-text="Registering In...">
                    Register</button>
                <a class="btn btn-default block full-width m-b" href="<?= base_url('login') ?>">Login</a>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var registerForm = $('#registerForm');
            var submitBtn = registerForm.find('#registerBtn');
            var login_page = $('#login_page');


            registerForm.on('submit', (ev) => {
                ev.preventDefault();
                swal.fire({
                    html: '<h2>Loading...</h2>',
                    showConfirmButton: false,
                    allowOutsideClick: false,

                });

                Swal.showLoading();
                $.ajax({
                    url: "<?= site_url() . 'register-process' ?>",
                    type: "POST",
                    data: registerForm.serialize(),
                    success: (data) => {
                        // buttonIdle(submitBtn);
                        json = JSON.parse(data);
                        if (json['error']) {
                            swal("Registrasi Gagal", json['message'], "error");
                            return;
                        } else {
                            // swal("Success Registration", 'check your email to activation', "success").then((result) => {
                            // $(location).attr('href', '<?= base_url() ?>');
                            swal("Registrasi Berhasil", 'Silahkan cek gmail anda untuk aktifasi akun, dan login kembali!', "success").then((result) => {});
                        }
                    },
                    error: () => {}
                });
            });

        });
    </script>

    <!-- Login End-->
    <!-- main jquery-->
    <script src="<?= base_url() ?>assets/js/jquery-3.6.0.js"></script>
    <!-- Theme Customizer-->
    <script src="<?= base_url() ?>assets/js/layout-storage.js"></script>
    <script src="<?= base_url() ?>assets/js/customizer.js"></script>
    <!-- Feather icons js-->
    <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather.js"></script>
    <!-- Bootstrap js-->
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <!-- Scrollbar-->
    <script src="<?= base_url() ?>assets/js/vendors/simplebar.js"></script>
    <!-- Custom script-->
    <script src="<?= base_url() ?>assets/js/custom-script.js"></script>
</body>

</html>