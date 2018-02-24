$(document).ready(function(){

    /* Au chargement de la page */
    var credits = $("#credits");
    credits.hide();

    /* Evenements sur credits */
        $("span:contains('Crédits')").mouseover(function(){
        credits.fadeIn();
    });
    $("#copyright").mouseleave(function(){
        credits.fadeOut();
    });

    /* Rendre les liens des crédits "target blank" */
    $("#credits a").attr("target","_blank");

});

function appelAjax(){
    $.get('/TP/2T/RES/appelHTML.php?rq=config', function (retour){
       $("#contenu").html(retour);
    });
}