<?php 
/*Datenbankverbindung aufbauen */
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

/* Funktionen für die Benutzerverwaltung */

    /*
        nutzer_id - wird fortlaufend vergeben
    */

    function create_user(){

    }

    function edit_user(){

    }

    function delete_user(){

    }

    function show_users(){
        // eine Übersicht aller Nutzer ausgeben
    }

    function show_user($nutzer_id){
        // mit ID einen einzelnen Nutzer ausgeben
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Anmeldung`, `Recht`, `Anzeigename`  FROM `Nutzer` WHERE NUTZER_ID='$nutzer_id);
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }
/*Ende Funktionen Benutzerverwaltung */

/* Funktionen für Exponate */

    /*
        -exponat_id wird automatisch fortlaufend vergeben 
        $number - Exponat-Nummer (nicht die ID - ID wird automatisch vergeben) - Pflicht
        $title - Titel/Name - Pflicht
        $description - ausführliche Beschreibung - Standardwert falls nichts 
        $producer - Hersteller - Standardwert falls nichts
        $production_year - Baujahr - Standardwert falls nichts
        $price_today - aktueller Wert - Standardwert falls nichts
        $price_original - Originalpreis - Standardwert falls nichts
        $origin - Herkunft/Provenienz - Standardwert falls nichts
        $dimensions - Maße/Abmessungen - Standardwert falls nichts
        $material - Material - Standardwert falls nichts
        $accessibility - Zugänglichkeit - Standardwert falls nichts
        $events - Ausstellungen/Veranstaltungen - Standardwert falls nichts
        $visitor_interests - Notizen zum Besucherinteresse - Standardwert falls nichts
        $kat_id - ID aus der Tabelle Kategorie - Standardwert falls nichts
        $zu_id - ID aus der Tabelle Zustand - Pflicht
        $location_id - Id aus der Tabelle Standort - Pflicht
    */

    function get_exponate(){
        /* diese Funktion gibt alle Exponate aus */
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Objekt_ID`, `Exp-Nr`, `Titel`, `Beschreibung`, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
            `Material`, `Zugang`, `Ausstellung`, `Interesse`, `Kat_ID`, `Zu_ID`, `Standort_ID` FROM `Exponat`');
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }
    function get_exponat($exponat_id){
        /* diese Funktion nimmt eine Exponat ID entgegen und fragt das entsprechende Exponat in der DB ab*/
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Exp-Nr`, `Titel`, `Beschreibung`, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
            `Material`, `Zugang`, `Ausstellung`, `Interesse`, `Kat_ID`, `Zu_ID`, `Standort_ID` FROM `Exponat` WHERE Objekt_ID=' . $exponat_id);
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

    function add_exponat(
        $number, $title, $description, $producer, $production_year, $price_today, $price_original, $origin, $dimensions, $material, 
        $accessibility, $events, $visitor_interests, $kat_id, $zu_id, $location_id){
        /* diese Funktion legt eine neues Exponat an*/
        $pdo = connect();
        $stmt = $pdo->prepare("INSERT INTO Exponat (`Exp-Nr`, `Titel`, `Beschreibung`, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
            `Material`, `Zugang`, `Ausstellung`, `Interesse`, `Kat_ID`, `Zu_ID`, `Standort_ID`) 
            values ('$number','$title','$description','$producer','$production_year','$price_today','$price_original','$origin','$dimensions',
            '$material','$accessibility','$events','$visitor_interests',$kat_id,$zu_id,$location_id)");
        $stmt->execute();
    }

    function edit_exponat(
        $exponat_id, $number, $title, $description, $producer, $production_year, $price_today, $price_original, $origin, $dimensions, $material, 
        $accessibility, $events, $visitor_interests, $kat_id, $zu_id, $location_id){
        /* Diese Funktion verändert ein Exponat*/
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Exponat SET `Exp-Nr`='$number', `Titel`='$title', `Beschreibung`='$description', `Hersteller`='$producer', `Baujahr`=$production_year,
            `Wert`=$price_today, `OrigPreis`='$price_original', `Herkunft`='$origin', `Abmessungen`='$dimensions', `Material`='$material', `Zugang`=$accessibility, `Ausstellung`='$events',
            `Interesse`='$visitor_interests', `Kat_ID`=$kat_id, `Zu_ID`=$zu_id, `Standort_ID`=$location_id WHERE Objekt_ID=$exponat_id");
        $stmt->execute(); 
    }

/*Ende Funktionen für Exponate */

/*Entgegennehmen der Daten aus js und Weitergabe an Funktionen*/
if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['get_exponat']))){
    get_exponat($_GET['exponat_id']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['get_exponate']))){
    var_dump(get_exponate());
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['add_exponat']))){
    add_exponat($_GET['exp_nr'],$_GET['title'],$_GET['description'],$_GET['producer'],$_GET['production_year'],$_GET['price_today'],$_GET['price_original'],$_GET['origin'],
         $_GET['dimensions'],$_GET['material'],$_GET['access'],$_GET['events'],$_GET['visitor_interests'],$_GET['$kat_id'],$_GET['$zu_id'],$_GET['$location_id']
    );
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['edit_exponat']))){
    edit_exponat($_GET['exponat_id'],$_GET['exp_nr'],$_GET['title'],$_GET['description'],$_GET['producer'],$_GET['production_year'],$_GET['price_today'],$_GET['price_original'],$_GET['origin'],
         $_GET['dimensions'],$_GET['material'],$_GET['access'],$_GET['events'],$_GET['visitor_interests'],$_GET['$kat_id'],$_GET['$zu_id'],$_GET['$location_id']
    );
}

// $test = edit_exponat(3,'1.003','Testfunktion','Lorem ipsum','hersteller',2,2,'1 Moark','herkunft','abmessung','material',1,'veranstaltung','besucherinteresse',0,0,0);
// var_dump($test);

?>