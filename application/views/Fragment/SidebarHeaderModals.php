<div class="modal inmodal" id="profile_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated fadeIn">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Edit Profile</h4>
        <span class="infox"></span>
      </div>
      <div class="modal-body" id="modal-body">
        <form role="form" id="profile_form" onsubmit="return false;" type="multipart" autocomplete="off">
          <input type="hidden" id="id_userx" name="id_user">
          <!-- <div class="form-group">
            <label for="usernamex">Username</label> 
            <input type="text" placeholder="Username" class="form-control" id="usernamex" name="username" required="required">
          </div> -->
          <div class="form-group">
            <label for="namax">Nama</label>
            <input type="text" placeholder="Nama" class="form-control" id="namax" name="nama" required="required">
          </div>
          <div class="form-group">
            <label for="passwordx">Password</label>
            <input type="password" placeholder="Password" class="form-control" id="passwordx" name="password">
          </div>
          <div class="form-group">
            <label for="repasswordx">Konfirmasi Password</label>
            <input type="password" placeholder="Konfirmasi Password" class="form-control" id="repasswordx" name="repassword">
          </div>
          <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btnx" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal inmodal" id="editpassword_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated fadeIn">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Ganti Password</h4>
        <span class="infox"></span>
      </div>
      <div class="modal-body" id="modal-body">
        <form role="form" id="ganti_pass_form" onsubmit="return false;" type="multipart" autocomplete="off">
          <input type="hidden" id="id_userz" name="id_user">
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" placeholder="Password" class="form-control" id="password_now" name="old_password">
          </div>
          <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" placeholder="Password" class="form-control" id="password_new" name="password">
          </div>
          <div class="form-group">
            <label for="repasswordx">Konfirmasi Password Baru</label>
            <input type="password" placeholder="Konfirmasi Password" class="form-control" id="repassword_new" name="repassword">
          </div>
          <button class="btn btn-success my-1 mr-sm-2" type="submit" id="ganti_password_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal inmodal" id="photo_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated fadeIn">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Ganti Photo</h4>
        <span class="infoy"></span>
      </div>
      <div class="modal-body" id="modal-body">

        <form role="form" id="photo_form" onsubmit="return false;" type="multipart" autocomplete="off">
          <input type="" id="id_usery" name="id_user" hidden>
          <input type="" id="photoy" name="oldphoto" hidden>
          <div class="form-group  text-center">
            <img class="form-group  text-center" id='imgphotoy' src="" style='height: 200px;'>
          </div>
          <div class="form-group">
            <label for="usernamex"></label>
            <input type="file" placeholder="" class="form-control" name="photo" required="required">
          </div>
          <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btny" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
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

    var passwordButton = $('#password_btn');
    var photoButton = $('#photo_btn');
    var profileButton = $('#profile_btn');
    // ============= TO PROFIL
    var ProfileModal = {
      'self': $('#profile_modal'),
      'info': $('#profile_modal').find('.infox'),
      'form': $('#profile_modal').find('#profile_form'),
      'saveEditBtn': $('#profile_modal').find('#save_edit_btnx'),
      'idUser': $('#profile_modal').find('#id_userx'),
      'username': $('#profile_modal').find('#usernamex'),
      'nama': $('#profile_modal').find('#namax'),
      'password': $('#profile_modal').find('#passwordx'),
      'repassword': $('#profile_modal').find('#repasswordx'),
    }

    var ChangePasswordModal = {
      'self': $('#editpassword_modal'),
      'info': $('#editpassword_modal').find('.infox'),
      'form': $('#editpassword_modal').find('#ganti_pass_form'),
      'saveEditBtn': $('#editpassword_modal').find('#ganti_password_btn'),
      'idUser': $('#editpassword_modal').find('#id_userz'),
      'repassword_now': $('#editpassword_modal').find('#password_now'),
      'password_new': $('#editpassword_modal').find('#password_new'),
      'repassword_new': $('#editpassword_modal').find('#repassword_new'),
    }


    var swalSaveConfigure = {
      title: "Konfirmasi simpan",
      text: "Yakin akan menyimpan data ini?",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#18a689",
      confirmButtonText: "Ya, Simpan!",
    };

    var user = JSON.parse(`<?= json_encode(DataStructure::slice($this->session->userdata(), ['id_user', 'username', 'nama', 'title_role', 'nama_kabupaten', 'photo'])) ?>`);
    var profile = {
      'username': $('#header_username'),
      'nama': $('#header_nama'),
      'title': $('#header_title'),
    }

    renderProfile(user);

    function renderProfile(user) {
      profile.username.html('<?= $this->session->userdata('username') ?>');
      profile.nama.html('<?= $this->session->userdata('nama') ?>');
      var title = user['title_role'];
      profile.title.html(title);
    }

    profileButton.on('click', () => {
      ProfileModal.form.trigger('reset');
      ProfileModal.self.modal('show');
      ProfileModal.self.modal('show');
      ProfileModal.password.prop('placeholder', '(Unchanged)')
      ProfileModal.password.prop('required', false);
      ProfileModal.repassword.prop('placeholder', '(Unchanged)')

      var currentData = user;
      ProfileModal.idUser.val(currentData['id_user']);
      ProfileModal.username.val(currentData['username']);
      ProfileModal.nama.val(currentData['nama']);
    });


    ProfileModal.password.on('change', () => {
      confirmPasswordRule(ProfileModal.password, ProfileModal.repassword);
    });

    ProfileModal.repassword.on('keyup', () => {
      confirmPasswordRule(ProfileModal.password, ProfileModal.repassword);
    });
    ChangePasswordModal.password_new.on('change', () => {
      confirmPasswordRule(ChangePasswordModal.password_new, ChangePasswordModal.repassword_new);
    });

    ChangePasswordModal.repassword_new.on('keyup', () => {
      confirmPasswordRule(ChangePasswordModal.password_new, ChangePasswordModal.repassword_new);
    });

    function confirmPasswordRule(password, rePassword) {
      if (password.val() != rePassword.val()) {
        rePassword[0].setCustomValidity('Password tidak sama');
      } else {
        rePassword[0].setCustomValidity('');
      }
    }

    ProfileModal.form.submit(function(event) {
      event.preventDefault();
      swal(swalSaveConfigure).then((result) => {
        if (!result.value) {
          return;
        }
        buttonLoading(ProfileModal.saveEditBtn);
        $.ajax({
          url: "<?= site_url('UserController/editUser') ?>",
          'type': 'POST',
          data: ProfileModal.form.serialize(),
          success: function(data) {
            buttonIdle(ProfileModal.saveEditBtn);


            swal("Simpan Berhasil", "", "success").then((result) => {
              document.location.reload();
            })

          },
          error: function(e) {}
        });
      });
    });

    ChangePasswordModal.form.submit(function(event) {
      event.preventDefault();
      swal(swalSaveConfigure).then((result) => {
        if (!result.value) {
          return;
        }
        buttonLoading(ChangePasswordModal.saveEditBtn);
        $.ajax({
          url: "<?= site_url('UserController/changePassword') ?>",
          'type': 'POST',
          data: ChangePasswordModal.form.serialize(),
          success: function(data) {
            buttonIdle(ChangePasswordModal.saveEditBtn);
            var json = JSON.parse(data);
            if (json['error']) {
              swal("Gagal Ganti Password", json['message'], "error");
              return;
            }
            swal("Berhasil Ganti Password", "", "success").then((result) => {
              document.location.reload();
            })

          },
          error: function(e) {}
        });
      });
    });
    // ============= TO Photo
    var PhotoModal = {
      'self': $('#photo_modal'),
      'info': $('#photo_modal').find('.infoy'),
      'form': $('#photo_modal').find('#photo_form'),
      'saveEditBtn': $('#photo_modal').find('#save_edit_btny'),
      'id_user': $('#photo_modal').find('#id_usery'),
      'imgphoto': $('#photo_modal').find('#imgphotoy'),
      'photo': $('#photo_modal').find('#photoy'),
      'username': $('#photo_modal').find('#usernamey'),

    }

    var swalSaveConfigure = {
      title: "Konfirmasi simpan",
      text: "Yakin akan menyimpan data ini?",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#18a689",
      confirmButtonText: "Ya, Simpan!",
    };

    var photo = {
      'photo': $('#header_username'),
    }

    // renderPhoto(user);
    // function renderPhoto(user){
    //   photo.username.html(user['username']);
    //   photo.nama.html(user['nama']);
    //   var title = user['title_role'] + (user['nama_kabupaten'] ? ' - ' + user['nama_kabupaten'] : '')
    //   photo.title.html(title);
    // }
    passwordButton.on('click', () => {

      ChangePasswordModal.form.trigger('reset');
      ChangePasswordModal.self.modal('show');
      ChangePasswordModal.self.modal('show');
      var currentData = user;
      ChangePasswordModal.idUser.val(currentData['id_user']);

    });

    photoButton.on('click', () => {

      PhotoModal.form.trigger('reset');
      PhotoModal.self.modal('show');
      PhotoModal.self.modal('show');

      var currentData = user;

      PhotoModal.id_user.val(currentData['id_user']);
      PhotoModal.photo.val(currentData['photo']);
      PhotoModal.imgphoto.prop('src', `<?= base_url('upload/profile/') ?>` + currentData['photo']);
      PhotoModal.username.val(currentData['username']);
    });



    PhotoModal.form.submit(function(event) {
      event.preventDefault();
      swal(swalSaveConfigure).then((result) => {
        if (!result.value) {
          return;
        }
        buttonLoading(PhotoModal.saveEditBtn);
        $.ajax({
          url: "<?= site_url('UserController/editPhoto') ?>",
          'type': 'POST',
          data: new FormData(this),
          processData: false,
          contentType: false,
          cache: false,
          async: false,
          success: function(data) {
            buttonIdle(PhotoModal.saveEditBtn);


            swal("Simpan Berhasil", "", "success").then((result) => {
              document.location.reload();
            })

          },
          error: function(e) {}
        });
      });
    });
  });
</script>