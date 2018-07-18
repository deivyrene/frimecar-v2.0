/*
    Funciones de ayuda
*/



  $(function($){
                                             
                        $.datepicker.regional['es'] = {
                            closeText: 'Cerrar',
                            prevText: '&#x3c;Ant',
                            nextText: 'Sig&#x3e;',
                            currentText: 'Hoy',
                            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                            'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                            'Jul','Ago','Sep','Oct','Nov','Dic'],
                            dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
                            dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
                            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
                            weekHeader: 'Sm',
                            dateFormat: 'yy/mm/dd',
                            firstDay: 1,
                            isRTL: false,
                            showMonthAfterYear: false,
                            yearSuffix: ''};
                        $.datepicker.setDefaults($.datepicker.regional['es']);
                });



function validaCorreo(id) 
{
    //Utilizamos una expresion regular
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
 
    //Se utiliza la funcion test() nativa de JavaScript
    if (regex.test($('#'+id).val().trim())) 
    {
        alert('Correo validado');
    }
    else 
    {
        alert('La direccion de correo no es valida');
        $('#'+id).val("");
        $('#'+id).focus();
    }
}

function SoloNumeros(value,id)
{

        if(isNaN(value))
        {
                $("#"+id).val("");
                                    
        }

}

function SoloLetras(value,id)
{

        if(!isNaN(value))
        {
                $("#"+id).val("");
                                    
        }

            
}

function cortina(id)
{
    $("#"+id).slideToggle();
}

function consulta(view)
{

    var id = $("#buscador").val();
    var campo = $("#var_busqueda").val();

    if(id == ""){
        return alert("Ingrese Datos para Consultar");
    }

    window.location = view+'.php?id='+id+'&campo='+campo+'&_pagi_pg='+2+'&_pagi_pg='+1;
}

function volver (argument) 
{
      window.location = '../';
}



//Permite solo numeros en input
function ValidaSoloNumeros() 
{
  if ((event.keyCode < 48) || (event.keyCode > 57)) 
       
       event.returnValue = false;
}

function validarLetras(e) 
{ 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; // backspace
        if (tecla==32) return true; // espacio
        if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
        if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
        if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
        if (tecla==9) return true; //Ctrl tab
        patron = /[a-zA-Z]/; //patron
 
        te = String.fromCharCode(tecla); 
        return patron.test(te); // prueba de patron
}   

//Apertura una ventana modal
function modal(value)
{
            
            $("#"+value).dialog({ <!--  ------> muestra la ventana  -->
                width: "800",  <!-- -------------> ancho de la ventana -->
                height: "auto",<!--  -------------> altura de la ventana -->
                show: "blind", <!-- -----------> animación de la ventana al aparecer -->
                hide: "slide", <!-- -----------> animación al cerrar la ventana -->
                modal: "true"  <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa (muy elegante) -->
                });
        
}


function mostrar_tipos()
{
    var id = $("#registro_tipo").val();

    if(id == "")
    {
        $("#nomina_quincenal_, #arc, #nomina_gen, #islr, #nomina_mensual_, #aporte_parafiscal, #ret_islr_salario").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#tablero_tipos").show(); // Do something after 5 seconds
                        }, 300);
                    });
    }

    if(id == "nomina_mensual_")
    {
        $("#nomina_quincenal_, #arc, #nomina_gen, #islr, #inventario, #aporte_parafiscal, #ret_islr_salario").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }

    if(id == "nomina_quincenal_")
    {
        $("#arc, #nomina_gen, #inventario, #nomina_mensual_, #aporte_parafiscal, #ret_islr_salario").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }

    if(id == "arc")
    {
        $("#nomina_quincenal_, #nomina_gen, #islr, #inventario, #nomina_mensual_, #aporte_parafiscal, #ret_islr_salario").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }

    if(id == "nomina_gen")
    {
        $("#arc, #nomina_quincenal_, #islr, #inventario, #nomina_mensual_, #aporte_parafiscal, #ret_islr_salario").hide('slow', function()
                   {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }

    if(id == "islr")
    {
        $("#nomina_quincenal_, #nomina_gen, #arc, #inventario, #nomina_mensual_, #aporte_parafiscal, #ret_islr_salario").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }
    if(id == "inventario")
    {
        $("#nomina_quincenal_, #nomina_gen, #arc, #islr, #nomina_mensual_, #aporte_parafiscal, #ret_islr_salario").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }
    if(id == "aporte_parafiscal")
    {
        $("#nomina_quincenal_, #nomina_gen, #arc, #islr, #inventario, #nomina_mensual_, #ret_islr_salario").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }
    if(id == "ret_islr_salario")
    {
        $("#aporte_parafiscal, #nomina_quincenal_, #nomina_gen, #arc, #islr, #inventario, #nomina_mensual_").hide('slow', function()
                    {
                        setTimeout(function() 
                        {
                             $("#"+id).show(); // Do something after 5 seconds
                        }, 300);
                    });
    }
    
}

function reportes(id)
{
    if(id == "quincenal") 
    {
        var quincena = $('#quincena_nomina').val();
        var periodo = $('#periodo_quincena').val();
        var tipo = $('#tipo').val();

        if(quincena == "" || periodo == "" || tipo == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
            window.open("reporte/rpt_nomina.php?quincena="+quincena+"&periodo="+periodo+"&tipo="+tipo);
        }
        
    };

    if(id == "mensual") 
    {
        var mes = $('#mes_mensual').val();
        var periodo = $('#periodo_mensual').val();

        if(mes == "" || periodo == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
            window.open("reporte/rpt_nomina_mes.php?mes="+mes+"&periodo="+periodo);
        }
        
    };

    if(id == "arc")
    {
        var cedula = $('#cedula_arc').val().toUpperCase();
        var ano = $('#periodo_arc').val();

        if(cedula == "" || ano == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
             window.open("reporte/rpt_retencion_varias.php?cedula="+cedula+"&ano="+ano);
        }

    };

    if(id == "nomina_general")
    {
        var periodo = $('#periodo_nomina').val().toUpperCase();

        if(periodo == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
            window.open("reporte/rpt_vacaciones.php?periodo="+periodo);
        }

    };

    if(id == "islr")
    {
        var cedula = $('#cedula_islr').val().toUpperCase();
        var periodo = $('#periodo_islr').val();
        var mes = $('#mes_islr').val();
        var temp = "temp";

        if(cedula == "" || periodo == "" || mes == "" || temp == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
            window.open("reporte/rpt_retencion_1.php?periodo="+periodo+"&cedula="+cedula+"&mes="+mes+"&temp="+temp);
        }
    };

    if(id == "inventario")
    {
        var periodo = $('#periodo_inv').val().toUpperCase();
        var mes = $('#mes_inv').val();
        var descripcion = $('#descripcion_inv').val();

        if(periodo == "" || mes == "" || descripcion == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
            window.open("reporte/rpt_inventario.php?periodo="+periodo+"&descripcion="+descripcion+"&mes="+mes);
        }
    }

    if(id == "aporte_parafiscal")
    {
        var mes = $('#mes_parafiscal').val();
        var periodo = $('#periodo_parafiscal').val().toUpperCase();

        if(periodo == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
            window.open("reporte/rpt_aportes_parafiscales.php?mes="+mes+"&periodo="+periodo);
        }
    }

    if(id == "descargar_xml")
    {
        var mes = $('#mes_xml').val();
        var periodo = $('#periodo_xml').val();

        if(periodo == "")
        {
            alert("No debe dejar campos vacíos");
        }
        else
        {
            window.open("reporte/rpt_xml_islr_sueldos.php?mes="+mes+"&periodo="+periodo);
        }
    }
}

/*
    Funciones de peticiones a la base de datos
*/

function login()
{
    
    $('#form_login').submit(function() {
        
        var user = $('#user').val();
        var pass = $('#pass').val();
        var login = 'login';

        $.ajax({
            type:"GET",
            url: "php/control.php",
            data:{
                'user':user,
                'pass': pass,
                'login' : login
            },

            beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
            {
                $("#respuesta").html("<center><img  width='40px' src='php/imagenes/loading.gif'></center>");
            },

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
               //alert(data);
                if(data == "false")
                {
                    $("#respuesta").html('<div class="alert alert-danger" align="center" role="alert">Usuario no registrado</div>');
                }
                else
                {
                    window.location = 'php/index.php';
                    
                }
                
            }
        });
    
        return false;///preventDefault preveeno manda en formulario

    });

}

function cerrar()
{
    var cerrar = 'cerrar';

    $.ajax({
            type:"GET",
            url: "control.php",
            data: { 'cerrar':cerrar},

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
                //alert(data);
                if(data == "true")
                {
                    window.location = '../';
                }
                
            }
        });
}

$(function(){
        $("input[name='inputFile']").on("change", function(){
            var formData = new FormData($("#form_documento")[0]);
            var ruta = "control.php";
            $.ajax
            ({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    $("#respuesta_documento").html(datos);
                }
            });
        });
     });

function agregar_usuario()
{
        var tipo_nac = $('#tipo_nac').val().toUpperCase();
        var cedula = $('#cedula').val().toUpperCase();
        var nombre = $('#nombre').val().toUpperCase();
        var apellido = $('#apellido').val().toUpperCase();
        var correo = $('#correo').val();
        var rol = $('#rol').val();
        var username = $('#username').val();
        var pass = $('#pass').val();
        var agregar_usuario= 'agregar_usuario';


        if(tipo_nac == "" || cedula == "" || nombre == "" || apellido == "" || correo == ""  || rol == ""  || username == ""  || pass == "")
        {
            $("#respuesta").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
        }
        else
        {

            $.ajax({
                type:"GET",
                url: "control.php",
                data:{
                    'tipo_nac': tipo_nac,
                    'cedula': cedula,
                    'nombre': nombre,
                    'apellido': apellido,
                    'correo': correo,
                    'rol': rol,
                    'username': username,
                    'pass': pass,
                    'agregar_usuario' : agregar_usuario
                },
                cache : false,

                beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                {
                    $("#enviar_usuario").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                },
                
                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {
                    //console.log(data);

                    if(data == "false")
                    {
                        $("#respuesta").html('<div class="alert alert-danger" align="center" role="alert">No se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location='tpl_usuarios.php';
                        },600);
                    }
                    if(data == "true")
                    {
                        $("#respuesta").html('<div class="alert alert-success" align="center" role="alert">Se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location='tpl_usuarios.php';
                        },700);
                    }
                    
                }
            });
        }
}

