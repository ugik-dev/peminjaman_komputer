<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <!-- <select class="form-control mr-sm-2" name="id_labor" id="id_labor"></select> -->

                    <!-- <input type="hidden" placeholder="" class="form-control" id="id_role" name="id_role" value="3"> -->
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

                            <th style="width: 15%; text-align:center!important">ID</th>
                            <th style="width: 12%; text-align:center!important">LABOR</th>
                            <th style="width: 12%; text-align:center!important">LABEL</th>
                            <th style="width: 12%; text-align:center!important">STATUS</th>
                            <th style="width: 7%; text-align:center!important">ACTION</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal inmodal" id="komputer_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 class="modal-title">Form Komputer</h4>
                <a href="javascript:void(0);" data-bs-dismiss="modal"><i class="ti-close"></i></a>
            </div>
            <div class="modal-body" id="modal-body">
                <form role="form" id="bank_soal_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_komputer" name="id_komputer">

                    <div class="form-group">
                        <label for="nama">Label Komputer</label>
                        <input type="text" placeholder="" class="form-control" id="label_komputer" name="label_komputer" required="required"></input>
                    </div>
                    <div class="form-group">
                        <label for="nama">Status</label>
                        <select class="form-control mr-sm-2" name="status" id="status">
                            <option value="Y"> Aktif</option>
                            <option value="N"> Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Laboratorium</label>
                        <select class="form-control mr-sm-2" name="id_labor" id="id_labor">
                        </select>
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
        $('#master_komputer').addClass('active');

        var toolbar = {
            'form': $('#toolbar_form'),
            'showBtn': $('#show_btn'),
            'addBtn': $('#show_btn'),
            'id_labor': $('#toolbar_form').find('#id_labor'),
            'id_komputer': $('#toolbar_form').find('#id_komputer'),
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

        var KomputerModal = {
            'self': $('#komputer_modal'),
            'info': $('#komputer_modal').find('.info'),
            'form': $('#komputer_modal').find('#bank_soal_form'),
            'addBtn': $('#komputer_modal').find('#add_btn'),
            'saveEditBtn': $('#komputer_modal').find('#save_edit_btn'),
            'id_komputer': $('#komputer_modal').find('#id_komputer'),
            'id_labor': $('#komputer_modal').find('#id_labor'),
            'label_komputer': $('#komputer_modal').find('#label_komputer'),
            'status': $('#komputer_modal').find('#status'),
        }

        swalLoading();
        $.when(getAllLabor(), getAllKomputer(), ).done(function(a1, a2, a3) {
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

        var dataKomputer = {};
        var dataRole = {};

        toolbar.form.submit(function(event) {
            event.preventDefault();
            switch (toolbar.form[0].target) {
                case 'show':
                    getAllKomputer();
                    break;
                case 'add':
                    showKomputerModal();
                    break;
            }
        });

        // getAllKomputer()

        function getAllKomputer() {
            return $.ajax({
                url: `<?php echo site_url('GeneralController/getAllKomputer/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataKomputer = json['data'];
                    renderKomputer(dataKomputer);
                },
                error: function(e) {}
            });
        }

        function getAllLabor() {
            return $.ajax({
                url: `<?php echo site_url('GeneralController/getAllLabor/') ?>`,
                'type': 'POST',
                data: {},
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    data = json['data'];
                    renderOptLabor(data);
                },
                error: function(e) {}
            });
        }

        function renderOptLabor(data) {
            KomputerModal.id_labor.empty();
            KomputerModal.id_labor.append($('<option>', {
                value: "",
                text: "-- Pilih Labor --"
            }));

            Object.values(data).forEach((d) => {
                console.log(d)
                KomputerModal.id_labor.append($('<option>', {
                    value: d['id_labor'],
                    text: d['id_labor'] + ' :: ' + d['nama_labor'],
                }));
            });
        }


        function renderKomputer(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {

                var detailButton = `
                <li>
      <a class="detail dropdown-item" href='<?= site_url() ?>AdminController/rekap/${d['id_komputer']}'><i class='fa fa-share'></i> Rekap</a>
      </li>
      `;
                var editButton = `
                <li>
        </li>
        <a class="edit dropdown-item" data-id='${d['id_komputer']}'><i class='fa fa-pencil'></i> Edit </a>
        </li>
      `;
                var deleteButton = `
                <li>
        <a class="delete dropdown-item" data-id='${d['id_komputer']}'><i class='fa fa-trash'></i> Hapus </a>
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
  </div>    `;

                renderData.push([d['id_komputer'], d['nama_labor'], d['label_komputer'], d['status'] == 'Y' ? 'Aktif' : 'Tidak Aktif', button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.edit', function() {
            event.preventDefault();
            KomputerModal.form.trigger('reset');
            KomputerModal.addBtn.hide();
            KomputerModal.saveEditBtn.show();
            var id = $(this).data('id');
            var cur = dataKomputer[id];
            KomputerModal.id_komputer.val(cur['id_komputer']);
            KomputerModal.id_labor.val(cur['id_labor']);
            KomputerModal.status.val(cur['status']);
            KomputerModal.label_komputer.val(cur['label_komputer']);


            KomputerModal.self.modal('show');
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
                    url: "<?= site_url('AdminController/deleteKomputer') ?>",
                    'type': 'POST',
                    data: {
                        'id_komputer': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataKomputer[id];
                        swal("Delete Berhasil", "", "success");
                        renderKomputer(dataKomputer);
                    },
                    error: function(e) {}
                });
            });
        });

        function showKomputerModal() {
            KomputerModal.self.modal('show');
            KomputerModal.addBtn.show();
            KomputerModal.saveEditBtn.hide();
            KomputerModal.form.trigger('reset');
        }

        KomputerModal.form.submit(function(event) {
            event.preventDefault();
            switch (KomputerModal.form[0].target) {
                case 'add':
                    addKomputer();
                    break;
                case 'edit':
                    editKomputer();
                    break;
            }
        });

        function addKomputer() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(KomputerModal.addBtn);
                $.ajax({
                    url: `<?= site_url('AdminController/addKomputer') ?>`,
                    'type': 'POST',
                    data: KomputerModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(KomputerModal.addBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataKomputer[bank_soal['id_komputer']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderKomputer(dataKomputer);
                        KomputerModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }

        function editKomputer() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(KomputerModal.saveEditBtn);
                $.ajax({
                    url: `<?= site_url('AdminController/editKomputer') ?>`,
                    'type': 'POST',
                    data: KomputerModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(KomputerModal.saveEditBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataKomputer[bank_soal['id_komputer']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderKomputer(dataKomputer);
                        KomputerModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }
    });
</script>