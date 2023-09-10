<?php $this->load->view('Fragment/HeaderFragment', ['title' => $title]); ?>
<div class="jumbotron " style="height: 95%">
    <div class="background_login" id="login_page"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3">
                        <img class="ulogo" src="<?= base_url('assets/img/polman.png'); ?>" style="width : 100%; height: auto">
                    </div>
                    <div class="col-md-9 ulayout">
                        <h2 class="display-5 shadowed mb-0 mt-0" style="color : #004d99">Sistem Informaasi Peminjaman Komputer</h2>
                        <h1 class="display-4 shadowed mb-0" style="color : #004d99">POLMAN BABEL</h1>
                        <p class="lead shadowed mb-0 mt-0" style="color:#bfbfbf">POLITEKNIK MANUFAKTUR</p>
                        <p class="lead shadowed mt-0" style="color : #004d99">BANGKA BELITUNG</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="ibox-content loginForm" style="background-color:#ffffff61">
                    <form id="loginForm" class="m-t" role="form">
                        <h3 style="color: black;">Login / Masuk</h3>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username / NIK" required="required">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                        </div>
                        <button type="submit" id="loginBtn" class="btn btn-primary block full-width m-b" data-loading-text="Loging In...">Login</button>
                        <a type="button" href="register" class="btn btn-info block full-width m-b" data-loading-text=""><i class="fa fa-user"></i> Register</a>

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

        var loginForm = $('#loginForm');
        var submitBtn = loginForm.find('#loginBtn');
        var login_page = $('#login_page');

        loginForm.on('submit', (ev) => {
            ev.preventDefault();
            buttonLoading(submitBtn);
            $.ajax({
                url: "<?= site_url() . 'login-process' ?>",
                type: "POST",
                data: loginForm.serialize(),
                success: (data) => {
                    buttonIdle(submitBtn);
                    json = JSON.parse(data);
                    if (json['error']) {

                        swal("Login Gagal", json['message'], "error");
                        return;
                    }
                    $(location).attr('href', '<?= site_url() ?>' + json['user']['nama_controller']);
                },
                error: () => {
                    buttonIdle(submitBtn);
                }
            });
        });

        // var counter = Math.floor(Math.random() * 100) + 1;
        // var image_count = 2;
        // login_page.addClass(`img_0`);
    });
</script>
<style>
    body {
        background-color: #f3f3f4 !important;
    }


    .img_0 {
        background-image: url('assets/img/background/bg-polman.jpg');
        background-size: cover;
        background-position: center;

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