function modal_editar_usu(value,id_usuario,nombre_usuario,apellido_usuario,login_usuario,pass_usuario,rol_usuario,correo_usuario,tipo_nac_usuario,cedula_usuario)
{
            
            modal(value);
            $('#id_usuario').val(id_usuario);
            $('#nombre_usuario').val(nombre_usuario);
            $('#apellido_usuario').val(apellido_usuario);
            $('#login_usuario').val(login_usuario);
            $('#pass_usuario').val(pass_usuario);
            $('#rol_usuario').val(rol_usuario);
            $('#correo_usuario').val(correo_usuario);
            $('#tipo_nac_usuario').val(tipo_nac_usuario);
            $('#cedula_usuario').val(cedula_usuario);
   
}

function editar_usuario()
{
        var id_usuario = $('#id_usuario').val();
        var tipo_nac = $('#tipo_nac_usuario').val().toUpperCase();
        var cedula = $('#cedula_usuario').val().toUpperCase();
        var nombre = $('#nombre_usuario').val().toUpperCase();
        var apellido = $('#apellido_usuario').val().toUpperCase();
        var correo = $('#correo_usuario').val();
        var rol = $('#rol_usuario').val();
        var username = $('#login_usuario').val();
        var pass = $('#pass_usuario').val();
        var editar_usuario= 'editar_usuario';


        if(tipo_nac == "" || cedula == "" || nombre == "" || apellido == "" || correo == ""  || rol == ""  || username == ""  || pass == "")
        {
            $("#respuesta_").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
        }
        else
        {

            $.ajax({
                type:"GET",
                url: "control.php",
                data:{
                    'id_usuario': id_usuario,
                    'tipo_nac': tipo_nac,
                    'cedula': cedula,
                    'nombre': nombre,
                    'apellido': apellido,
                    'correo': correo,
                    'rol': rol,
                    'username': username,
                    'pass': pass,
                    'editar_usuario' : editar_usuario
                },
                cache : false,

                beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                {
                    $("#editar_usuario").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                },
                
                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {
                    //console.log(data);

                    if(data == "false")
                    {
                        $("#respuesta_").html('<div class="alert alert-danger" align="center" role="alert">No se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location='tpl_usuarios.php';
                        },600);
                    }
                    if(data == "true")
                    {
                        $("#respuesta_").html('<div class="alert alert-success" align="center" role="alert">Se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location='tpl_usuarios.php';
                        },700);
                    }
                    
                }
            });
        }
}


function agregar_personal()
{
 
        var cedula = $('#cedula').val().toUpperCase();
        var rif = $('#rif').val().toUpperCase();
        var apellido = $('#apellido').val().toUpperCase();
        var nombre = $('#nombre').val().toUpperCase();
        var cargo = $('#cargo').val();
        var tipo = $('#tipo').val();
        var sueldo = $('#sueldo').val();
        var direccion = $('#direccion').val();
        var telefono = $('#telefono').val();
        var fecha = $('#fecha').val();
        var retencion = $('#retencion_1').val();
        var agregar_personal = 'agregar_personal';
        var page = 'tpl_personal';

        if(cedula == "" || rif == "" || apellido == "" || nombre == "" || cargo == ""  || tipo == ""  || sueldo == ""  || direccion == ""  || telefono == ""  || fecha == "")
        {
            $("#respuesta_persona").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
        }
        else
        {

            if(retencion == 'retencion_')
            {
                page = 'tpl_retencion_islr';
            }


            $.ajax({
                type:"GET",
                url: "control.php",
                data:{
                    'cedula': cedula,
                    'rif': rif,
                    'nombre': nombre,
                    'apellido': apellido,
                    'cargo': cargo,
                    'tipo': tipo,
                    'sueldo': sueldo,
                    'direccion': direccion,
                    'telefono': telefono,
                    'fecha': fecha,
                    'retencion': retencion,
                    'agregar_personal' : agregar_personal
                },
                cache : false,

                beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                {
                    $("#enviar_personal").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                },

                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {
                    //alert(data);

                    if(data == "false")
                    {
                        $("#respuesta_persona").html('<div class="alert alert-danger" align="center" role="alert">No se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location=page+".php";
                        },600);
                    }
                    if(data == "true")
                    {
                        $("#respuesta_persona").html('<div class="alert alert-success" align="center" role="alert">Se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location=page+".php";
                        },700);
                    }
                    
                }
            });
        }
}


//Apertura una ventana modal
function modal_editar(value,id,ced,rif,ape,nom,car,tipo,dire,telf,sueldo,fecha)
{
            
            modal(value);
            $('#ed_id').val(id);
            $('#ed_cedula').val(ced);
            $('#ed_rif').val(rif);
            $('#ed_apellido').val(ape);
            $('#ed_nombre').val(nom);
            $('#ed_direccion').val(dire);
            $('#ed_telefono').val(telf);
            $('#ed_cargo').val(car);
            $('#ed_tipo').val(tipo);
            $('#ed_sueldo').val(sueldo);
            $('#ed_fecha').val(fecha);
   
}

function modal_mostrar(value,cedula,rif,apellido,nombre,direccion,telefono,cargo,tipo,sueldo,fecha)
{
            
            modal(value);
            $('#cedula_mos').html(cedula);
            $('#rif_mos').html(rif);
            $('#apellido_mos').html(apellido);
            $('#nombre_mos').html(nombre);
            $('#direccion_mos').html(direccion);
            $('#telefono_mos').html(telefono);
            $('#cargo_mos').html(cargo);
            $('#tipo_mos').html(tipo);
            $('#sueldo_mos').html(sueldo);
            $('#fecha_mos').html(fecha); 
}

function editar_per()
{

        var id = $('#ed_id').val();
        var apellido = $('#ed_apellido').val().toUpperCase();
        var nombre = $('#ed_nombre').val().toUpperCase();
        var cargo = $('#ed_cargo').val();
        var tipo = $('#ed_tipo').val();
        var direccion = $('#ed_direccion').val();
        var telefono = $('#ed_telefono').val();
        var sueldo = $('#ed_sueldo').val();
        var fecha = $('#ed_fecha').val();
        var pagina = $('#pagina').val();
        var editar_personal = 'editar_personal';
        var retencion = $('#retencion_1').val();
        var page = 'tpl_personal';

        if(cedula == "" || rif == "" || apellido == "" || nombre == "" || cargo == ""  || tipo == ""  || sueldo == ""  || direccion == ""  || telefono == ""  || fecha == "")
        {
            $("#respuesta_editar_persona").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
        }
        else
        {

                if(retencion == 'retencion_')
                {
                    page = 'tpl_retencion_islr';
                }


                $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{

                        'id': id,
                        'nombre': nombre,
                        'apellido': apellido,
                        'cargo': cargo,
                        'tipo': tipo,
                        'direccion': direccion,
                        'telefono': telefono,
                        'sueldo': sueldo,
                        'fecha': fecha,
                        'retencion': retencion,
                        'editar_personal' : editar_personal
                    },

                    beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                    {
                        $("#editar_personal_").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                    },

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        console.log(data);

                        if(data == "false")
                        {
                            $("#respuesta_editar_persona").html('<div class="alert alert-danger" align="center" role="alert">Operación Fallida</div>');
                            setTimeout(function(){
                                window.location=page+".php?_pagi_pg="+pagina;
                            },600);
                        }
                        else
                        {
                            $("#respuesta_editar_persona").html('<div class="alert alert-success" align="center" role="alert">Operación exitosa</div>');
                            setTimeout(function(){
                                window.location=page+".php?_pagi_pg="+pagina;
                            },600);
                        }
                        
                    }
                });
        }
 
}

//Apertura una ventana modal para inhabilitar personal
function modal_inhabilitar(value,id)
{
            
            modal(value);
            $('#inh_id').val(id);
   
}

function inhabilitar_personal()
{
    var id_personal = $('#inh_id').val();
    var fecha_egreso = $('#fecha_egreso').val();
    var motivo_egreso= $('#motivo_egreso').val();
    var pagina = $('#pagina').val();
    var inhabilitar_personal = 'inhabilitar_personal';

    if(fecha_egreso == "" || motivo_egreso == "")
    {
        $("#respuesta_egreso").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
    }
    else
    {

    
        $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{
                        'inhabilitar_personal' : inhabilitar_personal,
                        'fecha_egreso' : fecha_egreso,
                        'motivo_egreso' : motivo_egreso,
                        'id_personal' : id_personal,
                    },
                    cache : false,

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        
                        if(data == "true")
                        {
                            $("#respuesta_egreso").html('<div class="alert alert-success" align="center" role="alert">Operación exitosa</div>');
                            window.location="tpl_personal.php?_pagi_pg="+pagina;
                        }
                        else
                        {
                            $("#respuesta_egreso").html('<div class="alert alert-success" align="center" role="alert">No se pudo registrar</div>');
                        }
                        
                    }
                });
    }
   
}

function habilitar_personal(value)
{
    var id_personal = value;
    var pagina = $('#pagina').val();
    var habilitar_personal = 'habilitar_personal';

    setTimeout(function(){  
        $.ajax({
            type:"GET",
            url: "control.php",
            data:{
                'habilitar_personal' : habilitar_personal,
                'id_personal' : id_personal,
            },
            cache : false,

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
                
                
                if(data == "true")
                {
                    window.location="tpl_personal.php?_pagi_pg="+pagina;
                }
                
            }
        });
    },700);
}



