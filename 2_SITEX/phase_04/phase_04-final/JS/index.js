var myData = [];

/**
 * Fonction loader au démarrage de la page
 */
$(document).ready(function() {

    /**
     * Page Initialization
     */

    var credits = $('#credits');
    credits.hide();

    // Set target to blank for all links in #credits
    $('#credits a').each(function() {
        $(this).attr('target', '_blanck');
    });

    // Set the first element of the menu to selected
    $('#menu a:first').addClass('selected');

    // Add section#gestion after div#global
    $('#global').after('<section id="gestion"></section>');
    $('#gestion').append('<aside id="error"></aside>')
                .append('<aside id="message"></aside>')
                .append('<aside id="debug"></aside>')
                .append('<aside id="jsonError"></aside>')
                .append('<aside id="kint"></aside>');
    $('#gestion aside').hide();

    // Crée le menu JQuery
    $('#menu').menu({
        position: {my: "center top+5", at: "center bottom+5"}
    });


    /**
     * Event Managment
     */

    // Affiche les liens du footer quand la souri est sur "crédits"
    $('#auteur + span').mouseover(function() {
        credits.fadeIn();
    });

    // Cache les liens du footer
    $('#copyright').mouseleave(function() {
        credits.fadeOut();
    });

    // Managment des evênements des liens du menu
    $('.menu a').click(function (event) {
        event.preventDefault();
        $('.menu a').removeClass('selected');
        $(this).toggleClass('selected');
        appelAjax(this);
    });

    // Hide #gestion aside on double click
    $('#gestion aside').dblclick(function() {
        $(this).fadeOut(500);
    });

});

/* ---------- GESTION DE RETOUR ---------- */

/**
 * Gère les retour envoyé par la fonction toSend de PHP
 * @param retour Données reçues
 */
