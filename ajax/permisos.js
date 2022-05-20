//Busqueda de usuarios

//FUNCION PARA BUSCAR LISTA DE TIPOS DE PERMISOS
listaPermisos();
function listaPermisos(){
    $.ajax({
        url: '../modelos/permisos/permisosBuscarTP.php',
        type: "GET",

        success: function (respuesta){
            let busqueda = JSON.parse(respuesta);
            let template = '';
            busqueda.forEach(obj => {
                template += `<option value="${obj.id}" id="${obj.id}" style="font-size: 15px;" >${obj.descripcion}</option>`
            });
            $('#tipoPermiso').html(template);
            $('#AtipoPermiso').html(template);
        }
    })
}

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------


// FUNCION PARA BUSCAR USUARIO
function buscarUsuario(){
    $('#buscarU').keyup(function(){
        if($('#buscarU').val()){
            let buscarU = $('#buscarU').val();
            
            $.ajax({
                url: '../modelos/permisos/permisosBuscarU.php',
                type: 'POST',
                data: { buscarU },
                
                success: function (respuesta){
                    
                    let busqueda = JSON.parse(respuesta);
                    let template = '';
                    
                    busqueda.forEach(obj => {
                        template += `<option value="${obj.id}" id="${obj.id}"style="font-size: 15px;">${obj.nombre} ${obj.apellido}</option>`
                    });

                    $('.seleccionaUsuario').html(template);

                }
            })
        }else{
            obtenerUsuarios();
        }
    })
}



//FUCNION PARA BUSCAR TODOS LOS USUARIOS
function obtenerUsuarios(){
    $.ajax({
        url: '../modelos/permisos/permisosBuscarU.php',
        type: "GET",

        success: function (respuesta){
            let busqueda = JSON.parse(respuesta);
            let template = '';
            
            busqueda.forEach(obj => {
                template += `<option value="${obj.id}" id="${obj.id}"style="font-size: 15px;">${obj.nombre} ${obj.apellido}</option>`
            });

            $('.seleccionaUsuario').html(template);

        }
    })

}

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------


//FUNCION PARA BUSCAR PERMISOS
function buscarPermiso(){
    obtenerPermisos();

    $('#buscarP').keyup(function(){
        buscar();
    })
}

function buscar(){
    if($('#buscarP').val()){
        let buscarP = $('#buscarP').val();
        
        $.ajax({
            url: '../modelos/permisos/permisosBuscarP.php',
            type: 'POST',
            data: { buscarP },
            
            success: function (respuesta){
                
                let busqueda = JSON.parse(respuesta);
                let template = '';
                
                let n=1;
                busqueda.forEach(obj => {
                    let botones = ':::::::::::::::::::  :::::::::::::::::::'
                    if(obj.tipoPermiso != 'Cumpleaños'){
                        botones = `<button id="${obj.permisoId}" usuarioId="${obj.usuarioId}" type="button" class="btn btn-warning editar" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Editar</button>
                                <button id="${obj.permisoId}" usuarioId="${obj.usuarioId}" type="button" class="btn btn-danger borrar">Borrar</button>`
                    }
                    template += `<tr>
                        <td scope="row">${n}</td>
                        <td>${obj.nombre}</td>
                        <td>${obj.apellido}</td>
                        <td>${obj.telefono}</td>
                        <td>${obj.tipoPermiso}</td>
                        <td>${obj.fechaInicio}</td>
                        <td>${obj.fechaFin}</td>
                        <td>${obj.remunerado}</td>
                        <td>
                            ${botones}
                        </td>
                    </tr>`
                    n++;
                });
    
                $('#tablaPermisos').html(template);

            }
        })
    }else{
        obtenerPermisos();
    }
}






//FUNCION PARA OBTENER TODOS LOS PERMISOS
function obtenerPermisos(){
    $.ajax({
        url: '../modelos/permisos/permisosBuscarP.php',
        type: "GET",

        success: function (respuesta){
            
            let busqueda = JSON.parse(respuesta);
            let template = '';
            n=1;
            busqueda.forEach(obj => {
                let botones = ':::::::::::::::::::  :::::::::::::::::::'
                if(obj.tipoPermiso != 'Cumpleaños'){
                    botones = `<button id="${obj.permisoId}" usuarioId="${obj.usuarioId}" type="button" class="btn btn-warning editar" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Editar</button>
                        <button id="${obj.permisoId}" usuarioId="${obj.usuarioId}" type="button" class="btn btn-danger borrar">Borrar</button>`
                }
                template += `<tr>
                    <td>${n}</td>
                    <td>${obj.nombre}</td>
                    <td>${obj.apellido}</td>
                    <td>${obj.telefono}</td>
                    <td>${obj.tipoPermiso}</td>
                    <td>${obj.fechaInicio}</td>
                    <td>${obj.fechaFin}</td>
                    <td>${obj.remunerado}</td>
                    <td>
                        ${botones}
                    </td>
                </tr>`
                n++;
            });

            $('#tablaPermisos').html(template);

        }
    })

}








