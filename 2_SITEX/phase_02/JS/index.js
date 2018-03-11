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

    /*$(".menu a").click(appelAjax);*/
    $('.menu a').click(function(event){
       event.preventDefault();
       $(".menu a").removeClass('selected');
       $(this).addClass('selected');
       appelAjax(this);
    });
    /* Phase 2 - 3.2 */
    // $("<section id='gestion'></section>").insertAfter("#global");
    // $("#gestion").append("<aside id='error'></aside>");
    // $("#error").hide();
    /* Phase 2 - 3.4 */
   /* $("aside#error").dblclick(function(){
        $("aside#error").fadeOut(0.5);
    });*/
    /* Phase 2 - 4.2 */
    $("<section id='gestion'></section>").insertAfter("#global");
    $("#gestion").append("<aside id='error'></aside>")
        .append("<aside id='message'></aside>")
        .append("<aside id='debug'></aside>")
        .append("<aside id='jsonError'></aside>")
        .append("<aside id='kint'></aside>");
    // $("#gestion").children().hide();

    $("#gestion").children().dblclick(function(){
        $("#gestion").children().fadeOut(0.5);
    });
});

function appelAjax(elmt){
    var request = $(elmt).attr('href').split('.html')[0];
    $.get('index.php?rq=' + request, gereRetour);
}

function gereRetour(retour){
    retour = testJson(retour);
    for (var action in retour){
        switch(action){
            case 'display' :
                $("main").html(retour[action]);
                $("main").fadeIn();
                break;
            case 'error':
                $("#error").html(retour[action]);
                $("#error").fadeIn();
               /* $("#error").click(function(){
                    $("#error").html(retour[action]);
                    $("#error").fadeIn();
                });*/
                break;
            default :
                console.log('action inconnue :' + action);
                console.log(retour[action]);
                break;
        }
    }
}

function testJson(json){
    var parsed;
    try {
        parsed = JSON.parse(json);
    } catch (e) {
        console.log('jsonError:' + json);
    }
    return parsed;
}

