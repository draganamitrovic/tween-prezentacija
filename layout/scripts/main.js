function toggleMenu() {
    var x = document.getElementById("topbar-small");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}