<?php

namespace Controllers;

use application\controllers\Controller;
use application\helpers\SessionHelper;
use Models\Category;
use Models\File;
use application\helpers\DirectoryHelper;

class FileController extends Controller
{

    public function actionUpload()
    {
        $session = SessionHelper::getInstance();

        if ($session->user) {
            if ($this->request->post->isFile) {
                $model = new File();
                $model->user_id = $session->user->id;
                $model->default_name = $_FILES['file']['name'];

                $category = Category::getCategory($model->getExtension($_FILES['file']['name']));

                $model->category_id = $category->id;

                $savedFile = $model->saveFile($_FILES['file']);

                if (isset($savedFile['error'])) {
                    return $this->render('index', $savedFile);
                } else {
                    $model->name = $savedFile['name'];
                    $model->save();
                }
            }
            return $this->redirect();
        } else {
            return $this->redirect();
        }
    }

    public function actionDownload()
    {
        if ($this->request->post->id) {
            $file = File::find($this->request->post->id);

            header('Content-Disposition: attachment; filename=".' . basename($file->defaultName) . '."');

            readfile(DirectoryHelper::getRootDirectory() . File::FOLDER_NAME . $file->name);
        }

        return $this->redirect();
    }

    public function actionDelete()
    {
        if ($this->request->post->id) {
            $file = File::find($this->request->post->id);
            $file->delete();

            $session = SessionHelper::getInstance();
            $session->success = ["Файл {$file->default_name} успешно удален!"];

            @unlink(DirectoryHelper::getRootDirectory() . File::FOLDER_NAME . $file->name);

            return $this->redirect();
        }

        return $this->redirect();
    }
}