<?php
class DB {

    private static $connection = null;

    public static function connect() {
        global $config;

        if (self::$connection == null) {

            self::$connection = new PDO("mysql:host=" . $config['db']['ip'] . ";" . "dbname=" . $config['db']['banco'], $config['db']['usuario'], $config['db']['senha'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$connection->setAttribute(PDO::ATTR_TIMEOUT , 5);
        }

        return self::$connection;
    }

    public static function prepare($sql) {
        return self::connect()->prepare($sql);
    }

    public static function query($sql) {
        return self::connect()->query($sql);
    }

    public static function lastInsertId() {
        return self::connect()->lastInsertId();
    }

    public static function select($returnObject, $keyColumn, $keyValue) {
        $stmt = DB::prepare("SELECT * FROM ".strtolower(get_class($returnObject))." WHERE ".$keyColumn." = :keyValue LIMIT 1;");
        $stmt->bindParam(":keyValue", $keyValue);
        $stmt->execute();

        if($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            foreach(array_keys($row) as $column) {
                $oldColumn = $column;
                $column = "set".$column;

                try {
                    $returnObject->$column($row[$oldColumn]);
                }
                catch(Exception $e) {}

                if(strlen($oldColumn) > 3 && substr($oldColumn, 0, 3) === "id_") {
                    $relatedObjectName = ucfirst(str_replace("id_", "", $oldColumn));
                    $relatedObject = $relatedObjectName::select("id", $row[$oldColumn]);
                    $oldColumn = "set".$relatedObjectName;
                    try {
                        $returnObject->$oldColumn($relatedObject);
                    }
                    catch(Exception $e) {}
                }
            }

            return $returnObject;
        }
        else
            return null;
    }

    public static function selectAll($returnObject, $filters = [], $limit = 100, $offset = 0, $orderBy = null, $orderDirection = "ASC") {

        if(sizeof($filters) > 0) {
            $whereParams = [];

            foreach($filters as $column => $value)
                $whereParams[] = $column." = :".$column;

            $whereString = implode(" AND ", $whereParams);
        }

        $stmt = DB::prepare("SELECT * FROM ".strtolower(get_class($returnObject)).(sizeof($filters) > 0 ? " WHERE ".$whereString : "").($orderBy != null ? " ORDER BY ".$orderBy." ".$orderDirection : "")." LIMIT ".$limit." OFFSET ".$offset.";");

        foreach($filters as $column => &$value) {
            $column = ":".$column;
            $stmt->bindParam($column, $value);
        }

        $returnList = [];

        if($stmt->execute()) {
            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $object = clone $returnObject;
                foreach(array_keys($row) as $column) {
                    $oldColumn = $column;
                    $column = "set".$column;

                    try {
                        $object->$column($row[$oldColumn]);
                    }
                    catch(Exception $e) {}

                    if(strlen($oldColumn) > 3 && substr($oldColumn, 0, 3) === "id_") {
                        $relatedObjectName = ucfirst(str_replace("id_", "", $oldColumn));
                        $relatedObject = $relatedObjectName::select("id", $row[$oldColumn]);
                        $oldColumn = "set".$relatedObjectName;
                        try {
                            $object->$oldColumn($relatedObject);
                        }
                        catch(Exception $e) {}
                    }
                }

                $returnList[] = $object;
            }

            return $returnList;
        } else
            return [];
    }

    public static function insert($object) {
        $columnsArray =  array_keys((array)$object);

        $i = 0;
        foreach($columnsArray as $columnCheck) {
            $getString = "get".ucfirst($columnCheck);

            if($object->$getString() === null) {
                echo array_splice($columnsArray, $i, 1)[0];
                $i--;
            }

            $i++;
        }

        $columns = implode(", ", $columnsArray);
        $columnsValues = ":".implode(", :", $columnsArray);

        $stmt = DB::prepare("INSERT INTO ".strtolower(get_class($object))." (".$columns.") VALUES (".$columnsValues.");");

        foreach($object as $column => &$value) {
            if(!in_array($column, $columnsArray))
                continue;

            $column = ":".$column;
            $stmt->bindParam($column, $value);
        }

        if($stmt->execute())
            return self::lastInsertId();
        else
            return null;
    }

    public static function update($object, $keyColumn) {
        $columnsArray =  array_keys((array)$object);

        $columns = "";
        foreach($columnsArray as $column) {
            if($column == $keyColumn | $column == "id")
                continue;

            $columns .= $column." = :".$column.",";
        }

        $columns = substr($columns, 0, -1);

        $stmt = DB::prepare("UPDATE ".strtolower(get_class($object))." SET ".$columns." WHERE ".$keyColumn." = :".$keyColumn." LIMIT 1;");

        foreach($object as $column => $value) {
            $column = ":".$column;
            $stmt->bindParam($column, $value);
        }

        if($stmt->execute())
            return true;
        else
            return false;
    }
}

