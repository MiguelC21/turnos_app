

/////CODIGO PARA LA EDICION Y FUCNCIONAMIENTO DE LOS PUESTOS 


    // import {horarios} from "./horarios.js";

    accionP = "..."
// Funcion para insertar puestos

    $(document).on('click', '#insertarPuestoBoton', function(){
        $('#insertarPuesto').trigger('reset');//Resetar el formulario
        accionP = "registrar"
    })


// Funcion para Actualizar puestos 

    $(document).on('click', '.actualizarPuesto', function(){
        // $('#insertarPuesto').trigger('reset');//Resetar el formulario
        accionP = "actualizar"
        if(accionP == "actualizar"){
            let id = $(this)[0];
            id = $(id).attr('id');
            const datosForm ={
                accion: "obtener",
                id: id, 
            }

            $.post('../modelos/puestos/puestosActualizar.php', datosForm, function(respuesta){
                const  dato = JSON.parse(respuesta);
                $('#puestoId').val(dato.id);
                $('#codigo').val(dato.codigo);
                $('#descripcion').val(dato.descripcion);
                
            });

            $('#insertarPuesto').submit(function(e){

                e.preventDefault();//prevenir recarga de la pagina
                // $('#insertarPuesto').trigger('reset');//Resetar el formulario
                $('#cerrarFP').click();//Cerrar el formulario

                const datosForm = {
                    accion: accionP,
                    id: $('#puestoId').val(),
                    codigo: $('#codigo').val(),
                    descripcion: $('#descripcion').val(),
                };


                $.post("../modelos/puestos/puestosActualizar.php", datosForm, function (respuesta) {
                    $('#insertarPuesto').trigger('reset');
                    if(respuesta){
                        console.log(respuesta);
                        // obtenerPuestos_horaios();
                        // buscarPuestos_horaios();
                        swal({ //Alerta registro exitoso
                            title: "Actualizacion exitosa!",
                            text: "Se a modificó el registro correctamente",
                            icon: "success",
                            })
                        buscar();
                    }

                })
            });
        }
    })




//Condicionales para insertar datos

    $('#insertarPuesto').submit(function(e){
        if (accionP == "registrar"){
            const datosForm ={
                accionP: accionP,
                codigo: $('#codigo').val(),
                descripcion: $('#descripcion').val()
            }
            
            e.preventDefault();//prevenir recarga de la pagina
            $('#cerrarFP').click();//Cerrar el formulario
            $('#insertarPuesto').trigger('reset');//Resetar el formulario
    
                $.post("../modelos/puestos/puestosInsertar.php", datosForm, function (respuesta) {
                    $('#formulario').trigger('reset');
                    
                    if(respuesta){
                        // obtenerPuestos_horaios();
                        // buscarPuestos_horaios();
                        swal({ //Alerta registro exitoso
                            title: "Registro exitoxo!",
                            text: "Se a agregado el registro de manera exitosa",
                            icon: "success",
                            })
                        buscar();
                    }
                }
                );
                
        }
        
    })




    //Fucnion para actualziar el estado del puesto

    $(document).on('click', '.estado', function(){
        accionP = "actualizarEstado"
        let idd = $(this)[0];
        let id = $(idd).attr('id');
        let estado = $(idd).is(':checked');
        const datosForm ={
            accion: accionP,
            id: id, // Aqui va el id
            estado: estado,
        }
        $.post("../modelos/puestos/puestosActualizar.php", datosForm, function (respuesta) {
            if(respuesta){
                // horarios();
                buscar();
            }
        });
    })

    


// funcion para eliminar un puesto

$(document).on('click', '.eliminarPuesto', function(){


    //ALERTA
    swal({ //Alerta de borrado
        title: "Eliminar?",
        text: "Deseas eliminar este puesto definitivamente!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            //Codigo a ejecutar-------------------------------------
            let id = $(this)[0];
            id = $(id).attr('id');

            const datosForm ={
                id: id, // Aqui va el id
            }
            
            
            $.post("../modelos/puestos/puestosEliminar.php", datosForm, function (respuesta) {
                
                
                if(respuesta){
                    console.log(respuesta);
                    
                    // buscarPuestos_horaios();
                    swal({ //Alerta registro exitoso
                        title: "Registro eliminado!",
                        text: "Se a eliminado el registro de manera exitosa!",
                        icon: "success",
                        })
                    buscar();
                }
            }
            );
            //--------------------------------------------------------
        } else {
            swal("Tu registro esta a salvo!");
        }
    });
})


// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________
// _____________________________________________________________________________________________



//CODIGO PARA LA EDICION Y FUNCIONAMIENTO DE LOS HORARIOS

