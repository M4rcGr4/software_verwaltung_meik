function decodeHTMLEntitiesUsingDOMParser(str) {
    // Hilfsfunktion für die Ausgabe
    // macht aus &amp; wieder ein &
    var parser = new DOMParser();
    var dom = parser.parseFromString('<!doctype html><body>' + str, 'text/html');
    return dom.body.textContent;
}

function get_values(){
    // die gespeicherten Werte werden aus der Datenbank geladen, in dem der PHP Controller aufgerufen wird
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../inc/controller.php?values=all', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var jsonResponse = JSON.parse(xhr.responseText);
            displayTodos(jsonResponse);
        }
    };
    xhr.send();
}

function addTodo(){
    var alertElement = document.querySelector('.alert');
    var inputElement = document.getElementById('todoinput');
    var inputValue = inputElement.value;

    if(inputValue === ""){
        // Warnmeldung wenn der Nutzer versucht einen leeren Input abzusenden
        alertElement.innerHTML = "Wert darf nicht leer sein!";
        alertElement.style.display = "block";
    }
    else{
        // Wert aus dem Input wird an den PHP Controller geschickt der diesen speichert
        fetch('./inc/controller.php?add=' + encodeURIComponent(inputValue) , {
            method: 'GET'
        });
        inputElement.value="";
        alertElement.style.display = "none";

        // danach werden die Daten wieder aus der DB ausgelesen
        // würde man das Element per js direkt ins DOM schreiben, hätte man die ID nicht welche in der Datenbank festgelegt wird
        // ist mit einem Timeout versehen, damit wird sichergestellt, dass erst der Speicherprozess der Datenbank abgeschlossen ist
        // bevor man die Daten wieder aus der DB ausliest
        setTimeout(function() {
            get_values();
        }, 100);
    }
}

function displayTodos(data) {
    var container = document.getElementById('todolist');
    container.innerHTML = "";
    
    data.forEach(function(item) {
        // Werte welche in der Datenbank als &amp; gespeichert werden wieder zurück zu & kodieren
        item.todo_value = decodeHTMLEntitiesUsingDOMParser(item.todo_value);

        // Erstelle ein neues Container-Div für jedes Element
        var todoItem = document.createElement('li');
        todoItem.className = 'todoitem';
        todoItem.id = "todo-" + item.id;
        
        // Erstelle ein P-Tag für den todo_value
        var value = document.createElement('p');
        value.textContent = item.todo_value;

        // Erstelle den edit button mit icon
        var edit = document.createElement('button');
        var editicon = document.createElement('i');
        editicon.className = 'fas fa-pencil-alt'; // FontAwesome Icon Klasse
        edit.appendChild(editicon);

        // Setze ein onclick Event auf den Button, damit man editieren kann
        edit.onclick = function() {
            editTodo(item.id);
        };

        // Erstelle den delete button mit icon
        var del = document.createElement('button');
        var delicon = document.createElement('i');
        delicon.className = 'far fa-times-circle';
        del.appendChild(delicon);

        del.onclick = function() {
            delTodo(item.id);
        };
        
        // Füge den p mit Wert sowie den Editier und den Lösch Button hinzu
        todoItem.appendChild(value);
        todoItem.appendChild(edit);
        todoItem.appendChild(del);
        
        // Füge das Container-Div zum Hauptcontainer hinzu
        container.appendChild(todoItem);
    });
}

function editTodo(id){
    var todoItem = document.getElementById('todo-' + id);
    var currentValue = todoItem.querySelector('p').textContent;

    // Ersetze <p> durch <input>
    var input = document.createElement('input');
    input.type = 'text';
    input.value = currentValue;

    // Ersetze den Edit-Button durch den Save-Button
    var saveButton = document.createElement('button');
    var saveIcon = document.createElement('i');
    saveIcon.className = 'far fa-check-circle'; // FontAwesome Save Icon
    saveButton.appendChild(saveIcon);

    // Setze das onclick-Event auf den Save-Button
    saveButton.onclick = function() {
        saveTodo(id, input.value);
    };

    // Ersetze das <p>-Element und den Button im DOM
    todoItem.replaceChild(input, todoItem.querySelector('p'));
    todoItem.replaceChild(saveButton, todoItem.querySelector('button'));

    // entferne den löschen button
    todoItem.removeChild(todoItem.children[2]);

    var editInput = todoItem.querySelector('input');

    // Event-Listener für das input Feld welches nach klick auf Edit generiert wurde
    // dadurch kann man mit klick auf Enter speichern
    editInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            saveTodo(id, input.value);
        }
    });
}
function saveTodo(id, newValue){
    fetch('./inc/controller.php?id=' + id + '&save=' + encodeURIComponent(newValue) , {
        method: 'GET'
    });
    var todoItem = document.getElementById('todo-' + id);

    // Ersetze <input> zurück durch <p>
    var newP = document.createElement('p');
    newP.textContent = newValue;

    // Ersetze den Save-Button zurück durch den Edit-Button
    var editButton = document.createElement('button');
    var editIcon = document.createElement('i');
    editIcon.className = 'fas fa-pencil-alt';
    editButton.appendChild(editIcon);

    // Setze das onclick-Event auf den Edit-Button
    editButton.onclick = function() {
        editTodo(id);
    };

    // Ersetze das <input>-Element und den Button im DOM
    todoItem.replaceChild(newP, todoItem.querySelector('input'));
    todoItem.replaceChild(editButton, todoItem.querySelector('button'));

    // Setze einen neuen Delete Button
    var del = document.createElement('button');
    var delicon = document.createElement('i');
    delicon.className = 'far fa-times-circle';
    del.appendChild(delicon);

    del.onclick = function() {
        delTodo(id);
    };

    todoItem.appendChild(del);
}
function delTodo(id) {
    // Entferne das Element aus dem DOM
    var itemElement = document.getElementById('todo-' + id);
    if (itemElement) {
        itemElement.remove();
    }

    fetch('./inc/controller.php?id=' + id + '&delete=true' , {
        method: 'GET'
    });
}