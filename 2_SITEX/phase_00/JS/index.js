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

    $(".menu a").click(appelAjax);
});

function appelAjax(event){
   event.preventDefault();
   console.log(this.attributes.href.value);
   var request = $(this).attr('href').split('.html')[0];
   $.get('/TP/2T/RES/appelHTML.php?rq=' + request, function (retour){
        $("#contenu").html(retour);
   });
}