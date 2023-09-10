<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <button class="btn btn-md btn-primary mb-15 float-start" id="add_btn" type="button" data-bs-toggle="modal" data-bs-target="#DataModal">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </form>
                <table id="FDataTable" class="display dataTable cell-border" id="basicdata-tbl" style="width: 100%">
                    <thead style="width: 100%">
                        <tr>
                            <th colspan="2" style="background-color: white; text-align:center!important;vertical-align: middle;">Waktu Peminjaman</th>
                            <th style=" text-align:center!important;vertical-align: middle;" rowspan="2">Ruang</th>
                            <th style=" text-align:center!important;vertical-align: middle;" rowspan="2">Komputer</th>
                            <th style=" text-align:center!important;vertical-align: middle;" rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th style="text-align:center!important">Dari</th>
                            <th style="text-align:center!important">Sampai</th>
                        </tr>
                    </thead>
                    <tbody style="width: 100%"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="peminjaman_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Peminjaman</h4>
                <a href="javascript:void(0);" data-bs-dismiss="modal"><i class="ti-close"></i></a>
            </div>
            <div class="modal-body" id="modal-body">
                <form role="form" id="peminjaman_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_peminjaman" name="id_peminjaman">
                    <label for="open_start">Waktu Pengerjaan Peminjaman</label>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="time_start"> Dari</label>
                                    <input type="datetime-local" placeholder="" class="form-control" id="time_start" name="time_start" required="required"></input>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="time_end"> Sampai</label>
                                    <input type="datetime-local" placeholder="" class="form-control" id="time_end" name="time_end" required="required"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a class="btn btn-secondary my-1 mr-sm-2 text-white" id="search_ready_komputer"><i class="fa fa-search"></i> <strong> Cari Komputer</strong></a>
                    </div>
                    <div class="col-lg-12">
                        <table id="ReadyTable" class="table table-bordered table-hover" style="padding:0px">
                            <thead>
                                <tr>
                                    <th style="width: 15%; text-align:center!important">Ruang</th>
                                    <th style="width: 12%; text-align:center!important">Komputer</th>
                                    <th style="width: 7%; text-align:center!important">Pilih</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..." onclick="this.form.target='add'"><strong>Simpan</strong></button>
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
        $('#my_task').addClass('active');

        var PeminjamanModal = {
            'self': $('#peminjaman_modal'),
            'info': $('#peminjaman_modal').find('.info'),
            'form': $('#peminjaman_modal').find('#peminjaman_form'),
            'add_btn': $('#peminjaman_modal').find('#add_btn'),
            'search': $('#peminjaman_modal').find('#search_ready_komputer'),
            'id_peminjaman': $('#peminjaman_modal').find('#id_peminjaman'),
            'time_start': $('#peminjaman_modal').find('#time_start'),
            'time_end': $('#peminjaman_modal').find('#time_end'),
        }

        var toolbar = {
            'form': $('#toolbar_form'),
            'showBtn': $('#show_btn'),
            'addBtn': $('#add_btn'),
            'id_mapel': $('#toolbar_form').find('#id_mapel'),
            'search': $('#toolbar_form').find('#search'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [{
                className: 'dt-center',
                targets: [4]
            }, ],
            deferRender: false,
            "ordering": false,
            'search': false,
            "paging": false,
            'info': false,
        });

        var ReadyTable = $('#ReadyTable').DataTable({
            'columnDefs': [{
                className: 'dt-center',
                targets: [2]
            }, ],
            deferRender: false,
            "order": false,
            'searching': false,
            "paging": false,
            'info': false
        });

        var swalSaveConfigure = {
            title: "Konfirmasi",
            text: "Yakin akan menyimpan?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
        };

        var swalConfirm = {
            title: "Konfirmasi",
            text: "Yakin akan meminjaman pada waktu ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya!",
        };


        var dataRiwayat = {};
        var dataRole = {};

        swalLoading();
        $.when(getRiwayat()).done(function(a1, a2, a3) {
            swal.close();
        });

        function getRiwayat() {
            return $.ajax({
                url: `<?php echo site_url('Mahasiswa/getRiwayat/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataRiwayat = json['data'];
                    renderRiwayat(dataRiwayat);
                },
                error: function(e) {}
            });
        }

        function span_status(data) {
            if (data == 'lulus') {
                return '<i class="fa fa-check text-success"> Lulus </i>'
            } else {
                return '<i class="fa fa-times text-danger"> Tidak Lulus </i>'
            }
        }

        toolbar.addBtn.on('click', () => {
            console.log('<?= date('Y-m-d') . 'T' . date('h:i') ?>')
            PeminjamanModal.self.modal('show');
            PeminjamanModal.time_start.val('<?= date('Y-m-d') . 'T' . date('H:i') ?>');
            PeminjamanModal.time_end.val('<?= date('Y-m-d', strtotime("+1 hour")) . 'T' . date('H:i', strtotime("+1 hour")) ?>');
        })

        function renderRiwayat(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderData = [];
            Object.values(data).forEach((exam) => {

                var button = `
                        <button class="register btn btn-primary" data-id='${exam['id_session_exam']}'><i class='fa fa-arrow-circle-right '></i> Daftar </button>
                    `;
                renderData.push([exam['time_start'], exam['time_end'], exam['nama_labor'], exam['label_komputer'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }


        function renderReadyKomputer(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderDataKomp = [];
            Object.values(data).forEach((com) => {
                var st = `<div class="alert alert-warning"><i class='fa fa-clock-o '></i>Belum dimulai</div>`

                var button = `
                <label style="width : 100%" class="select_komputer" for="Defaultradio${com['id_komputer']}">
                      <input class="form-check-input" type="radio" value="${com['id_komputer']}" id="Defaultradio${com['id_komputer']}" name="select_komputer">
                  </label>  `;
                renderDataKomp.push([com['nama_labor'], com['label_komputer'], button]);
            });
            ReadyTable.clear().rows.add(renderDataKomp).draw('full-hold');
        }

        ReadyTable.on('click', '.select_komputer', () => {
            var value_select = $('input[name="select_komputer"]:checked').val();
            PeminjamanModal.add_btn.prop('disabled', false);
        })

        PeminjamanModal.search.on('click', function() {
            event.preventDefault();
            swalLoading();
            PeminjamanModal.add_btn.prop('disabled', true)
            $.ajax({
                url: "<?= site_url('GeneralController/searchReady') ?>",
                'type': 'get',
                data: PeminjamanModal.form.serialize(),
                success: function(data) {
                    swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        swal("Gagal", json['message'], "error");
                        return;
                    }
                    renderReadyKomputer(json['data']);
                    var value_select = $('input[name="select_komputer"]:checked').val();
                    if (value_select == undefined) {
                        PeminjamanModal.add_btn.prop('disabled', true)
                    } else
                    if (value_select == '') {
                        PeminjamanModal.add_btn.prop('disabled', true)
                    } else {
                        PeminjamanModal.add_btn.prop('disabled', false)
                    }
                },
                error: function(e) {}
            });
        });


        FDataTable.on('click', '.register', function() {
            event.preventDefault();
            var id = $(this).data('id');
            PeminjamanModal.self.modal('show');
            PeminjamanModal.id_exam.val(id);
        });

        PeminjamanModal.form.submit(function(ev) {
            ev.preventDefault();
            swal(swalConfirm).then((result) => {
                if (!result.value) {
                    return;
                }
                // swalLoading();

                $.ajax({
                    url: "<?= site_url('Mahasiswa/addPeminjaman') ?>",
                    'type': 'POST',
                    data: PeminjamanModal.form.serialize(),
                    success: function(data) {
                        swal.close();
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Gagal", json['message'], "error");
                            return;
                        }
                        dataRiwayat[json['data']['id_peminjaman']] = json['data'];
                        renderRiwayat(dataRiwayat);

                        swal("Berhasil", "", "success");
                        PeminjamanModal.self.modal('hide');

                    },
                    error: function(e) {}
                });
            });
        })
    });
</script>