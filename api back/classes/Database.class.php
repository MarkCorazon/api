<?php
    require 'config/config.php';

    class Database {
        private $conn;

        function __construct(){
            global $response, $_CONFIG;

            $conn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']);
            if ($conn->connect_error) {
                $response->customResponse('{ "code": 500, "message": "Database connectie error '. $conn->connect_error .'" }');
                die($response->getResponse());
            } else {
                $this->conn = $conn;
            }
        }

        public function getConn() {
            return $this->conn;
        }

        public function secure($variable) {
            return $this->getConn()->real_escape_string(htmlspecialchars($variable));
        }
    }

    $db = new Database;
?>
