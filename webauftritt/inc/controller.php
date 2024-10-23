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

?>