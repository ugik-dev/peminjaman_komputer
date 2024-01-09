<!-- Tampilan master prodi pada aktor kalab -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <input type="hidden" placeholder="Search" class="form-control my-1 mr-sm-2" id="search" name="search">
                    <button hidden type="submit" class="btn btn-success my-1 mr-sm-2" id="show_btn" data-loading-text="Loading..." onclick="this.form.target='show'"><i class="fal fa-search"></i> Cari</button>
                    <button type="submit" class="btn btn-primary my-1 mr-sm-2" id="add_btn" data-loading-text="Loading..." onclick="this.form.target='add'"><i class="fa fa-plus"></i> Tambah</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                    <thead>
                        <tr>

                            <th style="width: 5%; text-align:center!important">ID</th>
                            <th style="width: 50%; text-align:center!important">PROGRAM STUDI</th>

                            <th style="width: 7%; text-align:center!important">ACTION</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal inmodal" id="jurusan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 class="modal-title">Form Prodi</h4>
                <a href="javascript:void(0);" data-bs-dismiss="modal"><i class="ti-close"></i></a>
            </div>
            <div class="modal-body" id="modal-body">
                <form role="form" id="jurusan_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_jurusan" name="id_jurusan">

                    <div class="form-group">
                        <label for="nama">Program Studi</label>
                        <input type="text" placeholder="" class="form-control" id="nama_jurusan" name="nama_jurusan" required="required"></input>
                    </div>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..." onclick="this.form.target='add'"><strong>Tambah Data</strong></button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..." onclick="this.form.target='edit'"><strong>Simpan Perubahan</strong></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#master').addClass('active');
        $('#master_jurusan').addClass('active');

        var toolbar = {
            'form': $('#toolbar_form'),
            'showBtn': $('#show_btn'),
            'addBtn': $('#show_btn'),
            'id_jurusan': $('#toolbar_form').find('#id_jurusan'),
            'search': $('#toolbar_form').find('#search'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [
                    1, "desc"
                ],
                [
                    2, "asc"
                ]
            ]
        });

        var JurusanModal = {
            'self': $('#jurusan_modal'),
            'info': $('#jurusan_modal').find('.info'),
            'form': $('#jurusan_modal').find('#jurusan_form'),
            'addBtn': $('#jurusan_modal').find('#add_btn'),
            'saveEditBtn': $('#jurusan_modal').find('#save_edit_btn'),
            'id_jurusan': $('#jurusan_modal').find('#id_jurusan'),
            'nama_jurusan': $('#jurusan_modal').find('#nama_jurusan'),
            'status': $('#jurusan_modal').find('#status'),
        }

        swalLoading();
        $.when(getAllJurusan(), ).done(function(a1, a2, a3) {
            swal.close();
        });

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

        var dataJurusan = {};
        var dataRole = {};

        toolbar.form.submit(function(event) {
            event.preventDefault();
            switch (toolbar.form[0].target) {
                case 'show':
                    getAllJurusan();
                    break;
                case 'add':
                    showJurusanModal();
                    break;
            }
        });

        // getAllJurusan()

        function getAllJurusan() {
            return $.ajax({
                url: `<?php echo site_url('GeneralController/getAllJurusan/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataJurusan = json['data'];
                    renderJurusan(dataJurusan);
                },
                error: function(e) {}
            });
        }



        function renderJurusan(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {

                var detailButton = `
                    <li>
                        <a class="detail dropdown-item" href='<?= site_url() ?>KepalaLab/rekap/${d['id_jurusan']}'><i class='fa fa-share'></i> Rekap</a>
                    </li>
                    `;
                var editButton = `
                    <li>
                        <a class="edit dropdown-item" data-id='${d['id_jurusan']}'><i class='fa fa-pencil'></i> Edit </a>
                    </li>
                    `;
                var deleteButton = `
                    <li>
                        <a class="delete dropdown-item" data-id='${d['id_jurusan']}'><i class='fa fa-trash'></i> Hapus </a>
                    </li>
                    `;
                var button = `
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" id="single-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='fa fa-bars'></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="single-dropdown">   
                            ${detailButton}
                            ${editButton}
                            ${deleteButton}
                        </ul>
                         </div>  
                        `;

                renderData.push([d['id_jurusan'], d['nama_jurusan'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.edit', function() {
            event.preventDefault();
            JurusanModal.form.trigger('reset');
            JurusanModal.addBtn.hide();
            JurusanModal.saveEditBtn.show();
            var id = $(this).data('id');
            var cur = dataJurusan[id];
            JurusanModal.id_jurusan.val(cur['id_jurusan']);
            JurusanModal.status.val(cur['status']);
            JurusanModal.nama_jurusan.val(cur['nama_jurusan']);


            JurusanModal.self.modal('show');
        });

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            console.log(id)
            swal(swalDeleteConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('KepalaLab/deleteJurusan') ?>",
                    'type': 'POST',
                    data: {
                        'id_jurusan': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataJurusan[id];
                        swal("Delete Berhasil", "", "success");
                        renderJurusan(dataJurusan);
                    },
                    error: function(e) {}
                });
            });
        });

        function showJurusanModal() {
            JurusanModal.self.modal('show');
            JurusanModal.addBtn.show();
            JurusanModal.saveEditBtn.hide();
            JurusanModal.form.trigger('reset');
        }

        JurusanModal.form.submit(function(event) {
            event.preventDefault();
            switch (JurusanModal.form[0].target) {
                case 'add':
                    addJurusan();
                    break;
                case 'edit':
                    editJurusan();
                    break;
            }
        });

        function addJurusan() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(JurusanModal.addBtn);
                $.ajax({
                    url: `<?= site_url('KepalaLab/addJurusan') ?>`,
                    'type': 'POST',
                    data: JurusanModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(JurusanModal.addBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataJurusan[bank_soal['id_jurusan']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderJurusan(dataJurusan);
                        JurusanModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }

        function editJurusan() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(JurusanModal.saveEditBtn);
                $.ajax({
                    url: `<?= site_url('KepalaLab/editJurusan') ?>`,
                    'type': 'POST',
                    data: JurusanModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(JurusanModal.saveEditBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataJurusan[bank_soal['id_jurusan']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderJurusan(dataJurusan);
                        JurusanModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }
    });
</script>