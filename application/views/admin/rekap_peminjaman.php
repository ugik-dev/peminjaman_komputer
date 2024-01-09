<!-- Tampilan halaman rekap peminjaman pada admin dan kalab -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" placeholder="Search" class="form-control my-1 mr-sm-2" id="search" name="search">
                        </div>
                        <div class="col-md-4">
                            <select class="form-control mr-sm-2" name="id_labor" <?=
                                                                                    ($this->session->userdata('id_role') == 1) ? 'hidden' : ''
                                                                                    ?> id="id_labor"></select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control mr-sm-2" name="id_komputer" id="id_komputer"> </select>
                        </div>
                    </div>
                    <button hidden type="submit" class="btn btn-success my-1 mr-sm-2" id="show_btn" data-loading-text="Loading..." onclick="this.form.target='show'"><i class="fal fa-search"></i> Cari</button>
                    <button hidden class="btn btn-primary my-1 mr-sm-2" id="add_btn" data-loading-text="Loading..."><i class="fal fa-plus"></i> Tambah</button>
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
                            <th colspan="2" style="background-color: white; text-align:center!important;vertical-align: middle;">Waktu Peminjaman</th>
                            <th style="width: 15%; text-align:center!important;vertical-align: middle;" rowspan="2">Lab</th>
                            <th style="width: 15%; text-align:center!important;vertical-align: middle;" rowspan="2">Komputer</th>
                            <th style="width: 15%; text-align:center!important;vertical-align: middle;" rowspan="2">Nama</th>
                            <th style="width: 15%; text-align:center!important;vertical-align: middle;" rowspan="2">Prodi</th>
                            <th style="width: 15%; text-align:center!important;vertical-align: middle;" rowspan="2">Keterangan</th>
                            <th style="width: 15%; text-align:center!important;vertical-align: middle;" rowspan="2">Status</th>
                            <th style="width: 15%; text-align:center!important;vertical-align: middle;" rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th style="width: 5%; text-align:center!important">Dari</th>
                            <th style="width: 5%; text-align:center!important">Sampai</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="peminjaman_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 class="modal-title" id="into-form"></h4>
                <a href="javascript:void(0);" data-bs-dismiss="modal"><i class="ti-close"></i></a>
            </div>
            <div class="modal-body" id="modal-body">
                <form role="form" id="peminjaman_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_peminjaman" name="id_peminjaman">
                    <input type="hidden" id="type" name="type">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="time">Waktu <span id="info-time"></span></label>
                                    <input type="datetime-local" placeholder="" class="form-control" id="time" name="time" required="required"></input>
                                </div>
                            </div>
                        </div>
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
            'id_peminjaman': $('#peminjaman_modal').find('#id_peminjaman'),
            'infoTime': $('#peminjaman_modal').find('#info-time'),
            'infForm': $('#peminjaman_modal').find('#into-form'),
            'time': $('#peminjaman_modal').find('#time'),
            'type': $('#peminjaman_modal').find('#type'),
        }

        var toolbar = {
            'form': $('#toolbar_form'),
            'showBtn': $('#show_btn'),
            'addBtn': $('#add_btn'),
            'id_labor': $('#toolbar_form').find('#id_labor'),
            'id_komputer': $('#toolbar_form').find('#id_komputer'),
            'search': $('#toolbar_form').find('#search'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [{
                className: 'dt-center',
                targets: [4]
            }, ],
            deferRender: false,
            "order": false,
            'search': false,
            "paging": false,
            'info': false,
            "scrollX": true,
            dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            'colvis'
        ]
        });

        var ReadyTable = $('#ReadyTable').DataTable({
            'columnDefs': [],
            deferRender: false,
            "order": false,
            'searching': false,
            "paging": false,
            'info': false
        });



        var FDataTable2 = $('#FDataTable2').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [2, "desc"]
            ]
        });


        var swalSaveConfigure = {
            title: "Konfirmasi",
            text: "Yakin akan memulai ujian?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Mulai Sekarang!",
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

        toolbar.form.submit(function(event) {
            event.preventDefault();
            switch (toolbar.form[0].target) {
                case 'show':
                    getKelolahbank_soal();
                    break;
                case 'add':
                    addNew();
                    break;
            }
        });

        swalLoading();
        $.when(getAllLabor(), getRekap()).done(function(a1, a2, a3) {
            swal.close();
        });
        toolbar.id_labor.on('change', () => {
            return $.ajax({
                url: `<?php echo site_url('GeneralController/getAllKomputer/') ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    data = json['data'];
                    renderOptKomp(data);
                    getRekap()
                },
                error: function(e) {}
            });
        })
        toolbar.id_komputer.on('change', () => {
            getRekap()
        })

        function getRekap() {
            return $.ajax({
                url: `<?php echo site_url('AdminController/getRekap/') ?>`,
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



        function getAllLabor() {
            return $.ajax({
                url: `<?php echo site_url('GeneralController/getAllLabor/') ?>`,
                'type': 'get',
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

        function timers() {

            var countDownDate = new Date("Jan 5, 2024 15:37:25").getTime();
            dataCount = document.getElementsByClassName("count");
            Object.values(dataCount).forEach((d) => {
                var id = $(d).data();
                console.log(id);
            });
            console.log(dataCount);

            var x = setInterval(function() {

                var now = new Date().getTime();

                Object.values(dataCount).forEach((d) => {
                    var curData = $(d).data();

                    var countDownDate = new Date(curData['end']).getTime();

                    var distance = countDownDate - now;
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    var id = $(d).html(days + "d " + hours + "h " +
                        minutes + "m " + seconds + "s ");
                    if (distance < 0) {
                        $(d).removeClass('text-success')
                        $(d).addClass('text-danger')
                    }
                });

            }, 1000);

        }

        function span_status(data, start, end, id) {
            if (data == '1') {
                return '<span class="text-primary bold"><i class="fa fa-hourglass-half text-primary">  </i> <b>Belum Checkin</b> </span>';
            } else
            if (data == '2') {
                console.log(start);
                var date1 = new Date(start); // 9:00 AM
                var date2 = new Date(end); // 5:00 PM
                console.log(date1);
                console.log(date2);
                var diff = date2 - date1;
                var msec = diff;
                var hh = Math.floor(msec / 1000 / 60 / 60);
                msec -= hh * 1000 * 60 * 60;
                var mm = Math.floor(msec / 1000 / 60);
                msec -= mm * 1000 * 60;
                var ss = Math.floor(msec / 1000);
                msec -= ss * 1000;
                console.log(hh + ":" + mm + ":" + ss);
                if (date1 < date2) {
                    var milisec_diff = date2 - date1;
                } else {
                    var milisec_diff = date2 - date1;
                }
                var days = Math.floor(milisec_diff / 1000 / 60 / (60 * 24));
                var date_diff = new Date(milisec_diff);
                console.log(days + " Days " + date_diff.getHours() + " Hours " + date_diff.getMinutes() + " Minutes " + date_diff.getSeconds() + " Seconds");
                time = 'start';

                return `<span class="text-success bold"><i class="fa fa-check-square-o text-success">  </i> <b>Checkin</b> </span>
                <br><b class="count text-success bold" data-id="${id}" data-end="${end}">${time}</b>
                `;

            } else
            if (data == '3') {
                return '<span class="text-light bold"><i class="fa fa-history text-light">  </i> <b>Checkout</b> </span>'
            } else
            if (data == '4') {
                return '<span class="text-danger bold"><i class="fa fa-times text-danger">  </i> <b>Batal</b> </span>'
            }
        }

        function renderOptLabor(data) {
            toolbar.id_labor.empty();
            toolbar.id_labor.append($('<option>', {
                value: "",
                text: "-- Semua Laboratorium --"
            }));

            Object.values(data).forEach((d) => {
                console.log(d)
                toolbar.id_labor.append($('<option>', {
                    value: d['id_labor'],
                    text: d['nama_labor'],
                }));
            });
        }

        function renderOptKomp(data) {
            toolbar.id_komputer.empty();
            toolbar.id_komputer.append($('<option>', {
                value: "",
                text: "-- Semua Komputer --"
            }));

            Object.values(data).forEach((d) => {
                console.log(d)
                toolbar.id_komputer.append($('<option>', {
                    value: d['id_komputer'],
                    text: d['label_komputer'],
                }));
            });
        }

        function renderRiwayat(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderData = [];
            Object.values(data).forEach((rent) => {
                var button = '';
                if (rent['status'] == 1)
                    button = `<div class="btn-group-vertical" style="width : 100% !important">
                        <button class="checkin btn btn-success btn-sm btn-block" data-id='${rent['id_peminjaman']}'><i class='fa fa-sign-in'></i> Checkin </button>
                    `;
                if (rent['status'] == 2)
                    button = `<div class="btn-group-vertical" style="width : 100% !important">
                        <button class="checkout btn btn-success btn-sm btn-block" data-id='${rent['id_peminjaman']}'><i class='fa fa-sign-out'></i> Checkout </button>
                    `;

                button = button + `
              </div>`;
                renderData.push([rent['time_start'].slice(0, 16), rent['time_end'].slice(0, 16), rent['nama_labor'], rent['label_komputer'], rent['nama_mahasiswa'], rent['nama_jurusan'], rent['keterangan'], rent['status'] != 2 ? span_status(rent['status']) : span_status(rent['status'], rent['time_start'], rent['time_end'], rent['id_peminjaman']), button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
            timers();
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
                        <input class="form-control select_komputer" type="radio" name="select_komputer" value='${com['id_komputer']}'> </input>
                    `;
                renderDataKomp.push([com['nama_labor'], com['label_komputer'], button]);
            });
            ReadyTable.clear().rows.add(renderDataKomp).draw('full-hold');
        }

        ReadyTable.on('click', '.select_komputer', () => {
            var value_select = $('input[name="select_komputer"]:checked').val();
            PeminjamanModal.add_btn.prop('disabled', false);
        })

        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return (
                [
                    date.getFullYear(),
                    padTo2Digits(date.getMonth() + 1),
                    padTo2Digits(date.getDate()),
                ].join('-') +
                ' ' + [
                    padTo2Digits(date.getHours()),
                    padTo2Digits(date.getMinutes()),
                ].join(':')
            );
        }



        FDataTable.on('click', '.checkin', function() {
            event.preventDefault();
            cur_time = formatDate(new Date());
            console.log(cur_time);
            var id = $(this).data('id');
            PeminjamanModal.self.modal('show');
            PeminjamanModal.type.val("checkin");
            PeminjamanModal.id_peminjaman.val(id);
            PeminjamanModal.time.val(cur_time);
            PeminjamanModal.infForm.html("Form Checkin")
            PeminjamanModal.infoTime.html("Checkin")
        });
        FDataTable.on('click', '.checkout', function() {
            event.preventDefault();
            cur_time = formatDate(new Date());
            console.log(cur_time);
            var id = $(this).data('id');
            PeminjamanModal.self.modal('show');
            PeminjamanModal.type.val("checkout");
            PeminjamanModal.id_peminjaman.val(id);
            PeminjamanModal.time.val(cur_time);
            PeminjamanModal.infForm.html("Form Checkout")
            PeminjamanModal.infoTime.html("Checkout")
        });
        PeminjamanModal.form.submit(function(ev) {
            console.log('subs')
            ev.preventDefault();
            swal(swalConfirm).then((result) => {
                if (!result.value) {
                    return;
                }

                $.ajax({
                    url: "<?= site_url('AdminController/action') ?>",
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
                        // window.location.href = '<?= base_url() ?>my-task/' + json['data'];
                        // renderRiwayat(dataRiwayat);
                    },
                    error: function(e) {}
                });
            });
        })
    });
</script>