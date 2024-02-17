//bases
var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 
var nombre_usuario = $('meta[name="nombre_usuario"]').attr('content');
var dominio = $('meta[name="dominio"]').attr('content');
var puerto = $('meta[name="puerto"]').attr('content');

//crea el socket
var socket = io.connect(dominio+':'+puerto);

socket.on("client_nuevoPost", function(data)
{ 
    //popup superior
    $.bigBox({
        title   : data.titulo,
        content : data.mensaje,
        color : "#3276B1",
        icon : "fa fa-bell swing animated",
        timeout : 5000
    });
    posteos();
    return false;
});

socket.on("client_nuevoEnBuzon", function(data)
{ 
    //Si el usuario actual es el indicado por parámetro..
    if(id_usuario == data.idUsuarioSiguiente)
    {  
        $.bigBox({
            title   : "Nuevo radicado en buzón",
            content : data.mensaje,
            color : "#739E73",
            icon : "fa fa-bell swing animated",
            timeout : 5000
        });   

        var ruta = base_url +'/'+ 'buzon/cantidadBuzon';  

        var parametros = {
            "id_usuario" : id_usuario
        };
      
        $.ajax({                
            data:  parametros,               
            url:   ruta,
            type:  'post',
            success:  function (responseText) {
                $("#textoPendientesMaster").text(responseText);
                $("#textoPendientes").text(responseText);
            },
        });
        buzonProcesos();      
        return false;
    }
});

socket.on("client_nuevaAgenda", function(data)
{ 
    //Si el usuario actual es el indicado por parámetro..
    if(id_usuario == data.idUsuarioAgenda)
    {  
        $.bigBox({
            title   : "Nueva tarea agendada",
            content : data.mensaje,
            color : "#739E73",
            icon : "fa fa-bell swing animated",
            timeout : 5000
        });   
    
        tareasPendientes();  
        tareasInformativas(1);          
        return false;
    }
});