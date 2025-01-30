<?php 

/* Session starten / initialisieren */
if(session_status() == 1){
	session_start();
    if(empty($_SESSION)){
        $_SESSION['routing'] = 'anmeldung';
        $_SESSION['anmelde_id'] = NULL;
        $_SESSION['anmelde_name'] = "";
        $_SESSION['recht'] = 0;
        $_SESSION['status_msg'] = "";
    }
}

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
/* Hilfsfunktion */
function arrayToString(array $array): string {
    $result = [];

    foreach ($array as $key => $value) {
        $result[] = "{$key}: {$value}";
    }

    return implode(", ", $result);
}

/*Funktionen für Zustand und Standort */
    function show_zustaende($filter){
        //alle Zustände zeigen
        $wherestr='';
        if ($filter == 'nicht_geloescht') {
            //Filter: nicht gelöscht
            $wherestr = 'WHERE ZU_ID > 0'; 
        }
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT Zu_ID, Bezeichnung FROM Zustand $wherestr");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
/* //////////////////////////////////////////////// Exponate ///////////////////////////////////////////// */
/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
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

        $new_exponat = [
            "number" => $number,
            "title" => $title,
            "description" => $description,
            "producer" => $producer,
            "production_year" => $production_year,
            "price_today" => $price_today,
            "price_original" => $price_original,
            "origin" => $origin,
            "dimensions" => $dimensions,
            "material" => $material,
            "events" => $events,
            "visitor_interests" => $visitor_interests,
            "kat_id" => $kat_id,
            "zu_id" => $zu_id,
            "location_id" => $location_id
        ];

        write_log($new_exponat, "add", 0, 0);
    }

    function edit_exponat(
        $exponat_id, $number, $title, $description, $producer, $production_year, $price_today, $price_original, $origin, $dimensions, $material, 
        $events, $visitor_interests, $kat_id, $zu_id, $location_id){
        /* Diese Funktion verändert ein Exponat*/

        $new_exponat = [
            "exponat_id" => $exponat_id,
            "number" => $number,
            "title" => $title,
            "description" => $description,
            "producer" => $producer,
            "production_year" => $production_year,
            "price_today" => $price_today,
            "price_original" => $price_original,
            "origin" => $origin,
            "dimensions" => $dimensions,
            "material" => $material,
            "events" => $events,
            "visitor_interests" => $visitor_interests,
            "kat_id" => $kat_id,
            "zu_id" => $zu_id,
            "location_id" => $location_id
        ];

        if(has_exponat_changed($new_exponat)){
            write_log($new_exponat, "edit", 0, $exponat_id);
        }

        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Exponat SET `Exp-Nr`='$number', `Titel`='$title', `Beschreibung`='$description', `Hersteller`='$producer', `Baujahr`='$production_year',
            `Wert`='$price_today', `OrigPreis`='$price_original', `Herkunft`='$origin', `Abmessungen`='$dimensions', `Material`='$material', `Ausstellung`='$events',
            `Interesse`='$visitor_interests', `Kat_ID`=$kat_id, `Zu_ID`=$zu_id, `Standort_ID`=$location_id WHERE Objekt_ID=$exponat_id");
        $stmt->execute(); 
    }

    function delete_exponat($exponat_id){
        /*Exponat löschen*/
        $exp_to_delete = get_exponat($exponat_id)[0];

        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Exponat SET Zu_ID = -1 WHERE Objekt_ID=$exponat_id");
        $stmt->execute();

        write_log($exp_to_delete, "delete", 0, $exponat_id);
    }

    function has_exponat_changed($new_exponat){
        $current_exp = get_exponat($new_exponat['exponat_id'])[0];
        $exp_id = $new_exponat['exponat_id'];
        $has_changed = false;

        unset($new_exponat['exponat_id']);

        $keyMapping = [
            "Exp-Nr" => "number",
            "Titel" => "title",
            "Beschreibung" => "description",
            "Hersteller" => "producer",
            "Baujahr" => "production_year",
            "Wert" => "price_today",
            "OrigPreis" => "price_original",
            "Herkunft" => "origin",
            "Abmessungen" => "dimensions",
            "Material" => "material",
            "Ausstellung" => "events",
            "Interesse" => "visitor_interests",
            "Kat_ID" => "kat_id",
            "Zu_ID" => "zu_id",
            "Standort_ID" => "location_id"
        ];

        foreach ($keyMapping as $key1 => $key2) {
            if ((string)$current_exp[$key1] !== (string)$new_exponat[$key2]) {
                $has_changed = true;
            }
        }
        var_dump($has_changed);
        return $has_changed;
    }

    function validate_exponat() {
        $empty_feld="";
        $pflichtfelder = ['expBesch','expTitel','expName'];
        foreach ($pflichtfelder as $feld) {
            if (empty($_POST[$feld])) {$empty_feld = $feld;}
        }
        if ($empty_feld !== "") {
            return $empty_feld;
        }

    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['get_exponat']))){
        get_exponat($_POST['exponat_id']);
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['get_exponate']))){
        get_exponate();
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['add_exponat']))){
        if (validate_exponat() !== "") {
            $_SESSION['status_msg'] = validate_exponat();
            $_POST = array();
        } else {
            if(empty($_POST['expBaujahr'])){$_POST['expBaujahr'] = 0;}
            if(empty($_POST['expWert'])){$_POST['expWert'] = 0;}
            if(empty($_POST['expOrgPreis'])){$_POST['expOrgPreis'] = 0;}
            add_exponat($_POST['expName'],$_POST['expTitel'],$_POST['expBesch'],$_POST['expHersteller'],$_POST['expBaujahr'],$_POST['expWert'],$_POST['expOrgPreis'],$_POST['expHerkunft'],
                $_POST['expMaße'],$_POST['expMaterial'],$_POST['expVeranst'],$_POST['expNote'],$_POST['expKat'],$_POST['expZust'],$_POST['expStandort']
            );
        }

        header("Location: ../index.php");
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['edit_exponat']))){
        if(empty($_POST['expBaujahr'])){$_POST['expBaujahr'] = 0;}
        if(empty($_POST['expWert'])){$_POST['expWert'] = 0;}
        if(empty($_POST['expOrgPreis'])){$_POST['expOrgPreis'] = 0;}
        edit_exponat($_POST['exp_id'],$_POST['expName'],$_POST['expTitel'],$_POST['expBesch'],$_POST['expHersteller'],$_POST['expBaujahr'],$_POST['expWert'],$_POST['expOrgPreis'],$_POST['expHerkunft'],
        $_POST['expMaße'],$_POST['expMaterial'],$_POST['expVeranst'],$_POST['expNote'],$_POST['expKat'],$_POST['expZust'],$_POST['expStandort']
        );
        $_SESSION['routing'] = 'edit';
    }

