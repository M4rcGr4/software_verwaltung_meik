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
        anmeldung - Anmeldename - Pflicht
        Recht - Zugriffsberechtigung - Standardwert falls nichts
        pw - Passwort - Pflicht
        Anzeigename - Standardwert, Anmeldung falls nichts
        geloescht - 1 wenn gelöscht
    */

    function create_user($anmeldung,$recht,$passwort,$anzeigename){
        //Nutzer anlegen
        $pdo = connect();
        $stmt = $pdo->prepare("INSERT INTO `Nutzer` (`Anmeldung`, `Recht`, `pw`, `Anzeigename`, `geloescht`) VALUES ('$anmeldung',$recht,'$passwort','$anzeigename',0)");
        $stmt->execute();     
    }

    function edit_user($nutzer_id,$anmeldung,$recht,$passwort,$anzeigename){
        //Nutzer bearbeiten
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE `Nutzer` SET `Anmeldung`='$anmeldung', `Recht`=$recht, `pw`='$passwort', `Anzeigename`='$anzeigename' WHERE NUTZER_ID=".$nutzer_id);
        $stmt->execute();        
    }

    function delete_user($nutzer_id){
        //Nutzer löschen
        $pdo = connect();
        $stmt = $pdo->prepare('UPDATE `Nutzer` SET geloescht=1 WHERE NUTZER_ID='.$nutzer_id);
        $stmt->execute();        
    }

    function show_users(){
        // eine Übersicht aller Nutzer ausgeben
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Anmeldung`, `Recht`, `Anzeigename`  FROM `Nutzer`');
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

    function show_user($nutzer_id){
        // mit ID einen einzelnen Nutzer ausgeben
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Anmeldung`, `Recht`, `Anzeigename`  FROM `Nutzer` WHERE NUTZER_ID='.$nutzer_id);
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
        $events - Ausstellungen/Veranstaltungen - Standardwert falls nichts
        $visitor_interests - Notizen zum Besucherinteresse - Standardwert falls nichts
        $kat_id - ID aus der Tabelle Kategorie - Standardwert falls nichts
        $zu_id - ID aus der Tabelle Zustand - Pflicht
        $location_id - Id aus der Tabelle Standort - Pflicht
    */

    function get_exponate(){
        /* diese Funktion gibt alle Exponate aus, die nicht gelöscht sind */
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT `Objekt_ID`, `Exp-Nr`, `Titel`, e.Beschreibung Beschreibung, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
            `Material`, `Ausstellung`, `Interesse`, IFNULL(k.Bezeichnung,'') Kategorie, `Zu_ID`, `Standort_ID` FROM `Exponat` e
            LEFT JOIN Kategorie k ON k.Kat_ID = e.Kat_ID WHERE Zu_ID > 0");
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

    function add_exponat(
        $number, $title, $description, $producer, $production_year, $price_today, $price_original, $origin, $dimensions, $material, 
        $events, $visitor_interests, $kat_id, $zu_id, $location_id){
        /* diese Funktion legt eine neues Exponat an*/
        $pdo = connect();
        $stmt = $pdo->prepare("INSERT INTO Exponat (`Exp-Nr`, `Titel`, `Beschreibung`, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
            `Material`, `Ausstellung`, `Interesse`, `Kat_ID`, `Zu_ID`, `Standort_ID`) 
            values ('$number','$title','$description','$producer','$production_year','$price_today','$price_original','$origin','$dimensions',
            '$material','$events','$visitor_interests',$kat_id,$zu_id,$location_id)");
        $stmt->execute();
    }

    function edit_exponat(
        $exponat_id, $number, $title, $description, $producer, $production_year, $price_today, $price_original, $origin, $dimensions, $material, 
        $events, $visitor_interests, $kat_id, $zu_id, $location_id){
        /* Diese Funktion verändert ein Exponat*/
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Exponat SET `Exp-Nr`='$number', `Titel`='$title', `Beschreibung`='$description', `Hersteller`='$producer', `Baujahr`=$production_year,
            `Wert`=$price_today, `OrigPreis`='$price_original', `Herkunft`='$origin', `Abmessungen`='$dimensions', `Material`='$material', `Ausstellung`='$events',
            `Interesse`='$visitor_interests', `Kat_ID`=$kat_id, `Zu_ID`=$zu_id, `Standort_ID`=$location_id WHERE Objekt_ID=$exponat_id");
        $stmt->execute(); 
    }

/*Ende Funktionen für Exponate */

/* Funktionen für Kategorien*/
    function add_kategorie($kat_name, $kat_beschreibung){
        //Kategorie anlegen
        $pdo = connect();
        $stmt = $pdo->prepare("INSERT INTO Kategorie (Bezeichnung,Beschreibung) VALUES ('$kat_name','$kat_beschreibung')");
        $stmt->execute();
    }

    function edit_kategorie($kat_id,$kat_name, $kat_beschreibung){
        //Kategorie bearbeiten
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Kategorie SET Bezeichnung='$kat_name', Beschreibung='$kat_beschreibung' WHERE Kat_ID=$kat_id");
        $stmt->execute();
    }

    function show_kategorie($kat_id){
        //Kategorie zeigen
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT Bezeichnung, Beschreibung FROM Kategorie WHERE Kat_ID=$kat_id");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

    function show_kategorien(){
        //Kategorie zeigen
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT Bezeichnung, Beschreibung FROM Kategorie");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }
/* Ende Funktionen für Kategorien*/

/*Entgegennehmen der Daten aus js und Weitergabe an Funktionen*/
if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['create_user']))){
    create_user($_GET['anmeldung'],$_GET['recht'],$_GET['passwort'],$_GET['anzeigename']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['edit_user']))){
    edit_user($_GET['nutzer_id'],$_GET['anmeldung'],$_GET['recht'],$_GET['passwort'],$_GET['anzeigename']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['delete_user']))){
    delete_user($_GET['nutzer_id']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['show_users']))){
    show_users();
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['show_user']))){
    show_user($_GET['nutzer_id']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['get_exponat']))){
    get_exponat($_GET['exponat_id']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['get_exponate']))){
    get_exponate();
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['add_exponat']))){
    if(empty($_GET['expBaujahr'])){$_GET['expBaujahr'] = 0;}
    if(empty($_GET['expWert'])){$_GET['expWert'] = 0;}
    if(empty($_GET['expOrgPreis'])){$_GET['expOrgPreis'] = 0;}
    add_exponat($_GET['expName'],$_GET['expTitel'],$_GET['expBesch'],$_GET['expHersteller'],$_GET['expBaujahr'],$_GET['expWert'],$_GET['expOrgPreis'],$_GET['expHerkunft'],
         $_GET['expMaße'],$_GET['expMaterial'],$_GET['expVeranst'],$_GET['expNote'],$_GET['expKat'],$_GET['expZust'],$_GET['expStandort']
    );

    header("Location: ../index.php");
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['edit_exponat']))){
    if(empty($_GET['expBaujahr'])){$_GET['expBaujahr'] = 0;}
    if(empty($_GET['expWert'])){$_GET['expWert'] = 0;}
    if(empty($_GET['expOrgPreis'])){$_GET['expOrgPreis'] = 0;}
    edit_exponat($_GET['exponat_id'],$_GET['expName'],$_GET['expTitel'],$_GET['expBesch'],$_GET['producer'],$_GET['production_year'],$_GET['price_today'],$_GET['price_original'],$_GET['origin'],
         $_GET['dimensions'],$_GET['material'],$_GET['events'],$_GET['visitor_interests'],$_GET['$kat_id'],$_GET['$zu_id'],$_GET['$location_id']
    );
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['add_kategorie']))){
    add_kategorie($_GET['katName'],$_GET['katBeschreib']);

    header("Location: ../index.php");
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['edit_kategorie']))){
    edit_kategorie($_GET['kat_id'],$_GET['kat_name'],$_GET['kat_beschreibung']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['show_kategorie']))){
    show_kategorie($_GET['kat_id']);
}

if(($_SERVER['REQUEST_METHOD']==='GET') && (!empty($_GET['show_kategorien']))){
    show_kategorien();
}

?>