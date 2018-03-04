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

    /* Rendre les liens des crédits ouvrable dans une nouvelle fenetre */
    $("#credits a").attr("target","_blank");

    /* Phase 01.01 */
    $("#menu a:first").addClass('selected');

    $(".menu a").click(function(event){
        event.preventDefault(); // prévenir
        $(".menu a").removeClass('selected');
        $(this).addClass('selected');
        appelAjax(this);
    });
});

function appelAjax(event){
   event.preventDefault();
   console.log(this);
   var request = $(this).attr('href').split('.html')[0];
   // phase 0.8 appelAjax a la place d'appelHTML
   $.get('/TP/2T/RES/appelAjax.php?rq=' + request, gereRetour);
}

function gereRetour(retour){
    retour = testJson(retour);
    $("#contenu").html(retour);
}

function testJson(json){
    var parsed;
    try {
        parsed = JSON.parse(json);
        parsed = "C'est bien du JSON dont les clés sont : <hr>"
                + Object.keys(parsed).join(" - ")
                + "<hr>"
                + json ;

    } catch (e) {
        parsed = json;
    }
    return parsed;
}

