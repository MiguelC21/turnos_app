

//FUNCION PARA BUSCAR PERMISOS
function buscarTurno(){
    obtenerTurnos();
    $('#buscarT').keyup(function(){
        buscar();
    })
}

function buscar(){
    if($('#buscarT').val()){
        let buscarT = $('#buscarT').val();
        
        $.ajax({
            url: '../modelos/turnos/turnosVer.php',
            type: 'POST',
            data: { buscarT },
            
            success: function (respuesta){
            
                // console.log(respuesta);
                let busqueda = JSON.parse(respuesta);
                let template = '';
                let n=1;
                busqueda.forEach(obj => {
                    template += `<tr>
                        <td id="turnoId" hidden>${obj.turnoId}</td>
                        <td >${n}</td>
                        <td >${obj.nombre}</td>
                        <td>${obj.apellido}</td>
                        <td>${obj.telefono}</td>
                        <td>${obj.puestoTrabajo}</td>
                        <td>${obj.horaInicio}</td>
                        <td>${obj.horaFin}</td>
                        <td>${obj.fechaTurno}</td>
                        <td>${obj.observacion}</td>
                    </tr>`
                    n++;
                });
                
                $('#datosTabla').html(template);
                
            }
            
        })
    }else{
        obtenerTurnos();
    }
}



//Funcion para obtener todos los permisos

function obtenerTurnos(){
    $.ajax({
        url: '../modelos/turnos/turnosVer.php',
        type: "GET",
        
        success: function (respuesta){
            
            // console.log(respuesta);
            let busqueda = JSON.parse(respuesta);
            let template = '';
            n=1;
            busqueda.forEach(obj => {
                template += `<tr>
                    <td id="turnoId" hidden>${obj.turnoId}</td>
                    <td >${n}</td>
                    <td >${obj.nombre}</td>
                    <td>${obj.apellido}</td>
                    <td>${obj.telefono}</td>
                    <td>${obj.puestoTrabajo}</td>
                    <td>${obj.horaInicio}</td>
                    <td>${obj.horaFin}</td>
                    <td>${obj.fechaTurno}</td>
                    <td>${obj.observacion}</td>
                </tr>`
                n++;
            });

            $('#datosTabla').html(template);

        }
    })


    }

    $('#generarTurno').submit(function(e){

        e.preventDefault();

        const datosForm ={
            fechaUser: $('#fechaInicio').val(),
        }
        // console.log(datosForm);
        $.post("../modelos/turnos/generarTurno.php", datosForm, function (respuesta) {
            $('#generarTurno').trigger('reset');
            msg = JSON.parse(respuesta)
            console.log(msg)
            if(msg == 'error'){
                swal("Error al generar", "El numero de empleados disponibles no son suficientes para cubrir la totalidad de turnos activos actualmente.");
            }else{

                setTimeout(300);
                $('#generaExcel').click()

                buscarTurno();

                swal({ //Alerta registro exitoso
                    title: "Accion exitoxa!",
                    text: "Generando excel... Espera unos segundos",
                    icon: "success",
                    }
                );
            }
        
        });
    })

// Ejecucion de las funciones
buscarTurno();