<?php

namespace application\models;

use application\database\Database;

abstract class Model
{
    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    public static function findAll()
    {
        return Database::execute('SELECT * FROM `' . static::getTableName() . '`;')
            ->fetchAll();
    }

    public static function find($id)
    {
        return Database::execute('SELECT * FROM `' . static::getTableName() . '` WHERE id = :id;', ['id' => $id])
            ->fetchObject(static::class);
    }

    public static function where($parameter, $condition, $value)
    {
        return Database::execute("SELECT * FROM `" . static::getTableName() . "` WHERE 
        {$parameter} {$condition} :parameter;", ['parameter' => $value])
            ->fetchAll();
    }

    public static function whereFirst($parameter, $condition, $value)
    {
        return Database::execute("SELECT * FROM `" . static::getTableName() . "` WHERE 
        {$parameter} {$condition} :parameter;", ['parameter' => $value])
            ->fetchObject();
    }

    public function delete()
    {
        return Database::execute('DELETE  FROM `' . static::getTableName() . '` WHERE id = :id;', ['id' => $this->id]);
    }

    public static function withLeftJoin($joinTable, $key, $parameter, $condition, $value)
    {
        return Database::execute("SELECT *, " . static::getTableName() .'.id'." as ".static::getTableName()."Id
        FROM " . static::getTableName() . "
        LEFT JOIN " . $joinTable . "
            ON (" . static::getTableName() . ".".$key."=" . $joinTable .'.id'.") 
        WHERE {$parameter} {$condition} :parameter;", ['parameter' => $value])->fetchAll();
    }

    public function save()
    {
        $objectVars = get_object_vars($this);
        $properties = [];
        foreach ($objectVars as $key => $var) {
            $properties[strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key))] = $var;
        }

        $columns = implode(',', array_keys($properties));
        $values = implode(',', array_fill(0, count($properties), '?'));

        return Database::execute("INSERT INTO `" . static::getTableName() . "` ({$columns}) VALUES ({$values})", array_values($properties));

    }

    abstract protected static function getTableName(): string;
}