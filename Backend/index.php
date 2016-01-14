<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/person', 'getPersons');
$app->post('/person', 'addPerson');
$app->put('/person/:id', 'updatePerson');
$app->delete('/person/:id', 'deletePerson');
$app->run();

//Select All
function getPersons() {
    try {
        $db = getConnection();
        $stmt = $db->query('select * from person');
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Save Data
function addPerson() {
    global $app;
    $data = json_decode($app->request()->getBody());
    $sql = "insert into person values(?,?,?,?)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $data->id);
        $stmt->bindParam(2, $data->name);
        $stmt->bindParam(3, $data->address);
        $stmt->bindParam(4, $data->hobbies);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Edit Data
function updatePerson($id) {
    global $app;
    $data = json_decode($app->request()->getBody());
    $sql = "update person set name=?,address=?,hobbies=? where id = ?";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $data->name);
        $stmt->bindParam(2, $data->address);
        $stmt->bindParam(3, $data->hobbies);
        $stmt->bindParam(4, $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Delete Data
function deletePerson($id) {
    $sql = "delete from person where id = :id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Connection Database
function getConnection() {
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "qwerty";
    $dbname = "rudy";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
