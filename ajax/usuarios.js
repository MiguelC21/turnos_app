
//PEDIR DATOS A LA BASE DE DATOS

$(function(){
buscarLista();
actualizar();
//Busqueda de usuarios
    function buscarLista(){
        obtenerLista();
        // obtenerLista();
        
        $('#buscar').keyup(function(){

            buscar();
            
        })
    } 
    





    //Envio de los Datos del fromulario Registrar usuario

    $('#formulario').submit(function(e){
        
        const datosForm ={
            tipoDocumento: $('#tipoDocumento').val(),
            nDocumento: $('#nDocumento').val(),
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            correo: $('#correo').val(),
            telefono: $('#telefono').val(),
            fechaNacimiento: $('#fechaNacimiento').val()
        }
        e.preventDefault();
        $.post("../modelos/usuarios/usuariosInsertar.php", datosForm, function (respuesta) {
            let msj = JSON.parse(respuesta);
            if(msj == 'repetido'){
                swal("El numero de documento que ingresaste ya se encuentra registrado!");
            }else{
                $('#formulario').trigger('reset');
                obtenerLista();
                swal({ //Alerta registro exitoso
                    title: "Registro exitoxo!",
                    text: "Se a agregado el registro de manera exitosa",
                    icon: "success",
                    })
            }
        }
        );
    })





    //Funcion para recolectar los adatos para la tabla usuarios

    function obtenerLista(){
        $.ajax({
            url: "../modelos/usuarios/usuariosBuscar.php",
            type: "GET",
            success: function (respuesta){
                
                let busqueda = JSON.parse(respuesta);
                        let template = '';
                        let n=1;
                        busqueda.forEach(obj => {
                            
                            if(obj.estado == 0){
                                estado = '<button  type="button" class="btn btn-danger estado">INACTIVO</button>'
                            }else if(obj.estado == 1){
                                estado = '<button  type="button" class="btn btn-success estado">ACTIVO</button>'
                            }
                            if(obj.permiso == 1 && obj.estado == 1){
                                estado = '<a href="../vistas/permisos.html"  type="button" class="btn btn-secondary">PERMISO</a>'
                            }
                            template += `<tr  idUsuario="${obj.id}"><td hidden >${obj.id}</td>
                            <td>${n}</td>
                            <td>${obj.nombre}</td>
                            <td>${obj.apellido}</td>
                            <td>${obj.tipoDocumento}</td>
                            <td>${obj.nDocumento}</td>
                            <td>${obj.correo}</td>
                            <td>${obj.telefono}</td>
                            <td>${obj.fechaNacimiento}</td>
                            <td>${obj.fechaRegistro}</td>
                            <td>${estado}</td>
                            <td><button type="button" class="btn btn-warning editar" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</button></td> </tr>`
                            n++;
                        });
                        $('#registros').html(template);
                        turnosActivos();
            }
    
        })
    }




    
    //Actualizar
    //Estados--------------------------------------------------
    function actualizar (){
        $(document).on('click', '.estado', function (){
            estado = $(this).text(); //Seleccionamos el estado actual del usuario
            let id = $(this)[0].parentElement.parentElement; //adquiero el id del usuario seleccionado
            id = $(id).attr('idUsuario');
            accion = "actualizarEstado";
            const datos = {
                idUsuario: id,
                accion: accion,
                estado: estado
            }
            
            $.post('../modelos/usuarios/usuariosActualizar.php', datos, function(respuesta){
                
                buscar();
            })
            
    })
    //Datos--------------------------------------------------
    $(document).on('click', '.editar', function (){
        // $('#popUp').removeClass('oculto')
        let id = $(this)[0].parentElement.parentElement; //adquiero el id del usuario seleccionado 
        id = $(id).attr('idUsuario');
        accion = "actualizarDatos";
        const datos = {
            idUsuario: id,
            accion: accion
        }

        $.post('../modelos/usuarios/usuariosActualizar.php', datos, function(respuesta){
            const  dato = JSON.parse(respuesta);
            $('#Aid').val(dato.id);
            $('#AtipoDocumento').val(dato.tipoDocumento);
            $('#AnDocumento').val(dato.nDocumento);
            $('#Anombre').val(dato.nombre);
            $('#Aapellido').val(dato.apellido);
            $('#Acorreo').val(dato.correo);
            $('#Atelefono').val(dato.telefono);
            $('#AfechaNacimiento').val(dato.fechaNacimiento);

            
        })
        $('#frmActualizar').submit(function(e){
        
            const datosForm ={
                id: $('#Aid').val(),
                tipoDocumento: $('#AtipoDocumento').val(),
                nDocumento: $('#AnDocumento').val(),
                nombre: $('#Anombre').val(),
                apellido: $('#Aapellido').val(),
                correo: $('#Acorreo').val(),
                telefono: $('#Atelefono').val(),
                fechaNacimiento: $('#AfechaNacimiento').val()
            }
            e.preventDefault();
            
            $.post("../modelos/usuarios/usuariosActualizar.php", datosForm, function (respuesta) {
                let msj = JSON.parse(respuesta);
                if(msj == 'repetido'){
                    swal("El numero de documento que ingresaste ya se encuentra registrado!");
                }else{
                    $('#frmActualizar').trigger('reset');
                    $('#cerrar').click() //ocultamos/cerramos el modal
                    buscar();
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
    })

    }




    //Funcion Buscar
    function buscar(){
        if($('#buscar').val()){

            let buscar = $('#buscar').val();
            
            $.ajax({
                url: '../modelos/usuarios/usuariosBuscar.php',
                type: 'POST',
                data: { buscar },
                
                success: function(respuesta){
                    let busqueda = JSON.parse(respuesta);
                    let template = '';
                    n=1;
                    busqueda.forEach(obj => {
                        
                        if(obj.estado == 0){
                            estado = '<button  type="button" class="btn btn-danger estado">INACTIVO</button>'
                        }else if(obj.estado == 1){
                            estado = '<button  type="button" class="btn btn-success estado">ACTIVO</button>'
                        }
                        if(obj.permiso == 1 && obj.estado == 1){
                            estado = '<a href="../vistas/permisos.html"  type="button" class="btn btn-secondary">PERMISO</a>'
                        }
                        template += `<tr idUsuario="${obj.id}" > <td hidden>${obj.id}</td>
                        <td>${n}</td>
                        <td>${obj.nombre}</td>
                        <td>${obj.apellido}</td>
                        <td>${obj.tipoDocumento}</td>
                        <td>${obj.nDocumento}</td>
                        <td>${obj.correo}</td>
                        <td>${obj.telefono}</td>
                        <td>${obj.fechaNacimiento}</td>
                        <td>${obj.fechaRegistro}</td>
                        <td>${estado}</td>
                        <td><button  type="button" class="btn btn-warning editar" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</button></td> </tr>`
                        n++;
                    });
                    $('#registros').html(template);
                    turnosActivos();
                }
            })
            
        }else{
            obtenerLista();
        }
    
    }

    function turnosActivos(){
        $.ajax({
            url: "../modelos/usuarios/usuariosTotal.php",
            type: "GET",
            success: function (respuesta){
                let busqueda = JSON.parse(respuesta)
                busqueda.forEach(total =>{
                    $('#disponibles').html(`Disponibles: ${total.disponibles}`);
                    $('#activos').html(`Activos: ${total.activos}`);
                })
            }
        })
    
    }





})