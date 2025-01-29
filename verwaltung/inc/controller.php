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
    }

    function edit_exponat(
        $exponat_id, $number, $title, $description, $producer, $production_year, $price_today, $price_original, $origin, $dimensions, $material, 
        $events, $visitor_interests, $kat_id, $zu_id, $location_id){
        /* Diese Funktion verändert ein Exponat*/
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Exponat SET `Exp-Nr`='$number', `Titel`='$title', `Beschreibung`='$description', `Hersteller`='$producer', `Baujahr`='$production_year',
            `Wert`='$price_today', `OrigPreis`='$price_original', `Herkunft`='$origin', `Abmessungen`='$dimensions', `Material`='$material', `Ausstellung`='$events',
            `Interesse`='$visitor_interests', `Kat_ID`=$kat_id, `Zu_ID`=$zu_id, `Standort_ID`=$location_id WHERE Objekt_ID=$exponat_id");
        $stmt->execute(); 
    }

    function delete_exponat($exponat_id){
        /*Exponat löschen*/
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE Exponat SET Zu_ID = -1 WHERE Objekt_ID=$exponat_id");
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
    
/* Ende Funktionen für Kategorien*/

/*Funktionen für Zustand und Standort */
    function show_zustaende($filter){
        //alle Zustände zeigen
        $wherestr='';
        if ($filter == 'nicht_geloescht') {
            $wherestr = 'WHERE ZU_ID > 0'; 
        }
        //Filter: nicht gelöscht
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT Zu_ID, Bezeichnung FROM Zustand $wherestr");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

        json_encode($values);
        return $values;
    }

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

/*Ende Funktionen für Zustand und Standort */

/*Entgegennehmen der Daten aus js und Weitergabe an Funktionen*/
if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['delete_user']))){
    delete_user($_POST['nutzer_id']);
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_users']))){
    show_users();
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_user']))){
    show_user($_POST['nutzer_id']);
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['get_exponat']))){
    get_exponat($_POST['exponat_id']);
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['get_exponate']))){
    get_exponate();
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['add_exponat']))){
    if(empty($_POST['expBaujahr'])){$_POST['expBaujahr'] = 0;}
    if(empty($_POST['expWert'])){$_POST['expWert'] = 0;}
    if(empty($_POST['expOrgPreis'])){$_POST['expOrgPreis'] = 0;}
    add_exponat($_POST['expName'],$_POST['expTitel'],$_POST['expBesch'],$_POST['expHersteller'],$_POST['expBaujahr'],$_POST['expWert'],$_POST['expOrgPreis'],$_POST['expHerkunft'],
         $_POST['expMaße'],$_POST['expMaterial'],$_POST['expVeranst'],$_POST['expNote'],$_POST['expKat'],$_POST['expZust'],$_POST['expStandort']
    );

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

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['add_kategorie']))){
    add_kategorie($_POST['katName'],$_POST['katBeschreib']);

    header("Location: ../index.php");
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['edit_kategorie']))){
    edit_kategorie($_POST['kat_id'],$_POST['kat_name'],$_POST['kat_beschreibung']);
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_kategorie']))){
    show_kategorie($_POST['kat_id']);
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['add_standort']))){
    add_standort($_POST['standortName']);
    
    header("Location: ../index.php");
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['edit_standort']))){
    edit_standort($standort_id,$standort_name);
}

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['show_standorte']))){
    show_standorte();
}

/* Hilfsfunktionen */

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

if(($_SERVER['REQUEST_METHOD']==='POST') && (!empty($_POST['routing'])) && ($_SESSION['anmelde_id'] !== NULL)){
    var_dump($_POST);
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
        echo "<br>";
        var_dump($_POST);
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

if(($_SERVER['REQUEST_METHOD']==='POST') && ($_SESSION['anmelde_id'] === NULL)){
    $username = $_POST['nutzername'];
    if(validate_username($username)){

        $password_db = get_password_hash($username);

        if(password_verify($_POST['passwort'], $password_db)){
            //echo "hurrayyyy, logged in";
            //echo "<br> Session Status nach Anmeldung: " . session_status() . "--- <br>";

            // nutzer-id und $is_admin aus db abrufen und in die Session speichern
            // routing anpassen -> wenn anmelde_id !== NULL -> überprüfe $is_admin und gestatte nur teile des routing

            $_SESSION['anmelde_id'] = get_user_data($username)[0]['Nutzer_ID'];
            $_SESSION['anmelde_name'] = get_user_data($username)[0]['Anzeigename'];
            $_SESSION['recht'] = get_user_data($username)[0]['Recht'];
            $_SESSION['status_msg'] = "";
            //session_write_close();
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
?>