<?php

    class Validate {
        public function xml($xml, $table) {
            $xmlDocument = new DOMDocument;

            $xmlDocument->loadXML($xml);
            return $xmlDocument->schemaValidate("xsd/". $table .".xsd");
        }
        
        public function json($json, $table) {
            $schema = file_get_contents("draft07/". $table .".json");

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://assertible.com/json',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => [
                    'schema' => $schema,
                    'json' => $json
                ]
            ]);

            $resp = curl_exec($curl);

            curl_close($curl);

            return var_dump($resp);

        }
    }

?>
