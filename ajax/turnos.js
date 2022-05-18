

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
            
                console.log(respuesta);
                let busqueda = JSON.parse(respuesta);
                let template = '';
                busqueda.forEach(obj => {
                    template += `<tr>
                        <td id="turnoId" hidden>${obj.turnoId}</td>
                        <td >${obj.nombre}</td>
                        <td>${obj.apellido}</td>
                        <td>${obj.telefono}</td>
                        <td>${obj.puestoTrabajo}</td>
                        <td>${obj.horaInicio}</td>
                        <td>${obj.horaFin}</td>
                        <td>${obj.fechaTurno}</td>
                        <td>${obj.observacion}</td>
                    </tr>`
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
            
            console.log(respuesta);
            let busqueda = JSON.parse(respuesta);
            let template = '';
            busqueda.forEach(obj => {
                template += `<tr>
                    <td id="turnoId" hidden>${obj.turnoId}</td>
                    <td >${obj.nombre}</td>
                    <td>${obj.apellido}</td>
                    <td>${obj.telefono}</td>
                    <td>${obj.puestoTrabajo}</td>
                    <td>${obj.horaInicio}</td>
                    <td>${obj.horaFin}</td>
                    <td>${obj.fechaTurno}</td>
                    <td>${obj.observacion}</td>
                </tr>`
            });

            $('#datosTabla').html(template);

        }
    })


    }


// Ejecucion de las funciones
buscarTurno();