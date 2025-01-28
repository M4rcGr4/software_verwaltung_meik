<?php 
function connect(){
    $host = 'localhost';
    $user = 'meik';
    $db = 'meik';
    $pw = 'ZwQ66SmSEn§s4A~H';

    try {
        // $conn = 'mysql:dbname=' . $db . ';host='. $host . ';';
        // $pdo = new PDO($conn, $user, $pw);
        $pdo = new PDO('mysql:host=localhost;dbname=meik', 'meik', 'ZwQ66SmSEn§s4A~H', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    catch(PDOException $e) {
        echo "<p>Fehler mit der Datenbankverbindung</p>";
        echo $e;
        exit('Unable to connect Database.');
        die();
    }
    return $pdo;
}

function get_exponate(){
    /* diese Funktion gibt alle Exponate aus, die nicht gelöscht sind */
    $pdo = connect();
    $stmt = $pdo->prepare("SELECT `Objekt_ID`, `Exp-Nr`, `Titel`, e.Beschreibung Beschreibung, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
        `Material`, `Ausstellung`, `Interesse`, IFNULL(k.Bezeichnung,'') Kategorie, IFNULL(z.Bezeichnung,'') Zustand, IFNULL(s.Name,'') Standort FROM `Exponat` e
        LEFT JOIN Kategorie k ON k.Kat_ID = e.Kat_ID 
        LEFT JOIN Zustand z ON z.Zu_ID = e.Zu_ID
        LEFT JOIN Standort s ON s.Standort_ID = e.Standort_ID 
        WHERE e.Zu_ID > 0");
    $stmt->execute();
    $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

    json_encode($values);
    return $values;
}
function get_exponat($exponat_id){
    /* diese Funktion nimmt eine Exponat ID entgegen und fragt das entsprechende Exponat in der DB ab*/
    $pdo = connect();
    $stmt = $pdo->prepare('SELECT `Exp-Nr`, `Titel`, `Beschreibung`, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
        `Material`, `Ausstellung`, `Interesse`, `Kat_ID`, `Zu_ID`, `Standort_ID` FROM `Exponat` WHERE Objekt_ID=' . $exponat_id);
    $stmt->execute();
    $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

    json_encode($values);
    return $values;
}
?>