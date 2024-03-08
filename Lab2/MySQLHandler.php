<?php

class MySQLHandler {
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function select($table, $columns, $conditions = null) {
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table;
        if ($conditions) {
            $sql .= " WHERE " . $conditions;
        }

        $result = $this->connection->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    // Implement other CRUD operations as needed
}
?>
