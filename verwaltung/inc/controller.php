<?php 
$host = 'localhost';
$user = 'meik';
$db = 'meik';
$pw = 'ZwQ66SmSEn§s4A~H';

try {
    $conn = 'mysql:dbname=' . $db . ';host='. $host . ';';
    $pdo = new PDO($conn, $user, $pw);
}
catch(PDOException $e) {
    echo "<p>Fehler mit der Datenbankverbindung</p>";
    echo $e;
    exit('Unable to connect Database.');
}

/* Funktionen für die Benutzerverwaltung */

function create_user(){

}

function edit_user(){

}

function delete_user(){

}

function show_users(){
    // eine Übersicht aller Nutzer ausgeben
}

function show_user(){
    // mit ID einen einzelnen Nutzer ausgeben
}

/* Funktionen für Exponate */

function get_exponate(){
    /* diese Funktion gibt alle Exponate aus */
    $pdo = connect();
//    $stmt = $pdo->prepare('SELECT * FROM *');
    $stmt->execute();
    $values = $stmt->fetchAll(PDO:FETCH_ASSOC);

    json_encode($values);
    return $values;
}
function get_exponat($exponat_id){
    /* diese Funktion nimmt eine Exponat ID entgegen und fragt das entsprechende Exponat in der DB ab*/
    $pdo = connect();
//  $stmt = $pdo->prepare('SELECT * FROM *');
    $stmt->execute();
    $values = $stmt->fetchAll(PDO:FETCH_ASSOC);

    json_encode($values);
    return $values;
}
function add_exponat($number, $title, $description, $producer, $production_year, $price, $origin, $dimensions, $material, $accessibility, $location, $events, $visitor_interests){
    /* diese Funktion legt eine neues Exponat an*/
    $pdo = connect();
//  $stmt = $pdo->prepare('SELECT * FROM *');
    $stmt->execute();
}
?>