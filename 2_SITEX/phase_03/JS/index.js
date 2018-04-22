var myData = [];

function appelAjax(elmt){
    $.ajaxSetup({"processData" : false, "contentType": false});
    //console.log(arguments.callee.name,elmt);
    var data = new FormData();
    var request ='unknownUri';
    switch(true){
        case Boolean(elmt.href):
            request = $(elmt).attr('href').split(".html")[0];
            break;
        case Boolean(elmt.action):
            request = $(elmt).attr('action').split('.html')[0];
            data = new FormData(elmt);
            break;
    }
    data.append('senderId',elmt.id);
    $.post('?rq=' + request,data, gereRetour);
}

function testJson(json){
    var parsed;
    try {
        parsed = JSON.parse(json);
    } catch (e) {
        parsed = {'jsonError' : {'error': e , 'json' : json }}
    }
    return parsed;
}

function makeTheadObject(el, type='Array'){
    var out = '<thead>\t<tr>\n\t\t<th>' +(type == 'Array' ? 'index' : 'clé') + '</th>'
        + Object.keys(el).map(function(x){return '\t\t<th>' + x + '</th>'}).join('\n')
        + '\t</tr>\n</thead>\n';
    return out;
}

function makeTheadArray(el, type='Array'){
    var out = '<thead>\t<tr>\n\t\t<th>' +(type == 'Array' ? 'index' : 'clé') + '</th>'
       + Object.keys(el).map(function(x){return '\t\t<th>col_' + x + '</th>'}).join('\n')
       + '\t</tr>\n</thead>\n';
    return out;
}

function makeTbody(tab, type ='Array'){
    var out = '<tbody>'
       + Object.keys(tab)
           .map(function(k){ return '\t<tr id=' + (type == 'Array' ? 'lig_' : '') + k + '>\n\t\<td>' + k + '</td>\n'
               + Object.keys(tab[k])
                   .map(function(x){return '\t\t<td>'+ tab[k][x] + '</td>';}).join('\n')
               + '</tr>';
           }).join('\n')
       + '</tbody>';
    return out;
}

function makeTableFromObject(tab){
    var firstElement = tab[Object.keys(tab)[0]];
    var elementType = firstElement.constructor.name;
    var fonction = 'makeThead' + elementType;
    var out = '<table class="myTab '+ elementType +'">'
        + window[fonction](firstElement,elementType)
        + makeTbody(tab,'Object')
        + '</table>';
    return out;
}

function makeTableFromArray(tab){
    var firstElement = tab[Object.keys(tab)[0]];
    var elementType = firstElement.constructor.name;
    var fonction = 'makeThead' + elementType;
    var out = '<table class="myTab '+ elementType +'">'
        + window[fonction](firstElement,elementType)
        + makeTbody(tab,'Array')
        + '</table>';
    return out;
}

function makeTable(tab){
    var fonction = 'makeTableFrom' + tab.constructor.name;
    var out = window[fonction](tab);
    return out;
}

function makeOptions(l, v, a) {
    l.map(function(o) {
        return '<option value=' + o[v] + '>' + o[a] + '</option>\n'
    }).join('\n');
}
/*

function makeOptions (l,v,a){ //liste via req sql, proprietÃ© pour la value, nom pour l'affichage.
    return l.map(function(option){
        return  '<option value=' + option[v] + '>' + option[a] + '</option> ';
    }).join('\n');
}
 */
function gereRetour(retour) {
    retour = testJson(retour);
    var destination = '#contenu';
    if ($(retour['destination']).length > 0) {
        destination = retour['destination'];
        delete (retour['destination']);
    }
    for (let action in retour) {
        switch (action) {
            case 'display' :
                $("#contenu").html(retour[action]).fadeIn(500);
                break;
            case 'debug' :
            case 'error' :
                $("#" + action).html(retour[action]).fadeIn(500);
                break;
            case 'makeTable' :
                var table = makeTable(retour[action]);
                $("#contenu").html(table).fadeIn(500);
                break;
                //return $("#debug").html(table).fadeIn(500);
            case 'jsonError' :
                var html = "<p><b>Error :</b></p>" +
                    retour[action].error +
                    "<hr><p><b>Json :</b></p>" +
                    retour[action].json;
                $("#"+ action).html(html).fadeIn(500);
                break;
            case 'formTP05' :
                $("#contenu").html(retour[action]).fadeIn(500);
                $("#formSelect").change(function() {
                    appelAjax(this.parentElement);
                });
                break;
            case 'data' :
                //$('#debug').html(makeTable(JSON.parse(retour[action]))).fadeIn(500);
                myData['allGroups'] = JSON.parse(retour[action]);
                $('#formSelect').html(makeOptions(myData.allGroups, 'nom', 'nom'));
                break;
            default :
                console.log('action inconnue :' + action);
                console.log(retour[action]);
                break;
        }
    }
}

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

    $("#menu a:first").addClass('selected');

    $('.menu a').click(function(event){
        event.preventDefault();
        $(".menu a").removeClass('selected');
        $(this).addClass('selected');
        appelAjax(this);
    });

    /* Phase 2 - 4.2 */
    $("<section id='gestion'></section>").insertAfter("#global");

    var gestion = $("#gestion");

    gestion.append("<aside id='error'></aside>")
        .append("<aside id='message'></aside>")
        .append("<aside id='debug'></aside>")
        .append("<aside id='jsonError'></aside>")
        .append("<aside id='kint'></aside>");

    gestion.children().hide();

    gestion.children().dblclick(function(){
        $(this).fadeOut(500);
    });
});
