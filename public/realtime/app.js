const myModule = require('./mymodule');
let ambiente = myModule.ambiente();
let puerto = myModule.puerto();
let clave = myModule.clave();
let crt = myModule.crt();
let bundle = myModule.bundle();//

if(ambiente == 1)
{
	//SERVIDOR ###
	var fs = require('fs');
	var options = {
	  key: fs.readFileSync(clave),
	  cert: fs.readFileSync(crt),
	  ca: [fs.readFileSync(bundle)]
	};
	var app = require('https').createServer(options);
	var io = require('socket.io').listen(app);
	app.listen(puerto);
	//###------------------------------------------------------
}
else
{
	//LOCAL
	var io = require('socket.io').listen(puerto);
	//----------
}

//al conectar un usuario||socket, este evento viene predefinido por socketio
io.sockets.on('connection', arranque);

function arranque(socketUsuario) 
{   
	//******* Escucha ************************************	
	socketUsuario.on("server_nuevoPost", function(data)
	{   console.log(data.nombresUsuario);
		//******* Emite **********************************
		//crea la notificación para todos los usuarios conectados excepto el usuario que está creando el post
		socketUsuario.broadcast.emit("client_nuevoPost", {titulo: "Nueva Publicación", mensaje: data.nombresUsuario + " ha realizado una publicación." });		
	});
 	//**************************************************

	//******* Escucha ************************************
	socketUsuario.on('server_nuevoEnBuzon', function (data) {
		console.log(data.idUsuarioSiguiente+" "+data.mensaje);
	    io.sockets.emit("client_nuevoEnBuzon", data);
	});	

	//******* Escucha ************************************
	socketUsuario.on('server_nuevaAgenda', function (data) {
		console.log(data.idUsuarioAgenda+" "+data.mensaje);
	    io.sockets.emit("client_nuevaAgenda", data);
	});	
}