//Apertura una ventana modal para la quincena
function modal_retencion(value,id)
{
            modal(value);
            $('#id_perReten').val(id);
}

function calcula_impuesto()
{
    var retencion = $('#por_reten').val();
    var monto = $('#c_retencion').val();

    impuesto = (monto * retencion) / 100;

    total = monto - impuesto;

    $('#c_pagada').val(total.toFixed(2));
    $('#imp_retenido').val(impuesto.toFixed(2));

}

function agregar_retencion()
{

    //$('#form_retencion').submit(function() {
        
        var id_perReten = $('#id_perReten').val();
        var n_operacion = $('#n_operacion').val();
        var n_comprobante = $('#n_comprobante').val();
        var fecha_abono = $('#fecha_abono').val();
        var n_factura = $('#n_factura').val();
        var n_control = $('#n_control').val();
        var n_nota_debito = $('#n_nota_debito').val();
        var n_nota_credito = $('#n_nota_credito').val();
        var t_transaccion = $('#t_transaccion').val();
        var c_retencion = $('#c_retencion').val();
        var por_reten = $('#por_reten').val();
        var c_pagada = $('#c_pagada').val();
        var cod_concep = $('#codigo_concept').val();
        var imp_retenido = $('#imp_retenido').val();
        var pagina = $('#pagina').val();
        var agregar_reten = 'agregar_reten';

        if(fecha_abono == "" || n_nota_debito == "" || n_nota_credito == "" || t_transaccion == "" || c_retencion == "" || por_reten == "" || c_pagada == "" || cod_concep == "" || imp_retenido == "")
        {
            $("#respuesta_retencion").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
        }
        else
        {
                $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{
                        'id_perReten': id_perReten,
                        'n_operacion': n_operacion,
                        'n_comprobante': n_comprobante,
                        'fecha_abono': fecha_abono,
                        'n_factura': n_factura,
                        'n_control': n_control,
                        'n_nota_debito': n_nota_debito,
                        'n_nota_credito': n_nota_credito,
                        't_transaccion': t_transaccion,
                        'c_retencion': c_retencion,
                        'por_reten': por_reten,
                        'c_pagada': c_pagada,
                        'cod_concep': cod_concep,
                        'imp_retenido': imp_retenido,
                        'agregar_reten' : agregar_reten
                    },
                    cache : false,

                    beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                    {
                        $("#retencion_personal").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                    },

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        //console.log(data);
                        if(data == "false")
                        {
                            $("#respuesta_retencion").html('<div class="alert alert-danger" align="center" role="alert">Operación Fallida</div>');
                            setTimeout(function(){
                                    window.location="tpl_retencion_islr.php?_pagi_pg="+pagina;
                            },600);
                        }
                        if(data == "true")
                        {
                            $("#respuesta_retencion").html('<div class="alert alert-success" align="center" role="alert">Se ha registrado</div>');
                            setTimeout(function(){
                                window.open("reporte/rpt_retencion_1.php?id="+id_perReten);
                            },01);
                            window.location="tpl_retencion_islr.php?_pagi_pg="+pagina;
                        }
                        if(data == "error_1")
                        {
                            $("#respuesta_retencion").html('<div class="alert alert-danger" align="center" role="alert">El Personal ya hizo su retención</div>');
                            setTimeout(function(){
                                    window.location="tpl_retencion_islr.php?_pagi_pg="+pagina;
                            },700);
                        }
                        
                    }
                });
        }
        //return false;///preventDefault preveeno manda en formulario

    //});
}

function ultima_retencion()
{
    id_personal = $('#id_perReten').val();
    con = "1";
    window.open("reporte/rpt_retencion_1.php?id="+id_personal+"&con="+con);
}

//Apertura una ventana modal para la quincena
function modal_quincena(value,id,sueldo,apell,nombre,imp_ret,tipo,dias_traba)
{
           

        if(value == "quincena_")
        { 
           
            $('#principal').hide('slow', function()
            {
                setTimeout(function() 
                {
                        $("#"+value).show(); 
                        $('#q_id').val(id);
                        $('#q_sueldo').val(sueldo);
                        $('#q_tipo').val(tipo);
                        $('#ret_iva').val(imp_ret);
                        $('#titulo').html('Asignación: '+nombre+' '+apell+'<br><br>Días Trabajados Ultima Quincena: '+dias_traba);

                        alert('Los montos a cargar, si poseen decimales, el separador a usar es el Punto(.). Ejem: 5750.54');
                }, 300);
            });

        }

        if(value == "ed_quincena_")
        {
            $('#principal').hide('slow', function()
            {
                setTimeout(function() 
                {
                    $("#"+value).show(); 
                    $('#q_id_ed').val(id);
                    $('#q_sueldo_ed').val(sueldo);
                    $('#q_tipo_ed').val(tipo);
                    $('#ret_iva_ed').val(imp_ret);
                    $('#titulo_ed').html('Asignación: '+nombre+' '+apell+'<br><br> Días Trabajados Ultima Quincena: '+dias_traba);

                }, 300);
            });

        }


}


function verifica_quincena(item)
{
     
        if(item != "modificar")
        {
            var id_personal = $('#q_id').val();
            var quincena = $('#quincena').val();
            var verifica_quincena = "verifica_quincena";

             $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{
                        'id_personal': id_personal,
                        'quincena': quincena,
                        'verifica_quincena' : verifica_quincena
                    },

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        
                        if(data == "false")
                        {
                            $( "#dias_traba" ).prop( "disabled", false );
                            $( "#dias_feriados" ).prop( "disabled", false );
                            $( "#dias_cesta" ).prop( "disabled", false );
                            $( "#bonificacion" ).prop( "disabled", false );
                            $( "#h_extras_diur" ).prop( "disabled", false );
                            $( "#h_extras_noct" ).prop( "disabled", false );
                            $( "#otros" ).prop( "disabled", false );
                            $( "#cant_lunes" ).prop( "disabled", false );
                            $( "#prestamos" ).prop( "disabled", false );
                            $( "#ret_iva" ).prop( "disabled", false );
                            $( "#calcular_asignacion" ).prop( "disabled", false );
                        }
                        if(data == "true")
                        {
                            alert('El empleado ya tiene la quincena registrada, elija la quincena correcta');
                            $( "#dias_traba" ).prop( "disabled", true );
                            $( "#dias_feriados" ).prop( "disabled", true );
                            $( "#dias_cesta" ).prop( "disabled", true );
                            $( "#bonificacion" ).prop( "disabled", true );
                            $( "#h_extras_diur" ).prop( "disabled", true );
                            $( "#h_extras_noct" ).prop( "disabled", true );
                            $( "#otros" ).prop( "disabled", true );
                            $( "#cant_lunes" ).prop( "disabled", true );
                            $( "#prestamos" ).prop( "disabled", true );
                            $( "#ret_iva" ).prop( "disabled", true );
                            $( "#calcular_asignacion" ).prop( "disabled", true );
                        }
                        
                    }
                });
        }
        else
        {
            var id_personal = $('#q_id_ed').val();
            var quincena = $('#quincena_ed').val();
            var ult_quincena = "ult_quincena";

             $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{
                        'id_personal': id_personal,
                        'quincena' : quincena,
                        'ult_quincena' : ult_quincena
                    },

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        if(data == "false")
                        {
                            alert("No existen datos");
                        }

                        else
                        {
                            //Cargamos la ventana modal y mostramos los datos a editar
                            
                            var data_=JSON.parse(data);
                            
                            $('#id_quincena_ed').val(data_['id_quincena']);
                            $('#id_deduccion_ed').val(data_['id_deduccion']);
                            $('#fecha_inicio_ed').val(data_['fecha_inicio_quin']);
                            $('#fecha_fin_ed').val(data_['fecha_fin_quin']);
                            $('#tipo_pago_asig_ed').val(data_['tipo_pago_quin']);
                            $('#dias_traba_ed').val(data_['dias_trabajados']);
                            $('#dias_feriados_ed').val(data_['cant_dias_feriados']);
                            $('#dias_cesta_ed').val(data_['cant_dias_cesta_ticket']);
                            $('#bonificacion_ed').val(data_['bonificacion']);
                            $('#h_extras_diur_ed').val(data_['cant_horas_extras_d']);
                            $('#h_extras_noct_ed').val(data_['cant_horas_extras_n']);
                            $('#cesta_bs_ed').val(data_['cesta_ticket']);
                            $('#otros_ed').val(data_['otros_pagos']);
                            $('#cant_lunes_ed').val(data_['cant_lunes']);
                            $('#seguro_social_ed').val(data_['monto_seguro']);
                            $('#faov_ed').val(data_['monto_faov']);
                            $('#prestamos_ed').val(data_['prestamos']);
                            $('#ret_iva_ed').val(data_['ret_iva']);
                            $('#asig_quinc_ed').val(data_['asignacion']);
                            $('#ret_total_ed').val(data_['retencion']);
                            $('#neto_cobrar_ed').val(data_['total']);
                            $('#vacaciones_ed').val(data_['dias_vacas']);
                            $('#bono_vacacional_ed').val(data_['dias_bono_vacas']);
                            $('#total_vacaciones_ed').val(data_['pago_vacaciones']);
                            $('#total_bono_vacacional_ed').val(data_['pago_bono_vacacional']);
                            $('#utilidades_ed').val(data_['dias_utilidades']);
                            $('#total_utilidades_ed').val(data_['total_utilidades']);
                            $('#interes_anti_ed').val(data_['interes_anti']);
                            $('#adelanto_anti_ed').val(data_['adelanto_anti']);
                        }
                        
                    }
                });
        }


}

