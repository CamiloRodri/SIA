var ChartFiltro;
var limite;
var url_base64 = [];

function crearGrafica(canvas = null, tipo, titulo = null,  etiquetas, etiquetasData, data = null) {
    var dynamicColorsArray = function (cantidad) {
        let colors =[];
        for (let i = 0; i < cantidad; i++) {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            colors.push("rgb(" + r + "," + g + "," + b + ")");
        }
        return colors

    };

    var dynamicColors = function () {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };

    var dataset = [];

    for (let i = 0; i < etiquetasData.length; i++){
        let aux = {};
        aux['label'] = etiquetasData[i];
        aux['data'] = data[i];
        if(tipo != 'line'){
            aux['backgroundColor'] = dynamicColorsArray(data[i].length);
        }
        else{    
            aux['borderColor'] = dynamicColors();
            aux['fill'] = false;
        }
        dataset.push(aux);
    }
    
   
    var jsonChart = {
        type: tipo,
        data: {
            labels: etiquetas,
            datasets: dataset,
        },
        options:{
            title:{
                display:true,
                text: titulo
            },
            animation: {
                onComplete: function (animation) {
                    if(url_base64.length < limite)
                        url_base64.push(this.toBase64Image());
                }
            },

            "scales": { 
            }

        },
    };
    if (tipo == 'bar' || tipo == 'horizontalBar'){
        jsonChart.options.scales = {
            "yAxes": [{
                "ticks": {
                    "beginAtZero": true
                }
            }],
            "xAxes": [{
                "ticks": {
                    "beginAtZero": true
                }
            }]
        };
    }

    var ctx = document.getElementById(canvas).getContext('2d');
    var myChart = new Chart(ctx, jsonChart);
    
    return myChart;
}

function peticionGraficasDocumentales(ruta) {
     $.ajax({
         url: ruta,
         type: 'GET',
         dataType: 'json',
         success: function (r) {
            $('.progress-bar').css('width', r.completado + '%').attr('aria-valuenow', r.completado);
            $('#graficas').removeClass('hidden');
            $('.progress-bar').text(r.completado + '% completado')
             
            
            crearGrafica('pie_completado', 'pie', 'Grado de completitud', ['Completado', 'Faltante'], ['adasd'], r.dataPie);
            crearGrafica('fechas_cantidad', 'line', 'Cantidad de archivos subidos por fecha',
                r.labels_fecha, ['cantidad'], r.data_fechas);

            ChartFiltro = crearGrafica('documentos_indicador', 'bar', 'Documentos subidos por indicador', r.labels_indicador,
                ['Cantidad'], r.data_indicador
            );
            
             
         },
         error: function () {
             alert('Ocurrio un error en el servidor ...');
         }
     });
}
var filtro;
var caracteristicas;
function peticionGraficasEncuestas(ruta) {
    $.ajax({
        url: ruta,
        type: 'GET',
        dataType: 'json',
        success: function (r) {
           $('#graficas').removeClass('hidden');
           filtro = crearGrafica('pie_filtro', 'doughnut',"Cantidad de Encuestados", r.labels_encuestado, ['adasd'], r.data_encuestado);
           crearGrafica('encuestados', 'bar', 'Cantidad de Encuestados', r.labels_encuestado,['Cantidad'], r.data_encuestado);
           caracteristicas = crearGrafica('caracteristicas', 'horizontalBar', r.data_factor, r.labels_caracteristicas,
           ['Valorización'], r.data_caracteristicas);
        },
        error: function(xhr,err)
        {
            alert("readyState: "+err.readyState+"\nstatus: "+err.status);
            alert("responseText: "+err.responseText);
        }
    });
}

var caracteristicas;
function peticionGraficasMejoramiento(ruta) {
    $.ajax({
        url: ruta,
        type: 'GET',
        dataType: 'json',
        success: function (r) {
           $('#graficas').removeClass('hidden');
           caracteristicas = crearGrafica('caracteristicas', 'horizontalBar', r.data_factor, r.labels_caracteristicas,
           ['Valorización'], r.data_caracteristicas);
        },
        error: function(xhr,err)
        {
            alert("readyState: "+err.readyState+"\nstatus: "+err.status);
            alert("responseText: "+err.responseText);
        }
    });
}


function peticionGraficasHistorial(ruta) {
    $.ajax({
        url: ruta,
        type: 'GET',
        dataType: 'json',
        success: function (r) {
            $('.progress-bar').css('width', r.completado + '%').attr('aria-valuenow', r.completado);
            $('#graficas').removeClass('hidden');
            $('.progress-bar').text(r.completado + '% completado')


            crearGrafica('pie_completado', 'pie', 'Grado de completitud', ['Completado', 'Faltante'], ['adasd'], r.dataPie);
            crearGrafica('fechas_cantidad', 'line', 'Cantidad de archivos subidos por fecha',
                r.labels_fecha, ['cantidad'], r.data_fechas);

            ChartFiltro = crearGrafica('documentos_indicador', 'bar', 'Documentos subidos por indicador', r.labels_indicador,
                ['Cantidad'], r.data_indicador
            );

            var select2 = $('#factor_documental');
            // Limpiamos el select
            select2.find('option').remove();
            select2.append('<option value="">-- Seleccione --</option>');
            $.each(r.factores, function (key, data) { // indice, valor
                select2.append('<option value="' + key + '">' + data + '</option>');
            });

            filtro = crearGrafica('pie_filtro', 'doughnut', "Cantidad de Encuestados", r.labels_encuestado, ['adasd'], r.data_encuestado);
            crearGrafica('encuestados', 'bar', 'Cantidad de Encuestados', r.labels_encuestado, ['Cantidad'], r.data_encuestado);
            caracteristicas = crearGrafica('caracteristicas', 'horizontalBar', r.factor_elegido, r.labels_caracteristicas,
                ['Valorización'], r.data_caracteristicas);

            var select2 = $('#factor');
            // Limpiamos el select
            select2.find('option').remove();
            select2.append('<option value="">-- Seleccione --</option>');
            $.each(r.data_factor, function (key, data) { // indice, valor
                select2.append('<option value="' + key + '">' + data + '</option>');
            });


        },
        error: function () {
            alert('Ocurrio un error en el servidor ...');
        }
    });
}