<?php

    class Convert {
        public function toXML($rawData) {
            header('Content-type: text/xml');
            $writer = new XMLWriter();

            $writer->openUri('php://output');
            $writer->startDocument('1.0', 'UTF-8');

            $writer->startElement('countries');

            foreach($rawData as $row) {
                $writer->startElement('country');
                $writer->startAttribute('name');
                    $writer->text($row['country_name']);
                $writer->endAttribute();
                $writer->startAttribute('code');
                    $writer->text($row['code']);
                $writer->endAttribute();

                if($rawData->fetch_fields()[0]->table == 'deaths') {
                    $writer->startElement('deaths');
                        $writer->startAttribute('per-residents');
                            $writer->text(1000);
                        $writer->endAttribute();
                        $writer->text($row['deaths']);
                    $writer->endElement();
                } else if($rawData->fetch_fields()[0]->table == 'happiness') {
                    $writer->startElement('happiness-rank');
                        $writer->startAttribute('score');
                            $writer->text($row['score']);
                        $writer->endAttribute();
                        $writer->text($row['rank']);
                    $writer->endElement();
                } else if($rawData->fetch_fields()[0]->table == 'alcohol') {
                    $writer->startElement('alcohol-consumption');
                        $writer->startElement('unit');
                            $writer->startAttribute('type');
                                $writer->text('liter');
                            $writer->endAttribute();
                            $writer->text($row['alcohol']);
                        $writer->endElement();
                    $writer->endElement();
                }
                $writer->endElement();
            }
            $writer->endDocument();
        }

        public function toJson($rawData) {
            global $response;

            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            $i = 0;
            $resp = '{ "countries": [';
            foreach($rawData as $row) {
                $resp .= '{"country": {';
                if($rawData->fetch_fields()[0]->table == 'deaths') {
                    $resp .= '"code": "'. $row['code'] .'", "name": "'. $row['country_name'] .'","deaths": { "per-residents": 1000, "amount": '. $row['deaths'] .' }';
                } else if($rawData->fetch_fields()[0]->table == 'happiness') {
                    $resp .= '"code": "'. $row['code'] .'", "name": "'. $row['country_name'] .'","happiness": { "score": '. $row['score'] .', "rank": '. $row['rank'] .' }';
                } else if($rawData->fetch_fields()[0]->table == 'alcohol') {
                    $resp .= '"code": "'. $row['code'] .'", "name": "'. $row['country_name'] .'","alcohol-consumption": { "type": "liter", "unit": '. $row['alcohol'] .' }';
                }
                $resp .= '}}';
                if( $i !== $rawData->num_rows - 1) {
                    $resp .= ',';
                }
                $i++;
            }

            $resp .= ']}';

            $response->makeResponse($resp);
        }
    }

?>
