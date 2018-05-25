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

function makeOptions(list, value, txt) {
    return list.map(function(o) {
        return '<option value=' + o[value] + '>' + o[txt] + '</option>\n'
    }).join('\n');
}

function filtrage() {
    var v = $(this).val();
    $(this).removeClass();
    switch($(this).parent().find("input:checked").val()){
        case 'I':
            $(this).addClass('I');
            break;
        case 'B':
            v = '^' + v ;
            $(this).addClass('B');
            break;
        case 'E':
            v += '$';
            $(this).addClass('E');
            break;
    }
    var r = new RegExp(v,'i');
    var l = myData['allGroups'].filter(function(x){
        return x.nom.match(r)
    });
    //console.log(l);
    $('#formSelect').html(makeOptions(l,'nom','nom'));
}

function gereRetour(retour) {
    retour = testJson(retour);
    let destination = '#contenu';
    if($(retour['destination']).length > 0) { // si destination existe
        destination = retour['destination']; // prise en compte
        delete (retour['destination']); // on supprime la liste
    }
    $("#gestion aside").fadeOut(400);
    for (let action in retour) {
        switch (action) {
            case 'display' :
                $(destination).html(retour[action]).fadeIn(500);
                break;
            case 'kint':
            case 'debug':
            case 'error':
                $("#" + action).html(retour[action]).fadeIn(500);
                break;
            case 'makeTable' :
                var table = makeTable(retour[action]);
                //let destination = (retour['destination'] ? retour['destination'] : '#contenu');
                $(destination).html(table).fadeIn(500);
                break;
            case 'jsonError' :
                var html = "<p><b>Error :</b></p>" +
                    retour[action].error +
                    "<hr><p><b>Json :</b></p>" +
                    retour[action].json;
                $("#"+ action).html(html).fadeIn(500);
                break;
            case 'formTP05' :
                $(destination).html(retour[action]).fadeIn(500);
                $("#formSelect").change(function() {
                    appelAjax(this.parentElement);
                });
                $("#formSearch").submit(function(evnmt){evnmt.preventDefault();})
                    .find('input').keyup(filtrage);

                //$("#formSearch").find("input:checked").keyup(filtrage);
                $("#formSearch").find("input[type=radio]").change(function(){
                    $("#formSearch input[name=tp05Text]").trigger('keyup');
                });
                break;
            case 'data' :
                //$('#debug').html(makeTable(JSON.parse(retour[action]))).fadeIn(500);
                myData['allGroups'] = JSON.parse(retour[action]);
                $('#formSelect').html(makeOptions(myData.allGroups, 'nom', 'nom'));
                //console.log(makeOptions(myData.allGroups, 'nom', 'nom'));
                break;
            case 'montrer':
                $(retour[action]).fadeIn(500);
                break;
            case 'cacher':
                $(retour[action]).fadeOut(250);
                break;
            case 'formConfig':
                $(destination).html(retour[action]);
                $("#modifConfig").submit(function(evnt){
                    evnt.preventDefault();
                    appelAjax(this);
                });
                break;
            case 'formLogin':
                // attention le prof voulait section cachée /hidden
                $(destination).html(retour[action]);
                $("#formLogin").submit(function(evnt){
                    evnt.preventDefault();
                    appelAjax(this);
                });
                $("#logMdPP").click(function(evnt){
                    // l'appel ajax doit etre mis avant l'arret de propagation d'evnts
                    appelAjax(this);
                    evnt.preventDefault();

                });
                break;
            case 'layout':
                var infos = JSON.parse(retour[action]);
                $('#titre').html('<img id="logo" alt="logo" src="' + infos.logoPath + '" />' + infos.titre);
                break;
            case 'userConnu':
                myData['user'] = JSON.parse(retour[action]);
                $('#contenu').html('Bienvenue ' + myData['user'].uPseudo);
                $('#menu a[href="gestLog.html"]').text('Déconnexion');
                $('body').css('background', '#4C4F22');
                break;
            case 'logout':
                console.log('logout');
                delete (myData['user']);
                $('body').css('background', '');
                $('#menu a[href="gestLog.html"]').text('Connexion');
                $(destination).html('<div title="Déconnnexion">' + retour[action] + '</div>').find('div').dialog({
                    modal: true,
                    width: 100,
                    height: 70,
                    classes: {
                        'ui-dialog': 'dialOk'
                    },
                    resizable: false,
                    dragable: false,
                    position: {
                        my: 'right top',
                        at: 'center bottom+5',
                        of: '#menu a[href="gestLog.html"]'
                    }
                });
                break;
            default :
                console.log('action inconnue : ' + action);
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

    $('#menu').menu({
        position: { my: "center top", at: "center bottom+5" }
    });
});



/* Notes pour le filtrage dans textArea du formulaire TP05 */
// retourne le contenu du champ :
//          document.formSearch.tp05Text.value (document.[name du form].[name du textArea].[])
//   en regex :
//      var r = new RegExp('2t','i');
//      for (let x of myData.allGroups) console.log(x.nom.match(r))
// retourne les groupes contenant "v" dans le nom du groupe
//          myData['allGroups'].filter(function(x){return x.nom.indexOf(v)!== -1;})
//
// retourne les groupes dont le nom COMMENCENT par "v"
//          myData['allGroups'].filter(function(x){return x.nom.indexOf(v)=== 0;})
//
// ! plus complexe pour le "se termine par"
// On va la traduire par :
/* Si le contenu recherché est dans la chaine,
 la dernière position où on le trouve est « la longueur de la chaine - la longueur
 de ce qu'on recherche*/
/*    myData['allGroups'].filter(function(x){
          let lastPos=x.nom.lastIndexOf(v);
          return lastPos !=-1 && lastPos == (x.nom.length-v.length)
      })
*/

// TP05 7.6.3
// $('#formSearch').find('[name=tp05Text]').val(); ==> renvoit la valeur dans le champ texte du formulaire par le nom
//      ou
// $('#formSearch [name=tp05Text']).val();


