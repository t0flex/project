<?php

namespace Models;

use application\models\Model;

/**
 * Class User
 * @package Models
 *
 * @property string $email
 * @property string $password
 */
class User extends Model
{
    protected static function getTableName(): string
    {
        return 'users';
    }
}