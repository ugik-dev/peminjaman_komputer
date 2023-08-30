<?php
$resScrore = explode(',', $contentData['score_arr']);
// echo json_encode($contentData);
?>
<div class="container">

    <div class="wrapperwrapper-content animated fadeInRight">
        <div class="ibox section-container">
            <div class="ibox-content">
                <div class="col-lg-12">
                    <h2>Matematika : <?= $resScrore[0] ?></h2>
                    <h2>Fisika : <?= $resScrore[1] ?></h2>
                    <h2>Bahasa Indonesia : <?= $resScrore[2] ?></h2>
                    <h2>Bahasa Inggris : <?= $resScrore[3] ?></h2>
                    <hr>
                    <h1>Akumulasi Score : <?= $contentData['score'] ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>