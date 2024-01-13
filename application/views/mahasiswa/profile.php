<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="preForm" class="m-t" role="form">
                    <?php
                    if (empty($ret_data['id_data'])) {
                        echo '<div class="alert alert-success">Aktif</div>';
                    } else {
                        if ($ret_data['status_data'] == 0) {
                            echo '<div class="alert alert-success">Aktif</div>';
                        } else if ($ret_data['status_data'] == 1) {
                            echo '<div class="alert alert-success">Aktif</div>';
                        } else  {
                            echo '<div class="alert alert-danger">Non Aktif</div>';
                        } 
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIM</label>
                                <input type="text" value="<?= $this->session->userdata('username') ?>" class="form-control" disabled="disabled" autocomplete="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" value="<?= $this->session->userdata('nama') ?>" class="form-control" id="nama" name="nama" autocomplete="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" value="<?= $this->session->userdata('email') ?>" class="form-control" id="email" name="email" required="required" autocomplete="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="text" value="<?= $this->session->userdata('phone') ?>" class="form-control" id="phone" name="phone" required="required" autocomplete="username">
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
                                <label>Nama Prodi</label>
                                <input type="text" value="<?= !empty($ret_data['nama_jurusan']) ? $ret_data['nama_jurusan'] : '' ?>" class="form-control" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Masuk</label>
                                <input type="text" value="<?= !empty($ret_data['tahun_masuk']) ? $ret_data['tahun_masuk'] : '' ?>" class="form-control" id="tahun_masuk" name="tahun_masuk" required="required" autocomplete="username">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea rows="4" type="text" class="form-control" id="alamat" name="alamat" required="required"><?= !empty($ret_data['alamat']) ? $ret_data['alamat'] : '' ?></textarea>
                    </div>
                    <hr>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label>File NIM<small style="color: red"> *max 300kb</small></label>
                            <input type="file" class="form-control" id="file_nim" name="file_nim" <?= empty($ret_data['file_nim']) ? ' required="required"' : '' ?>>
                        </div>
                        <?= !empty($ret_data['file_nim']) ? '<img style="width : 250px; height: 150px" src="' . base_url('upload/nim/') . $ret_data['file_nim'] . '">' : '' ?>
                    </div>
                    <button type="submit" id="registerBtn" class="btn btn-primary block full-width m-b" data-loading-text="Loading...">
                        Simpan</button>
                </form>
                <p class="m-t">
                </p>
            </div>
        </div>
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
            $.ajax({
                url: "<?= base_url() . 'mahasiswa/update_profile' ?>",
                type: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: (data) => {
                    json = JSON.parse(data);
                    if (json['error']) {
                        swal("Submit Gagal", json['message'], "error");
                        return;
                    } else {
                        swal("Submit Berhasil", '', "success");
                    }
                    location.reload();
                },
                error: () => {
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