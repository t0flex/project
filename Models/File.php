<?php

namespace Models;

use application\models\Model;
use application\helpers\DirectoryHelper;
use SplFileInfo;

class File extends Model
{
    public const FOLDER_NAME = 'web' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;

    protected static function getTableName(): string
    {
        return 'files';
    }

    /**
     * @param $file
     * @return array|bool
     */
    public function saveFile(array $file)
    {
        $folder = DirectoryHelper::getRootDirectory() . self::FOLDER_NAME;

        $this->makeDir($folder);

        $uploadedFile = self::getRandomFileName($folder, $this->getExtension($file['name']));

        if (is_uploaded_file($file['tmp_name'])) {
            if (move_uploaded_file($file['tmp_name'], $folder . $uploadedFile)) {
                $result['name'] = $uploadedFile;
            } else {
                $result['errors'] = "Во время загрузки файла произошла ошибка";
            }
        } else {
            $result['errors'] = "Файл не  загружен";
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
    public function getExtension($fileName)
    {
        $extension = new SplFileInfo($fileName);
        return $extension->getExtension();
    }

    private function makeDir($path)
    {
        return is_dir($path) || mkdir($path);
    }
}