<?php

//PDO 

class Db {

    private static $conn;

    private function condane() {
        $data = array();
        $filepath = realpath(dirname(__FILE__));
        $d = simplexml_load_file($filepath . '/xml/db.xml');

        $data['dns'] = $d->db->dns;
        $data['prefix'] = $d->db->prefix;
        $data['server'] = $d->db->host;
        $data['username'] = $d->db->username;
        $data['password'] = $d->db->password;
        $data['dbname'] = $d->db->dbname;
        return $data;
    }

    public function connect() {
        $data = self::condane();
        try {
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
            self::$conn = new PDO($data['dns'] . ":host=" . $data['server'] . ";dbname=" . $data['dbname'] . "", $data['username'], $data['password'], $options);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function close() {
        self::$conn = null;
        self::$queriesCounter = 0;
    }

    public function insert($table, $column, $value) {
        db::connect();
        ;
        $sql = "INSERT INTO " . $table . " (" . $column . ") VALUES (" . $value . ")";
        try {
            $stmt = self::$conn->exec($sql);
            return $stmt;
        } catch (PDOException $e) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function selectAll($table, $columns = '*', $where = '*') {
        db::connect();
        $query = "SELECT " . $columns . " FROM " . $table . "";
        if ($where != '*') {
            $query .= " WHERE " . $table . "." . $where;
        }
        $stmt = self::$conn->query($query);
        return $stmt;
    }

    public function delete($table, $where) {
        db::connect();
        $query = "DELETE FROM " . $table . " WHERE " . $table . "." . $where;
        $stmt = self::$conn->query($query);
    }

    public function updeate($table, $data, $where) {
        db::connect();
        $query = "UPDATE " . $table . " SET ";
        $ste = 0;
        foreach ($data as $key => $value) {

            if ($ste > 0) {
                $query .= ', ';
            }
            $query .= $key . " = '" . $value . "'";
            $ste++;
        }
        $query .= " WHERE " . $where;
        $stmt = self::$conn->query($query);
    }

}
