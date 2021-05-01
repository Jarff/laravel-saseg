require( 'datatables.net-bs4' );
require('datatables.net-bs4/css/dataTables.bootstrap4.min.css');
// require('datatables.net-select');

$(document).ready(function() {
    let dT = $('#dataTable').DataTable({
        "language": {
            "paginate": {
              "previous": "<",
              "next": ">"
            },
            "emptyTable": "No hay contenido disponible",
            "info": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando desde 0 hasta 0 de 0 registros",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontraron registros",
        },
        "columnDefs": [ {
            "orderable": false,
            "className": 'select-checkbox',
            "targets":   0
        } ],
        "select": {
            "style": 'os',
            "selector": 'td:first-child'
        },
        "order": [
            [0, 'desc']
        ]
    });
    // dT.on("click", "th.select-checkbox", function() {
    //     if ($("th.select-checkbox").hasClass("selected")) {
    //         dT.rows().deselect();
    //         $("th.select-checkbox").removeClass("selected");
    //     } else {
    //         dT.rows().select();
    //         $("th.select-checkbox").addClass("selected");
    //     }
    // }).on("select deselect", function() {
    //     ("Some selection or deselection going on")
    //     if (dT.rows({
    //             selected: true
    //         }).count() !== dT.rows().count()) {
    //         $("th.select-checkbox").removeClass("selected");
    //     } else {
    //         $("th.select-checkbox").addClass("selected");
    //     }
    // });
});