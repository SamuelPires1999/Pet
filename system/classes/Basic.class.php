<?php
class Basic {
    public static function select($keyColumn, $value, $returnObject) {
        return DB::select($returnObject, $keyColumn, $value);
    }

    public static function selectAll($filters, $orderBy = null, $orderDirection = "ASC", $limit = 100, $offset = 0, $returnObject) {
        return DB::selectAll($returnObject, $filters, $limit, $offset, $orderBy, $orderDirection);
    }

    public static function insert($object) {
        return DB::insert($object);
    }

    public static function update($object, $keyColumn) {
        return DB::update($object, $keyColumn);
    }

    function __call($func, $params)
    {
        if (substr($func,0, 3) == "set" && strlen($func) >= 4)
        {
            $name = strtolower(lcfirst(substr($func,3)));
            $attr = &$this->$name;

            $attr = $params[0];
            return $this;
        }
        if (substr($func,0, 3) == "get" && strlen($func) >= 4)
        {
            $name = strtolower(lcfirst(substr($func,3)));
            return $this->$name;
        }
    }
}