function gereRetour(retour) {
    retour = testeJson(retour);
    var destination = '#contenu';
    if ($(retour['destination']).length > 0) {
        destination = retour['destination'];
        delete (retour['destination']);
    }
    $('#gestion aside').fadeOut(215);
    for (var action in retour) {
        switch (action) {

            /* ---------- AFFICHAGE ---------- */

            case 'cacher':
                $(retour[action]).fadeOut(500);
                break;

            case 'montrer':
                $(retour[action]).fadeIn(500);
                break;

            case 'layout':
                var infos = JSON.parse(retour[action]);
                $('#titre').html('<img id="logo" alt="logo" src="' + infos.logoPath + '" />' + infos.titre);
                break;

            case 'newMenu':
                $('#menu').replaceWith("<ul id='menu' class='menu'>" + retour[action] + "</ul>");
                $('#menu').menu({
                    position: {my: "center top+5", at: "center bottom+5"}
                });
                $('.menu a').click(function (event) {
                    event.preventDefault();
                    $('.menu a').removeClass('selected');
                    $(this).toggleClass('selected');
                    appelAjax(this);
                });
                break;

            /* ----------- FORMULAIRES ----------- */

            case 'formTP05':
                $('#contenu').html(retour[action]);
                $('#formSelect').change(function () {
                    appelAjax(this.form);
                });
                $('#formSearch').submit(function(evt) {
                    evt.preventDefault();
                }).find('input[name=tp05Text]').keyup(filtrage);
                $('#formSearch').find('input[type=radio]').change(function () {
                    $('#formSearch input[name=tp05Text]').trigger('keyup');
                });
                break;

            case 'formConfig':
                $('#contenu').html(retour[action]);
                $('#modifConfig').submit(function(evt) {
                    evt.preventDefault();
                    appelAjax(this);
                });
                break;

            case 'formLogin':
                $('#contenu').html(retour[action]);
                $('#formLogin').submit(function(evt) {
                    evt.preventDefault();
                    appelAjax(this);
                });
                $('#logMdPP').click(function(evt) {
                    appelAjax(this);
                    evt.preventDefault();
                });
                break;

            /* ----------- AUTHENTIFICATION ----------- */

            case 'userConnu':
                myData['user'] = JSON.parse(retour[action]);
                $('#contenu').html('Bienvenue ' + myData['user'].uPseudo);
                $('body').css('background', '#4C4F22');
                break;

            case 'logout':
                delete (myData['user']);
                $('body').css('background', '');
                $('#contenu').html('<div title="Déconnnexion">' + retour[action] + '</div>').find('div').dialog({
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
                $('#entete footer #enReact').remove();
                break;

            case 'peutPas':
                $('#debug').html('<div title="Gestion des droits">' + retour[action] + '</div>').find('div').dialog({
                    modal: true,
                    width: '12em',
                    height: 70,
                    classes: {
                        'ui-dialog': 'dialKo'
                    },
                    resizable: false,
                    dragable: false,
                    position: {
                        my: 'left top',
                        at: 'left top',
                        of: '#contenu'
                    }
                });
                break;

            case 'estRéac':
                $('#entete footer').append(retour[action]);
                break;

            /* ---------- UTILITAIRE ---------- */

            case 'display':
                $('#contenu').html(retour[action]);
                break;

            case 'kint':
            case 'debug':
            case 'error':
                $('#' + action).html(retour[action]).fadeIn(1200);
                break;

            case 'makeTable':
                var table = makeTable(retour[action]);
                $(destination).html(table).fadeIn(500);
                break;

            case 'jsonError':
                var html = '<b>Error : </b><br>'
                    + retour[action].error
                    + '<hr><b>Json : </b><br>'
                    + retour[action].json;
                $('#' + action).html(html).fadeIn(1200);
                break;

            case 'data':
                myData['allGroups'] = JSON.parse(retour[action]);
                $('#formSelect').html(makeOptions(myData.allGroups, 'nom', 'nom'));
                //$('#debug').html(makeTable(JSON.parse(retour[action]))).fadeIn(1200);
                break;
            /* ----------- DEFAUT ----------- */

            default:
                console.log('Action inconnue : ' + action);
                console.log(retour[action]);
                break;
        }
    }
}

/* ---------- FONCTIONS AJAX/JSON ---------- */

/**
 * Envoie une requete Ajax à la page index.php et envoie la requête demandée en GET
 * @param elem
 */
function appelAjax(elem) {
    $.ajaxSetup({processData: false, contentType: false});
    var data = new FormData();
    var request = 'unknownUri';
    switch (true) {
        case Boolean(elem.href):
            request = $(elem).attr('href').split(".html")[0];
            break;

        case Boolean(elem.action):
            request = $(elem).attr('action').split('.html')[0];
            data = new FormData(elem);
            break;
    }
    data.append('senderId', elem.id);
    $.post("?rq=" + request, data, gereRetour);

}

/**
 * Récupère le json passé en paramètre et le parse en objet JS
 * Si le parse échoue, renvoie l'erreur ensuite display par l'action jsonError
 * @param json
 * @returns {*}
 */
function testeJson(json) {
    var parsed;
    try {
        parsed = JSON.parse(json);
    } catch(e) {
        parsed = {"jsonError": {'error': e, 'json': json}};
    }

    return parsed;
}

/* ---------- FONCTIONS DE GENERATION DE CODE HTML ---------- */

/**
 * Construit une liste d'options HTML5 (select)
 * @param list Liste d'options
 * @param value Clé de la liste à utiliser pour la valeur de l'option
 * @param displayTxt Clé de la liste à utiliser comme texte à afficher dans l'option
 * @returns {string}
 */
function makeOptions(list, value, displayTxt) {
    var option ='';
    list.forEach(function(x) {
        option += '<option value=' + x[value] + '>' + x[displayTxt] + '</option>\n'
    });
    return option;
}

/**
 * Crée un tableau HTML5 sur base d'un tableau d'objets passé en paramètre
 * @param tab
 * @returns {string}
 */
function makeTableFromObject(tab) {
    var firstElement = tab[Object.keys(tab)[0]];
    var elementType = firstElement.constructor.name;
    var fonction = 'makeThead' + elementType;
    var out = '<table class="myTab ' + elementType +  '">'
            + window[fonction](firstElement, elementType)
            + makeTbody(tab, 'Object')
            + '</table>';

    return out;
}

/**
 * Crée un tableau HTML5 sur base d'un tableau de tableau passé en paramètre
 * @param tab
 * @returns {string}
 */
function makeTableFromArray(tab) {
    var firstElement = tab[Object.keys(tab)[0]];
    var elementType = firstElement.constructor.name;
    var fonction = 'makeThead' + elementType;
    var out = '<table class="myTab ' + elementType +  '">'
        + window[fonction](firstElement, elementType)
        + makeTbody(tab, 'Array')
        + '</table>';

    return out;
}

/**
 * Crée le Thead d'un tableau HTML5 pour des objets
 * @param el
 * @param type
 * @returns {string}
 */
function makeTheadObject(el, type='Array') {
    var out = '<thead>\t<tr>\n\t\t<th>' + (type == 'Array' ? 'index' : 'clé') + '</th>'
            + Object.keys(el).map(function(x) {return '\t\n<th>' + x + '</th>'}).join('\n')
            +'\t</tr>\n</thead>\n';

    return out;
}

/**
 * Crée le Thead d'un tableau HTML5 pour des arrays
 * @param el
 * @param type
 * @returns {string}
 */
function makeTheadArray(el, type='Array') {
    var out = '<thead>\t<tr>\n\t\t<th>' + (type == 'Array' ? 'index' : 'clé') + '</th>'
        + Object.keys(el).map(function(x) {return '\t\n<th>col_' + x + '</th>'}).join('\n')
        +'\t</tr>\n</thead>\n';

    return out;
}

/**
 * Crée le Tbody d'un tableau HTML5 pour un array
 * @param tab
 * @param type
 * @returns {string}
 */
function makeTbody(tab, type='Array') {
    var out = '<tbody>'
            + Object.keys(tab)
                    .map(function (k) { return '\t<tr id=' + (type == 'Array' ? 'lig_': '') + k + '>\n\t\t<td>' + k + '</td>\n'
                                                + Object.keys(tab[k])
                                                        .map(function(x) {return '\t\t<td>' + tab[k][x] + '</td>';}).join('\n')
                                                + '\t</tr>';
                    }).join('\n');
            + '</tbody>';

    return out;
}

/**
 * Crée un tableau HTML5 sur base du tableau passé en paramètre
 * @param tab
 * @returns {*}
 */
function makeTable(tab) {
    var fonction = 'makeTableFrom' + tab.constructor.name;
    var out = window[fonction](tab);
    return out;
}

/* ---------- FONCTIONS UTILS ---------- */

/**
 * Fonction événementielle
 * Filtre les groupes en fonction de l'input dans une barre de recherche
 * Effectue la cherche sur le début, le milieu ou la fin de la chaine selon la radiobox sélectionnée
 */
function filtrage() {
    var v = $(this).val();
    $(this).removeClass()
    switch($(this).parent().find('input:checked').val()) {
        case 'I': $(this).addClass('I'); break;
        case 'B': v = '^' + v; $(this).addClass('B'); break;
        case 'E': v += '$'; $(this).addClass('E'); break;
    }
    var r = new RegExp(v, 'i');
    var l = myData['allGroups'].filter(function(x) {
        return x.nom.match(r);
    });
    $('#formSelect').html(makeOptions(l, 'nom', 'nom'));
}