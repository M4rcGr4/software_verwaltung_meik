// Es gibt 2 Variablen: Route ist die Route welche geroutet wird, sessionRoute ist die Route welche für den Tab gespeichert wird
// dadurch landet man beim neuladen der Seite nicht wieder automatisch auf dem Dashboard, sondern auf der Seite (z.B. Todo) die man vorher
// bereits geöffnet hatte -> diese ist in der sessionRoute gespeichert

function routing(input) {
    if(input != null){
        // wenn man über onclick die funktion aufruft wird die sessionRoute gespeichert
        // dann wird die eigentliche Route auf die sessionRoute gesetzt
        sessionStorage.setItem("sessionRoute", input);
        route = sessionStorage.getItem("sessionRoute");
        // wenn der Bildschirm kleiner ist als 751px wird automatisch die Seitenleiste eingeklappt
        if (window.innerWidth < 751) { // Prüft, ob die Bildschirmbreite kleiner als 600px ist
            toggleSidebar();
        }
    }
    else{
        // es wird überprüft ob bereits eine Route gespeichert ist
        // beim neuladen ist eine Route gespeichert
        // beim ersten Seitenaufruf ist die gespeicherte Route null -> es wird standartmäßig dashboard als Route gespeichert
        // wenn schon eine Route gespeichert ist wird die sessionRoute nicht verändert
        // dann wird die Route auf sessionRoute gesetzt
        if(sessionStorage.getItem("sessionRoute") == null){
            sessionStorage.setItem("sessionRoute", 'dashboard');
        }
        route = sessionStorage.getItem("sessionRoute");
    }

    // die PHP Template Datei wird geladen und im DOM an der richtigen Stelle platziert (das ist mit routing gemeint)
    var xhr = new XMLHttpRequest();
    var url = "./templates/" + encodeURIComponent(route) + ".php";

    xhr.open("GET", url, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("anchor").innerHTML = xhr.responseText;
        }
    };

    xhr.send();

    // wenn die Route todo ist, werden die Funktion aufgerufen, welche die gespeicherten Datensätze aus der Datenbank ließt
    if(route == "todo"){
        get_values();

        setTimeout(function() {
            var todoInput = document.getElementById('todoinput');

            // Event-Listener für das input Feld bei ADD -> wird nur hinzugefügt wenn auf Todo geroutet wurde
            // hat einen Timeout von einer halben Sekunde damit sichergestellt ist, dass das Input Feld im DOM geladen wurde
            // dadurch kann man mit klick auf Enter speichern
            todoInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    addTodo();
                }
            });
        }, 500);
    }
}
// diese Datei wird bei jedem laden / neuladen der Seite geladen
// dabei wird einmalig die Routing Funktion ausgeführt
// sonst würde der Content nicht geladen werden
routing(); 