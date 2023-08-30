<?php
$this->load->view('Fragment/HeaderFragment', ['title' => $title]);
?>
<style>
    .box-answer .btn {
        width: 18%;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <form role="form" id="exam_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="row">
                <div class="col-lg-3">
                    <div class="alert alert-info" role="alert">
                        <strong> Score : <?= $dataContent['score'] ?>
                            <br>Benar : <?= $dataContent['benar'] ?>
                        </strong>
                    </div>
                    <div class="ibox-content box-answer text-center nav" role="tablist">
                        <?= $btn ?>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="tab-content" id="pills-tabContent">
                        <?php
                        $i = 0;
                        foreach ($data_soal as $ds) {
                            echo '<div class="tab-pane fade" id="soal_' . $i . '" role="tabpanel" aria-labelledby="pills-home-tab"><div class="ibox-content"><strong>
                            ' . ($i + 1) . '. ' . str_replace("\r\n", '<br>', $ds['soal']['soal']) . '
                               </strong> <br><br>';
                            foreach ($ds['opsi'] as $ops) {
                                if (strval($ops['token_opsi']) == strval($ans[$i])) {
                                    $checked = 'checked';
                                } else
                                    $checked = '';

                                echo '<div class="form-check">
                                    <input class="form-check-input" disabled="disabled" type="radio" data-row="' . $i . '" name="row_' . $i . '" id="' . $ops['token_opsi'] . '" value="' . $ops['token_opsi'] . '" ' .  $checked . '>
                                    <label class="form-check-label" for="exampleRadios1">
                                    ' . $ops['name_opsi'] . '
                                    </label>
                                    </div>
                                    ';
                            }
                            echo '<br><br>
                            Jawaban : ' . $ds['soal']['name_opsi'] . '
                            <br>Pembahasan : <br>' . $ds['soal']['pembahasan'] . ' 
                            </div></div>';
                            $i++;
                        }
                        ?>
                        <!-- <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Selesai</strong></button> -->

                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {});
</script>
<?php $this->load->view('Fragment/FooterFragment');
