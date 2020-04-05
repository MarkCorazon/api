<?php
    require 'classes/Validate.class.php';

    if(isset($_POST['type']) && isset($_POST['validate']) && isset($_POST['table'])){
        $table = $_POST['table'];
        if($_POST['type'] == 'xml') {
            $xml = $_POST['validate'];
            $validate = new Validate;
            $validate->xml($xml, $table);
        } else if($_POST['type'] == 'json') {
            $json = $_POST['validate'];
            $validate = new Validate;
            $validate->json($json, $table);
        }
    }
?>
