$(document).ready(function(){
    $('.datepicker').datepicker({
        language: "es"
    });
    $('.dataTable').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se han encontrado registros.",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        }
    });
    $('.number').maskMoney({
        thousands: '.',
        precision: 0,
        allowZero: true
    });
    
    $('.dvInput, .rutInput').on('change',function(){
        var rut = $('.rutInput').val();
        var dv = getDV( rut.replace(/\./g,'') );
        if( $('.dvInput').val() != "" ){
            if( $('.dvInput').val() != dv ){
                if( !$('.rutInput').parent().hasClass('has-error') ){
                    $('.rutInput').parent().addClass('has-error');
                }
                $('.dvInput').val("");
                alert('El rut ingresado es incorrecto.');
            } else {
                if( $('.rutInput').parent().hasClass('has-error') ){
                    $('.rutInput').parent().removeClass('has-error');
                    $('.rutInput').parent().addClass('has-success');
                }
            }
        }
    });
    
    function getDV(numero) {
        nuevo_numero = numero.toString().split("").reverse().join("");
        for(i=0,j=2,suma=0; i < nuevo_numero.length; i++, ((j==7) ? j=2 : j++)) {
            suma += (parseInt(nuevo_numero.charAt(i)) * j); 
        }
        n_dv = 11 - (suma % 11);
        return ((n_dv == 11) ? 0 : ((n_dv == 10) ? "K" : n_dv));
    }
});