// obtenemos los tipos de turnos de la base de datos

obtenerTipoPermisos()

function obtenerTipoPermisos(){

    $.ajax({
        url: "../modelos/horarios/horariosVer.php",
        type: "GET",
        success: function (respuesta){
            let template = '';
            let busqueda = JSON.parse(respuesta);
            busqueda.forEach(obj => {
                template +=`<option value="${obj.horarioId}" id="${obj.horarioId}">COD: ${obj.codigo} -- De ${obj.horaInicio} a ${obj.horaFin}</option>`
            })
            $('#tipoTurno').html(template);
        }
    })
}


//Funcion para insertar un nuevo horario

accion = "..."
// Funcion para insertar Horarios

    $(document).on('click', '.insertarHorario', function(){
        $('#insertarHorario').trigger('reset');//Resetar el formulario
        accion = "registrar"
        let puestoId = $(this)[0];
            puestoId = $(puestoId).attr('id');
            $('#puestoId').val(puestoId);
        
        
    })


// Funcion para Actualizar horarios

    $(document).on('click', '.editarHorario', function(){
        $('#insertarHorario').trigger('reset');//Resetar el formulario
        accion = "actualizar"
        
        let id = $(this)[0];
            id = $(id).attr('horarioId');
            
            const datosForm ={
                accion: "obtener",
                horarioId: id,
            }

            $.post('../modelos/puestos_horarios/puesto_horariosActualizar.php', datosForm, function(respuesta){
                
                const  dato = JSON.parse(respuesta);
                $('#horarioId').val(dato.id);
                $('#tipoTurno').val(dato.tipoTurnoId);
                $('#observacion').val(dato.observacion);
            });
    })




//condicionales para ejecutar las opciones de actualizar o insertar un campo
//INSERTAR HORARIO
    $('#insertarHorario').submit(function(e){
        if (accion == "registrar"){
            
            const datosForm ={
                accion: accion,
                puestoId: $('#puestoId').val(),
                tipoTurnoId: $('#tipoTurno').val(),
                observacion: $('#observacion').val()
            }
            e.preventDefault();//prevenir recarga de la pagina
            $('#cerrarFH').click();//Cerrar el formulario
            $('#insertarHorario').trigger('reset');//Resetar el formulario
    
                $.post("../modelos/puestos_horarios/puesto_horariosInsertar.php", datosForm, function (respuesta) {
                    $('#insertarHorario').trigger('reset');
                    if(respuesta){
                        
                        // obtenerPuestos_horaios();
                        // buscarPuestos_horaios();
                        swal({ //Alerta registro exitoso
                            title: "Registro exitoxo!",
                            text: "Se a agregado el registro de manera exitosa",
                            icon: "success",
                            })
                        buscar();
                    }
                }
                );
//ACTUALIZAR HORARIO
        }else if(accion == "actualizar"){
            const datosForm ={
                accion: accion,
                horarioId: $('#horarioId').val(),
                tipoTurnoId: $('#tipoTurno').val(),
                observacion: $('#observacion').val()
            }
            e.preventDefault();//prevenir recarga de la pagina
            $('#insertarHorario').trigger('reset');//Resetar el formulario
            $('#cerrarFH').click();//Cerrar el formulario

            $.post("../modelos/puestos_horarios/puesto_horariosActualizar.php", datosForm, function (respuesta) {
                $('#formulario').trigger('reset');
                
                if(respuesta){
                    
                    swal({ //Alerta registro exitoso
                        title: "Actualizacion exitosa!",
                        text: "Se a modificó el registro correctamente",
                        icon: "success",
                        })
                    buscar();
                }
            }
            );
        }
        
    })




// funcion para eliminar un horario

