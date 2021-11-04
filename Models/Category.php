<?php

namespace Models;

use application\models\Model;

class Category extends Model
{
    public const DOCS = 'docx';
    public const PICTURES = 'pictures';
    public const OTHER = 'another';

    protected static function getTableName(): string
    {
        return 'categories';
    }

    public static function getCategory(string $extension)
    {
        switch ($extension) {
            case in_array($extension, ['png', 'jpg', 'jpeg']) :
                return self::whereFirst('value', '=', self::PICTURES);
                break;
            case in_array($extension, ['doc', 'docx', 'pdf']) :
                $category = self::whereFirst('value', '=', self::DOCS);
                break;
            default :
                $category = self::whereFirst('value', '=', self::OTHER);
                break;
        }

        return $category;
    }
}