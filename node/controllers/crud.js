const conexion = require('../database/db');
const bcrypt = require('bcryptjs');

//Clientes
exports.save = async (req, res) => {
    const Nom = req.body.Nom;
    const Cognom = req.body.Cognom;
    const DNI = req.body.DNI;
    const CorreuElectronic = req.body.CorreuElectronic;
    const Telefon = req.body.Telefon;
    const Usuari = req.body.Usuari;
    const Password = req.body.Password; // Contraseña sin hashear
    const Id_Pais = req.body.Id_Pais;
    const Ciudad = req.body.Ciudad;
    const CodigoPostal = req.body.CodigoPostal;

    try {
        // Hashear la contraseña
        const hashedPassword = await bcrypt.hash(Password, 10);

        // Insertar datos en la base de datos
        conexion.query(
            'INSERT INTO Clients SET ?',
            {
                Nom: Nom,
                Cognom: Cognom,
                DNI: DNI,
                CorreuElectronic: CorreuElectronic,
                Telefon: Telefon,
                Usuari: Usuari,
                Password: hashedPassword, // Contraseña hasheada
                Id_Pais: Id_Pais,
                Ciudad: Ciudad,
                CodigoPostal: CodigoPostal
            },
            (error, results) => {
                if (error) {
                    console.error('Error al insertar el cliente:', error);
                    res.status(500).send('Error al guardar el cliente');
                } else {
                    // Redirigir tras guardar
                    res.redirect('/'); // Ajusta la ruta según la lógica de tu aplicación
                }
            }
        );
    } catch (error) {
        console.error('Error al hashear la contraseña:', error);
        res.status(500).send('Error en el servidor');
    }
};

        

  exports.update = async (req, res) => {
    const id = req.body.Id_Client; // Cambiar 'id' por 'Id_Client' para mantener coherencia.
    const Nom = req.body.Nom;
    const Cognom = req.body.Cognom;
    const DNI = req.body.DNI;
    const CorreuElectronic = req.body.CorreuElectronic;
    const Telefon = req.body.Telefon;  
    const Usuari = req.body.Usuari;
    const Password = req.body.Password; // Contraseña proporcionada
    const Id_Pais = req.body.Id_Pais;
    const Ciudad = req.body.Ciudad;
    const CodigoPostal = req.body.CodigoPostal;

    try {
        let hashedPassword = Password;

        // Verificar si la contraseña ya está hasheada (los hashes bcrypt comienzan con "$2b$")
        if (!Password.startsWith("$2b$")) {
            hashedPassword = await bcrypt.hash(Password, 10); // Hashea solo si no lo está
        }

        // Ejecutar la consulta para actualizar los datos
        conexion.query(
            'UPDATE Clients SET Nom = ?, Cognom = ?, DNI = ?, CorreuElectronic = ?, Telefon = ?, Usuari = ?, Password = ?, Id_Pais = ?, Ciudad = ?, CodigoPostal = ? WHERE Id_Client = ?',
            [Nom, Cognom, DNI, CorreuElectronic, Telefon, Usuari, hashedPassword, Id_Pais, Ciudad, CodigoPostal, id],
            (error, results) => {
                if (error) {
                    console.error('Error en la consulta SQL:', error);
                    res.status(500).send('Error en la base de datos');
                } else {
                    res.redirect('/');
                }
            }
        );
    } catch (error) {
        console.error('Error al procesar la contraseña:', error);
        res.status(500).send('Error en el servidor');
    }
};


//Habitaciones

