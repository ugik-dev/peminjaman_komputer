<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox ssection-container">
        <div class="ibox-content">
            <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                <select class="form-control mr-sm-2" name="id_mapel" id="id_mapel" required>
                    <option value="">-- Semua Soal --</option>
                    <option value="6">Matematika</option>
                    <option value="5">Fisika</option>
                    <option value="2">Bahasa Indonesia</option>
                    <option value="3">Bahasa Inggris</option>
                </select>

                <!-- <input type="hidden" placeholder="" class="form-control" id="id_role" name="id_role" value="3"> -->
                <input type="text" placeholder="Search" class="form-control my-1 mr-sm-2" id="search" name="search">

                <button type="submit" class="btn btn-success my-1 mr-sm-2" id="show_btn" data-loading-text="Loading..." onclick="this.form.target='show'"><i class="fal fa-search"></i> Cari</button>
                <button type="submit" class="btn btn-primary my-1 mr-sm-2" id="add_btn" data-loading-text="Loading..." onclick="this.form.target='add'"><i class="fal fa-plus"></i> Tambah</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                            <thead>
                                <tr>

                                    <th style="width: 15%; text-align:center!important">Soal</th>
                                    <th style="width: 12%; text-align:center!important">Mapel</th>
                                    <th style="width: 12%; text-align:center!important">Jawaban</th>
                                    <th style="width: 7%; text-align:center!important">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal" id="bank_soal_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Kelola Soal</h4>
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form role="form" id="bank_soal_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_bank_soal" name="id_bank_soal">

                    <div class="form-group">
                        <label for="nama">Mata Pelajaran</label>
                        <select class="form-control mr-sm-2" name="id_mapel" id="id_mapel">
                            <option value="6">Matematika</option>
                            <option value="5">Fisika</option>
                            <option value="2">Bahasa Indonesia</option>
                            <option value="3">Bahasa Inggris</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Soal</label>
                        <textarea type="text" placeholder="" class="form-control" id="soal" name="soal" required="required"></textarea>
                    </div>
                    <div class="form-group" id="">
                        <label for="image">File Soal (img/pdf)</label>
                        <p class="no-margins"><span id="image">-</span></p>
                    </div>
                    <div class="form-group" id="">
                        <p class="no-margins"><span id="frm_img">-</span></p>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-10">
                            <input type="hidden" id="id_jawaban" name="id_jawaban">
                            <textarea type="text" placeholder="Jawaban" class="form-control" id="jawaban" name="jawaban" required="required"></textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <!-- <label for="password">Jawaban</label> -->
                            <input type="number" min="-5" step="1" max="5" placeholder="Poin" class="form-control" id="jawaban_poin" name="jawaban_poin" required="required"></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-10">
                            <input type="hidden" id="id_opsi_1" name="id_opsi_1">

                            <textarea type="text" placeholder="Opsi 1" class="form-control" id="opsi_1" name="opsi_1" required="required"></textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <!-- <label for="password">Jawaban</label> -->
                            <input type="number" min="-5" step="1" max="5" placeholder="Poin" class="form-control" id="opsi_1_poin" name="opsi_1_poin" required="required"></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-10">
                            <input type="hidden" id="id_opsi_2" name="id_opsi_2">
                            <textarea type="text" placeholder="Opsi 2" class="form-control" id="opsi_2" name="opsi_2" required="required"></textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <!-- <label for="password">Jawaban</label> -->
                            <input type="number" min="-5" step="1" max="5" placeholder="Poin" class="form-control" id="opsi_2_poin" name="opsi_2_poin" required="required"></input>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-10">
                            <input type="hidden" id="id_opsi_3" name="id_opsi_3">
                            <textarea type="text" placeholder="Opsi 3" class="form-control" id="opsi_3" name="opsi_3" required="required"></textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <!-- <label for="password">Jawaban</label> -->
                            <input type="number" min="-5" step="1" max="5" placeholder="Poin" class="form-control" id="opsi_3_poin" name="opsi_3_poin" required="required"></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-10">
                            <input type="hidden" id="id_opsi_4" name="id_opsi_4">
                            <textarea type="text" placeholder="Opsi 4" class="form-control" id="opsi_4" name="opsi_4" required="required"></textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <!-- <label for="password">Jawaban</label> -->
                            <input type="number" min="-5" step="1" max="5" placeholder="Poin" class="form-control" id="opsi_4_poin" name="opsi_4_poin" required="required"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- <label for="password">Opsi Peralihan 4</label> -->
                    </div>
                    <div class="form-group">
                        <!-- <label for="password">Pembahasan</label> -->
                        <textarea type="text" placeholder="Pembahasan" class="form-control" id="pembahasan" name="pembahasan"></textarea>
                    </div>
                    <div class="form-group" id="task_dokumen_form">
                        <label for="pembahasan_img">File Pembahasan (img/pdf)</label>
                        <p class="no-margins"><span id="pembahasan_img">-</span></p>
                    </div>
                    <div class="form-group" id="">
                        <p class="no-margins"><span id="frm_pembahasan">-</span></p>
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

        $('#bank_soal').addClass('active');


        var toolbar = {
            'form': $('#toolbar_form'),
            'showBtn': $('#show_btn'),
            'addBtn': $('#show_btn'),
            'id_mapel': $('#toolbar_form').find('#id_mapel'),
            'search': $('#toolbar_form').find('#search'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });


        var Kelolahbank_soalModal = {
            'self': $('#bank_soal_modal'),
            'info': $('#bank_soal_modal').find('.info'),
            'form': $('#bank_soal_modal').find('#bank_soal_form'),
            'addBtn': $('#bank_soal_modal').find('#add_btn'),
            'saveEditBtn': $('#bank_soal_modal').find('#save_edit_btn'),
            'id_bank_soal': $('#bank_soal_modal').find('#id_bank_soal'),
            'id_mapel': $('#bank_soal_modal').find('#id_mapel'),
            'soal': $('#bank_soal_modal').find('#soal'),
            'jawaban': $('#bank_soal_modal').find('#jawaban'),
            'jawaban_poin': $('#bank_soal_modal').find('#jawaban_poin'),
            'opsi_1': $('#bank_soal_modal').find('#opsi_1'),
            'opsi_2': $('#bank_soal_modal').find('#opsi_2'),
            'opsi_3': $('#bank_soal_modal').find('#opsi_3'),
            'opsi_4': $('#bank_soal_modal').find('#opsi_4'),
            'opsi_1_poin': $('#bank_soal_modal').find('#opsi_1_poin'),
            'opsi_2_poin': $('#bank_soal_modal').find('#opsi_2_poin'),
            'opsi_3_poin': $('#bank_soal_modal').find('#opsi_3_poin'),
            'opsi_4_poin': $('#bank_soal_modal').find('#opsi_4_poin'),
            'pembahasan': $('#bank_soal_modal').find('#pembahasan'),
            'frm_pembahasan': $('#bank_soal_modal').find('#frm_pembahasan'),
            'frm_img': $('#bank_soal_modal').find('#frm_img'),
            'pembahasan_img': new FileUploader($('#bank_soal_modal').find('#pembahasan_img'), "", "pembahasan_img", ".png , .pdf , .jpg , .jpeg , .pdf ", false, true),
            'image': new FileUploader($('#bank_soal_modal').find('#image'), "", "image", ".png , .pdf , .jpg , .jpeg , .pdf ", false, true),

        }

        // getAllMapel();

        // function getAllMapel() {
        //     buttonLoading(toolbar.showBtn);
        //     $.ajax({
        //         url: `<?= site_url('ParameterController/getAllMapel') ?>`,
        //         'type': 'GET',
        //         data: {},
        //         success: function(data) {
        //             buttonIdle(toolbar.showBtn);
        //             var json = JSON.parse(data);
        //             if (json['error']) {
        //                 swal("Simpan Gagal", json['message'], "error");
        //                 return;
        //             }
        //             dataMapel = json['data'];
        //             renderMapel(dataMapel);
        //         },
        //         error: function(e) {}
        //     });
        // }

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

        var dataKelolahbank_soal = {};
        var dataRole = {};

        toolbar.form.submit(function(event) {
            event.preventDefault();
            switch (toolbar.form[0].target) {
                case 'show':
                    getKelolahbank_soal();
                    break;
                case 'add':
                    showKelolahbank_soalModal();
                    break;
            }
        });

        getKelolahbank_soal()

        function getKelolahbank_soal() {
            return $.ajax({
                url: `<?php echo site_url('AdminController/getAllBankSoal/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataKelolahbank_soal = json['data'];
                    renderKelolahbank_soal(dataKelolahbank_soal);
                },
                error: function(e) {}
            });
        }


        // function renderMapel(data) {
        //     toolbar.id_mapel.empty();
        //     toolbar.id_mapel.append($('<option>', {
        //         value: "",
        //         text: "-- Pilih Mapel --"
        //     }));

        //     Kelolahbank_soalModal.id_mapel.empty();
        //     Kelolahbank_soalModal.id_mapel.append($('<option>', {
        //         value: "",
        //         text: "-- Pilih Mapel --"
        //     }));

        //     Object.values(data).forEach((d) => {
        //         toolbar.id_mapel.append($('<option>', {
        //             value: d['id_mapel'],
        //             text: d['nama_mapel'],
        //         }));
        //         Kelolahbank_soalModal.id_mapel.append($('<option>', {
        //             value: d['id_mapel'],
        //             text: d['nama_mapel'],
        //         }));
        //     });
        // }

        function renderKelolahbank_soal(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderData = [];
            Object.values(data).forEach((bank_soal) => {

                var detailButton = `
      <a class="detail dropdown-item" href='<?= site_url() ?>AdminController/DetailKelolahbank_soal?id_bank_soal=${bank_soal['id_bank_soal']}&nama_bank_soal=${bank_soal['nama']}'><i class='fa fa-share'></i> Detail Desa Wisata</a>
      `;
                var editButton = `
        <a class="edit dropdown-item" data-id='${bank_soal['id_bank_soal']}'><i class='fa fa-pencil'></i> Edit </a>
      `;
                var deleteButton = `
        <a class="delete dropdown-item" data-id='${bank_soal['id_bank_soal']}'><i class='fa fa-trash'></i> Hapus </a>
      `;
                var button = `
        <div class="btn-group" role="group">
          <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-bars'></i></button>
          <div class="dropdown-menu" aria-labelledby="action">
            ${editButton}
            ${deleteButton}
          </div>
        </div>
      `;

                renderData.push([bank_soal['soal'], bank_soal['nama_mapel'], bank_soal['name_opsi'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.edit', function() {
            event.preventDefault();
            Kelolahbank_soalModal.form.trigger('reset');
            Kelolahbank_soalModal.addBtn.hide();
            Kelolahbank_soalModal.saveEditBtn.show();
            swal({
                title: 'Data loading',
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading();
                }
            })
            var id = $(this).data('id');
            var bank_soal = dataKelolahbank_soal[id];
            $.ajax({
                url: "<?= site_url('AdminController/getOpsi') ?>",
                'type': 'Get',
                data: {
                    'id_bank_soal': id
                },
                success: function(data) {
                    swal.close()
                    var json = JSON.parse(data);
                    if (json['error']) {
                        swal("Gagal", json['message'], "error");
                        return;
                    }
                    opsi = json['data'];
                    Kelolahbank_soalModal.id_bank_soal.val(bank_soal['id_bank_soal']);
                    Kelolahbank_soalModal.pembahasan.val(bank_soal['pembahasan']);

                    i = 1;
                    Kelolahbank_soalModal.id_bank_soal.val(bank_soal['id_bank_soal']);
                    Kelolahbank_soalModal.id_mapel.val(bank_soal['id_mapel']);
                    Kelolahbank_soalModal.soal.val(bank_soal['soal']);
                    Object.values(opsi).forEach((d) => {
                        if (d['status'] == 'Y') {
                            document.getElementById('id_jawaban').value = d['id_opsi'];
                            Kelolahbank_soalModal.jawaban.val(d['name_opsi']);
                            Kelolahbank_soalModal.jawaban_poin.val(d['poin']);
                        } else {
                            document.getElementById('id_opsi_' + i).value = d['id_opsi'];
                            document.getElementById('opsi_' + i).value = d['name_opsi'];
                            document.getElementById('opsi_' + i + '_poin').value = d['poin'];
                            i++;
                        }

                    })
                    if (bank_soal['pembahasan_img'])
                        Kelolahbank_soalModal.frm_pembahasan.html('<img src="<?= base_url() ?>upload/pembahasan_img/' + bank_soal['pembahasan_img'] + '">')
                    else
                        Kelolahbank_soalModal.frm_pembahasan.html('No File')
                    if (bank_soal['image'])
                        Kelolahbank_soalModal.frm_img.html('<img src="<?= base_url() ?>upload/image/' + bank_soal['image'] + '">')
                    else
                        Kelolahbank_soalModal.frm_img.html('')


                    Kelolahbank_soalModal.self.modal('show');
                },
                error: function(e) {}
            });
        });

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            swal(swalDeleteConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('Kelolahbank_soalController/deleteKelolahbank_soal') ?>",
                    'type': 'POST',
                    data: {
                        'id_bank_soal': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataKelolahbank_soal[id];
                        swal("Delete Berhasil", "", "success");
                        renderKelolahbank_soal(dataKelolahbank_soal);
                    },
                    error: function(e) {}
                });
            });
        });

        function showKelolahbank_soalModal() {
            Kelolahbank_soalModal.self.modal('show');
            Kelolahbank_soalModal.addBtn.show();
            Kelolahbank_soalModal.saveEditBtn.hide();
            Kelolahbank_soalModal.form.trigger('reset');
            Kelolahbank_soalModal.id_mapel.val(toolbar.id_mapel.val());
            Kelolahbank_soalModal.frm_img.html('')
            Kelolahbank_soalModal.frm_pembahasan.html('')
            Kelolahbank_soalModal.jawaban_poin.val(4)
            // if (toolbar.id_mapel.val() == '16') {
            Kelolahbank_soalModal.opsi_1_poin.val(-1)
            Kelolahbank_soalModal.opsi_2_poin.val(-1)
            Kelolahbank_soalModal.opsi_3_poin.val(-1)
            Kelolahbank_soalModal.opsi_4_poin.val(-1)

            // }

        }

        Kelolahbank_soalModal.form.submit(function(event) {
            event.preventDefault();
            switch (Kelolahbank_soalModal.form[0].target) {
                case 'add':
                    addKelolahbank_soal();
                    break;
                case 'edit':
                    editKelolahbank_soal();
                    break;
            }
        });

        function addKelolahbank_soal() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(Kelolahbank_soalModal.addBtn);
                $.ajax({
                    url: `<?= site_url('AdminController/addBankSoal') ?>`,
                    'type': 'POST',
                    data:
                        // Kelolahbank_soalModal.form.serialize(),
                        new FormData(Kelolahbank_soalModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        buttonIdle(Kelolahbank_soalModal.addBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataKelolahbank_soal[bank_soal['id_bank_soal']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderKelolahbank_soal(dataKelolahbank_soal);
                        Kelolahbank_soalModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }

        function editKelolahbank_soal() {
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(Kelolahbank_soalModal.saveEditBtn);
                $.ajax({
                    url: `<?= site_url('AdminController/editBankSoal') ?>`,
                    'type': 'POST',
                    data: new FormData(Kelolahbank_soalModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        buttonIdle(Kelolahbank_soalModal.saveEditBtn);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var bank_soal = json['data']
                        dataKelolahbank_soal[bank_soal['id_bank_soal']] = bank_soal;
                        swal("Simpan Berhasil", "", "success");
                        renderKelolahbank_soal(dataKelolahbank_soal);
                        Kelolahbank_soalModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        }
    });
</script>