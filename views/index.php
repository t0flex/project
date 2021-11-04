<?php

/* @var $files \Models\File */

use application\helpers\SessionHelper;

if (SessionHelper::getInstance()->user) { ?>

    <form action="/file/upload" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlFile1">Загрузить файл</label>
            <input type="hidden" name="isFile" value="1">
            <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
            <button class="btn btn-lg btn-success btn-block" type="submit">Загрузить</button>
        </div>
    </form>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-7 p-lg-5 mx-auto my-5">
            Ваши файлы:

            <div class="row">
            <?php if(!empty($files)){
                foreach ($files as $key => $file){?>
                <div class="col-md-12 row">
                <div class="col-md-1"><?= $key + 1?>.</div>
                <div class="col-md-6"><?= $file['default_name']?></div>
                <div class="col-md-2"><?= $file['label']?></div>
                <div class="col-md-1 hover">
                <form method="post" action="/file/download">
                     <input type="hidden" name="id" value="<?= $file['filesId']?>">
                     <button type="submit" class="button_download"></button>
                </form>
                </div>
                <div class="col-md-1 hover">
                <form method="post" action="/file/delete">
                    <input type="hidden" name="id" value="<?= $file['filesId']?>">
                    <button type="submit" class="button_delete"></button>
                </form>
                </div>
                </div>
                <?php }
            } ?>
            </div>

    </div>
<?php
} else {
    ?>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Экзаменационный проект</h1>
            <p class="lead font-weight-normal">Облачное хранилище для файлов пользователей</p>
            <a class="btn btn-outline-secondary" href="/user/login">Войти</a>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

<?php } ?>