<?php

namespace Controllers;

use application\controllers\Controller;
use application\helpers\SessionHelper;
use Models\User;

class UserController extends Controller
{
    public function actionLogin()
    {
        $session = SessionHelper::getInstance();

        if ($session->user) {
            return $this->redirect();
        }

        if ($this->request->post) {
            $user = $this->getUser();

            if (!$user) {
                return $this->render('login', ['errors' => ['Такого пользователя нет']]);
            }

            if (password_verify($this->request->post->password, $user->password)) {

                $session->user = $user;

                return $this->redirect();
            } else {
                return $this->render('login', ['errors' => ['Неверные данные']]);
            }
        }

        return $this->render('login');
    }

    public function actionRegistration()
    {
        $session = SessionHelper::getInstance();

        if ($session->user) {
            return $this->redirect();
        }

        if ($this->request->post) {
            if ($this->request->post->password !== $this->request->post->passwordConfirm) {
                return $this->render('registration', ['errors' => ['Пароли не совпадают!']]);
            }

            $user = $this->getUser();
            if ($user) {
                return $this->render('registration', ['errors' => ['Такой пользователь уже есть']]);
            }

            $newUser = new User();
            $newUser->name = $this->request->post->name;
            $newUser->email = $this->request->post->email;
            $newUser->password = password_hash($this->request->post->password, PASSWORD_DEFAULT);
            $newUser->save();

            $session->user = $this->getUser();

            return $this->redirect();
        }

        return $this->render('registration');
    }

    public function actionLogout()
    {
        $session = SessionHelper::getInstance();

        if ($session->user) {
            $session->destroy();
        }

        return $this->redirect();
    }

    private function getUser()
    {
        return User::whereFirst('email', '=', $this->request->post->email);
    }
}