exports.savehab = (req, res)=>{

    const Numero_Habitacion = req.body.Numero_Habitacion;
    const Tipo = req.body.Tipo;
    const Capacidad = req.body.Capacidad;
    const Precio = req.body.Precio;
    
    const Id_Hotel = req.body.Id_Hotel;
   
    conexion.query('INSERT INTO Habitaciones SET ?', 
       {
       Numero_Habitacion:Numero_Habitacion, 
       Tipo:Tipo,
       Capacidad:Capacidad,
       Precio:Precio,
      
       Id_Hotel:Id_Hotel
   }, (error, results)=>{
       if(error){
           console.log(error);
       }else{
           res.redirect('/habitaciones/');
       }
   })
    //console.log(nom + " - "+cognom+" - "+dni+" - "+correu+" - "+telefon+" - "+usuari+" - "+password+" - "+pais+" - "+ciudad+" - "+codigopostal);
    console.log(req.body);
   
    
   };
   
   
   exports.updatehab = (req, res) => {
       const id = req.body.Id_Habitaciones; // Cambiar 'id' por 'Id_Client' para mantener coherencia.
       const Numero_Habitacion = req.body.Numero_Habitacion;
       const Tipo = req.body.Tipo;
       const Capacidad = req.body.Capacidad;
       const Precio = req.body.Precio;
 
       const Id_Hotel = req.body.Id_Hotel;
   
       conexion.query(
           'UPDATE Habitaciones SET Numero_Habitacion = ?, Tipo = ?, Capacidad = ?, Precio = ?,  Id_Hotel = ? WHERE Id_Habitaciones = ?',
           [Numero_Habitacion, Tipo, Capacidad, Precio, Id_Hotel, id],
           (error, results) => {
               if (error) {
                   console.error('Error en la consulta SQL:', error);
                   res.status(500).send('Error en la base de datos');
               } else {
                   res.redirect('/habitaciones/');
               }
           }
       );
   };
   
   //HOTEL

   exports.saveh = (req, res)=>{

    const Nombre = req.body.Nombre;
    const CorreoElectronico = req.body.CorreoElectronico;
    const Telefono = req.body.Telefono;
    const Direccion = req.body.Direccion;
    const CodigoPostal = req.body.CodigoPostal;  
    const Id_Pais = req.body.Id_Pais;
    const Ciudad = req.body.Ciudad;
    const Estrellas = req.body.Estrellas;
   
    conexion.query('INSERT INTO Hotel SET ?', 
       {
       Nombre:Nombre, 
       CorreoElectronico:CorreoElectronico,
       Telefono:Telefono,
       Direccion:Direccion,
       CodigoPostal:CodigoPostal,
       Id_Pais:Id_Pais,
       Ciudad:Ciudad,
       Estrellas:Estrellas
   }, (error, results)=>{
       if(error){
           console.log(error);
       }else{
           res.redirect('/hotel/');
       }
   })
    //console.log(nom + " - "+cognom+" - "+dni+" - "+correu+" - "+telefon+" - "+usuari+" - "+password+" - "+pais+" - "+ciudad+" - "+codigopostal);
    console.log(req.body);
   
    
   };
   
   exports.updateh = (req, res) => {
       const id = req.body.Id_Hotel; // Cambiar 'id' por 'Id_Client' para mantener coherencia.
       const Nombre = req.body.Nombre;
       const CorreoElectronico = req.body.CorreoElectronico;
       const Telefono = req.body.Telefono;
       const Direccion = req.body.Direccion;
       const CodigoPostal = req.body.CodigoPostal;  
       const Id_Pais = req.body.Id_Pais;
       const Ciudad = req.body.Ciudad;
       const Estrellas = req.body.Estrellas;
   
       conexion.query(
           'UPDATE Hotel SET Nombre = ?, CorreoElectronico = ?, Telefono = ?, Direccion = ?, CodigoPostal = ?, Id_Pais = ?, Ciudad = ?, Estrellas = ? WHERE Id_Hotel = ?',
           [Nombre, CorreoElectronico, Telefono, Direccion, CodigoPostal, Id_Pais, Ciudad, Estrellas,  id],
           (error, results) => {
               if (error) {
                   console.error('Error en la consulta SQL:', error);
                   res.status(500).send('Error en la base de datos');
               } else {
                   res.redirect('/hotel/');
               }
           }
       );
   };

   //PAIS:
  /*   exports.savep = (req, res ) =>{
     const Pais = req-body.Pais;
    

        conexion.query('INSERT INTO Pais SET ?',
        {Pais:Pais},( error, results)=>{
            if(error){
                console.log(error);
            }else{
                res.redirect('/pais/');
        }}
        //console.log(nom + " - "+cognom+" - "+dni+" - "+correu+" - "+telefon+" - "+usuari+" - "+password+" - "+pais+" - "+ciudad+" - "+codigopostal);
        console.log(req.body);
    )} */


   //OFERTAS

   exports.saveo = (req, res)=>{

    const Nombre = req.body.Nombre;
    const Descripcion = req.body.Descripcion;
    const Tipo = req.body.Tipo;
    const Dia_Inicio = req.body.Dia_Inicio;
    const Dia_Fin = req.body.Dia_Fin;  
    const Precio_Original = req.body.Precio_Original;
    const Precio_Oferta = req.body.Precio_Oferta;
    const Estado = req.body.Estado;
    const Id_Hotel = req.body.Id_Hotel;
    const Id_Habitacion = req.body.Id_Habitacion;
    const Id_Actividad = req.body.Id_Actividad;

   
    conexion.query('INSERT INTO Ofertas SET ?', 
       {
       Nombre:Nombre, 
       Descripcion:Descripcion,
       Tipo:Tipo,
       Dia_Inicio:Dia_Inicio,
       Dia_Fin:Dia_Fin,
       Precio_Original:Precio_Original,
       Precio_Oferta:Precio_Oferta,
       Estado:Estado,
       Id_Hotel:Id_Hotel,
       Id_Habitacion:Id_Habitacion,
       Id_Actividad:Id_Actividad
   }, (error, results)=>{
       if(error){
           console.log(error);
       }else{
           res.redirect('/ofertas/');
       }
   })
    //console.log(nom + " - "+cognom+" - "+dni+" - "+correu+" - "+telefon+" - "+usuari+" - "+password+" - "+pais+" - "+ciudad+" - "+codigopostal);
    console.log(req.body);
   
    
   };
 exports.updateo = (req, res) => {
    const id = req.body.Id_Oferta; 
    const Nombre = req.body.Nombre;
    const Descripcion = req.body.Descripcion;
    const Tipo = req.body.Tipo;
    const Dia_Inicio = req.body.Dia_Inicio;
    const Dia_Fin = req.body.Dia_Fin;  
    const Precio_Original = req.body.Precio_Original;
    const Precio_Oferta = req.body.Precio_Oferta;
    const Estado = req.body.Estado;
    const Id_Hotel = req.body.Id_Hotel; 
    const Id_Habitacion = req.body.Id_Habitacion === '' || req.body.Id_Habitacion === 'null' ? null : req.body.Id_Habitacion;
    const Id_Actividad = req.body.Id_Actividad;

    // Aquí ejecutamos la consulta
    conexion.query(
        'UPDATE Ofertas SET Nombre = ?, Descripcion = ?, Tipo = ?, Dia_Inicio = ?, Dia_Fin = ?, Precio_Original = ?, Precio_Oferta = ?, Estado = ?, Id_Hotel = ?, Id_Habitacion = ?, Id_Actividad = ? WHERE Id_Oferta = ?',
        [Nombre, Descripcion, Tipo, Dia_Inicio, Dia_Fin, Precio_Original, Precio_Oferta, Estado, Id_Hotel, Id_Habitacion, Id_Actividad, id],
        (error, results) => {
            if (error) {
                console.error('Error en la consulta SQL:', error);
                res.status(500).send('Error en la base de datos');
            } else {
                res.redirect('/ofertas/');
            }
        }
    );
};


 //ACTIVIDADES

 exports.savea = (req, res)=>{
    const Id_Hotel = req.body.Id_Hotel;
    const Dia_Inicio = req.body.Dia_Inicio;
    const Dia_Fin = req.body.Dia_Fin;  
    const Hora_Inicio = req.body.Hora_Inicio;
    const Hora_Fin = req.body.Hora_Fin;
    const Capacidad_Maxima = req.body.Capacidad_Maxima;
    const Ubicacion = req.body.Ubicacion;
    const Descripcion = req.body.Descripcion;
    const Actividad = req.body.Actividad;


   
    conexion.query('INSERT INTO Actividades SET ?', 
       {
       Id_Hotel:Id_Hotel,
       Dia_Inicio:Dia_Inicio,
       Dia_Fin:Dia_Fin,
       Hora_Inicio:Hora_Inicio,
       Hora_Fin:Hora_Fin,
       Capacidad_Maxima:Capacidad_Maxima,
       Ubicacion:Ubicacion,
       Descripcion:Descripcion,
       Nombre:Actividad

   }, (error, results)=>{
       if(error){
           console.log(error);
       }else{
           res.redirect('/actividades/');
       }
   })
    //console.log(nom + " - "+cognom+" - "+dni+" - "+correu+" - "+telefon+" - "+usuari+" - "+password+" - "+pais+" - "+ciudad+" - "+codigopostal);
    console.log(req.body);
   
    
   };
 exports.updatea = (req, res) => {
    const id = req.body.Id_Actividades; 
    const Actividad = req.body.Actividad;
    const Id_Hotel = req.body.Id_Hotel;
    const Dia_Inicio = req.body.Dia_Inicio;
    const Dia_Fin = req.body.Dia_Fin;  
    const Hora_Inicio = req.body.Hora_Inicio;
    const Hora_Fin = req.body.Hora_Fin;
    const Capacidad_Maxima = req.body.Capacidad_Maxima;
    const Ubicacion = req.body.Ubicacion;
    const Descripcion = req.body.Descripcion;

    // Aquí ejecutamos la consulta
    conexion.query(
        'UPDATE Actividades SET Nombre = ?, Id_Hotel = ?, Dia_Inicio = ?, Dia_Fin = ?, Hora_Inicio = ?, Hora_Fin = ?, Capacidad_Maxima = ?, Ubicacion = ?, Descripcion = ? WHERE Id_Actividades = ?',
        [Actividad, Id_Hotel,  Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, id],
        (error, results) => {
            if (error) {
                console.error('Error en la consulta SQL:', error);
                res.status(500).send('Error en la base de datos');
            } else {
                res.redirect('/actividades/');
            }
        }
    );
};

 //SERVICIO

 exports.saves = (req, res)=>{
    const Id_Hotel = req.body.Id_Hotel;
    const Servicio = req.body.Servicio;
    const Descripcion = req.body.Descripcion;  
    const Precio = req.body.Precio;
   
    conexion.query('INSERT INTO Servicio SET ?', 
       {
       Id_Hotel:Id_Hotel,
       Servicio:Servicio,
       Descripcion:Descripcion,
       Precio:Precio
       
   }, (error, results)=>{
       if(error){
           console.log(error);
       }else{
           res.redirect('/servicio/');
       }
   })
    //console.log(nom + " - "+cognom+" - "+dni+" - "+correu+" - "+telefon+" - "+usuari+" - "+password+" - "+pais+" - "+ciudad+" - "+codigopostal);
    console.log(req.body);
   
    
   };
 exports.updates = (req, res) => {
    const id = req.body.Id_Servicio; 
    const Id_Hotel = req.body.Id_Hotel;
    const Servicio = req.body.Servicio;
    const Descripcion = req.body.Descripcion;;  
    const Precio = req.body.Precio;
    

    // Aquí ejecutamos la consulta
    conexion.query(
        'UPDATE Servicio SET Id_Hotel = ?, Servicio = ?, Descripcion = ?, Precio = ? WHERE Id_Servicio = ?',
        [Id_Hotel, Servicio, Descripcion, Precio, id],
        (error, results) => {
            if (error) {
                console.error('Error en la consulta SQL:', error);
                res.status(500).send('Error en la base de datos');
            } else {
                res.redirect('/servicio/');
            }
        }
    );
};


