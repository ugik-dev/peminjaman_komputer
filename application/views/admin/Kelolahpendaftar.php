<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox ssection-container">
    <div class="ibox-content">
      <form class="form-inline" id="toolbar_form" onsubmit="return false;">
        <input type="hidden" placeholder="" class="form-control" id="id_role" name="id_role" value="3">
        <input type="text" placeholder="Nama / NIK" class="form-control my-1 mr-sm-2" id="search" name="search">
        <select class="form-control my-1 mr-sm-2" id="status_data" name="status_data">
          <option value="">-- Semua Status --</option>
          <option value="0">Belum input data</option>
          <option value="1">Menunggu verifikasi</option>
          <option value="3">Ditolak</option>
          <option value="2">Diterima</option>
        </select>
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

                  <th style="width: 15%; text-align:center!important">Username</th>
                  <th style="width: 12%; text-align:center!important">Nama</th>
                  <th style="width: 12%; text-align:center!important">Masuk</th>
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


<div class="modal inmodal" id="user_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated fadeIn">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Kelola User</h4>
        <span class="info"></span>
      </div>
      <div class="modal-body" id="modal-body">
        <form role="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
          <input type="hidden" placeholder="" class="form-control" id="id_role" name="id_role" value="3">
          <input type="hidden" id="id_user" name="id_user">
          <div class="form-group">
            <label for="nama">Nomor Induk</label>
            <input type="text" placeholder="Nomor Induk" class="form-control" id="username" name="username" required="required">
          </div>
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" placeholder="" class="form-control" id="nama" name="nama" required="required">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" placeholder="" class="form-control" id="password" name="password" required="required">
          </div>
          <div class="form-group">
            <label for="repassword">Re-Password</label>
            <input type="password" placeholder="" class="form-control" id="repassword" name="repassword" required="required">
          </div>
          <div class="form-group">
            <label for="tahun_masuk">Tahun Masuk</label>
            <input type="number" placeholder="" min="2014" max="2030" class="form-control" id="tahun_masuk" name="tahun_masuk" required="required">
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


