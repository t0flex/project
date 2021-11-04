<?php

namespace Controllers;

use application\controllers\Controller;
use application\helpers\SessionHelper;
use Models\File;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $session = SessionHelper::getInstance();

        $files = [];
        if ($session->user) {
            $files = File::withLeftJoin('categories', 'category_id', 'user_id', '=', $session->user->id);
        }

        return $this->render('index', ['files' => $files]);
    }
}