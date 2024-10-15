<?php
header('Content-Type: application/json');

$persons = [
    [
        "id" => 1,
        "nama" => "John Doe",
        "umur" => 30,
        "alamat" => ["jalan" => "Jalan ABC", "kota" => "Jakarta"],
        "hobi" => ["membaca", "bersepeda"]
    ],
    [
        "id" => 2,
        "nama" => "Jane Doe",
        "umur" => 25,
        "alamat" => ["jalan" => "Jalan DEF", "kota" => "Bandung"],
        "hobi" => ["menulis", "berenang"]
    ]
];

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode($persons);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $input['id'] = end($persons)['id'] + 1;
        $persons[] = $input;
        echo json_encode($input);
        break;

    case 'DELETE':
        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
        $id = end($url_parts);
        $persons = array_filter($persons, function ($person) use ($id) {
            return $person['id'] != $id;
        });
        echo json_encode(["message" => "Data dengan ID $id telah dihapus"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Metode HTTP tidak didukung"]);
        break;
}
?>