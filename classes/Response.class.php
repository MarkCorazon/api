<?php

    class Response {
        private $response;

        public function makeResponse($resp) {
            $this->response = $resp;
        }

        public function customResponse($code, $message) {
            $this->response = '{ "code": '. $code .', "message": "'. $message .'" }';
        }

        public function okResponse() {
            $this->response = '{ "code": 200, "message": "Success!" }';
        }

        public function missingParameterResponse($parameter) {
            if(is_array($parameter)) {
                $parameters = null;
                for ($i=0; $i < count($parameter); $i++) {
                    if($i == count($parameter) - 1) {
                        $parameters .= $parameter[$i];
                    } else {
                        $parameters .= $parameter[$i] . " en ";
                    }
                }
                $response = '{ "code": 400, "message": "De parameters '. $parameters .' missen. Voeg deze toe om een geldige response te krijgen" }';
            } else {
                $response = '{ "code": 400, "message": "De parameter '. $parameter .' mist. Voeg deze toe om een geldige response te krijgen" }';
            }

            $this->response = $response;
        }

        public function getResponse() {
            return $this->response;
        }
    }

    $response = new Response;

?>