function calcular_quincena()
{
        var DIA_CESTA_TICKET = $("#monto_bs_cesta").val();
 
        var id_personal = $('#q_id').val();
        var sueldo_diario = $('#q_sueldo').val();
        var quincena = $('#quincena').val();
        var dias_trabajados = $('#dias_traba').val() * 1;
        var dias_feriados = $('#dias_feriados').val() * 1;
        var dias_cesta = $('#dias_cesta').val() * 1;
        var bonificacion = $('#bonificacion').val();
        var h_extras_diur = $('#h_extras_diur').val() * 1;
        var h_extras_noct = $('#h_extras_noct').val() * 1;
        var otros = $('#otros').val();
        var cant_lunes = $('#cant_lunes').val();
        var prestamos = $('#prestamos').val();
        var ret_iva = $('#ret_iva').val();
        var total_vacas = $('#total_vacaciones').val() * 1;
        var total_bono_vacas = $('#total_bono_vacacional').val() * 1;
        var total_utilidades = $('#total_utilidades').val() * 1;
        var interes_anti = $('#interes_anti').val() * 1;
        var adelanto_anti = $('#adelanto_anti').val() * 1;

        if(quincena == "" || dias_trabajados == "" || cant_lunes == "")
        {
            $("#respuesta_quincena").html('<div class="alert alert-danger" align="center" role="alert">Llenar los campos básicos</div>');    
        }
        else
        {

            if(dias_trabajados == 5)
            {
                dias_trabajados = 4.95 * 1;
            }

            var asig_quinc = sueldo_diario * dias_trabajados;
            var asig_feriado = (sueldo_diario * 1.5) * dias_feriados;
            var asig_cesta = dias_cesta * DIA_CESTA_TICKET;
            var asig_h_diur = (sueldo_diario/7.5 * 1.5) * h_extras_diur;
            var asig_h_noct = (sueldo_diario/7.5 * 1.8) * h_extras_noct;
            var asig_bonif = bonificacion * 1;
            var asig_otros = otros * 1;
            var asig_total = asig_quinc + asig_feriado + asig_cesta + asig_h_diur + asig_h_noct + asig_bonif + asig_otros + total_vacas + total_bono_vacas + total_utilidades + interes_anti + adelanto_anti;

            var semana_cot = (sueldo_diario * 30) * 12 / 52;
            var ret_seguro = (semana_cot * cant_lunes) * 0.045;

            var ret_faov = (sueldo_diario * 15) * 0.01;
            var ret_prestamo = prestamos * 1;
            var ret_iva_ = ret_iva * 1;
            var ret_total = ret_seguro + ret_faov + ret_iva_ + ret_prestamo;

            var neto_cobrar = asig_total - ret_total;

            //alert(asig_quinc+" "+asig_feriado+" "+asig_cesta+" "+asig_h_diur+" "+asig_h_noct+" "+asig_bonif+" "+asig_otros+" "+total_vacas+" "+total_bono_vacas);

            $('#dias_feriados').val(dias_feriados);
            $('#dias_cesta').val(dias_cesta);
            $('#h_extras_noct').val(h_extras_noct);
            $('#h_extras_diur').val(h_extras_diur);
            $('#cesta_bs').val(asig_cesta.toFixed(4));
            $('#asig_quinc').val(asig_total.toFixed(4));
            $('#seguro_social').val(ret_seguro.toFixed(4));
            $('#faov').val(ret_faov.toFixed(4));
            $('#neto_cobrar').val(neto_cobrar.toFixed(4));
            $('#ret_total').val(ret_total.toFixed(4));
        }

}

function calcular_quincena_editar()
{

        var DIA_CESTA_TICKET = $("#monto_bs_cesta").val();

        var id_personal = $('#q_id_ed').val();
        var sueldo_diario = $('#q_sueldo_ed').val();
        var quincena = $('#quincena').val();
        var dias_trabajados = $('#dias_traba_ed').val() * 1;
        var dias_feriados = $('#dias_feriados_ed').val() * 1;
        var dias_cesta = $('#dias_cesta_ed').val() * 1;
        var bonificacion = $('#bonificacion_ed').val();
        var h_extras_diur = $('#h_extras_diur_ed').val() * 1;
        var h_extras_noct = $('#h_extras_noct_ed').val() * 1;
        var otros = $('#otros_ed').val();
        var cant_lunes = $('#cant_lunes_ed').val();
        var prestamos = $('#prestamos_ed').val();
        var ret_iva = $('#ret_iva_ed').val();
        var total_vacas = $('#total_vacaciones_ed').val() * 1;
        var total_bono_vacas = $('#total_bono_vacacional_ed').val() * 1;
        var total_utilidades = $('#total_utilidades_ed').val() * 1;
        var interes_anti = $('#interes_anti_ed').val() * 1;
        var adelanto_anti = $('#adelanto_anti_ed').val() * 1;


            if(dias_trabajados == 5)
            {
                dias_trabajados = 4.95 * 1;
            }


            var asig_quinc = sueldo_diario * dias_trabajados;
            var asig_feriado = (sueldo_diario * 1.5) * dias_feriados;
            var asig_cesta = dias_cesta * DIA_CESTA_TICKET;
            var asig_h_diur = (sueldo_diario/7.5 * 1.5) * h_extras_diur;
            var asig_h_noct = (sueldo_diario/7.5 * 1.8) * h_extras_noct;
            var asig_bonif = bonificacion * 1;
            var asig_otros = otros * 1;
            var asig_total = asig_quinc + asig_feriado + asig_cesta + asig_h_diur + asig_h_noct + asig_bonif + asig_otros + total_vacas + total_bono_vacas + total_utilidades + interes_anti + adelanto_anti;

            var semana_cot = (sueldo_diario * 30) * 12 / 52;
            var ret_seguro = (semana_cot * cant_lunes) * 0.045;

            var ret_faov = (sueldo_diario * 15) * 0.01;
            var ret_prestamo = prestamos * 1;
            var ret_iva_ = ret_iva * 1;
            var ret_total = ret_seguro + ret_faov + ret_iva_ + ret_prestamo;

            var neto_cobrar = asig_total - ret_total;

            $('#dias_feriados_ed').val(dias_feriados);
            $('#dias_cesta_ed').val(dias_cesta);
            $('#h_extras_noct_ed').val(h_extras_noct);
            $('#h_extras_diur_ed').val(h_extras_diur);
            $('#cesta_bs_ed').val(asig_cesta.toFixed(4));
            $('#asig_quinc_ed').val(asig_total.toFixed(4));
            $('#seguro_social_ed').val(ret_seguro.toFixed(4));
            $('#faov_ed').val(ret_faov.toFixed(4));
            $('#neto_cobrar_ed').val(neto_cobrar.toFixed(4));
            $('#ret_total_ed').val(ret_total.toFixed(4));
        

}

function calcular_vacas(id, id_, id_3)
{
     var sueldo_diario = $('#'+id_3).val();
     var dias = $('#'+id_).val();

     var total = sueldo_diario * dias;

     $('#'+id).val(total.toFixed(2));

}

function agregar_quincena()
{

   //$('#form_quincena').submit(function() {
        var DIA_CESTA_TICKET = $("#monto_bs_cesta").val();
        var id_personal = $('#q_id').val();
        var sueldo_diario = $('#q_sueldo').val();
        var tipo = $('#q_tipo').val();
        var quincena = $('#quincena').val();
        var dias_trabajados = $('#dias_traba').val();
        var dias_feriados = $('#dias_feriados').val();
        var dias_cesta = $('#dias_cesta').val();
        var bonificacion = $('#bonificacion').val();
        var h_extras_diur = $('#h_extras_diur').val();
        var h_extras_noct = $('#h_extras_noct').val();
        var otros = $('#otros').val();
        var cant_lunes = $('#cant_lunes').val();
        var prestamos = $('#prestamos').val();
        var ret_iva = $('#ret_iva').val();
        var pagina = $('#pagina').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var tipo_pago = $('#tipo_pago_asig').val();

        var dias_vacas = $('#vacaciones').val() * 1;
        var dias_bono_vacas = $('#bono_vacacional').val() * 1;
        var total_vacas = $('#total_vacaciones').val() * 1;
        var total_bono_vacas = $('#total_bono_vacacional').val() * 1;
        var dias_utilidades = $('#utilidades').val() * 1;
        var total_utilidades = $('#total_utilidades').val() * 1;
        var interes_anti = $('#interes_anti').val() * 1;
        var adelanto_anti = $('#adelanto_anti').val() * 1;

        if(quincena == "" || dias_trabajados == "" || cant_lunes == "" || tipo_pago == "" || fecha_inicio == "" || fecha_fin == "")
        {
            $("#respuesta_quincena").html('<div class="alert alert-danger" align="center" role="alert">Llenar los campos básicos</div>');    
        }
        else
        {


                if(dias_trabajados == 5)
                {
                    dias_trabajados = 4.95 * 1;
                }

                var asig_quinc = sueldo_diario * dias_trabajados;
                var asig_feriado = (sueldo_diario * 1.5) * dias_feriados;
                var asig_cesta = dias_cesta * DIA_CESTA_TICKET;
                var asig_h_diur = (sueldo_diario/7.5 * 1.5) * h_extras_diur;
                var asig_h_noct = (sueldo_diario/7.5 * 1.8) * h_extras_noct;
                var asig_bonif = bonificacion * 1;
                var asig_otros = otros * 1;
                var asig_total = asig_quinc + asig_feriado + asig_cesta + asig_h_diur + asig_h_noct + asig_bonif + asig_otros + total_vacas + total_bono_vacas + total_utilidades + interes_anti + adelanto_anti;

                var semana_cot = (sueldo_diario * 30) * 12 / 52;
                var ret_seguro = (semana_cot * cant_lunes) * 0.045;

                var ret_faov = (sueldo_diario * 15) * 0.01;
                var ret_prestamo = prestamos * 1;
                var ret_iva_ = ret_iva * 1;
                var ret_total = ret_seguro + ret_faov + ret_iva + ret_prestamo;

                var neto_cobrar = asig_total - ret_total;

                var agregar_quincena = 'agregar_quincena';


                $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{
                        'id_personal': id_personal,
                        'tipo': tipo,
                        'dias_feriados': dias_feriados,
                        'dias_cesta': dias_cesta,
                        'h_extras_noct': h_extras_noct,
                        'h_extras_diur': h_extras_diur,
                        'cant_lunes': cant_lunes,
                        'quincena': quincena,
                        'asig_quinc': asig_quinc,
                        'asig_cesta': asig_cesta,
                        'dias_trabajados': dias_trabajados,
                        'asig_bonif': asig_bonif,
                        'asig_feriado': asig_feriado,
                        'asig_h_diur': asig_h_diur,
                        'asig_h_noct': asig_h_noct,
                        'asig_otros': asig_otros,
                        'ret_seguro': ret_seguro,
                        'ret_faov' : ret_faov,
                        'ret_prestamo': ret_prestamo,
                        'ret_iva_' : ret_iva_,
                        'fecha_inicio' : fecha_inicio,
                        'fecha_fin' : fecha_fin,
                        'tipo_pago': tipo_pago,
                        'dias_vacas': dias_vacas,
                        'dias_bono_vacas': dias_bono_vacas,
                        'total_vacas': total_vacas,
                        'total_bono_vacas': total_bono_vacas,
                        'dias_utilidades': dias_utilidades,
                        'total_utilidades': total_utilidades,
                        'interes_anti': interes_anti,
                        'adelanto_anti': adelanto_anti,
                        'agregar_quincena' : agregar_quincena
                    },

                    beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                    {
                        $("#enviar_quincena").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                    },

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        
                        //alert(data);
                        if(data == "false")
                        {
                            $("#respuesta_quincena").html('<div class="alert alert-danger" align="center" role="alert">Error al momento de registar</div>');
                            setTimeout(function(){
                                    window.location="tpl_personal.php?_pagi_pg="+pagina;
                            },800);
                        }
                        if(data == "true")
                        {
                            $("#respuesta_quincena").html('<div class="alert alert-success" align="center" role="alert">Se ha registrado exitosamente</div>');
                            setTimeout(function(){
                                window.open("reporte/rpt_recibo_2.php?id="+id_personal+"&quincena="+quincena);
                            },01);
                            window.location="tpl_personal.php?_pagi_pg="+pagina;
                        }
                        if(data == "tiene")
                        {
                            $("#respuesta_quincena").html('<div class="alert alert-success" align="center" role="alert">Personal ya tiene quincena registrada</div>');
                            setTimeout(function(){
                                    window.location="tpl_personal.php?_pagi_pg="+pagina;
                            },700);
                        }
                        
                    }
                });
    
       // return false;///preventDefault preveeno manda en formulario

   // });
        }

}


