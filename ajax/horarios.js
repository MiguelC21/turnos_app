
//Funcion para insertar un nuevo horario
accion = "registrar"
$('#botonFrm').html('Registrar');
// Funcion para insertar Horarios
$('#formulario').submit(function(e){
    
    if (accion == "registrar"){
        console.log("Por aquí pase")
        const datosForm ={
            accion: accion,
            id: $('#horarioId').val(),
            codigo: $('#codigo').val(),
            horaInicio: $('#horaInicio').val(),
            horaFin: $('#horaFin').val()
        }
        e.preventDefault();//prevenir recarga de la pagina
        $('#formulario').trigger('reset');//Resetar el formulario

            $.post("../modelos/horarios/horariosInsertar.php", datosForm, function (respuesta) {
                $('#formulario').trigger('reset');
                if(respuesta){
                    
                    // obtenerPuestos_horaios();
                    // buscarPuestos_horaios();
                    swal({ //Alerta registro exitoso
                        title: "Registro exitoxo!",
                        text: "Se a agregado el registro de manera exitosa",
                        icon: "success",
                        })
                    listaHoraios();
                }
            }
            );
            
    }else if(accion == "actualizar"){
        const datosForm ={
            accion: accion,
            horarioId: $('#horarioId').val(),
            codigo: $('#codigo').val(),
            horaInicio: $('#horaInicio').val(),
            horaFin: $('#horaFin').val()
        }
        
        e.preventDefault();//prevenir recarga de la pagina
        $('#formulario').trigger('reset');//Resetar el formulario

        $.post("../modelos/horarios/horariosActualizar.php", datosForm, function (respuesta) {
            $('#formulario').trigger('reset');
            
            if(respuesta){
                
                swal({ //Alerta registro exitoso
                    title: "Actualizacion exitosa!",
                    text: "Se a modificó el registro correctamente",
                    icon: "success",
                    })
                $('#botonFrm').html('Registrar');
                $('#btnFrm').addClass('ocultar');
                listaHoraios();
            }
        }
        );
    }
    
})

// Funcion para Actualizar horarios

    $(document).on('click', '.editar', function(){
        $('#formulario').trigger('reset');//Resetar el formulario
        accion = "actualizar"
        
        let id = $(this)[0];
            id = $(id).attr('horarioId');
            
            const datosForm ={
                accion: "obtener",
                horarioId: id,
            }
            $.post('../modelos/horarios/horariosActualizar.php', datosForm, function(respuesta){
                const  dato = JSON.parse(respuesta);
                $('#horarioId').val(dato.id);
                $('#codigo').val(dato.codigo);
                $('#horaInicio').val(dato.horaInicio);
                $('#horaFin').val(dato.horaFin);
                $('#botonFrm').html('Actualizar');
                $('#btnFrm').removeClass('ocultar');
            });
        
    })

//Funcion para cancelar la actualizacion
$(document).on('click', '#btnFrm', function(){ 
    $('#horarioId').val("");
    $('#codigo').val("");
    $('#horaInicio').val("");
    $('#horaFin').val("");
    $('#botonFrm').html('Registrar');
    $('#btnFrm').addClass('ocultar');
    accion = "registrar"
    }
)


// funcion para eliminar un horario

$(document).on('click', '.borrar', function(){

    //ALERTA
    swal({ //Alerta de borrado
        title: "Eliminar?",
        text: "Deseas eliminar este horario definitivamente?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            //Codigo a ejecutar-------------------------------------
            accion = "eliminar"
            let id = $(this)[0];
            id = $(id).attr('horarioId');
            const datosForm ={
                accion: accion,
                horarioId: id, 
            }
            
            $.post("../modelos/horarios/horariosBorrar.php", datosForm, function (respuesta) {
                
                if(respuesta){
                    console.log(respuesta);
                    swal({ //Alerta registro exitoso
                        title: "Registro eliminado!",
                        text: "Se a eliminado el registro de manera exitosa!",
                        icon: "success",
                        })
                    listaHoraios()
                }
            }
            );
            //--------------------------------------------------------
        } else {
            swal("Tu registro esta a salvo!");
        }
    });
})



// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------




// //BUSQUEDA DE LOS DATOS

function listaHoraios(){
    $.ajax({
        url: "../modelos/horarios/horariosVer.php",
        type: "GET",
        success: function (respuesta){
            let template = '';
            let busqueda = JSON.parse(respuesta);
            let n=1;
            busqueda.forEach(obj => {
                
                let horarioId = obj.horarioId
                let codigo = obj.codigo
                let horaInicio = obj.horaInicio
                let horaFin = obj.horaFin

                template += `
                    <tr>
                        <td>${n}</td>
                        <td>${codigo}</td>
                        <td>${horaInicio}</td>
                        <td>${horaFin}</td>
                        <td>
                            <div class="mb-3" style="width: 100%; text-align: end;">
                                <a href="#cabecera" ><button horarioId="${horarioId}" type="button" class="btn btn-warning editar">Editar</button></a>
                                <button horarioId="${horarioId}" type="button" class="btn btn-danger borrar">Borrar</button>
                            </div>
                        </td>
                    </tr>
                    `
                    n++;
            });

            $('#datosTabla').html(template);
            
        }

    })
    
    
}


listaHoraios();