//Tarifa

exports.savet = (req, res)=>{
    const Id_Hotel = req.body.Id_Hotel;
    const Id_Habitacion = req.body.Id_Habitacion;
    const Id_Actividad = req.body.Id_Actividad;  
    const Id_Servicios = req.body.Id_Servicios;
    const Tipo_Habitacion = req.body.Tipo_Habitacion;
    const Temporada = req.body.Temporada;
    const Precio = req.body.Precio;

   
    conexion.query('INSERT INTO Tarifa SET ?', 
       {
       Id_Hotel:Id_Hotel,
       Id_Habitacion:Id_Habitacion,
       Id_Actividad:Id_Actividad,
       Id_Servicios:Id_Servicios,
       Tipo_Habitacion:Tipo_Habitacion,
       Temporada:Temporada,
       Precio:Precio
       
   }, (error, results)=>{
       if(error){
           console.log(error);
       }else{
           res.redirect('/tarifa/');
       }
   })
    //console.log(nom + " - "+cognom+" - "+dni+" - "+correu+" - "+telefon+" - "+usuari+" - "+password+" - "+pais+" - "+ciudad+" - "+codigopostal);
    console.log(req.body);
   
    
   };
 exports.updatet = (req, res) => {
    const id = req.body.Id_Tarifa; 
    const Id_Hotel = req.body.Id_Hotel;
    const Id_Habitacion = req.body.Id_Habitacion;
    const Id_Actividad = req.body.Id_Actividad;  
    const Id_Servicios = req.body.Id_Servicios;
    const Tipo_Habitacion = req.body.Tipo_Habitacion;
    const Temporada = req.body.Temporada;
    const Precio = req.body.Precio;
    

    // Aquí ejecutamos la consulta
    conexion.query(
        'UPDATE Tarifa SET Id_Hotel = ?, Id_Habitacion = ?,Id_Actividad = ?, Id_Servicios = ?, Tipo_Habitacion = ?, Temporada = ?,Precio = ? WHERE Id_Tarifa = ?',
        [Id_Hotel, Id_Habitacion, Id_Actividad,Id_Servicios,Tipo_Habitacion,Temporada ,Precio, id],
        (error, results) => {
            if (error) {
                console.error('Error en la consulta SQL:', error);
                res.status(500).send('Error en la base de datos');
            } else {
                res.redirect('/tarifa/');
            }
        }
    );
};