function modificar_quincena()
{

   //$('#form_quincena').submit(function() {

    var DIA_CESTA_TICKET = $("#monto_bs_cesta").val();
        
        var id_personal = $('#q_id_ed').val();
        var sueldo_diario = $('#q_sueldo_ed').val();
        var id_quincena = $('#id_quincena_ed').val();
        var id_deduccion = $('#id_deduccion_ed').val();
        var quincena = $('#quincena_ed').val();
        var dias_trabajados = $('#dias_traba_ed').val();
        var dias_feriados = $('#dias_feriados_ed').val();
        var dias_cesta = $('#dias_cesta_ed').val();
        var bonificacion = $('#bonificacion_ed').val();
        var h_extras_diur = $('#h_extras_diur_ed').val();
        var h_extras_noct = $('#h_extras_noct_ed').val();
        var otros = $('#otros_ed').val();
        var cant_lunes = $('#cant_lunes_ed').val();
        var prestamos = $('#prestamos_ed').val();
        var ret_iva = $('#ret_iva_ed').val();
        var pagina = $('#pagina').val();
        var fecha_inicio = $('#fecha_inicio_ed').val();
        var fecha_fin = $('#fecha_fin_ed').val();
        var tipo_pago = $('#tipo_pago_asig_ed').val();
        var dias_vacas = $('#vacaciones_ed').val() * 1;
        var dias_bono_vacas = $('#bono_vacacional_ed').val() * 1;
        var total_vacas = $('#total_vacaciones_ed').val() * 1;
        var total_bono_vacas = $('#total_bono_vacacional_ed').val() * 1;
        var dias_utilidades = $('#utilidades_ed').val() * 1;
        var total_utilidades = $('#total_utilidades_ed').val() * 1;
        var interes_anti = $('#interes_anti_ed').val() * 1;
        var adelanto_anti = $('#adelanto_anti_ed').val() * 1;

        if(quincena == "" || dias_trabajados == "" || cant_lunes == "" || tipo_pago == "" || fecha_inicio == "" || fecha_fin == "")
        {
            $("#respuesta_modifica").html('<div class="alert alert-danger" align="center" role="alert">Llenar los campos básicos</div>');    
        }
        else
        {

                if(dias_trabajados == 5)
                {
                    dias_trabajados = 4.95 * 1;
                }

                var asig_quinc = sueldo_diario * dias_trabajados;
                var asig_feriado = (sueldo_diario * 1.5) * dias_feriados;
                var asig_cesta = dias_cesta * DIA_CESTA_TICKET;
                var asig_h_diur = (sueldo_diario/7.5 * 1.5) * h_extras_diur;
                var asig_h_noct = (sueldo_diario/7.5 * 1.8) * h_extras_noct;
                var asig_bonif = bonificacion * 1;
                var asig_otros = otros * 1;
                var asig_total = asig_quinc + asig_feriado + asig_cesta + asig_h_diur + asig_h_noct + asig_bonif + asig_otros + total_vacas + total_bono_vacas + total_utilidades + interes_anti + adelanto_anti;

                var semana_cot = (sueldo_diario * 30) * 12 / 52;
                var ret_seguro = (semana_cot * cant_lunes) * 0.045;

                var ret_faov = (sueldo_diario * 15) * 0.01;
                var ret_prestamo = prestamos * 1;
                var ret_iva_ = ret_iva * 1;
                var ret_total = ret_seguro + ret_faov + ret_iva + ret_prestamo;

                var neto_cobrar = asig_total - ret_total;

                var modificar_quincena = 'modificar_quincena';


                $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{
                        'id_personal': id_personal,
                        'id_quincena': id_quincena,
                        'id_deduccion': id_deduccion,
                        'dias_feriados': dias_feriados,
                        'dias_cesta': dias_cesta,
                        'h_extras_noct': h_extras_noct,
                        'h_extras_diur': h_extras_diur,
                        'cant_lunes': cant_lunes,
                        'quincena': quincena,
                        'asig_quinc': asig_quinc,
                        'asig_cesta': asig_cesta,
                        'dias_trabajados': dias_trabajados,
                        'asig_bonif': asig_bonif,
                        'asig_feriado': asig_feriado,
                        'asig_h_diur': asig_h_diur,
                        'asig_h_noct': asig_h_noct,
                        'asig_otros': asig_otros,
                        'ret_seguro': ret_seguro,
                        'ret_faov' : ret_faov,
                        'ret_prestamo': ret_prestamo,
                        'ret_iva_' : ret_iva_,
                        'fecha_inicio' : fecha_inicio,
                        'fecha_fin' : fecha_fin,
                        'tipo_pago': tipo_pago,
                        'dias_vacas': dias_vacas,
                        'dias_bono_vacas': dias_bono_vacas,
                        'total_vacas': total_vacas,
                        'total_bono_vacas': total_bono_vacas,
                        'dias_utilidades': dias_utilidades,
                        'total_utilidades': total_utilidades,
                        'interes_anti': interes_anti,
                        'adelanto_anti': adelanto_anti,
                        'modificar_quincena' : modificar_quincena
                    },

                    beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                    {
                        $("#modificar_quincena_").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                    },

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        
                        //alert(data);
                        if(data == "false")
                        {
                            $("#respuesta_modifica").html('<div class="alert alert-danger" align="center" role="alert">Error al momento de modificar</div>');
                            setTimeout(function(){
                                    window.location="tpl_personal.php?_pagi_pg="+pagina;
                            },800);
                        }
                        if(data == "true")
                        {
                            $("#respuesta_modifica").html('<div class="alert alert-success" align="center" role="alert">Se ha modificado exitosamente</div>');
                            setTimeout(function(){
                                    window.location="tpl_personal.php?_pagi_pg="+pagina;
                            },700);
                        }
                        
                    }
                });
            
       // return false;///preventDefault preveeno manda en formulario

   // });
        }

}

function modal_pago(value,id)
{
            
        modal(value);
        $('#re_id').val(id);

}

function generar_recibo()
{
    var id_personal = $('#re_id').val();
    var periodo = $('#periodo_recibo').val();
    var quincena = $('#quincena_recibo').val();
    var pagina = $('#pagina').val();
    var tipo_ = $('#tipo_recibo').val();

    if(periodo == "" || quincena == "")
    {
        alert("Elija una Opción");
    }
    else if(tipo_ == 1)
    {
        setTimeout(function(){
                window.open("reporte/rpt_recibo_2.php?id="+id_personal+"&periodo="+periodo+"&quincena="+quincena,'_blank');
        },01);
    }
    else if(tipo_ == 2)
    {
        setTimeout(function(){
                window.open("reporte/rpt_recibo_1.php?id="+id_personal+"&periodo="+periodo+"&quincena="+quincena,'_blank');
        },01);
    }
}

function act_cantidad()
{
    var cant_vaca = $('#cant_vaca').val() * 1;
    var cant_toro = $('#cant_toro').val() * 1;
    var total = 0;

    total = cant_vaca + cant_toro;

    $('#cant_mondongo').val(total);
    $('#cant_cuero').val(total);
}