/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
/* //////////////////////////////////////////////// Kategorien /////////////////////////////////////////// */
/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */

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
        $stmt = $pdo->prepare("SELECT k.Bezeichnung, k.Beschreibung, count(e.Objekt_ID) AnzahlExp FROM Kategorie k
        LEFT JOIN Exponat e on e.Kat_ID=k.Kat_ID
        WHERE k.Kat_ID=$kat_id
        GROUP BY k.Kat_ID
        ");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

    function show_kategorien(){
        //Kategorie zeigen
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT k.Kat_ID, k.Bezeichnung, k.Beschreibung, count(e.Objekt_ID) AnzahlExp FROM Kategorie k 
            LEFT JOIN Exponat e on e.Kat_id=k.Kat_id GROUP BY k.kat_ID
        ");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

    function delete_kategorie($kat_id){
        //Kategorie löschen
        $pdo = connect();
        $stmt = $pdo->prepare("DELETE FROM Kategorie WHERE Kat_ID=$kat_id");
        $stmt->execute();

        $stmt = $pdo->prepare("UPDATE Exponat SET Kat_ID=0 WHERE Kat_ID=$kat_id");
        $stmt->execute();
    }

    function validate_kategorie($kategorie){
        //überprüfen ob kategorie vorhanden
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Bezeichnung`  FROM `Kategorie`');
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $db_has_kategorie = false;

        for($index = 0; $index < count($values); $index++){
            if($values[$index]['Bezeichnung'] === $kategorie){
                $db_has_kategorie = true;
            }
        }
        return $db_has_kategorie;
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['add_kategorie']))){
        if($_POST['katName'] == ""){
            $_SESSION['status_msg'] = "kat_empty";
            $_POST = array();
            header("Location: ../index.php");
        }else if(validate_kategorie($_POST['katName'])){
            $_SESSION['status_msg'] = "kat_exists";
            $_POST = array();
            header("Location: ../index.php");
        }
        else{
            add_kategorie($_POST['katName'],$_POST['katBeschreib']);
            $_SESSION['status_msg'] = "kat_added";
            $_SESSION['routing'] = "show_all_kat";
            header("Location: ../index.php");
        }

    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['edit_kategorie']))){
        if($_POST['kat_name'] == ""){
            $_SESSION['status_msg'] = "kat_empty";
            $_POST = array();
            header("Location: ../index.php");
        }else{
            edit_kategorie($_POST['kat_id'],$_POST['kat_name'],$_POST['kat_beschreibung']);
            $_SESSION['status_msg'] = "kat_added";
            header("Location: ../index.php");
        }
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_kategorie']))){
        show_kategorie($_POST['kat_id']);
    }
    if(($_SERVER['REQUEST_METHOD']==='POST') && ($_POST['routing'] == "delete_kat")){
        delete_kategorie($_POST['kat_id']);
        $_SESSION['routing'] = "show_all_kat";
        $_SESSION['status_msg'] = "kat_deleted";
        header("Location: ../index.php");
    }

/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
/* //////////////////////////////////////////////// STANDORTE //////////////////////////////////////////// */
/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
    function show_standorte(){
        //alle Standorte zeigen
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT s.Standort_ID, s.Name, COUNT(e.Objekt_ID) AnzahlExp FROM Standort s
        LEFT JOIN Exponat e on e.Standort_ID=s.Standort_ID
        GROUP BY s.Standort_ID
        ");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

    function show_standort($standort_id){
        //einen Standort zeigen
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT s.Standort_ID, s.Name, COUNT(e.Objekt_ID) AnzahlExp FROM Standort s
        LEFT JOIN Exponat e on e.Standort_ID=s.Standort_ID
        WHERE s.Standort_ID=$standort_id 
        GROUP BY s.Standort_ID
        ");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

    function add_standort($standort_name){
        //Standort anlegen
        $pdo = connect();
        $stmt = $pdo->prepare("INSERT INTO Standort (Name) VALUES ('$standort_name')");
        $stmt->execute();
    }

    function edit_standort($standort_id,$standort_name){
        //Standort bearbeiten
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Standort SET Name='$standort_name' WHERE Standort_ID=$standort_id");
        $stmt->execute();
    }
    function delete_standort($standort_id){
        /* alle zugeordneten Exponate in default_standort verschieben */
        /* Standort löschen */
        $pdo = connect();
        $stmt = $pdo->prepare("DELETE FROM Standort WHERE Standort_ID=$standort_id");
        $stmt->execute();
        
        $stmt = $pdo->prepare("UPDATE Exponat SET Standort_ID=0 WHERE Standort_ID=$standort_id");
        $stmt->execute();
    }

    function validate_standort($standort){
        //überprüfen ob Standort vorhanden
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Name`  FROM `Standort`');
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $db_has_standort = false;

        for($index = 0; $index < count($values); $index++){
            if($values[$index]['Name'] === $standort){
                $db_has_standort = true;
            }
        }
        return $db_has_standort;
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['add_standort']))){
        if ($_POST['standortName'] === "") {
            $_POST = array();
            $_SESSION['status_msg'] = "standort_empty";
        } elseif (validate_standort($_POST['standortName'])) {
            $_POST = array();
            $_SESSION['status_msg'] = "standort_exists";
        } else {
            $_SESSION['status_msg'] = "standort_added";
            add_standort($_POST['standortName']);
        }
        header("Location: ../index.php");
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['edit_standort']))){
        if($_POST['standortName'] == ""){
            $_SESSION['status_msg'] = "standort_empty";
        }
        else{
            edit_standort($_POST['standort_id'],$_POST['standortName']);
            $_SESSION['status_msg'] = "standort_added";
        }
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_standort']))){
        show_standort($_POST['standort_id']);
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && $_POST['routing'] === 'show_standorte'){
        show_standorte();
    }
    if(($_SERVER['REQUEST_METHOD']==='POST') && $_POST['routing'] === 'delete_standort'){
        delete_standort($_POST['standort_id']);
        $_SESSION['routing'] = "show_all_standort";
        $_SESSION['status_msg'] = "standort_deleted";
        header("Location: ../index.php");
    }