$(document).on('click', '.eliminarHorario', function(){

    //ALERTA
    swal({ //Alerta de borrado
        title: "Eliminar?",
        text: "Deseas eliminar este puesto definitivamente!",
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
            
            
            $.post("../modelos/puestos_horarios/puesto_horariosEliminar.php", datosForm, function (respuesta) {
                
                
                if(respuesta){
                    console.log(respuesta);
                    // obtenerPuestos_horaios();
                    // buscarPuestos_horaios();
                    swal({ //Alerta registro exitoso
                        title: "Registro eliminado!",
                        text: "Se a eliminado el registro de manera exitosa!",
                        icon: "success",
                        })
                    buscar();
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


//BUSQUEDA DE DATOS


//Buscar - lista completa
function buscarLista(){

    listaPuestos();
    // obtenerLista();
    
    $('#buscarPuesto').keyup(function(){

        buscar();
        
    })
}




// Funcion para mostar listado de todos los puestos

function listaPuestos(){
    $.ajax({
        url: "../modelos/puestos/puestosVer.php",
        type: "GET",
        success: function (respuesta){
            
            let template = '';
            let busqueda = JSON.parse(respuesta);
                
                
                busqueda.forEach(obj => {
                    
                    let estado = "";
                    let color = ""
                    if (obj.estado == 1){
                        estado = "checked"
                        color = "background-color: rgb(37, 163, 94);"
                    }else if(obj.estado == 0){
                        estado = "unchecked"
                        color = "background-color: rgb(204, 61, 64);"
                    }

                    template += `<div class="card border-secondary mb-3 listaP" style="margin: 10px; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; padding: 3px; width: 100%;">
                    <div style="display: flex; flex-direction: row; flex-wrap: wrap; margin: auto 2px; width: max-content; min-height: 35px; ${color} border-radius: 3px; color: white; justify-content: center; text-align: center;">
                        <legend style="margin: auto 3px; font-size: 16px; width: max-content;">${obj.codigo}</legend>
                        <legend style="margin: auto 3px; font-size: 11px; color: rgb(216, 210, 210);width: auto;">${obj.descripcion}</legend>
                    </div>
                    <div style="display: flex; flex-direction: row; flex-wrap: wrap; margin: auto 2px; width: max-content; min-height: 35px; justify-content: center; ">
                        <div id="${obj.puestoId}" style="display: flex; flex-direction: row; flex-wrap: wrap; background-color: rgb(238, 238, 238);  min-height: 35px;" class="${obj.puestoId} limpiar hrs">
                            


                        </div>
                        <div style="display: flex; flex-direction: row; flex-wrap: nowrap; background-color: rgb(238, 238, 238); margin-left: 4px;  min-height: 35px;" class="hrs">
                            <legend style="margin: auto 3px; font-size: 16px;">
                                <img id="${obj.puestoId}" class="botones insertarHorario" title="Agragar horario" style="height: 15px; margin-top: -5px; cursor:pointer;" src="../vistas/img/mas.png" data-bs-toggle="modal"
                                data-bs-target="#exampleModa2">
                            </legend>
                        </div>
                    </div>
                    <div style="flex: content;">
                    </div>
                    <div style="display: flex; flex-direction: row; flex-wrap: nowrap; margin: auto 2px; justify-content: right; height: 35px;">
                        <legend style="text-align: right; margin: auto 3px; width: max-content;">
                            <img id="${obj.puestoId}" class="botones actualizarPuesto" title="Editar" style="height: 20px; margin-top: -10px; cursor:pointer;" src="../vistas/img/editar.png" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                        </legend>
                        <legend style="text-align: right; margin: auto 3px; width: max-content; font-size: 16px;">
                            <img id="${obj.puestoId}" class="botones eliminarPuesto" title="Eliminar" style="height: 20px; margin-top: -5px; cursor:pointer;" src="../vistas/img/eliminar.png" >
                        </legend>
                        <legend style="text-align: right; margin: auto 3px; width: max-content; font-size: 16px;">
                            <div class="form-check form-switch" >
                                <input style="cursor:pointer;" title="Activar-Desactivar" class="form-check-input estado" type="checkbox" id="${obj.puestoId}" ${estado}>
                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                            </div>
                        </legend>
                    </div>
                </div>`
                    

                });
                $('#listaPuestos').html("");
                $('#listaPuestos').html(template);
                
        }
    })
    turnosActivos();
    setTimeout(listaHoraios,200);
}


//Funcion Buscar Puestos
function buscar(){
    if($('#buscarPuesto').val()){

        let buscar = $('#buscarPuesto').val();
        
        $.ajax({
            url: '../modelos/puestos/puestosVer.php',
            type: 'POST',
            data: { buscar: buscar },
            
            success: function(respuesta){
                let busqueda = JSON.parse(respuesta);
                let template = '';
                
                busqueda.forEach(obj => {

                    let estado = "";
                    let color = ""
                    if (obj.estado == 1){
                        estado = "checked"
                        color = "background-color: rgb(37, 163, 94);"
                    }else if(obj.estado == 0){
                        estado = "unchecked"
                        color = "background-color: rgb(204, 61, 64);"
                    }


                    template += `<div class="card border-secondary mb-3 listaP" style="margin: 10px; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; padding: 3px; width: 100%;">
                    <div style="display: flex; flex-direction: row; flex-wrap: wrap; margin: auto 2px; width: max-content; min-height: 35px; ${color} border-radius: 3px; color: white; justify-content: center; text-align: center;">
                        <legend style="margin: auto 3px; font-size: 16px; width: max-content;">${obj.codigo}</legend>
                        <legend style="margin: auto 3px; font-size: 11px; color: rgb(216, 210, 210);width: auto;">${obj.descripcion}</legend>
                    </div>
                    <div style="display: flex; flex-direction: row; flex-wrap: wrap; margin: auto 2px; width: max-content; min-height: 35px; justify-content: center; ">
                        <div id="${obj.puestoId}" style="display: flex; flex-direction: row; flex-wrap: wrap; background-color: rgb(238, 238, 238);  min-height: 35px;" class="${obj.puestoId} limpiar hrs">
                            


                        </div>
                        <div style="display: flex; flex-direction: row; flex-wrap: nowrap; background-color: rgb(238, 238, 238); margin-left: 4px;  min-height: 35px;" class="hrs">
                            <legend style="margin: auto 3px; font-size: 16px;">
                                <img id="${obj.puestoId}" class="botones insertarHorario" title="Agragar horario" style="height: 15px; margin-top: -5px; cursor:pointer;" src="../vistas/img/mas.png" data-bs-toggle="modal"
                                data-bs-target="#exampleModa2">
                            </legend>
                        </div>
                    </div>
                    <div style="flex: content;">
                    </div>
                    <div style="display: flex; flex-direction: row; flex-wrap: nowrap; margin: auto 2px; justify-content: right; height: 35px;">
                        <legend style="text-align: right; margin: auto 3px; width: max-content;">
                            <img id="${obj.puestoId}" class="botones actualizarPuesto" title="Editar" style="height: 20px; margin-top: -10px; cursor:pointer;" src="../vistas/img/editar.png" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                        </legend>
                        <legend style="text-align: right; margin: auto 3px; width: max-content; font-size: 16px;">
                            <img id="${obj.puestoId}" class="botones eliminarPuesto" title="Eliminar" style="height: 20px; margin-top: -5px; cursor:pointer;" src="../vistas/img/eliminar.png" >
                        </legend>
                        <legend style="text-align: right; margin: auto 3px; width: max-content; font-size: 16px;">
                            <div class="form-check form-switch" >
                                <input style="cursor:pointer;" title="Activar-Desactivar" class="form-check-input estado" type="checkbox" id="${obj.puestoId}" ${estado}>
                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                            </div>
                        </legend>
                    </div>
                </div>`
                });

                $('#listaPuestos').html("");
                $('#listaPuestos').html(template);
                turnosActivos();
                setTimeout(listaHoraios,200);

            }
        })
        
        
    }else{
        setTimeout(listaPuestos,200);
    }

}






//Funcion para obtener el listado de horarios

function listaHoraios(){
    $('.limpiar').html("");
    $.ajax({
        url: "../modelos/puestos_horarios/puesto_horariosVer.php",
        type: "GET",
        success: function (respuesta){
            let template = '';
            let busqueda = JSON.parse(respuesta);
            
                busqueda.forEach(obj2 => {

                    hora = `${obj2.horaInicio} a ${obj2.horaFin}`
                    observacion = `Observacion: ${obj2.observacion}`
                    puesto = `.${obj2.puestoId}`
                    template = `
                    <div style="margin: auto 6px; display: flex; flex-direction:row; flex-wrap: nowrap;" class="horas">

                        <div style="margin: auto 6px; width: 5px; height: 5px; font-size: 16px; background-color: rgb(44, 124, 51); border-radius: 10px;">
                        </div>

                        <div style="margin: auto 6px auto -2px; width: max-content; font-size: 16px;" title="${observacion}">
                        ${hora} 
                        </div>

                        <div style="margin: auto 6px; width: max-content; font-size: 16px;">
                            <img id="${obj2.puestoId}" horarioId="${obj2.horarioId}" class="botones eliminarHorario" title="Eliminar" style="height: 15px; margin-top: -6px; cursor:pointer;" src="../vistas/img/eliminar.png" alt=""> 
                        </div>

                        <div style="margin: auto 6px; width: max-content; font-size: 16px;">
                            <img id="${obj2.puestoId}" horarioId="${obj2.horarioId}" class="botones editarHorario" title="Editar" style="height: 15px; margin-top: -6px; margin-right: 5px;cursor:pointer;" src="../vistas/img/editar.png" data-bs-toggle="modal"
                            data-bs-target="#exampleModa2">
                        </div>
                    </div>
                    `
                    
                    $(puesto).append(template);

                });
                
        }

    })
    
    
}


// Funcion para buscar el numero de turnos activos actuamente

function turnosActivos(){
    $.ajax({
        url: "../modelos/puestos_horarios/puesto_horariosTotal.php",
        type: "GET",
        success: function (respuesta){
            $('#turnosActivos').html(`Total turnos activos: ${respuesta}`);
        }
    })

}


buscarLista();

