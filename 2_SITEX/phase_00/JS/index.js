$(document).ready(function(){

    /* Au chargement de la page */
    var credits = $("#credits");
    credits.hide();

    /* Evenements sur credits */
    var onWordCredits = $("span:contains('Crédits')");
    onWordCredits.mouseover(function(){
        credits.fadeIn();
    })

    onWordCredits.mouseleave(function(){
        credits.fadeOut();
    })
});

