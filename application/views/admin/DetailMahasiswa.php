<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="preForm" class="m-t" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Status</b></label>
                                <select class="form-control my-1 mr-sm-2" id="status_data" name="status_data">
                                    <option value="0" <?= $ret_data['status_data'] == 0 ? 'selected ' : '' ?>>Belum input data</option>
                                    <option value="1" <?= $ret_data['status_data'] == 1 ? 'selected ' : '' ?>>Menunggu verifikasi</option>
                                    <option value="3" <?= $ret_data['status_data'] == 3 ? 'selected ' : '' ?>>Ditolak</option>
                                    <option value="2" <?= $ret_data['status_data'] == 2 ? 'selected ' : '' ?>>Diterima</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b></b></label>
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
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b></b></label>
                                <div width="100%">
                                    <button type="submit" id="registerBtn" style="width:100% !important" class="btn btn-primary btn-lg btn-block full-width m-b" data-loading-text="Loading...">
                                        <i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Email</label>
                                <input type="text" value="<?= !empty($ret_data['email']) ? $ret_data['email'] : '' ?> " class="form-control" id="email" name="email" autocomplete="username">
                                <input type="hidden" name="id_user" value="<?= !empty($ret_data['id_user']) ? $ret_data['id_user'] : '' ?> ">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="text" value="<?= !empty($ret_data['phone']) ? $ret_data['phone'] : '' ?> " class="form-control" id="phone" name="phone" autocomplete="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" value="<?= !empty($ret_data['nama']) ? $ret_data['nama'] : '' ?>" class="form-control" id="nama" name="nama" required="required" autocomplete="username">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIM</label>
                                <input type="text" value="<?= !empty($ret_data['username']) ? $ret_data['username'] : '' ?> " class="form-control" id="nim" name="nim" autocomplete="username">
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
                                <label>Nama Jurusan</label>
                                <select placeholder="Jurusan" class="form-control" id="id_jurusan" name="id_jurusan" required="required">
                                    <option value=""></option>
                                    <?php
                                    foreach ($jurusan as $j) {
                                        echo "<option value='" . $j['id_jurusan'] . "' " . ($ret_data['id_jurusan'] == $j['id_jurusan'] ? 'selected' : '') . ">" . $j['nama_jurusan'] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Ijazah</label>
                                <input type="text" value="<?= !empty($ret_data['nomor_ijazah']) ? $ret_data['nomor_ijazah'] : '' ?>" class="form-control" id="nomor_ijazah" name="nomor_ijazah" required="required" autocomplete="username">
                            </div>
                        </div> -->
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
                </form>
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
            // buttonLoading(submitBtn);
            $.ajax({
                url: "<?= base_url() . 'AdminController/edit_data_mahasiswa' ?>",
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