/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
/* //////////////////////////////////////// Benutzerverwaltung /////////////////////////////////////////// */
/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
    /*
        nutzer_id - wird fortlaufend vergeben
        anmeldung - Anmeldename - Pflicht
        Recht - Zugriffsberechtigung - 0 (Standard), 1 (Admin)
        pw - Passwort - Pflicht
        Anzeigename - Standardwert, Anmeldung falls nichts
        geloescht - 1 wenn gelöscht
    */

    function create_user($anmeldung,$recht,$passwort,$anzeigename){
        //Nutzer anlegen
        $pdo = connect();
        $passwort=password_hash($passwort,PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO `Nutzer` (`Anmeldung`, `Recht`, `pw`, `Anzeigename`) VALUES ('$anmeldung',$recht,'$passwort','$anzeigename')");
        $stmt->execute();     
    }

    function edit_user($nutzer_id,$anmeldung,$recht,$anzeigename){
        //Nutzer bearbeiten
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE `Nutzer` SET `Anmeldung`='$anmeldung', `Recht`=$recht, `Anzeigename`='$anzeigename' WHERE NUTZER_ID=".$nutzer_id);
        $stmt->execute();        
    }

    function delete_user($nutzer_id){
        //Nutzer löschen
        $pdo = connect();
        $stmt = $pdo->prepare('DELETE FROM `Nutzer` WHERE NUTZER_ID='.$nutzer_id);
        $stmt->execute();        
    }

    function show_users(){
        // eine Übersicht aller Nutzer ausgeben
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `Nutzer_ID`, `Anmeldung`, `Recht`, `Anzeigename`  FROM `Nutzer`');
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
    function validate_username($username){
        $pdo = connect();
        $stmt = $pdo->prepare('SELECT `ANMELDUNG`  FROM `Nutzer`');
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $db_has_username = false;

        for($index = 0; $index < count($values); $index++){
            if($values[$index]['ANMELDUNG'] === $username){
                $db_has_username = true;
            }
        }
        return $db_has_username;
    }
    function get_password_hash($username){
        // mit ID einen einzelnen Nutzer ausgeben
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT `pw`  FROM `Nutzer` WHERE ANMELDUNG='$username'");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $values[0]['pw'];
    }
    function get_user_data($username){
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT *  FROM `Nutzer` WHERE ANMELDUNG='$username'");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $values;
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['routing'])) && ($_SESSION['anmelde_id'] !== NULL)){
        $_SESSION['routing'] = $_POST['routing'];
        if ($_POST['routing'] == 'delete' || $_POST['routing'] == 'show_all' || $_POST['routing'] == 'edit' || $_POST['routing'] == 'show_exp') {
            if (!empty($_POST['exp_id'])) $_SESSION['exp_id'] = $_POST['exp_id'];
            if ($_POST['routing'] == 'delete'){
                delete_exponat($_POST['exp_id']);
                $_SESSION['routing'] = 'show_all';
                $_SESSION['exp_id'] = null;
            }
        }
        if ($_POST['routing'] == 'show_users' || $_POST['routing'] == 'add_user') {
            if(($_POST['anmeldung'] == "") && ($_POST['anzeigename'] == "") && ($_POST['passwort'] == "") && ($_POST['passwort2'] == "")){
                header("Location: ../index.php");
            }
            if (!empty($_POST['nutzer_id'])) {
                $_SESSION['nutzer_id'] = $_POST['nutzer_id'];
            } 
            if (!empty($_POST['speichern']) && $_POST['speichern'] == '1') {
                if ($_POST['routing'] == 'add_user') {
                    if(!empty($_POST['anmeldung'])){
                        if(validate_username($_POST['anmeldung'])){
                            $_POST = array();
                            $_SESSION['status_msg'] = "username_exists";
                            header("Location: ../index.php");
                        }
                    }
                    else{
                        $_POST = array();
                        $_SESSION['status_msg'] = "username_empty";
                    }
                    if($_POST['passwort'] === "" || $_POST['passwort2'] === ""){
                        $_POST = array();
                        $_SESSION['status_msg'] = "password_empty";
                    }
                    else if($_POST['passwort'] !== $_POST['passwort2']){
                        $_POST = array();
                        $_SESSION['status_msg'] = "password_not_equal";
                    }
                    else{
                        create_user($_POST['anmeldung'],$_POST['recht'],$_POST['passwort'],$_POST['anzeigename']);
                        $_SESSION['status_msg'] = "";
                        $_SESSION['routing'] = "show_users";
                    }
                }
            }
        }
        if ($_POST['routing'] == "edit_user"){

            $_SESSION['nutzer_id'] = $_POST['nutzer_id'];

            if(!empty($_POST['speichern']) && $_POST['speichern'] == '1'){
                edit_user($_POST['nutzer_id'],$_POST['anmeldung'],$_POST['recht'],$_POST['anzeigename']);
                $_SESSION['status_msg'] = "";
                $_SESSION['routing'] = "show_users";
            }
        }
        if ($_POST['routing'] == 'show_all_kat' || $_POST['routing'] == 'show_kat' || $_POST['routing'] == 'edit_kat') {
            if (!empty($_POST['kat_id'])) $_SESSION['kat_id'] = $_POST['kat_id'];
        }
        if ($_POST['routing'] == 'show_all_standort' || $_POST['routing'] == 'show_standort' || $_POST['routing'] == 'edit_standort') {
            if (!empty($_POST['standort_id'])) $_SESSION['standort_id'] = $_POST['standort_id'];
        }
        header("Location: ../index.php");
    }
