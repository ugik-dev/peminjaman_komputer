<?php
$this->load->view('public/HeaderFragment',  ['title' => $title]);

?>
<div class="jumbotron " style="height: 0% ">
    <div class="background_login" id="login_page" style="position:fixed"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 head-school">
                <div class="row">
                    <div class="col-md-2 logo">
                        <img class="logo" src="<?php echo base_url('assets/img/study.png'); ?>" style="width : auto; height: 100px">
                    </div>
                    <div class="col-md-10 desk">
                        <h1 class="display-4 shadowed">Your Courses</h1>
                        <p class="lead shadowed">Ayok belajar bareng</p>

                        <!-- <p class="lead shadowed">Provinsi Kepulauan Bangka Belitung</p> -->
                    </div>
                </div>
            </div>

        </div>
        <?php
        // $this->load->view('public/Navbar.php',  ['title' => $title]);
        $this->load->view($content);
        // $this->load->view('public/FooterFragment');
        ?>
        <br>
    </div>
</div>
<?php $this->load->view('Fragment/FooterFragment'); ?>
</body>

<script>
    $(document).ready(function() {
        var login_page = $('#login_page');

        var counter = Math.floor(Math.random() * 100) + 1;
        var image_count = 3;
        login_page.addClass(`img_${counter % image_count}`);
        window.setInterval(function() {
            counter += 1;
            var prevIdx = (counter - 1) % image_count;
            var currIdx = counter % image_count;
            login_page.fadeOut('400', function() {
                login_page.removeClass(`img_${prevIdx}`);
                login_page.addClass(`img_${currIdx}`);
                login_page.fadeIn('400', function() {})
            });
        }, 15000);

    });
</script>

<style>
    body {
        background-color: #f3f3f4 !important;
    }

    .img_0 {
        background-image: url('<?= base_url() ?>assets/img/background/1-Lomba-Foto-Babar-2017_Menangkis-Tantangan_Lintang-Tatang.jpg');
    }

    .img_1 {
        background-image: url('<?= base_url() ?>assets/img/background/smansa.jpg');
    }

    .img_2 {
        background-image: url('<?= base_url() ?>assets/img/background/2-Agus-Ramdhany_Batu-penunggu-pantai.jpg');
    }


    .jumbotron {
        background-size: cover;
        height: 250px;
        border-radius: 0px;
        padding: 30px;
    }

    .background_login {
        position: absolute;
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
        background-color: #ffffff;
        border: 1px solid black;
        opacity: 0.6;
        filter: alpha(opacity=60);
        /* For IE8 and earlier */
    }

    .head-school .desk {
        width: 100%;
        max-width: 800px !important;
        max-height: 80px;
        padding: -10px -90px -30px -10px;
        margin-left: -90px !important;
    }

    .head-school .desk .display-6 {
        width: 100%;
        max-width: 800px;
        max-height: 80px;
        margin-top: -5px;
        margin: -10px 2px -9px 0px !important;
        font-size: 20px !important;
    }

    .head-school .desk .display-4 {
        width: 100%;
        max-width: 800px;
        max-height: 80px;
        margin-top: 5px;
        margin: 10px 2px -9px 0px !important;
        font-size: 40px !important;
    }

    .head-school .logo {
        width: 100%;
        margin: 1px;
        margin-bottom: 20px;
        width: auto !important;
        max-height: 100px;
        padding: -10px -12px 15px -15px;
        /* padding-bottom: -15 !important; */
    }


    @media (max-width: 369px) and (min-width: 100px) {
        .head-school .logo {
            width: 100%;
            margin: 1px;
            margin-bottom: 20px;
            width: 60px !important;
            max-height: 80px;
            padding: -10px -12px 15px -15px;
            /* padding-bottom: -15 !important; */
        }



        .head-school .desk {
            width: 100%;
            max-width: 250px !important;
            max-height: 80px;
            padding: -10px -12px -30px -10px;
            margin-left: 10px !important;
        }

        .head-school .desk .display-4 {
            width: 100%;
            max-width: 220px;
            max-height: 80px;
            font-size: 23px !important;
        }

        .head-school .desk .display-6 {
            width: 100%;
            max-width: 220px;
            max-height: 80px;
            margin-top: 1px;
            /* padding: 0px 0px 0px 0px !important; */
            margin: -10px 2px -9px 0px !important;
            font-size: 12px !important;
            line-height: 24px !important;
            font: 0px !important;
        }
    }


    @media (max-width: 1000px) and (min-width: 370px) {
        .head-school .logo {
            width: 100%;
            margin: 1px;
            margin-bottom: 20px;
            width: 60px !important;
            max-height: 80px;
            padding: -10px -12px 15px -15px;
            /* padding-bottom: -15 !important; */
        }



        .head-school .desk {
            width: 100%;
            max-width: 80% !important;
            max-height: 80px;
            padding: -10px -12px -30px -10px;
            margin-left: 10px !important;
        }

        .head-school .desk .display-4 {
            width: 100%;
            max-width: 100%;
            max-height: 80px;
            font-size: 23px !important;
        }

        .head-school .desk .display-6 {
            width: 100%;
            max-width: 220px;
            max-height: 80px;
            margin-top: 1px;
            /* padding: 0px 0px 0px 0px !important; */
            margin: -10px 2px -9px 0px !important;
            font-size: 12px !important;
            line-height: 24px !important;
            font: 0px !important;
        }
    }
</style>