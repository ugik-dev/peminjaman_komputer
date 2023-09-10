<?php $this->load->view('Fragment/HeaderFragment', ['title' => $title]); ?>
<div class="jumbotron " style="height: 95%">
    <div class="background_login" id="login_page"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <img class="ulogo" src="<?= base_url('assets/img/polman.png'); ?>" style="width : 100%; height: auto">
                    </div>
                    <div class="col-md-9 ulayout">
                        <h2 class="display-5 shadowed mb-0 mt-0" style="color : #004d99">Sistem Pendaftaran & Ujian</h2>
                        <h1 class="display-5 shadowed mb-0" style="color : #004d99"><b>POLMAN BABEL</b></h1>
                        <p class="lead shadowed mb-0 mt-0" style="color:#bfbfbf">POLITEKNIK MANUFAKTUR</p>
                        <p class="lead shadowed mt-0" style="color : #004d99">BANGKA BELITUNG</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ibox-content loginForm" style="background-color:#ffffff61">
                    <form id="registerForm" class="m-t" role="form">
                        <h3 style="color: black;">Registrasi / Daftar</h3>
                        <div class="form-group">
                            <input type="text" placeholder="NIK" class="form-control" id="username" name="username" required="required" autocomplete="username">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" placeholder="Password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" placeholder="Password" class="form-control" id="repassword" name="repassword" autocomplete="new-password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" placeholder="Email" class="form-control" id="email" name="email" required="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="text" placeholder="No Telepon" class="form-control" id="phone" name="phone" required="required">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <input type="text" placeholder="Nama" class="form-control" id="nama" name="nama" required="required">
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
                    <p class="m-t">
                        <!-- <small style="color: black;">DINAS PENDIDIKAN PROVINSI KEP. BANGKA BELITUNG</small> -->
                    </p>
                </div>
            </div>
        </div>
        <br>
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
                        //     $(location).attr('href', '<?= base_url() ?>');
                        // });
                    }
                },
                error: () => {}
            });
        });

    });
</script>
<style>
    body {
        background-color: #f3f3f4 !important;
    }

    .img_0 {
        background-image: url('assets/img/background/bg-1.jpg');
    }

    .img_1 {
        background-image: url('assets/img/background/bg-2.jpg');
    }

    .img_2 {
        background-image: url('assets/img/background/bg-3.jpg');
    }

    .jumbotron {
        background-size: cover;
        width: 100%;
        height: 250px;
        border-radius: 0px;
        padding: 130px;
    }

    .background_login {
        position: fixed;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        background-position: center;
        background-size: cover;
    }

    .shadowed {
        text-shadow: 2px 2px 1px #000000;
        color: #fff;
    }

    .logo-logo {
        margin: 30px;
        /* background-color: #ffffff; */
        /* border: 1px solid black; */
        /* opacity: 0.6; */
        filter: alpha(opacity=60);
        /* For IE8 and earlier */
    }

    .ulogo {
        max-width: 150px !important;
    }

    .ulayout {
        width: 90%;
    }

    @media (max-width: 369px) and (min-width: 200px) {
        .ulogo {
            max-width: 90% !important;
        }

        .ulayout {
            width: 300px !important;
            font-size: 10px !important;
            padding: 0px;
        }

        .display-4 {
            width: 180px !important;
            font-size: 20px !important;
            padding: 0px 0px 0px 0px !important;
            margin-bottom: 20px;
        }

        .lead {
            width: 180px !important;
            font-size: 10px !important;
            padding: 0px 0px 0px 0px !important;
            margin-top: -10px;
        }

        .col-md-3 {
            width: 100px !important;
            padding: 0px;
        }
    }

    @media (max-width: 800px) and (min-width: 400px) {
        .ulogo {
            max-width: 900% !important;
            width: 100px;
        }

        .ulayout {
            width: 800px !important;
            font-size: 10px !important;
            padding: 10px;
        }

        .display-4 {
            width: 400px !important;
            font-size: 30px !important;
            padding: 0px 0px 0px 0px !important;
            margin-bottom: 20px;
        }

        .lead {
            width: 300px !important;
            font-size: 10px !important;
            padding: 0px 0px 0px 0px !important;
            margin-top: -10px;
        }


        .col-md-3 {
            width: 80px !important;
            padding: 10px;
        }

        .loginForm {
            width: 50% !important;
        }
    }

    @media (max-width: 1200px) {
        .ulogo {
            max-width: 90% !important;
        }

        .ulayout {
            width: 400px !important;
            font-size: 10px !important;
            padding: 10px;
        }

        .display-4 {
            width: 400px !important;
            font-size: 30px !important;
            padding: 0px 0px 0px 0px !important;
            margin-bottom: 20px;
        }

        .lead {
            width: 300px !important;
            font-size: 10px !important;
            padding: 0px 0px 0px 0px !important;
            margin-top: -10px;
        }

        .col-md-3 {
            width: 200px;
            padding: 10px;
        }

        .loginForm {
            width: 100%;
        }
    }
</style>
<?php $this->load->view('Fragment/FooterFragment'); ?>