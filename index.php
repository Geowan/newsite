<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

function saveRecord($data){
    if(!file_exists('data.json')){
        file_put_contents('data.json',json_encode([]));
    }

    $array = json_decode(file_get_contents("data.json"));
    array_push($array, $data);

    $json = json_encode(empty($data)?[]:$array);
    file_put_contents("data.json", $json);
}


function getRecords(){
    if(!file_exists('data.json')){
        file_put_contents('data.json',json_encode([]));
    }
    return file_get_contents("data.json");

}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8');
    echo getRecords();
    return getRecords();

//    saveRecord([
//        "id" => "MMZ385",
//        "name" => "Jennifer Winters",
//        "designation" => "Senior Programmer"
//    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    saveRecord($_POST);
}
