
function lezart(value) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("finished").innerHTML = this.responseText;
    }
    xhttp.open("GET", "lezart_rendeles_reszletes.php?id="+value);
    xhttp.send();
};
function folyamat(value) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.getElementById("progress").innerHTML = this.responseText;
    }
    xhttp.open("GET", "folyamat_rendeles_reszletes.php?id="+value);
    xhttp.send();
};