function guardar_entrada(value)
{
    
    var cant_vaca = $('#cant_vaca').val() * 1;
    var cant_toro = $('#cant_toro').val() * 1;
    var fecha_entrada = $('#fecha_entrada').val();
    var cant_chinchurria = $('#cant_chinchurria').val();
    var cant_ccuero = $('#cant_ccuero').val();
    var total = cant_vaca + cant_toro;
    var agregar_entrada = 'agregar_entrada';

    if(fecha_entrada == " " || cant_chinchurria == " " || cant_ccuero == " ")
    {
        $("#respuesta_entrada").html('<div class="alert alert-danger" align="center" role="alert">No debe dejar campos vacíos</div>');
    }
    else
    {

        $.ajax({
            type:"GET",
            url: "control.php",
            data:
            {
                'agregar_entrada' : agregar_entrada,
                'cant_toro' : cant_toro,
                'cant_vaca' : cant_vaca,
                'cant_chinchurria' : cant_chinchurria,
                'cant_ccuero' : cant_ccuero,
                'total' : total,
                'fecha_entrada' :fecha_entrada
            },
            cache : false,

            beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
            {
                $("#enviar_materia").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
            },

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
               // alert(data);
                if(data == "true")
                {
                    $("#respuesta_entrada").html('<div class="alert alert-success" align="center" role="alert">Se ha ingresado exitosamente</div>');
                    setTimeout(function(){
                            window.location="tpl_inventario.php?get="+value;
                    },700);
                    
                }
                
            }
        });
    }
}

function modal_salida(value, id, vaca_entrada, toro_entrada, total_entrada)
{

        modal(value);

        $('#mat_id').val(id);
            
        $('#mat_').val(id);

        $('#cant_vaca_matanza').val(vaca_entrada);

        $('#cant_toro_matanza').val(toro_entrada);

        $('#temp_vaca').val(vaca_entrada);

        $('#temp_toro').val(toro_entrada);

        $('#total_entrada').val(total_entrada);

        $('#resto_temp').val(total_entrada);

        $('#resto_temp_').val(total_entrada);
            
}

function salida_matanza(value)
{
    if(value == 'MATANZA' || value == 'MONDONGO')
    {
        var cant_vaca_p = $('#cant_vaca_p').val() * 1;
        var cant_toro_p = $('#cant_toro_p').val() * 1;
        var cant_vaca_py = $('#cant_vaca_py').val() * 1;
        var cant_toro_py = $('#cant_toro_py').val() * 1;
        var precio_uno = $('#precio_uno').val() * 1;
        var auto_consumo_mat = $('#auto_consumo_mat').val() * 1;
        var retiro_mat = $('#retiro_mat').val() * 1;
        var cant_mondongo_p = $('#cant_mondongo_p').val() * 1;
        var cant_mondongo_py = $('#cant_mondongo_py').val() * 1;
        var salida_id = $('#mat_id').val();
        var descrip_tipo = value;
        var resto_temp = $('#resto_temp').val() * 1;
        var salida_matanza = 'salida_matanza';

        if(precio_uno == "")
        {
            $("#respuesta_salida").html('<div class="alert alert-danger" align="center" role="alert">No debe dejar campos vacíos</div>');
        }
        else
        {
            $.ajax({
                type:"GET",
                url: "control.php",
                data:
                {
                    'salida_matanza' : salida_matanza,
                    'salida_id' : salida_id,
                    'cant_toro_p' : cant_toro_p,
                    'cant_vaca_p' : cant_vaca_p,
                    'cant_mondongo_py' : cant_mondongo_py,
                    'cant_mondongo_p' : cant_mondongo_p,
                    'precio_uno' : precio_uno,
                    'cant_toro_py' : cant_toro_py,
                    'cant_vaca_py' : cant_vaca_py,
                    'auto_consumo_mat' : auto_consumo_mat,
                    'descrip_tipo' : descrip_tipo,
                    'resto_temp' : resto_temp,
                    'retiro_mat' : retiro_mat

                },
                cache : false,

                beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                {
                    $("#salida_materia").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                },

                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {
                    console.log(data);
                    if(data == "true")
                    {
                        $("#respuesta_salida").html('<div class="alert alert-success" align="center" role="alert">Se ha ingresado exitosamente</div>');
                        setTimeout(function(){
                                window.location="tpl_inventario.php?get="+value;
                        },1000);
                        
                    }
                    if(data == "error_mat")
                    {
                        $("#respuesta_salida").html('<div class="alert alert-danger" align="center" role="alert">Error inesperado</div>');
                        setTimeout(function(){
                                window.location="tpl_inventario.php?get="+value;
                        },700);
                        
                    }
                    if(data == "tiene_reg")
                    {
                        $("#respuesta_salida").html('<div class="alert alert-danger" align="center" role="alert">YA SE HA CARGADO LA SALIDA</div>');
                        setTimeout(function(){
                                window.location="tpl_inventario.php?get="+value;
                        },700);
                        
                    }
                }
            });
        }
    }

    if(value == 'CUEROS' || value == 'CHINCHURRIA' || value == 'CARNE-CUERO')
    {
        var cantidad_sal = $('#cantidad_sal').val() * 1;
        var salida_id = $('#mat_').val();
        var resto_temp_ = $('#resto_temp_').val() * 1;
        var descrip_tipo = value;
        var salida_matanza = 'salida_matanza';
        var precio_dos = $('#precio_dos').val() * 1;

        if(cantidad_sal == "" || precio_dos == "")
        {
            $("#respuesta_salida_2").html('<div class="alert alert-danger" align="center" role="alert">No debe dejar campos vacíos</div>');        
        }
        else
        {

            $.ajax({
                type:"GET",
                url: "control.php",
                data:
                {
                    'cantidad_sal' : cantidad_sal,
                    'salida_id' : salida_id,
                    'descrip_tipo' : descrip_tipo,
                    'precio_dos' : precio_dos,
                    'salida_matanza' : salida_matanza,
                    'resto_temp_' : resto_temp_

                },
                cache : false,

                beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                {
                    $("#salida_materia").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                },
                
                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {

                    console.log(data);
                    if(data == "true")
                    {
                        $("#respuesta_salida_2").html('<div class="alert alert-success" align="center" role="alert">Se ha ingresado exitosamente</div>');
                        setTimeout(function(){
                                window.location="tpl_inventario.php?get="+value;
                        },700);
                        
                    }
                    if(data == "error_mat")
                    {
                        $("#respuesta_salida_2").html('<div class="alert alert-danger" align="center" role="alert">Error inesperado</div>');
                        setTimeout(function(){
                                window.location="tpl_inventario.php?get="+value;
                        },700);
                        
                    }
                    if(data == "error_act")
                    {
                        $("#respuesta_salida_2").html('<div class="alert alert-danger" align="center" role="alert">Error actualizando los datos</div>');
                        setTimeout(function(){
                                window.location="tpl_inventario.php?get="+value;
                        },700);
                        
                    }
                    if(data == "tiene_reg")
                    {
                        $("#respuesta_salida_2").html('<div class="alert alert-danger" align="center" role="alert">Ya se ha cargado la Salida</div>');
                        setTimeout(function(){
                                window.location="tpl_inventario.php?get="+value;
                        },700);
                        
                    }
                    
                }
            });
        }
    }
    
}

function valida_inventario(id)
{
    var cantidad_ingre = $('#'+id).val() * 1;
    var cant_vaca = $('#cant_vaca_matanza').val() * 1;
    var cant_toro = $('#cant_toro_matanza').val() * 1;
    var total_entrada = $('#total_entrada').val() * 1;
    var resto_ = $('#resto_temp').val() * 1;
    var resto_t = $('#resto_temp_').val() * 1;
    var resto_vaca = $('#temp_vaca').val() * 1;
    var resto_toro = $('#temp_toro').val() * 1;


    if(cantidad_ingre > total_entrada)
    {
        alert('No se puede sobrepasar del inventario actual'); 
        $('#'+id).val('');   
        $('#resto_temp').val(resto_);           
    }
    else if(cantidad_ingre <= resto_)
    {
        var resto_temp = resto_ - cantidad_ingre;

        $('#resto_temp').val(resto_temp);
        $('#resto_temp_').val(resto_temp);

    }
    else if(cantidad_ingre > resto_)
    {
        alert('Se ha excedido el resto');
        $('#'+id).val('');
        $('#resto_temp').val(resto_);
    }

    bovino(id, cantidad_ingre, cant_vaca, resto_vaca, cant_toro, resto_toro, resto_);


}

function bovino(id, cantidad_ingre, cant_vaca, resto_vaca, cant_toro, resto_toro, resto_)
{
    //RESTA DE INVENTARIO DE VACA
    
    if(id == 'cant_vaca_p' || id == 'cant_vaca_py')
    {
       
        if(cantidad_ingre > cant_vaca)
        {
            alert('No se puede sobrepasar cantidad de vaca'); 
            $('#resto_temp').val(resto_);
            $('#'+id).val('');
        }
        else if(cantidad_ingre <= resto_vaca)
        {
            var resto_vaca_tem = resto_vaca - cantidad_ingre;
            
            $('#temp_vaca').val(resto_vaca_tem);
        }
        else if(cantidad_ingre > resto_vaca)
        {
            alert('Se ha excedido el resto de invantario vaca');
            $('#'+id).val('');
            $('#resto_temp').val(resto_);
        }
    }

    if(id == 'cant_toro_p' || id == 'cant_toro_py')
    {
       
        if(cantidad_ingre > cant_toro)
        {
            alert('No se puede sobrepasar cantidad de toro'); 
            $('#resto_temp').val(resto_);
            $('#'+id).val('');
        }
        else if(cantidad_ingre <= resto_toro)
        {
           
            var resto_toro_tem = resto_toro - cantidad_ingre;
            
            $('#temp_toro').val(resto_toro_tem);
        }
        else if(cantidad_ingre > resto_toro)
        {
            alert('Se ha excedido el resto de invantario toro');
            $('#'+id).val('');
            $('#resto_temp').val(resto_);
        }
    }
}