/*Anmeldung  */

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['delete_user']))){
        delete_user($_POST['nutzer_id']);
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_users']))){
        show_users();
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_user']))){
        show_user($_POST['nutzer_id']);
    }

    if(($_SERVER['REQUEST_METHOD']==='POST') && ($_SESSION['anmelde_id'] === NULL)){

        $username = $_POST['nutzername'];

        if(validate_username($username)){

            $password_db = get_password_hash($username);

            if(password_verify($_POST['passwort'], $password_db)){
                $_SESSION['anmelde_id'] = get_user_data($username)[0]['Nutzer_ID'];
                $_SESSION['anmelde_name'] = get_user_data($username)[0]['Anzeigename'];
                $_SESSION['recht'] = get_user_data($username)[0]['Recht'];
                $_SESSION['status_msg'] = "";
                header("Location: ../index.php");
            }
            else{
                $_SESSION['status_msg'] = "wrong_pw";
                header("Location: ../index.php");
            }
        }
        else{
            $_SESSION['status_msg'] = "wrong_username";
            header("Location: ../index.php");
        }
    }
    elseif(($_SESSION['anmelde_id'] !== NULL) && (isset($_POST['sign_out']))){
        $_SESSION = array();
        $_POST = array();
        header("Location: ../index.php");
    }

    if(($_SERVER['REQUEST_METHOD'] === "POST") && isset($_POST['delete_user']) && ($_POST['delete_user'] === "delete")){
        delete_user($_POST['nutzer_id']);
        header("Location: ../index.php");
    }

