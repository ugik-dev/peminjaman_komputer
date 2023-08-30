<div class="wrapper wrapper-content animated fadeInRight">


    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <form role="form" id="passing_grade_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn_x" data-loading-text="Loading..." onclick="this.form.target='add'"><strong>Simpan</strong></button>

                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                            <thead>
                                <tr>
                                    <th style="width: 15%; text-align:center!important">Mata Pelajaran</th>
                                    <th style="width: 7%; text-align:center!important">Matematika</th>
                                    <th style="width: 7%; text-align:center!important">Fisika</th>
                                    <th style="width: 7%; text-align:center!important">Bahasa Indonesia</th>
                                    <th style="width: 7%; text-align:center!important">Bahasa Inggris</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($dataContent as $jurusan) {

                                ?>
                                    <tr>
                                        <td><?= $jurusan['nama_jenis_jurusan'] ?></td>
                                        <td>
                                            <input type="hidden" name="id_pg_<?= $jurusan['id_jenis_jurusan'] ?>" value="<?= $jurusan['id_pg'] ?>">
                                            <input type="number" class="form-control" id="mtk_<?= $jurusan['id_jenis_jurusan'] ?>" name="mtk_<?= $jurusan['id_jenis_jurusan'] ?>" value="<?= $jurusan['mtk'] ?>">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="fisika_<?= $jurusan['id_jenis_jurusan'] ?>" name="fisika_<?= $jurusan['id_jenis_jurusan'] ?>" value="<?= $jurusan['fisika'] ?>">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="bind_<?= $jurusan['id_jenis_jurusan'] ?>" name="bind_<?= $jurusan['id_jenis_jurusan'] ?>" value="<?= $jurusan['bind'] ?>">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="bing_<?= $jurusan['id_jenis_jurusan'] ?>" name="bing_<?= $jurusan['id_jenis_jurusan'] ?>" value="<?= $jurusan['bing'] ?>">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        $('#passing_grade').addClass('active');
        // $('#set_mapel').addClass('active');


        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: false,
            searching: false,
            ordering: false,

        });


        var PGForm = $('#passing_grade_form');

        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
        };

        var swalDeleteConfigure = {
            title: "Konfirmasi hapus",
            text: "Yakin akan menghapus data ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
        };

        var dataMapel = {};
        var dataJ = {};
        var dataJ2 = {};

        PGForm.submit(function(event) {
            console.log('ss')
            event.preventDefault();
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: `<?= site_url('AdminController/editPassingGrade') ?>`,
                    'type': 'POST',
                    data: PGForm.serialize(),
                    success: function(data) {
                        buttonIdle(PGForm.addBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var mapel = json['data']
                        // dataMapel[mapel['id_mapel']] = mapel;
                        swal("Simpan Berhasil", "", "success");
                        // renderMapel(dataMapel);
                        // PGForm.saveEditBtn.show();
                        // PGForm.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>