function modal_otras_asig(value,id,sueldo,ape,nom,vaca,dias_vaca,fin_ano)
{
            
            modal(value);
            $('#id_otra').val(id);
            $('#sueldo_otra').val(sueldo);
            $('#titulo_otras').html('Nombre: '+ape+' '+nom+' -- Días Vacaciones: '+dias_vaca);
   
}

function guardar_otra_asig(value)
{

    var tipo_otra_asig = $('#tipo_otra_asig').val();
    var fecha_otras_asig = $('#fecha_otras_asig').val();
    var id_otra = $('#id_otra').val();
    var sueldo_otra = $('#sueldo_otra').val() * 1;
    var vaca_otra = $('#vaca_otra').val() * 1;
    var dias_otra = $('#dias_otra').val() * 1;
    var fin_otra = $('#fin_otra').val() * 1;
    var otros_ = $('#otros_').val() * 1;
    var otros_pagos = $('#otros_pagos').val() * 1;
    var pagina = $('#pagina').val();
    var guardar_otra_asig = 'guardar_otra_asig';

    $.ajax({
            type:"GET",
            url: "control.php",
            data:
            {
                'tipo_otra_asig' : tipo_otra_asig,
                'fecha_otras_asig' : fecha_otras_asig,
                'id_otra' : id_otra,
                'dias_otra' : dias_otra,
                'sueldo_otra' : sueldo_otra,
                'vaca_otra' :vaca_otra,
                'fin_otra' :fin_otra,
                'otros_' :otros_,
                'otros_pagos' :otros_pagos,
                'guardar_otra_asig' :guardar_otra_asig
            },
            cache : false,

            beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
            {
                $("#guardar_otra_asig_").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
            },

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
                //alert(data);
                if(data == "true")
                {
                    $("#respuesta_otra_asig").html('<div class="alert alert-success" align="center" role="alert">Se ha ingresado exitosamente</div>');
                    setTimeout(function(){
                            window.location="tpl_personal.php?get="+pagina;
                    },700);
                    
                }
                
            }
        });
}

function agregar_sujeto_ret()
{
 
        var rif_sujeto = $('#rif_sujeto').val().toUpperCase();
        var nombre_sujeto = $('#nombre_sujeto').val().toUpperCase();
        var direccion_sujeto = $('#direccion_sujeto').val().toUpperCase();
        var agregar_sujeto = 'agregar_sujeto';
        var page = 'tpl_retencion_iva';

        if(rif_sujeto == "" || nombre_sujeto == "" || direccion_sujeto == "")
        {
            $("#respuesta_sujeto").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
        }
        else
        {


            $.ajax({
                type:"GET",
                url: "control.php",
                data:{
                    'direccion_sujeto': direccion_sujeto,
                    'rif_sujeto': rif_sujeto,
                    'nombre_sujeto': nombre_sujeto,
                    'agregar_sujeto' : agregar_sujeto
                },
                cache : false,

                beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                {
                    $("#respuesta_sujeto").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                },

                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {
                   // alert(data);

                    if(data == "false")
                    {
                        $("#respuesta_sujeto").html('<div class="alert alert-danger" align="center" role="alert">No se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location=page+".php";
                        },600);
                    }
                    if(data == "true")
                    {
                        $("#respuesta_sujeto").html('<div class="alert alert-success" align="center" role="alert">Se ha realizado el registro</div>');
                        setTimeout(function(){
                            window.location=page+".php";
                        },700);
                    }
                    
                }
            });
        }
}

function modal_sujeto_iva(value,id_sujeto,rif_sujeto,nombre_sujeto,direccion_sujeto)
{
            
            modal(value);
            $('#ed_id_sujeto').val(id_sujeto);
            $('#ed_rif_sujeto').val(rif_sujeto);
            $('#ed_nombre_sujeto').val(nombre_sujeto);
            $('#ed_direccion_sujeto').val(direccion_sujeto);
}

function editar_sujeto()
{

        var ed_id_sujeto = $('#ed_id_sujeto').val();
        var ed_rif_sujeto = $('#ed_rif_sujeto').val().toUpperCase();
        var ed_nombre_sujeto = $('#ed_nombre_sujeto').val().toUpperCase();
        var ed_direccion_sujeto = $('#ed_direccion_sujeto').val();
        var pagina = $('#pagina').val();
        var editar_sujeto = 'editar_sujeto';
        var page = 'tpl_retencion_iva';

        if(ed_rif_sujeto == "" || ed_nombre_sujeto == "" || ed_direccion_sujeto == "")
        {
            $("#respuesta_editar_sujeto").html('<div class="alert alert-danger" align="center" role="alert">No puede dejar campos vacíos</div>');
        }
        else
        {


                $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{

                        'ed_id_sujeto': ed_id_sujeto,
                        'ed_rif_sujeto': ed_rif_sujeto,
                        'ed_nombre_sujeto': ed_nombre_sujeto,
                        'ed_direccion_sujeto': ed_direccion_sujeto,
                        'editar_sujeto' : editar_sujeto
                    },

                    beforeSend: function (data) //-->verificamos si ya se enviaron los parametros
                    {
                        $("#respuesta_editar_sujeto").html("<center><img style='margin-top:20px'  width='25px' src='imagenes/loading.gif'></center>");
                    },

                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {
                        console.log(data);

                        if(data == "false")
                        {
                            $("#respuesta_editar_sujeto").html('<div class="alert alert-danger" align="center" role="alert">No se pudo efectuar la operación</div>');
                            setTimeout(function(){
                                window.location=page+".php?_pagi_pg="+pagina;
                            },600);
                        }
                        else
                        {
                            $("#respuesta_editar_sujeto").html('<div class="alert alert-success" align="center" role="alert">Operación exitosa</div>');
                            setTimeout(function(){
                                window.location=page+".php?_pagi_pg="+pagina;
                            },600);
                        }
                        
                    }
                });
        }
 
}

function modal_retencion_iva(value,id_sujeto, nombre_sujeto, rif_sujeto)
{
            $('#principal').hide('slow', function()
                            {
                                setTimeout(function() 
                                {
                                        $("#"+value).show(); 
                                        $('#id_sujeto_ret').val(id_sujeto);
                                        $('#nombre_sujeto_ret').val(nombre_sujeto);
                                        $('#rif_sujeto_ret').val(rif_sujeto);
                                }, 300);
                            });
}


function agregar_operacion()
{
 
        var id_sujeto_ret = $('#id_sujeto_ret').val();
        var n_operacion = $('#n_operacion').val();
        var n_comprobante = $('#n_comprobante').val();
        var fecha_emision = $('#fecha_emision').val();
        var ano_retencion_iva = $('#ano_retencion_iva').val();
        var mes_retencion_iva = $('#mes_retencion_iva').val();
        var fecha_factura = $('#fecha_factura').val();
        var n_factura = $('#n_factura').val();
        var n_control = $('#n_control').val();
        var n_debito = $('#n_debito').val();
        var n_credito = $('#n_credito').val();
        var tipo_trans = $('#tipo_trans').val();
        var n_fact_afect = $('#n_fact_afect').val();
        var tota_iva = $('#tota_iva').val();
        var total_exc = $('#total_exc').val();
        var base_imponible = $('#base_imponible').val();
        var alicuota = $('#alicuota').val();
        var iva = $('#iva').val();
        var iva_ret = $('#iva_ret').val();
        var agregar_operacion = 'agregar_operacion';

       // alert(n_comprobante);

        if(fecha_emision != "" && n_operacion != "" && fecha_factura != "" && n_factura != "" && n_control != "" && tota_iva != "" && porcentaje != "" )
        {

        
            $.ajax({
                type:"GET",
                url: "control.php",
                data:{
                    'n_operacion': n_operacion,
                    'n_comprobante': n_comprobante,
                    'fecha_emision': fecha_emision,
                    'id_sujeto_ret': id_sujeto_ret,
                    'ano_retencion_iva': ano_retencion_iva,
                    'mes_retencion_iva': mes_retencion_iva,
                    'fecha_factura': fecha_factura,
                    'n_factura': n_factura,
                    'n_control': n_control,
                    'n_debito': n_debito,
                    'n_credito': n_credito,
                    'tipo_trans': tipo_trans,
                    'n_fact_afect': n_fact_afect,
                    'tota_iva': tota_iva,
                    'total_exc': total_exc,
                    'base_imponible': base_imponible,
                    'alicuota': alicuota,
                    'iva': iva,
                    'iva_ret': iva_ret,
                    'agregar_operacion' : agregar_operacion
                },
                cache : false,

                

                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {
                   
                   // alert(data.exito);
                    if(data.exito != true)
                    {
                        $("#respuesta_operacion").html('<div class="alert alert-danger" align="center" role="alert">No se ha realizado el registro</div>');
                        
                    }
                    if(data.exito == true)
                    {
                        $('#tabla_iva tr:last').after(
                         '<tr id="fila_'+data.id_+'">'
                          +
                          '<td>'+data.n_operacion+'</td>'
                          +
                          '<td>'+data.fecha_factura+'</td>'
                          +
                          '<td>'+data.n_factura+'</td>'
                          +
                          '<td>'+data.n_control+'</td>'
                          +
                          '<td>'+data.n_debito+'</td>'
                          +
                          '<td>'+data.n_credito+'</td>'
                          +
                          '<td>'+data.tipo_trans+'</td>'
                          +
                          '<td>'+data.n_fact_afect+'</td>'
                          +
                          '<td>'+data.tota_iva+'</td>'
                          +
                          '<td>'+data.total_exc+'</td>'
                          +
                          '<td>'+data.base_imponible+'</td>'
                          +
                          '<td>'+data.alicuota+'</td>'
                          +
                          '<td>'+data.iva+'</td>'
                          +
                          '<td>'+data.iva_ret+'</td>'
                          +
                          '<td><a onclick="eliminar()">Eliminar</a></td>'
                          +
                          '</tr>'
                         );
                            
                            $('#control_iva').val(data.exito);

                            $('#n_operacion').val("");
                            $('#fecha_factura').val("");
                            $('#n_factura').val("");
                            $('#n_control').val("");
                            $('#n_debito').val("");
                            $('#n_credito').val("");
                            $('#tipo_trans').val("");
                            $('#n_fact_afect').val("");
                            $('#tota_iva').val("");
                            $('#total_exc').val("");
                            $('#base_imponible').val("");
                            $('#alicuota').val("");
                            $('#iva').val("");
                            $('#iva_ret').val("");
                            $('#porcentaje').val("");

                            $('#retencion_personal_').show('');

                    }
                    
                }
            });
        }
        else
        {
            alert("No dejar campos vacíos");
        }
        
}

