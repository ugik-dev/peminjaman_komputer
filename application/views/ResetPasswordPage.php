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
                <div class="row">
                <input type="hidden"  class="form-control" id="token" name="token" value="<?=$token?>" required>
                <input type="hidden"  class="form-control" id="id_reset" name="id_reset" value="<?=$id_reset?>" required>
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
                
                <button type="submit" id="registerBtn" class="btn btn-primary block full-width m-b" data-loading-text="Registering In...">
                    Reset</button>
                <a class="btn btn-default block full-width m-b" href="<?= base_url('login') ?>">Login</a>
            </form>
            <!-- <div class="auth-footer">
        <h5 class="auth-with">Or login in with </h5>
        <ul class="login-list">
          <li><a class="bg-fb" href="javascript:void(0);"> <img class="img-fluid" src="<?= base_url() ?>assets/images/auth/1.png" alt="facebook">facebook</a></li>
          <li><a class="bg-google" href="javascript:void(0);"> <img class="img-fluid" src="<?= base_url() ?>assets/images/auth/2.png" alt="google">google</a></li>
        </ul>
      </div> -->
        </div>
    </div>
    <script>
        $(document).ready(function() {


            // Swal.fire({
            //     title: 'Success Registration',
            //     // html: 'check your email to activation',
            //     icon: 'success',
            // }).then((result) => {
            //     $(location).attr('href', '<?= base_url() ?>');
            // })

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
                    url: "<?= site_url() . 'reset2-process' ?>",
                    type: "POST",
                    data: registerForm.serialize(),
                    success: (data) => {
                        // buttonIdle(submitBtn);
                        json = JSON.parse(data);
                        if (json['error']) {
                            swal("Reset Gagal", json['message'], "error");
                            return;
                        } else {
                            // swal("Success Registration", 'check your email to activation', "success").then((result) => {
                                swal("Reset Berhasil", 'Silahkan masuk menggunakan nip dan password anda!', "success").then((result) => {
                                    $(location).attr('href', '<?= base_url() ?>');
                                });
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