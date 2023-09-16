const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

// Fonction pour fermer le menu burger
function closeMenu() {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}

// Ajoutez un écouteur de clic au hamburger
hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
});

// Ajoutez un écouteur de clic au document pour détecter les clics en dehors du menu
document.addEventListener("click", (event) => {
    const target = event.target;

    // Vérifiez si le clic est en dehors du hamburger et du menu
    if (!hamburger.contains(target) && !navMenu.contains(target)) {
        closeMenu(); // Fermez le menu si le clic est en dehors
    }
});

// Ajoutez également un écouteur de clic à chaque élément du menu pour le fermer lorsqu'un élément est cliqué
document.querySelectorAll(".nav-title").forEach((n) => {
    n.addEventListener("click", () => {
        closeMenu();
    });
});
