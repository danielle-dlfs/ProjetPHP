function verif(){

    var extensionArray = ['jpg', 'jpeg', 'gif', 'png'];

    var fileSize = document.getElementById("file").files[0].size;
    var extFile = document.getElementById("file").value.split('.')[1].toLowerCase();

    console.log(extensionArray.indexOf(extFile)); // si extension ok retourne 0
    if (extensionArray.indexOf(extFile) < 0) {
        document.getElementById("send").disabled = true;
        document.getElementById("msgUpload").innerHTML = "Erreur : mauvaise extension";
    } else {
        document.getElementById("send").disabled = false;
        document.getElementById("msgUpload").innerHTML = "Taille du fichier : " + fileSize + " Mb";
    }
}