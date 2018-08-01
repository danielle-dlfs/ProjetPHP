function verif(img) {

    var acceptTypes = ['jpg', 'jpeg', 'png', 'gif'];

    var ext = img.value.split('.')[1].toLocaleLowerCase();

    var submitButton = document.getElementById('submitButton');

    if (acceptTypes.indexOf(ext) < 0) {
        submitButton.disabled = true;
        document.getElementById("infos").innerText = "L'extension du fichier n'est pas supportée";
    } else {
        submitButton.disabled = false;
        document.getElementById("infos").innerText = 'Taille du fichier : ' + img.files[0].size;
    }

}