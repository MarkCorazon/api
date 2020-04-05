<?php
    require 'classes/Response.class.php';
    require 'classes/Request.class.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['type'])) {
            if($_GET['type'] == 'xml'){
                $request = new Request;
                $request->makeGetRequest();
            } else if($_GET['type'] == 'json'){
                $request = new Request;
                $request->makeGetRequest();
            } else {
                $response->customResponse(400, "Het ingevoerde type is geen xml of json");
            }
        } else {
            $response->missingParameterResponse("type");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response->customResponse(200, "Ahw yeeh");

        $request = new Request;
        $request->makePostRequest();
    }

    echo $response->getResponse();
?>
