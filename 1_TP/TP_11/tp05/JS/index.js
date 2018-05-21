$(document).ready(function() {

    var data = new FormData();
    data.append('senderId', 'formTP05');
    data.append('select', '2T');
    $.ajax({
        url: "/he201409/2_SITEX/PHASE_03/index.php?rq=formSubmit",
        processData: false,
        contentType: false,
        method: 'POST',
        data: data
    }).done(traitement)

});

function traitement(json) {
    var data = JSON.parse(json).makeTable;
    var keys = Object.keys(data[0]);
    var columns = keys.map(function (x) { return {title: x} });
    var dataset = data.map(function (x) { return keys.map(function (xk) { return x[xk] }) });
    $('body').html('<table id="example" class="display" style="width: 100%"></table>');
    $('#example').addClass('nowrap').dataTable({
        data: dataset,
        columns: columns,
        responsive: true,
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.16/i18n/French.json" },
        lengthMenu: [[5, 10, 25, 50, -1], ['cinq', 10, 25, 50, 'toutes']]
    });
}