function calcular_ret()
{   
    
    var total_iva = $('#tota_iva').val();
    var porcent = $('#porcentaje').val() / 100;
    var base_imp = total_iva / 1.12;
    var alicuota = 12;
    var impuesto = total_iva - base_imp;
    var ret_ = impuesto * porcent;

    $('#base_imponible').val(base_imp.toFixed(4));
    $('#alicuota').val(alicuota.toFixed(4));
    $('#iva').val(impuesto.toFixed(4));
    $('#iva_ret').val(ret_.toFixed(4));


}

function enviar_retencion_iva(value, id_su, n_com)
{
    if(value == true)
    {
        window.open("reporte/rpt_retencion_iva.php?id="+id_su+"&comprobante="+n_com);
    }
    else
    {


                var n_comprobante = $('#n_comprobante').val();
                var id_sujeto = $('#id_sujeto_ret').val();
                var control_iva = $('#control_iva').val();
                var fecha_emision = $('#fecha_emision').val();

                var n_operacion = $('#n_operacion').val();
                var fecha_factura = $('#fecha_factura').val();
                var n_factura = $('#n_factura').val();
                var n_control = $('#n_control').val();
                var tota_iva = $('#tota_iva').val();
                var porcentaje = $('#porcentaje').val();
                var consul_reten = 'consul_reten';

        $.ajax({
                    type:"GET",
                    url: "control.php",
                    data:{

                        'n_comprobante': n_comprobante,
                        'consul_reten' : consul_reten
                    },


                    success:  function (data) //-->verificamos si el servidor envio una respuesta
                    {

                        if(data == "false")
                        {
                            
                                if(control_iva == "true" && fecha_emision != "" && n_operacion != "" && fecha_factura != "" && n_factura != "" && n_control != "" && tota_iva != "" && porcentaje != "" )
                                {

                                    window.open("reporte/rpt_retencion_iva.php?id="+id_sujeto+"&comprobante="+n_comprobante);
                                    setTimeout(function(){
                                        window.location='tpl_retencion_iva.php';
                                    },13);

                                }
                                else
                                {
                                    alert("No dejar campos vacíos");
                                }
                        }
                        else
                        {
                            window.open("reporte/rpt_retencion_iva.php?id="+id_sujeto+"&comprobante="+n_comprobante);
                            setTimeout(function(){
                                        window.location='tpl_retencion_iva.php';
                                    },13);
                        }
                        
                    }
                });

    }

}

function modal_view_retencion_iva(value,id_sujeto, nombre_sujeto)
{
        
        $("#contenido_mostrar").empty();

        modal(value);

            $('#contenido_mostrar').html(
            
                '   <div class= "row" > '+
                        '<div class="col-md-12" >'+
                            
                                  '<center><div id="titulo_"></div></center>'+
                                  
                                  '<center><table class="table table-hover" id="table_view_iva">'+
                                      '<tr>'+
                                      '</tr>'+
                                  '</table></center>'+

                              '<div id="respuesta_mostrar"></div>'+
                        '</div>'+
                    '</div>'
                );
    
    
        var consulta_sujeto_ = "consulta_sujeto_";

        
            $('#titulo_').html("Retenciones de "+nombre_sujeto);


            $.ajax({
                type:"GET",
                url: "control.php",
                data:{
                    'id_sujeto': id_sujeto,
                    'consulta_sujeto_' : consulta_sujeto_
                },
                cache : false,

                

                success:  function (data) //-->verificamos si el servidor envio una respuesta
                {
                    

                    console.log(data.n_comprobante);

                    if(data.n_comprobante == false)
                    {
                        $("#respuesta_mostrar").html('<div class="alert alert-danger" align="center" role="alert">No se encontró datos relacionados</div>');

                    }
                    else
                    {

                      var row=JSON.parse(data);
                      var ver = true;

                              $('#table_view_iva tr:last').after(
                                      
                                      '<tr>'+
                                          '<td> Nº Comprobante'+'</td>'+
                                          '<td> Fecha Emision'+'</td>'+
                                          '<td> Iva Retenido'+'</td>'+
                                          '<td> Opción'+'</td>'+
                                      '</tr>'

                                );

                      $.each(row, function(i,item){

                              //console.log("<br>"+i+" - "+row[i].n_comprobante_iva+" - "+row[i].fecha_emision_iva+" - "+row[i].iva_retenido);
                              $('#table_view_iva tr:last').after(
                                 
                                     '<tr >'
                                      +
                                      '<td>'+row[i].n_comprobante_iva+'</td>'
                                      +
                                      '<td>'+row[i].fecha_emision_iva+'</td>'
                                      +
                                      '<td>'+row[i].iva_retenido+'</td>'
                                      +
                                      '<td><a onclick="enviar_retencion_iva('+ver+','+id_sujeto+','+row[i].n_comprobante_iva+')">Ver</a></td>'
                                      +
                                      '</tr>'
                                 
                                );
                       });
                    }
                         
                }
            });
                           
}

function antiguedad_acumulada(id)
{
    var variable = "";
    var monto_antiguedad = $('#buscador').val();
    var monto_interes = $('#buscador_').val();

    if(isNaN(monto_antiguedad) || isNaN(monto_interes))
    {
        alert("No Válido, Ingresar Datos Numéricos");
    }
    else
    {
        $.ajax({
            type:"GET",
            url: "tpl_prestaciones.php",
            data:{
                'variable' : variable
            },
            cache : false,

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
            
                if(data != "")
                {
                    window.location="tpl_prestaciones.php?id="+id+"&monto_antiguedad="+monto_antiguedad+"&monto_interes="+monto_interes;
                }
                
            }
        });
    }
}

function calcular_interes(cont)
{
    var menos_uno = cont - 1;
    var ant_acumulada = $("#ant_acumulada_"+menos_uno).val();
    var tasa_interes = $("#tasa_int_"+cont).val();
    var tasa_mensual = tasa_interes / 12;
    var intereses = (ant_acumulada * tasa_mensual.toFixed(4)) / 100;

    if(cont == 1)
    {
        var sum_interes = $("#buscador_").val();
        $("#tasa_mensual_"+cont).html(tasa_mensual.toFixed(4));
        $("#intereses"+cont).html(sum_interes);

    } 
    else
    {
       
        $("#tasa_mensual_"+cont).html(tasa_mensual.toFixed(4));
        $("#intereses"+cont).html(intereses.toFixed(2));
    
        var interes_ = $("#sum_interes_"+menos_uno).val() * 1;
        var sum_interes_ = interes_ + intereses;
        $("#sum_interes_"+cont).val(sum_interes_.toFixed(2));

        //console.log(sum_interes_);
  
    }
}

function calcular_total(cont, value)
{
      
       modal(value);

       var total_interes = $("#sum_interes_"+cont).val() * 1;
       var total_antiguedad = $("#ant_acumulada_"+cont).val() * 1;
       var total_ = total_interes + total_antiguedad;
       $("#total_antiguedad").val(total_antiguedad);
       $("#interes_antiguedad").val(total_interes);
       $("#total_").val(total_);
}

function agregar_periodo()
{
    
        var ano = $('#ano').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var periodo_ = 'periodo_';

        $.ajax({
            type:"GET",
            url: "control.php",
            data:{
                'ano': ano,
                'fecha_inicio' : fecha_inicio,
                'fecha_fin' : fecha_fin,
                'periodo_' : periodo_
            },

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
               //alert(data);
                if(data == "false")
                {
                    $("#respuesta_peri").html('<div class="alert alert-danger" align="center" role="alert">Ingrese un año diferente</div>');
                }
                if(data == "igual")
                {
                    $("#respuesta_peri").html('<div class="alert alert-danger" align="center" role="alert">Ya existe un período para este año</div>');
                }
                if(data == "true")
                {
                    $("#respuesta_peri").html('<div class="alert alert-info" align="center" role="alert">Registro exitoso</div>');
                    setTimeout(function(){
                                        window.location='tpl_periodo.php';
                                    },13);
                }
                
            }
        });
    
        

}

function eliminar_periodo(value)
{
    var id_periodo = value;
    var eliminar_periodo = 'eliminar_periodo';
    var pagina = $('#pagina').val();

    setTimeout(function(){  
        $.ajax({
            type:"GET",
            url: "control.php",
            data:{
                'eliminar_periodo' : eliminar_periodo,
                'id_periodo' : id_periodo,
            },
            cache : false,

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
                //alert(data);
                
                if(data == "true")
                {
                    window.location="tpl_periodo.php";
                }
                
            }
        });
    },700);
}


function agregar_cesta()
{
    
        var monto_bs = $('#monto_bs').val();
        var cesta_ = 'cesta_';

        $.ajax({
            type:"GET",
            url: "control.php",
            data:{
                'monto_bs': monto_bs,
                'cesta_' : cesta_
            },

            success:  function (data) //-->verificamos si el servidor envio una respuesta
            {
               //alert(data);
                if(data == "false")
                {
                    $("#respuesta_cesta").html('<div class="alert alert-danger" align="center" role="alert">Ingrese nuevamente</div>');
                }
                if(data == "true")
                {
                    $("#respuesta_cesta").html('<div class="alert alert-info" align="center" role="alert">Registro exitoso</div>');
                    setTimeout(function(){
                                        window.location='tpl_personal.php';
                                    },13);
                }
                
            }
        }); 

}