// Controlador crud.js
exports.updatereserva = (req, res) => {
    // Obtener el Id_Reserva de req.body
    const idReserva = req.body.Id_Reserva;

    // Obtener los valores del formulario de manera individual
    const Id_Hotel = req.body.Id_Hotel;
    const Id_Habitacion = req.body.Id_Habitacion;
    const Id_Actividad = req.body.Id_Actividad;
    const Id_Tarifa = req.body.Id_Tarifa;
    const Checkin = req.body.Checkin;
    const Checkout = req.body.Checkout;
    const Numero_Personas = req.body.Numero_Personas;
    const Id_Servicios = req.body.Id_Servicios;

    // Consulta para obtener el Id_Cliente asociado a la reserva
    const queryCliente = 'SELECT Id_Cliente FROM Reservas WHERE Id_Reserva = ?';

    conexion.query(queryCliente, [idReserva], (error, results) => {
        if (error) {
            console.error('Error al obtener el Id_Cliente:', error);
            return res.status(500).send('Error en la base de datos');
        }

        if (results.length > 0) {
            const Id_Cliente = results[0].Id_Cliente;  // Obtener el Id_Cliente de la reserva

            // Consulta para actualizar la reserva
            const queryUpdate = `
                UPDATE Reservas 
                SET Id_Hotel = ?, Id_Habitacion = ?, Id_Actividad = ?, Id_Tarifa = ?, 
                    Id_Servicios = ?, Checkin = ?, Checkout = ?, Numero_Personas = ? 
                WHERE Id_Reserva = ?
            `;

            conexion.query(queryUpdate, 
                [Id_Hotel, Id_Habitacion, Id_Actividad, Id_Tarifa, Id_Servicios, Checkin, Checkout, Numero_Personas, idReserva], 
                (error, results) => {
                    if (error) {
                        console.error('Error en la consulta SQL:', error);
                        return res.status(500).send('Error en la base de datos');
                    } else {
                        // Redirigir después de la actualización a la página del cliente
                        res.redirect(`/informacion/${Id_Cliente}`);
                    }
                }
            );
        } else {
            return res.status(404).send('Reserva no encontrada');
        }
    });
};
