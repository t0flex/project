<?php

namespace application\helpers;

class DirectoryHelper
{
    public static function getRootDirectory()
    {
        return dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
    }
}