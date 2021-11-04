<?php

namespace Models;

use application\helpers\DirectoryHelper;
use SplFileInfo;

/**
 * Class FileUpload
 * @package Models
 */
class FileUpload
{

    /**
     * @param $files
     * @return array|bool
     */
    public function uploadFiles($files)
    {
        $extension = $this->checkExtension($files);
        if ($extension === true) {
            return $this->saveFiles($files);
        }
        return false;
    }

    /**
     * @param $files
     * @return bool
     */
    private function checkExtension($files)
    {
        $result = true;
        foreach ($files['name'] as $file) {
            if (!preg_match("/\.(gif|png|jpg)$/", $this->getExtension($file))) {
                $result['error'][] = $file;
            }
        }
        return $result;
    }

    /**
     * @param $files
     * @return array|bool
     */
    private function saveFiles($files)
    {
        $result = [];
        $total = count($files['name']);
        $folder = DirectoryHelper::getRootDirectory() . 'web/images/';

        for ($i = 0; $i < $total; $i++) {
            $uploadedFile = self::getRandomFileName($folder, $this->getExtension($files['name'][$i]));

            if (is_uploaded_file($files['tmp_name'][$i])) {
                if (move_uploaded_file($files['tmp_name'][$i], $folder . $uploadedFile)) {
                    $result[] = $uploadedFile;
                } else {
                    $result['errors'] = "Во время загрузки файла произошла ошибка";
                }
            } else {
                $result['errors'] = "Файл не  загружен";
            }
        }

        return $result;
    }

    /**
     * @param $path
     * @param string $extension
     * @return string
     */
    public static function getRandomFileName($path, $extension = '')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . rand(0, 9999)) . $extension;
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return $name;
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getExtension($fileName)
    {
        $extension = new SplFileInfo($fileName);
        return $extension->getExtension();
    }

}