$(document).ready(function() {
    $(id_one).on('change', function(){
        var Id_select_1 = $(this).val();
        if(Id_select_1) {
            $.ajax({
                url: ruta+ '/'+Id_select_1,
                type:"GET",
                dataType:"json",
                beforeSend: function(){
                    $('#loader').css("visibility", "visible");
                },
                success:function(data) {
                    $(id_two).empty();
                    $.each(data, function(key, value){
                        $(id_two).append('<option value="'+ key +'">' + value + '</option>');
                    });
                },
                complete: function(){
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $(id_two).empty();
        }
    });
});

function selectDinamico(Id_select_1, Id_select_2, ruta){
    // Bloqueamos el SELECT de los select2
    $(Id_select_2).prop('disabled', true);

    // Hacemos la lógica que cuando nuestro SELECT cambia de valor haga algo
    $(Id_select_1).change(function () {
        // Guardamos el select de select2
        var select2 = $(Id_select_2);

        // Guardamos el select de select2
        var select2 = $(this);

        if ($(this).val() != '') {
            $.ajax({
                url: ruta + "/" + $(this).val(),
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    select2.prop('disabled', true);
                },
                success: function (r) {
                    select2.prop('disabled', false);

                    // Limpiamos el select
                    select2.find('option').remove();

                    $(r).each(function (i, v) { // indice, valor
                     select2.append('<option value="' + v.id + '">' + v.Nombre + '</option>');
                    })

                    select2.prop('disabled', false);
                },
                error: function () {
                    alert('Ocurrio un error en el servidor ..');
                    select2.prop('disabled', false);
                }
            });
        }
        else {
         select2.find('option').remove();
         select2.prop('disabled', true);
        }
    })
}