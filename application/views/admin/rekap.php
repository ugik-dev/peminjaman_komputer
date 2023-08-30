<div class="row">
  <div class="col-lg-12">
    <div class="ibox">
      <div class="ibox-content">
        <div class="table-responsive">
          <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
            <thead>
              <tr>
                <th style="width: 7%; text-align:center!important">NIK</th>
                <th style="width: 15%; text-align:center!important">Nama</th>
                <th style="width: 12%; text-align:center!important">Waktu</th>
                <th style="width: 5%; text-align:center!important">Total Nilai</th>
                <th style="width: 5%; text-align:center!important">Mtk</th>
                <th style="width: 5%; text-align:center!important">Fis</th>
                <th style="width: 5%; text-align:center!important">B Ind</th>
                <th style="width: 5%; text-align:center!important">B Ing</th>
                <th style="width: 10%; text-align:center!important">Minat</th>
                <th style="width: 10%; text-align:center!important">Hasil</th>
                <th style="width: 10%; text-align:center!important">Chatbot</th>
                <th style="width: 10%; text-align:center!important">Btn</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    var data = JSON.parse(`<?= json_encode($dataContent['child']) ?>`);
    console.log(data)
    var FDataTable = $('#FDataTable').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    render()

    function render() {
      if (data == null || typeof data != "object") {
        console.log("User::UNKNOWN DATA");
        return;
      }


      var i = 0;
      var renderData = [];
      Object.values(data).forEach((d) => {
        var corsscek = `
        <a class="btn btn-secondary" href='<?= base_url('AdminController/preview/') ?>${d['token']}'><i class='fa fa-eye'></i> </a>
      `;

        var button = `
        <div class="btn-group" role="group">
          <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-bars'></i></button>
          <div class="dropdown-menu" aria-labelledby="action">
          ${corsscek}
       
          </div>
        </div>
      `;
        n = d['score_arr'].split(',');
        btn = ``;
        renderData.push([d['username'], d['nama'], d['start_time'], d['score'], n[0] ? n[0] : '', n[1] ? n[1] : '', n[2] ? n[2] : '', n[3] ? n[3] : '', '1. ' + d['req_name'] + (d['req_name_2'] ? ('<br>2.' + d['req_name_2']) : ''),
          n[0] ? (d['req_name_exam'] ? d['req_name_exam'] : 'TIDAK LULUS') : 'BELUM UJIAN', d['req_c'] ? d['req_c'] : '', n[0] ? corsscek : ''
        ]);
      });
      FDataTable.clear().rows.add(renderData).draw('full-hold');
    }
  })
</script>