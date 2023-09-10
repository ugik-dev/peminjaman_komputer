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
                            <th style="width: 50%; text-align:center!important">NAMA LABOR</th>

                            <th style="width: 7%; text-align:center!important">ACTION</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal inmodal" id="labor_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 class="modal-title">Form Laboratorium</h4>
                <a href="javascript:void(0);" data-bs-dismiss="modal"><i class="ti-close"></i></a>
            </div>
            <div class="modal-body" id="modal-body">
                <form role="form" id="labor_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_labor" name="id_labor">

                    <div class="form-group">
                        <label for="nama">Nama Laboratorium</label>
                        <input type="text" placeholder="" class="form-control" id="nama_labor" name="nama_labor" required="required"></input>
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
        $('#master_labor').addClass('active');

        var toolbar = {
            'form': $('#toolbar_form'),
            'showBtn': $('#show_btn'),
            'addBtn': $('#show_btn'),
            'id_labor': $('#toolbar_form').find('#id_labor'),
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

        var LaborModal = {
            'self': $('#labor_modal'),
            'info': $('#labor_modal').find('.info'),
            'form': $('#labor_modal').find('#labor_form'),
            'addBtn': $('#labor_modal').find('#add_btn'),
            'saveEditBtn': $('#labor_modal').find('#save_edit_btn'),
            'id_labor': $('#labor_modal').find('#id_labor'),
            'nama_labor': $('#labor_modal').find('#nama_labor'),
            'status': $('#labor_modal').find('#status'),
        }

        swalLoading();
        $.when(getAllLabor(), ).done(function(a1, a2, a3) {
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

        var dataLabor = {};
        var dataRole = {};

        toolbar.form.submit(function(event) {
            event.preventDefault();
            switch (toolbar.form[0].target) {
                case 'show':
                    getAllLabor();
                    break;
                case 'add':
                    showLaborModal();
                    break;
            }
        });

        // getAllLabor()

        function getAllLabor() {
            return $.ajax({
                url: `<?php echo site_url('GeneralController/getAllLabor/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataLabor = json['data'];
                    renderLabor(dataLabor);
                },
                error: function(e) {}
            });
        }



        function renderLabor(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderData = [];
            Object.values(data).forEach((d) => {

                var detailButton = `
                    <li>
                        <a class="detail dropdown-item" href='<?= site_url() ?>AdminController/rekap/${d['id_labor']}'><i class='fa fa-share'></i> Rekap</a>
                    </li>
                    `;
                var editButton = `
                    <li>
                        <a class="edit dropdown-item" data-id='${d['id_labor']}'><i class='fa fa-pencil'></i> Edit </a>
                    </li>
                    `;
                var deleteButton = `
                    <li>
                        <a class="delete dropdown-item" data-id='${d['id_labor']}'><i class='fa fa-trash'></i> Hapus </a>
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

                renderData.push([d['id_labor'], d['nama_labor'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.edit', function() {
            event.preventDefault();
            LaborModal.form.trigger('reset');
            LaborModal.addBtn.hide();
            LaborModal.saveEditBtn.show();
            var id = $(this).data('id');
            var cur = dataLabor[id];
            LaborModal.id_labor.val(cur['id_labor']);
            LaborModal.status.val(cur['status']);
            LaborModal.nama_labor.val(cur['nama_labor']);


            LaborModal.self.modal('show');
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
                    url: "<?= site_url('AdminController/deleteLabor') ?>",
                    'type': 'POST',
                    data: {
                        'id_labor': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataLabor[id];
                        swal("Delete Berhasil", "", "success");
                        renderLabor(dataLabor);
                    },
                    error: function(e) {}
                });
            });
        });

        function showLaborModal() {
            LaborModal.self.modal('show');
            LaborModal.addBtn.show();
            LaborModal.saveEditBtn.hide();
            LaborModal.form.trigger('reset');
        }

        LaborModal.form.submit(function(event) {
            event.preventDefault();
            switch (LaborModal.form[0].target) {
                case 'add':
                    addLabor();
                    break;
                case 'edit':
                    editLabor();
                    break;
            }
        });

        function addLabor() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(LaborModal.addBtn);
                $.ajax({
                    url: `<?= site_url('AdminController/addLabor') ?>`,
                    'type': 'POST',
                    data: LaborModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(LaborModal.addBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataLabor[bank_soal['id_labor']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderLabor(dataLabor);
                        LaborModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }

        function editLabor() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(LaborModal.saveEditBtn);
                $.ajax({
                    url: `<?= site_url('AdminController/editLabor') ?>`,
                    'type': 'POST',
                    data: LaborModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(LaborModal.saveEditBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataLabor[bank_soal['id_labor']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderLabor(dataLabor);
                        LaborModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }
    });
</script>