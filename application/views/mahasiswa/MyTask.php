<div class="wrapper wrapper-content animated fadeInRight">
    <!-- <div class="ibox ssection-container">
        <div class="ibox-content">
            <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                <select class="form-control mr-sm-2" name="id_mapel" id="id_mapel" required></select>
                <input type="text" placeholder="Search" class="form-control my-1 mr-sm-2" id="search" name="search">

                <button type="submit" class="btn btn-success my-1 mr-sm-2" id="show_btn" data-loading-text="Loading..." onclick="this.form.target='show'"><i class="fal fa-search"></i> Cari</button>
                <button type="submit" class="btn btn-primary my-1 mr-sm-2" id="add_btn" data-loading-text="Loading..." onclick="this.form.target='add'"><i class="fal fa-plus"></i> Tambah</button>
            </form>
        </div>
    </div> -->

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <!-- <h1>Avaliable Exam</h1> -->
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                            <thead>
                                <tr>
                                    <th style="width: 15%; text-align:center!important">Waktu Pengerjaan</th>
                                    <th style="width: 12%; text-align:center!important">Nama</th>
                                    <th style="width: 12%; text-align:center!important"></th>
                                    <th style="width: 12%; text-align:center!important">Status</th>
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


<div class="modal inmodal" id="daftar_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Daftar</h4>
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form role="form" id="daftar_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_exam" name="id_session_exam">

                    <div class="form-group">
                        <label for="req_jurusan">Pilih Jurusan Yang Anda Minati 1</label>
                        <select class="form-control" id="req_jurusan" name="req_jurusan" required="required"> </select>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Pilih Jurusan Yang Anda Minati 2</label>
                        <select class="form-control" id="req_jurusan_2" name="req_jurusan_2"> </select>
                    </div>

                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="daftar_btn" data-loading-text="Loading..." onclick="this.form.target='edit'"><strong>Daftar Sekarang</strong></button>
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

        var DaftarModal = {
            'self': $('#daftar_modal'),
            'info': $('#daftar_modal').find('.info'),
            'form': $('#daftar_modal').find('#daftar_form'),
            'daftar_btn': $('#daftar_modal').find('#daftar_btn'),
            'id_exam': $('#daftar_modal').find('#id_exam'),
            'req_jurusan': $('#daftar_modal').find('#req_jurusan'),
            'req_jurusan_2': $('#daftar_modal').find('#req_jurusan_2'),
        }
        var toolbar = {
            'form': $('#toolbar_form'),
            'showBtn': $('#show_btn'),
            'addBtn': $('#show_btn'),
            'id_mapel': $('#toolbar_form').find('#id_mapel'),
            'search': $('#toolbar_form').find('#search'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: false,
            "order": false,
            'search': false,
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

        var swalDaftar = {
            title: "Konfirmasi",
            text: "Yakin akan mendaftar pada ujian ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Daftar!",
        };


        var dataAvaliabeExam = {};
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
        // swal({
        //     html: '<h1>Loading ..</h1>',
        //     allowOutsideClick: false
        // })
        // swal.showLoading();
        swalLoading();
        $.when(getAvaliableSession(), getAllJurusan()).done(function(a1, a2, a3) {
            swal.close();
            // the code here will be executed when all four ajax requests resolve.
            // a1, a2, a3 and a4 are lists of length 3 containing the response text,
            // status, and jqXHR object for each of the four ajax calls respectively.
        });
        // getAvaliableSession()

        function getAvaliableSession() {
            return $.ajax({
                url: `<?php echo site_url('Pendaftar/getAvaliableSession/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataAvaliabeExam = json['data'];
                    renderAvaliabeExam(dataAvaliabeExam);
                },
                error: function(e) {}
            });
        }

        // getAllJurusan()

        function getAllJurusan() {
            return $.ajax({
                url: `<?php echo site_url('ParameterController/getAllJurusan/') ?>`,
                'type': 'get',
                data: {},
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    data = json['data'];
                    renderJurusan(data);
                },
                error: function(e) {}
            });
        }

        function renderJurusan(data) {
            DaftarModal.req_jurusan.empty();
            DaftarModal.req_jurusan_2.empty();
            DaftarModal.req_jurusan.append($('<option>', {
                value: "",
                text: "-- Pilih --"
            }));
            DaftarModal.req_jurusan_2.append($('<option>', {
                value: "",
                text: "-- Pilih --"
            }));
            Object.values(data).forEach((d) => {
                DaftarModal.req_jurusan.append($('<option>', {
                    value: d['id_jurusan'],
                    text: d['nama_jurusan'],
                }));
                DaftarModal.req_jurusan_2.append($('<option>', {
                    value: d['id_jurusan'],
                    text: d['nama_jurusan'],
                }));
            });


        }


        // getYourHistory()

        function getYourHistory() {
            return $.ajax({
                url: `<?php echo site_url('Pendaftar/getYourHistory/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataHistory = json['data'];
                    renderHistory(dataHistory);
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



        function renderAvaliabeExam(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }

            var i = 0;

            var renderData = [];
            cur_str_time = Date.parse("<?= date('Y/m/d H:i:s') ?>");
            console.log(cur_str_time);
            Object.values(data).forEach((exam) => {

                if (Date.parse(exam['open_end']) <= cur_str_time) {
                    scoreArr = exam['score_arr'].split(',');
                    var button = ''
                    var st = `<div class="alert alert-success"><i class='fa fa-pencil-square-o '></i>Selesai</div>` +
                        'Matematika : ' + scoreArr[0] +
                        '<br>Fisika : ' + scoreArr[1] +
                        '<br>Bahasa Indonesia : ' + scoreArr[2] +
                        '<br>Bahasa Inggris : ' + scoreArr[3] +
                        '<hr><b>Score : ' + exam['score'] +
                        '</b><hr><b>Hasil : </b>' + (exam['req_exam'] == 0 || exam['req_exam'] == null ? 'tidak lulus' : exam['nama_jurusan'])


                    var button = `
                        <button class="start btn btn-primary mb-1" data-token='${exam['token']}'><i class='fa fa-arrow-circle-right '></i> Lihat Score </button>
                  <br>
                        <a class="btn btn-primary" href='<?= base_url('pendaftar/pembahasan/') ?>${exam['token']}'><i class='fa fa-arrow-circle-right '></i> Pembahasan </a>
                    `;

                } else
                if (Date.parse(exam['open_start']) <= cur_str_time) {
                    if (exam['exam_lock'] == 'Y') {
                        scoreArr = exam['score_arr'].split(',');
                        var button = ''
                        var st = `<div class="alert alert-success"><i class='fa fa-pencil-square-o '></i>Selesai</div>` +
                            'Matematika : ' + scoreArr[0] +
                            '<br>Fisika : ' + scoreArr[1] +
                            '<br>Bahasa Indonesia : ' + scoreArr[2] +
                            '<br>Bahasa Inggris : ' + scoreArr[3] +
                            '<hr><b>Score : ' + exam['score'] +
                            '</b><hr><b>Hasil : </b>' + (exam['req_exam'] == 0 || exam['req_exam'] == null ? 'tidak lulus' : exam['nama_jurusan'])

                        var button = `
                        <button class="start btn btn-primary mb-1" data-token='${exam['token']}'><i class='fa fa-arrow-circle-right '></i> Lihat Score </button>
                  <br>
                        <a class="btn btn-primary" href='<?= base_url('pendaftar/pembahasan/') ?>${exam['token']}'><i class='fa fa-arrow-circle-right '></i> Pembahasan </a>
                    `;
                    } else {

                        var st = `<div class="alert alert-danger"><i class='fa fa-pencil-square-o '></i>Sedang berjalan</div>`
                        if (exam['id_session_exam_user'])
                            var button = `
                        <button class="start btn btn-primary" data-token='${exam['token']}'><i class='fa fa-arrow-circle-right '></i> Start Exam </button>
                    `;
                        else
                            var button = `
                        <button class="register btn btn-primary" data-id='${exam['id_session_exam']}'><i class='fa fa-arrow-circle-right '></i> Daftar </button>
                    `;
                    }
                } else {
                    var st = `<div class="alert alert-warning"><i class='fa fa-clock-o '></i>Belum dimulai</div>`
                    if (exam['id_session_exam_user'])
                        var button = `
                        <button class="start btn btn-primary" data-token='${exam['token']}'><i class='fa fa-arrow-circle-right '></i> Start Exam </button>
                    `;
                    else
                        var button = `
                        <button class="register btn btn-primary" data-id='${exam['id_session_exam']}'><i class='fa fa-arrow-circle-right '></i> Daftar </button>
                    `;
                } //     console.log('sudah mulai');
                console.log(Date.parse(exam['open_start']) + st + ' :: ' + exam['name_session_exam']);


                // } else {
                //     console.log('belum mulai');

                // }

                renderData.push(['From :' + exam['open_start'] + '<br> To : ' + exam['open_end'], exam['nama_mapel'] + " :: " + exam['name_session_exam'], 'Jumlah Soal : 100 soal<br> Waktu Pengerjaan : ' + exam['limit_time'] + ' menit',
                    (exam['id_session_exam_user'] ? st : 'Belum Daftar'), button
                ]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        FDataTable.on('click', '.start', function() {
            event.preventDefault();
            var token = $(this).data('token');
            swal(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }

                window.location.href = '<?= base_url() ?>pendaftar/ujian/' + token;
                // renderAvaliabeExam(dataAvaliabeExam);
            });
        });

        FDataTable.on('click', '.register', function() {
            event.preventDefault();
            var id = $(this).data('id');
            DaftarModal.self.modal('show');
            DaftarModal.id_exam.val(id);
        });

        DaftarModal.form.on('submit', (ev) => {
            ev.preventDefault();
            console.log('sub')
            swal(swalDaftar).then((result) => {
                if (!result.value) {
                    return;
                }
                swalLoading();

                $.ajax({
                    url: "<?= site_url('Pendaftar/daftarSessionExam') ?>",
                    'type': 'POST',
                    data: DaftarModal.form.serialize(),
                    success: function(data) {
                        swal.close();
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Gagal", json['message'], "error");
                            return;
                        }
                        // delete dataAvaliabeExam[id];
                        swal("Berhasil", "", "success");
                        location.reload();
                        // window.location.href = '<?= base_url() ?>my-task/' + json['data'];
                        // renderAvaliabeExam(dataAvaliabeExam);
                    },
                    error: function(e) {}
                });
            });
        })
    });
</script>