<div class="modal inmodal" id="reset_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated fadeIn">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Reset Password User</h4>
        <span class="info"></span>
      </div>
      <div class="modal-body" id="modal-body">
        <form role="form" id="reset_form" onsubmit="return false;" type="multipart" autocomplete="off">
          <input type="hidden" id="id_user" name="id_user">

          <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" placeholder="" class="form-control" id="password" name="password" required="required">
          </div>
          <div class="form-group">
            <label for="repassword">Re-Password Baru</label>
            <input type="password" placeholder="" class="form-control" id="repassword" name="repassword" required="required">
          </div>

          <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..." onclick="this.form.target='edit'"><strong>Reset Password</strong></button>
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

    $('#kelolahsiswa').addClass('active');


    var toolbar = {
      'form': $('#toolbar_form'),
      'showBtn': $('#show_btn'),
      'addBtn': $('#show_btn'),
      'id_role': $('#id_role'),
    }

    var FDataTable = $('#FDataTable').DataTable({
      'columnDefs': [],
      deferRender: true,
      "order": [
        [0, "desc"]
      ]
    });

    var ResetModal = {
      'self': $('#reset_modal'),
      'info': $('#reset_modal').find('.info'),
      'form': $('#reset_modal').find('#reset_form'),
      'addBtn': $('#reset_modal').find('#add_btn'),
      'saveEditBtn': $('#reset_modal').find('#save_edit_btn'),
      'id_user': $('#reset_modal').find('#id_user'),
      'password': $('#reset_modal').find('#password'),
      'repassword': $('#reset_modal').find('#repassword'),
    }
    var KelolahuserModal = {
      'self': $('#user_modal'),
      'info': $('#user_modal').find('.info'),
      'form': $('#user_modal').find('#user_form'),
      'addBtn': $('#user_modal').find('#add_btn'),
      'saveEditBtn': $('#user_modal').find('#save_edit_btn'),
      'id_user': $('#user_modal').find('#id_user'),
      'nama': $('#user_modal').find('#nama'),
      'username': $('#user_modal').find('#username'),
      'id_role': $('#user_modal').find('#id_role'),
      'password': $('#user_modal').find('#password'),
      'repassword': $('#user_modal').find('#repassword'),
      'tahun_masuk': $('#user_modal').find('#tahun_masuk'),
      'deskripsi': $('#user_modal').find('#deskripsi'),
      'kabupaten': $('#user_modal').find('#kabupaten'),
    }
    KelolahuserModal.password.on('change', () => {
      confirmPasswordRule(KelolahuserModal.password, KelolahuserModal.repassword);
    });

    KelolahuserModal.repassword.on('keyup', () => {
      confirmPasswordRule(KelolahuserModal.password, KelolahuserModal.repassword);
    });

    function confirmPasswordRule(password, rePassword) {
      if (password.val() != rePassword.val()) {
        rePassword[0].setCustomValidity('Password tidak sama');
      } else {
        rePassword[0].setCustomValidity('');
      }
    }

    ResetModal.password.on('change', () => {
      confirmPasswordRule(ResetModal.password, ResetModal.repassword);
    });

    ResetModal.repassword.on('keyup', () => {
      confirmPasswordRule(ResetModal.password, ResetModal.repassword);
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

    var dataKelolahuser = {}
    var dataRole = {};

    toolbar.form.submit(function(event) {
      event.preventDefault();
      switch (toolbar.form[0].target) {
        case 'show':
          getKelolahuser();
          break;
        case 'add':
          showKelolahuserModal();
          break;
      }
    });

    getKelolahuser();

    function getKelolahuser() {
      return $.ajax({
        url: `<?php echo site_url('KelolahuserController/getAllKelolahUserPendaftaran/') ?>`,
        'type': 'POST',
        data: toolbar.form.serialize(),
        success: function(data) {
          var json = JSON.parse(data);
          if (json['error']) {
            return;
          }
          dataKelolahuser = json['data'];
          renderKelolahuser(dataKelolahuser);
        },
        error: function(e) {}
      });
    }



    function renderKelolahuser(data) {
      if (data == null || typeof data != "object") {
        console.log("User::UNKNOWN DATA");
        return;
      }

      var i = 0;

      var renderData = [];
      Object.values(data).forEach((user) => {
        var detailButton = `
      <a class="detail dropdown-item" href='<?= site_url() ?>AdminController/DetailPendaftar/${user['id_user']}'><i class='fa fa-share'></i> Detail</a>
      `;
        var editButton = `
        <a class="edit dropdown-item" data-id='${user['id_user']}'><i class='fa fa-pencil'></i> Edit User</a>
      `;
        var resetButton = `
        <a class="resetpassword dropdown-item" data-id='${user['id_user']}'><i class='fa fa-pencil'></i>Reset Password</a>
      `;
        var deleteButton = `
        <a class="delete dropdown-item" data-id='${user['id_user']}'><i class='fa fa-trash'></i> Hapus User</a>
      `;
        var button = `
        <div class="btn-group" role="group">
          <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-bars'></i></button>
          <div class="dropdown-menu" aria-labelledby="action">
          ${detailButton}
          ${resetButton}
          ${deleteButton}
           </div>
        </div>
      `;
        renderData.push([user['username'], user['nama'], statusData(user['status_data']), button]);
      });
      FDataTable.clear().rows.add(renderData).draw('full-hold');
    }

    FDataTable.on('click', '.resetpassword', function() {
      console.log('reset');
      var id = $(this).data('id');
      var user = dataKelolahuser[id];
      ResetModal.form.trigger('reset');
      ResetModal.self.modal('show');
      ResetModal.addBtn.hide();
      ResetModal.saveEditBtn.show();
      var id = $(this).data('id');
      var user = dataKelolahuser[id];
      ResetModal.id_user.val(user['id_user']);
    });

    FDataTable.on('click', '.edit', function() {
      event.preventDefault();
      KelolahuserModal.form.trigger('reset');
      KelolahuserModal.self.modal('show');
      KelolahuserModal.addBtn.hide();
      KelolahuserModal.saveEditBtn.show();
      var id = $(this).data('id');
      var user = dataKelolahuser[id];
      console.log(user)
      KelolahuserModal.password.prop('disabled', true);
      KelolahuserModal.repassword.prop('disabled', true);
      KelolahuserModal.id_user.val(user['id_user']);
      KelolahuserModal.nama.val(user['nama']);
      KelolahuserModal.username.val(user['username']);
      KelolahuserModal.tahun_masuk.val(user['tahun_masuk']);

    });

    FDataTable.on('click', '.delete', function() {
      event.preventDefault();
      var id = $(this).data('id');
      swal(swalDeleteConfigure).then((result) => {
        if (!result.value) {
          return;
        }
        $.ajax({
          url: "<?= site_url('KelolahuserController/deleteKelolahuser') ?>",
          'type': 'POST',
          data: {
            'id_user': id
          },
          success: function(data) {
            var json = JSON.parse(data);
            if (json['error']) {
              swal("Delete Gagal", json['message'], "error");
              return;
            }
            delete dataKelolahuser[id];
            swal("Delete Berhasil", "", "success");
            renderKelolahuser(dataKelolahuser);
          },
          error: function(e) {}
        });
      });
    });

    function showKelolahuserModal() {
      KelolahuserModal.self.modal('show');
      KelolahuserModal.addBtn.show();
      KelolahuserModal.saveEditBtn.hide();
      KelolahuserModal.form.trigger('reset');
      KelolahuserModal.password.prop('disabled', false);
      KelolahuserModal.repassword.prop('disabled', false);
    }

    ResetModal.form.submit(function(event) {
      event.preventDefault();
      switch (ResetModal.form[0].target) {
        case 'edit':
          editPassword();
          break;
      }
    });

    KelolahuserModal.form.submit(function(event) {
      event.preventDefault();
      switch (KelolahuserModal.form[0].target) {
        case 'add':
          addKelolahuser();
          break;
        case 'edit':
          editKelolahuser();
          break;
      }
    });

    function addKelolahuser() {
      swal(swalSaveConfigure).then((result) => {
        if (!result.value) {
          return;
        }
        buttonLoading(KelolahuserModal.addBtn);
        $.ajax({
          url: `<?= site_url('KelolahuserController/addUser') ?>`,
          'type': 'POST',
          data: KelolahuserModal.form.serialize(),
          success: function(data) {
            buttonIdle(KelolahuserModal.addBtn);
            var json = JSON.parse(data);
            if (json['error']) {
              swal("Simpan Gagal", json['message'], "error");
              return;
            }
            var user = json['data']
            dataKelolahuser[user['id_user']] = user;
            swal("Simpan Berhasil", "", "success");
            renderKelolahuser(dataKelolahuser);
            KelolahuserModal.self.modal('hide');
          },
          error: function(e) {}
        });
      });
    }

    function editKelolahuser() {
      swal(swalSaveConfigure).then((result) => {
        if (!result.value) {
          return;
        }
        buttonLoading(KelolahuserModal.saveEditBtn);
        $.ajax({
          url: `<?= site_url('KelolahuserController/editKelolahuser') ?>`,
          'type': 'POST',
          data: KelolahuserModal.form.serialize(),
          success: function(data) {
            buttonIdle(KelolahuserModal.saveEditBtn);
            var json = JSON.parse(data);
            if (json['error']) {
              swal("Simpan Gagal", json['message'], "error");
              return;
            }
            var user = json['data']
            dataKelolahuser[user['id_user']] = user;
            swal("Simpan Berhasil", "", "success");
            renderKelolahuser(dataKelolahuser);
            KelolahuserModal.self.modal('hide');
          },
          error: function(e) {}
        });
      });
    }

    function editPassword() {
      swal(swalSaveConfigure).then((result) => {
        if (!result.value) {
          return;
        }
        buttonLoading(ResetModal.saveEditBtn);
        $.ajax({
          url: `<?= site_url('KelolahuserController/editPassword') ?>`,
          'type': 'POST',
          data: ResetModal.form.serialize(),
          success: function(data) {
            buttonIdle(ResetModal.saveEditBtn);
            var json = JSON.parse(data);
            if (json['error']) {
              swal("Simpan Gagal", json['message'], "error");
              return;
            }
            var user = json['data']
            dataKelolahuser[user['id_user']] = user;
            swal("Simpan Berhasil", "", "success");
            renderKelolahuser(dataKelolahuser);
            ResetModal.self.modal('hide');
          },
          error: function(e) {}
        });
      });
    }
  });
</script>