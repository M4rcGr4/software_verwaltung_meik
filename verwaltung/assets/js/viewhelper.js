function toggleSidebar(){
    const sidebar = document.querySelector('.sidebar');
    const container = document.querySelector('.container');
    sidebar.classList.toggle('disabled');
    container.classList.toggle('disabled');

}
function toggleAnimation(){
    const sidebar = document.querySelector('.sidebar');
    const container = document.querySelector('.container');
    sidebar.classList.toggle('animated');
    container.classList.toggle('animated');
}
document.addEventListener('DOMContentLoaded', () => {
    const menu = document.querySelector('.sidebar .menu i');

    menu.addEventListener('click', () => {
        toggleSidebar();
    });
});

function checkScreenSize() {
    if (window.innerWidth < 751) { // Prüft, ob die Bildschirmbreite kleiner als 600px ist
        toggleAnimation();
        toggleSidebar();
        setTimeout(function() {
            toggleAnimation();
        }, 100);
    }
}

// Führe die Funktion einmal beim Laden der Seite aus
checkScreenSize();