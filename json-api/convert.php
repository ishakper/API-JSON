<?php

$jsonData = file_get_contents('http://localhost/API JSON/json-api/api.php');


if ($jsonData === false) {
   
    die('Error: Unable to retrieve data from the API');
}


$persons = json_decode($jsonData, true);


if ($persons === null) {

    die('Error: Invalid JSON data');
}


$xml = new SimpleXMLElement('<persons/>');


foreach ($persons as $person) {
    if (isset($person['id'], $person['nama'], $person['umur'], $person['alamat'], $person['alamat']['jalan'], $person['alamat']['kota'], $person['hobi'])) {
        $personElement = $xml->addChild('person');
        $personElement->addChild('id', $person['id']);
        $personElement->addChild('name', $person['nama']);
        $personElement->addChild('age', $person['umur']);
        
       
        $address = $personElement->addChild('address');
        $address->addChild('street', $person['alamat']['jalan']);
        $address->addChild('city', $person['alamat']['kota']);
        
     
        $hobbies = $personElement->addChild('hobbies');
        foreach ($person['hobi'] as $hobi) {
            $hobbies->addChild('hobby', $hobi);
        }
    } else {

        die('Error: Missing data for person');
    }
}


header('Content-Type: application/xml');


echo $xml->asXML();
?>