<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="">
  <meta name="keywords" content="admin template,html 5 admin template , dmeki admin , dashboard template, bootstrap 5 admin template, responsive admin template">
  <title>SIPK-POLMAN BABEL|Login
  </title>
  <link rel="icon" href="<?= base_url() ?>assets/images/logo/icon-logo.png" type="image/x-icon">
  <link rel="shortcut icon" href="<?= base_url() ?>assets/images/logo/icon-logo.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/vendor/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/vendor/themify-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/vendor/simplebar.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/vendor/bootstrap.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/style.css" id="customstyle" rel="stylesheet">
  <script src="<?= base_url('assets/') ?>js/plugins/sweetalert/sweetalert2.all.min.js"></script>

  <script src="<?= base_url() ?>assets/js/jquery-3.6.0.js"></script>
  <script src="<?= base_url('assets/') ?>js/custom.js?v=0.0.2"></script>

</head>

<body>
  <div class="auth-main">
    <div class="codex-authbox">
      <div class="auth-header">
        <div class="codex-brand"><a href="index.html"><img class="img-fluid light-logo" src="<?= base_url() ?>assets/images/logo/logo.png" alt=""><img class="img-fluid dark-logo" src="<?= base_url() ?>assets/images/logo/dark-logo.png" alt=""></a></div>
        <h3>Selamat Datang Sistem Informasi Peminjaman Komputer Politeknik Negeri Babel</h3>
      </div>
      <form id="loginForm">
        <div class="form-group">
          <label class="form-label">NIM / USERNAME</label>
          <input class="form-control" type="text" required name="username" placeholder="NIM / USERNAME">
        </div>
        <div class="form-group mb-0">
          <div class="auth-remember">
            <div class="form-check custom-chek">
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-primary" id="loginBtn" type="submit"><i class="fa fa-unlock"></i> Reset </button>
          <a class="btn btn-light" type="button" href="<?= base_url() ?>login"><i class="fa fa-sign-in"></i> Kembali ke halaman Login</a>
        </div>
      </form>
    </div>
  </div>
  <script>
    $(document).ready(function() {

      var loginForm = $('#loginForm');
      var submitBtn = loginForm.find('#loginBtn');
      var login_page = $('#login_page');

      loginForm.on('submit', (ev) => {
        ev.preventDefault();
        Swal.fire({
            title: "Loading!",
        });
        Swal.showLoading();
        $.ajax({
          url: "<?= base_url('reset-process') ?>",
          type: "POST",
          data: loginForm.serialize(),
          success: (data) => {
            json = JSON.parse(data);
            if (json['error']) {
              swal("Login Gagal", json['message'], "error");
              return;
            }
            swal("Berhasil", "Silahkan cek email anda untuk melakukan reset", "success").then((result) => {
                                    $(location).attr('href', '<?= base_url('login') ?>');
                                });;
            
          },
          error: () => {
            buttonIdle(submitBtn);
          }
        });
      });

    });
  </script>

  <script src="<?= base_url() ?>assets/js/jquery-3.6.0.js"></script>
  <script src="<?= base_url() ?>assets/js/layout-storage.js"></script>
  <script src="<?= base_url() ?>assets/js/customizer.js"></script>
  <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/js/vendors/simplebar.js"></script>
  <script src="<?= base_url() ?>assets/js/custom-script.js"></script>
</body>

</html>