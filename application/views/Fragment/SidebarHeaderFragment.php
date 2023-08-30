<li class="nav-header">
  <div class="dropdown profile-element">
    <?php
    if (empty($this->session->userdata('photo'))) {
      $img = base_url('upload/profile_small.jpg');
    }else{
      $img = base_url('upload/profile/') . $this->session->userdata('photo');
    }  ?>
    <img alt="image" class="rounded-circle" style="width:48px; height:48px;" src="<?= $img ?>" />
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
      <span class="block m-t-xs font-bold"><span id="header_nama"></span> (<span id="header_username"></span>) </span>

      <span class="text-muted text-xs block">
        <span id="header_title"></span>
        <b class="caret"></b>
      </span>
    </a>
    <ul class="dropdown-menu animated fadeInRight m-t-xs">
      <li><a id="profile_btn" class="dropdown-item">Edit Profile</a></li>
      <li><a id="password_btn" class="dropdown-item">Ganti Password</a></li>
      <li><a id="photo_btn" class="dropdown-item">Ganti Photo</a></li>
      <!-- <li><a class="dropdown-item" href="<?= site_url('UserController/logout/') ?>">Logout</a></li> -->
      <!-- <li><a id="pesan_btn" class="dropdown-item" href="<?= site_url('AdminController/Message/') ?>">Pesan</a></li>
         <li><a id="pesan_btn" class="dropdown-item" href="<?= site_url('PimpinanController/Message/') ?>">Pesan</a></li>
       
         <li><a id="pesan_btn" class="dropdown-item" href="<?= site_url('OperatorController/Message/') ?>">Pesan</a></li> -->


    </ul>
  </div>
  <div class="logo-element">
    SS
  </div>
</li>
<script>
  $(document).ready(function() {
    // getNotRead();
    function getNotRead() {
      return $.ajax({
        url: `<?php echo site_url('MessageController/getNotRead/') ?>`,
        'type': 'GET',
        data: {},
        success: function(data) {
          var json = JSON.parse(data);
          notread = json['data'];
          // notread['notread'] = '0';
          if (notread['notread'] != '0') {
            pesan_btn = document.getElementById("pesan_btn");
            headermessage = document.getElementById("statusmessage");
            pesan_btn.innerHTML = `Pesan<span class="label label-info" id="not_read">${notread['notread']}</span>`;
            headermessage.innerHTML = `<span class="label label-info" id="headermessage">notifikasi!</span>`;
          } else {

          }
        },
        error: function(e) {}
      });
    }

  });
</script>