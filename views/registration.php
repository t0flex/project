<link href="../../css/signin.css" rel="stylesheet">


<form class="form-signin" method="POST" enctype="multipart/form-data">
    <img class="mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
    <label for="inputEmail" class="sr-only">Ваше имя</label>
    <input type="text" id="inputName" name="name" class="form-control" placeholder="Имя" required autofocus>
    <label for="inputName" class="sr-only">Email</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Пароль" required>
    <label for="inputPasswordReset" class="sr-only">Повторите пароль</label>
    <input type="password" id="inputPasswordReset" name="passwordConfirm" class="form-control"
           placeholder="Повторите пароль" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
</form>
