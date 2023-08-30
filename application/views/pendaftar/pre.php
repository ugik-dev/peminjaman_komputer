<div class="col-md-12">
    <div class="ibox-content loginForm" style="background-color:#ffffff61">
        <form id="preForm" class="m-t" role="form">
            <?php
            if (empty($ret_data['id_data'])) {
                echo '<div class="alert alert-secondary">Belum input data</div>';
            } else {
                if ($ret_data['status_data'] == 0) {
                    echo '<div class="alert alert-secondary">Belum input data</div>';
                } else if ($ret_data['status_data'] == 1) {
                    echo '<div class="alert alert-primary">Menunggu Verifikasi</div>';
                } else if ($ret_data['status_data'] == 2) {
                    echo '<div class="alert alert-success">Diverifikasi</div>';
                } else if ($ret_data['status_data'] == 3) {
                    echo '<div class="alert alert-danger">Ditolak</div>';
                }
            }
            ?>
            <!-- <div class="alert alert-danger"><i class='fa fa-pencil-square-o '></i>Sudah dimulai</div> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" value="<?= $this->session->userdata('nama') ?>" class="form-control" disabled="disabled" autocomplete="username">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor KTP</label>
                        <input type="text" value="<?= $this->session->userdata('username') ?>" class="form-control" disabled="disabled" autocomplete="username">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" value="<?= !empty($ret_data['tempat_lahir']) ? $ret_data['tempat_lahir'] : '' ?>" class="form-control" id="tempat_lahir" name="tempat_lahir" required="required" autocomplete="username">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" value="<?= !empty($ret_data['tanggal_lahir']) ? $ret_data['tanggal_lahir'] : '' ?>" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required="required" autocomplete="username">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Sekolah Asal</label>
                        <input type="text" value="<?= !empty($ret_data['nama_sekolah']) ? $ret_data['nama_sekolah'] : '' ?>" class="form-control" id="nama_sekolah" name="nama_sekolah" required="required" autocomplete="username">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Ijazah</label>
                        <input type="text" value="<?= !empty($ret_data['nomor_ijazah']) ? $ret_data['nomor_ijazah'] : '' ?>" class="form-control" id="nomor_ijazah" name="nomor_ijazah" required="required" autocomplete="username">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label>Alamat Sekolah Asal</label>
                <textarea rows="4" type="text" class="form-control" id="alamat_sekolah" name="alamat_sekolah" required="required"><?= !empty($ret_data['alamat_sekolah']) ? $ret_data['alamat_sekolah'] : '' ?></textarea>
            </div>
            <hr>
            <div class="col-md-6 mb-2">
                <div class="form-group">
                    <label>File KTP<small style="color: red"> *max 300kb</small></label>
                    <input type="file" class="form-control" id="file_ktp" name="file_ktp" <?= empty($ret_data['file_ktp']) ? ' required="required"' : '' ?>>
                </div>
                <?= !empty($ret_data['file_ktp']) ? '<img style="width : 250px; height: 150px" src="' . base_url('upload/ktp/') . $ret_data['file_ktp'] . '">' : '' ?>
            </div>
            <button type="submit" id="registerBtn" class="btn btn-primary block full-width m-b" data-loading-text="Loading...">
                Simpan</button>
        </form>
        <p class="m-t">
            <!-- <small style="color: black;">DINAS PENDIDIKAN PROVINSI KEP. BANGKA BELITUNG</small> -->
        </p>
    </div>
</div>

<script>
    $(document).ready(function() {

        var preForm = $('#preForm');
        var divregion = $('#divregion');
        var region = $('#region');
        var submitBtn = preForm.find('#registerBtn');
        var login_page = $('#login_page');


        preForm.submit(function(ev) {
            ev.preventDefault();
            // buttonLoading(submitBtn);
            $.ajax({
                url: "<?= base_url() . 'pendaftar/pre' ?>",
                type: "POST",
                // data: preForm.serialize(),
                data: new FormData(this),
                processData: false,
                contentType: false,
                // cache: false,
                // async: false,
                success: (data) => {
                    // buttonIdle(submitBtn);
                    json = JSON.parse(data);
                    if (json['error']) {
                        swal("Submit Gagal", json['message'], "error");
                        return;
                    } else {
                        swal("Submit Berhasil", '', "success");
                    }
                    location.reload();
                    // $(location).attr('href', '<?= site_url() ?>' + json['user']['nama_controller']);
                },
                error: () => {
                    // buttonIdle(submitBtn);
                }
            });
        });

        var counter = Math.floor(Math.random() * 100) + 1;
        var image_count = 28;
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