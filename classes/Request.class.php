<?php
    require 'classes/Database.class.php';
    require 'classes/Convert.class.php';

    class Request {
        public function makeGetRequest() {
            global $_CONFIG, $response, $db;

            $requiredGetParams = $_CONFIG['getRequired'];
            if($this->checkIfParameterIsMissing($requiredGetParams)) {
                return;
            }

            $conn = $db->getConn();
            $set = $db->secure($_GET['set']);

            if($set == 'deaths' || $set == 'happiness' || $set == 'alcohol') {
                if(isset($_GET['country_code'])) {
                    $country_code = $db->secure($_GET['country_code']);
                    $rawData = $conn->query("SELECT * FROM {$set} INNER JOIN countries ON {$set}.code = countries.code WHERE {$set}.code='{$country_code}' ")or die($conn->error);
                } else {
                    $rawData = $conn->query("SELECT * FROM {$set} INNER JOIN countries ON {$set}.code = countries.code")or die($conn->error);
                }
                if($rawData->num_rows) {
                    if($_GET['type'] == 'xml') {
                        $convert = new Convert;
                        $convert->toXML($rawData);
                    } else if($_GET['type'] == 'json') {
                        $convert = new Convert;
                        $convert->toJson($rawData);
                    }
                } else {
                    $response->customResponse(404, "Er is geen data gevonden met de opgevraagde parameters");
                }
            } else {
                $response->customResponse(404, "Dataset " . $set . " is niet gevonden");
            }
        }

        // TODO: Check of country al bestaat in countries
        // TODO: Als country al bestaat in andere tabel dan afbreken en error terug responden

        public function makePostRequest() {
            global $_CONFIG, $response, $db;

            $requiredPostParams = $_CONFIG['postRequired'];
            if($this->checkIfParameterIsMissing($requiredPostParams)) {
                return;
            }

            $conn = $db->getConn();
            $set = $db->secure($_POST['set']);
            $country_name = $db->secure($_POST['country_name']);
            $country_code = $db->secure($_POST['country_code']);

            if($set == 'deaths' || $set == 'happiness' || $set == 'alcohol') {
                if($set == 'deaths') {
                    if(isset($_POST['deaths'])) {
                        $deaths = $db->secure($_POST['deaths']);
                        $conn->query("INSERT INTO countries (code, country_name) VALUES ('{$country_code}', '{$country_name}')")or die($conn->error);
                        $conn->query("INSERT INTO deaths (code, deaths) VALUES ('{$country_code}', '{$deaths}')");
                    } else {
                        $response->missingParameterResponse('deaths');
                    }
                } else if($set == 'happiness') {
                    $requiredParams = ['score', 'rank'];
                    if($this->checkIfParameterIsMissing($requiredParams)) {
                        return;
                    }
                    $rank = $db->secure($_POST['rank']);
                    $score = $db->secure($_POST['score']);
                    $conn->query("INSERT INTO countries (code, country_name) VALUES ('{$country_code}', '{$country_name}')")or die($conn->error);
                    $conn->query("INSERT INTO happiness (code, rank, score) VALUES ('{$country_code}', '{$rank}', '{$score}')");
                } else if($set == 'alcohol') {
                    if(isset($_POST['alcohol'])) {
                        $alcohol = $db->secure($_POST['alcohol']);
                        $conn->query("INSERT INTO countries (code, country_name) VALUES ('{$country_code}', '{$country_name}')")or die($conn->error);
                        $conn->query("INSERT INTO alcohol (code, alcohol) VALUES ('{$country_code}', '{$alcohol}')");
                    } else {
                        $response->missingParameterResponse('alcohol');
                    }
                }

                // if($rawData->num_rows) {
                //     if($_GET['type'] == 'xml') {
                //         $convert = new Convert;
                //         $convert->toXML($rawData);
                //     } else if($_GET['type'] == 'json') {
                //         $convert = new Convert;
                //         $convert->toJson($rawData);
                //     }
                // } else {
                //     $response->customResponse(404, "Er is geen data gevonden met de opgevraagde parameters");
                // }
            } else {
                $response->customResponse(404, "Dataset " . $set . " is niet gevonden");
            }
        }

        public function is_empty($input) {
            if($input == '' || is_null($input)){
                $result = true;
            } else {
                $result = false;
            }

            return $result;
        }


        public function checkIfParameterIsMissing($parameters) {
            global $response;

            $missingParameters = [];

            foreach ($parameters as $required) {
                if($_SERVER['REQUEST_METHOD'] == "GET") {
                    if(isset($_GET[$required])) {
                        if($this->is_empty($_GET[$required])) {
                            array_push($missingParameters, $required);
                        }
                    } else {
                        array_push($missingParameters, $required);
                    }
                } else if($_SERVER['REQUEST_METHOD'] == "POST") {
                    if(isset($_POST[$required])) {
                        if($this->is_empty($_POST[$required])) {
                            array_push($missingParameters, $required);
                        }
                    } else {
                        array_push($missingParameters, $required);
                    }
                }
            }

            if(!empty($missingParameters)) {
                if(count($missingParameters) == 1) {
                    $response->missingParameterResponse($missingParameters[0]);
                } else {
                    $response->missingParameterResponse($missingParameters);
                }
                return true;
            }

            return false;
        }
    }

?>