// FUNCION PARA REGISTRAR PERMISOS

function registrar(){

    $('#formulario').submit(function(e){
        
        const datosForm ={
            usuarioId: $('#usuario').val(),
            tipoPermiso: $('#tipoPermiso').val(),
            fechaInicio: $('#fechaInicio').val(),
            fechaFin: $('#fechaFin').val(),
            remunerado: $('#remunerado').val()
        }
        e.preventDefault();
        
        $.post("../modelos/permisos/permisosInsertarP.php", datosForm, function (respuesta) {
            $('#formulario').trigger('reset');
            
            if(respuesta){
                obtenerUsuarios();
                buscarPermiso();
                swal({ //Alerta registro exitoso
                    title: "Registro exitoxo!",
                    text: "Se a agregado el registro de manera exitosa",
                    icon: "success",
                    })
                
            }
        }
        );
    })

}









// FUNCION PARA ACTUALIZAR LOS PERMISOS

function actualizarTurnos(){
    $(document).on('click', '.editar', function (){
        
        let id = $(this)[0]; //adquiero el id del permiso seleccionado
        idPermiso = $(id).attr('id');
        const datos = {
            idPermiso: idPermiso
        }
        
        $.post('../modelos/permisos/permisosActualizar.php', datos, function(respuesta){
            
            const  dato = JSON.parse(respuesta);
            nombreC = `${dato.nombre} ${dato.apellido}`;
            $('#AusuarioId').val(dato.usuarioId);
            $('#ApermisoId').val(dato.permisoId);
            $('#AtipoPermiso').val(dato.tipoPermiso);
            $('#Anombre').html(nombreC);
            $('#AfechaInicio').val(dato.fechaInicio);
            $('#AfechaFin').val(dato.fechaFin);
            $('#Aremunerado').val(dato.remunerado);
        
        })
        
        
    })
    
    //Funcion para proceder a actualizar los nuevos datos
    $('#actualizarP').submit(function(e){

        e.preventDefault();

        const datosForm ={
            usuarioId: $ ('#AusuarioId').val(),
            permisoId: $('#ApermisoId').val(),
            tipoPermiso: $('#AtipoPermiso').val(),
            fechaInicio: $('#AfechaInicio').val(),
            fechaFin: $('#AfechaFin').val(),
            remunerado: $('#Aremunerado').val()
        }
        
        $.post("../modelos/permisos/permisosActualizar.php", datosForm, function (respuesta) {
            $('#actualizarP').trigger('reset');
            if(respuesta){
                
                $('#cerrar').click() //ocultamos/cerramos el modal
                buscar();
                obtenerUsuarios();

                swal({ //Alerta registro exitoso
                    title: "Accion exitoxa!",
                    text: "La actualizacion se a realizado de manera correcta",
                    icon: "success",
                    }
                );
            }
            
        }
        );
    })
    

}









// FUNCION PARA ELIMINAR LOS DATOS 

function eliminarTurno(){
    $(document).on('click', '.borrar', function (){
        
        swal({ //Alerta de borrado
            title: "Eliminar?",
            text: "Deseas eliminar este registro definitivamente?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                //Codigo a ejecutar-------------------------------------
                let id = $(this)[0]; //adquiero el id del permiso seleccionado
                permisoId = $(id).attr('id');
                usuarioId = $(id).attr('usuarioId');

                const datos = {
                    permisoId: permisoId,
                    usuarioId: usuarioId
                }
                
                $.post('../modelos/permisos/permisosEliminar.php', datos, function(respuesta){
                    
                    obtenerPermisos();
                    obtenerUsuarios();

                    swal("El registro se a eliminado exitosamente!", { //Mensaje exito
                        icon: "success",
                        });
                })
                //--------------------------------------------------------
            } else {
                swal("Tu registro esta a salvo!");
            }
        });

        

        
    })
}





// EJECUCION DE LAS FUNCIONES
eliminarTurno();
actualizarTurnos()
obtenerPermisos();
buscarPermiso();
registrar();
obtenerUsuarios();
buscarUsuario();
