$(document).ready(function() {
    $.ajax('charge.php').done(traitement);
});

function traitement(json){
    var data = JSON.parse(json).data; // on mémorise le contenu de l'item data
    var keys = Object.keys(data[0]);
    var columns = keys.map(function (x){ return {title: x} });
    var dataSet = data.map(function (x) { return keys.map(function (xk) { return x[xk] }) });
    $("body").html("<table id='example' class='display' style='width:100%'></table>");
    $("#example").dataTable({
        data : dataSet,
        columns : columns,
        responsive: true,
        language: {url : "https://cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"},
        lengthMenu: [[5, 10, 25, 50, -1], ['cinq', 10, 25, 50, 'toutes']],
        columnDefs: [{ targets: [-1, -3], className: 'dt-body-right' }]
        // pageLength: 10
    });
}