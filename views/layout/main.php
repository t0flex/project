<?php

/* @var $content \application\controllers\Controller */

use application\helpers\SessionHelper;

?>

<html>
<head>
    <title>
        Проект
    </title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="../../css/main.css" rel="stylesheet">

</head>


<body>

<nav class="site-header sticky-top py-1">
    <div class="container d-flex flex-column flex-md-row justify-content-between">
        <?php if (SessionHelper::getInstance()->user) { ?>
            <a class="py-2 d-none d-md-inline-block" href="/user/logout">Выйти</a>
        <?php } else { ?>
            <a class="py-2 d-none d-md-inline-block" href="/">Главная</a>
            <a class="py-2 d-none d-md-inline-block" href="/user/registration">Регистрация</a>
        <?php } ?>
    </div>
</nav>

<?php if (isset($success)) {

    foreach ($success as $value) {
        echo '<div class="alert alert-success">' . $value . '</div>';
    }

} ?>

<?php if (isset($errors)) {

    foreach ($errors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }

} ?>

<?= $content ?>

</body>
</html>