/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */
/* //////////////////////////////////////// Audit Log //////////////////////////////////////////////////// */
/* /////////////////////////////////////////////////////////////////////////////////////////////////////// */

function write_log($made_changes, $log_add_edit, $log_type, $log_obj_id){
    // id -> von DB vergeben
    $date = date("Y:m:d-H:i");
    $edit_user_id = $_SESSION['anmelde_id'];
    // alle Änderungen als Text
    $made_changes = arrayToString($made_changes);
    // Arten von Objekten: 0-Exp, 1-Kat, 2-Standorte, 3-Nutzer
    $log_add_edit = $log_add_edit; // gibt an ob Objekt hinzugefügt / bearbeitet / gelöscht wurde
    $log_type = $log_type;
    $log_obj_id = $log_obj_id;

    $pdo = connect();
    $stmt = $pdo->prepare("INSERT INTO Log(`Log_Datum`,`Log_Text`,`Edit_Nutzer_ID`,`Log_add_edit`,`Log_Typ`,`Log_Obj_ID`) values (now(),'$made_changes','$edit_user_id','$log_add_edit',$log_type,$log_obj_id)");
    $stmt->execute();

    /*
    $stmt = $pdo->prepare("INSERT INTO Exponat (`Exp-Nr`, `Titel`, `Beschreibung`, `Hersteller`, `Baujahr`, `Wert`, `OrigPreis`, `Herkunft`, `Abmessungen`,
        `Material`, `Ausstellung`, `Interesse`, `Kat_ID`, `Zu_ID`, `Standort_ID`) 
        values ('$number','$title','$description','$producer','$production_year','$price_today','$price_original','$origin','$dimensions',
        '$material','$events','$visitor_interests',$kat_id,$zu_id,$location_id)");
    */
}
function show_log(){
    $pdo = connect();
    $stmt = $pdo->prepare('SELECT * FROM `Log`');
    $stmt->execute();
    $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>