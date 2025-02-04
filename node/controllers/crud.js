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
    const Disponibilidad = req.body.Disponibilidad;  
    const Id_Hotel = req.body.Id_Hotel;
   
    conexion.query('INSERT INTO Habitaciones SET ?', 
       {
       Numero_Habitacion:Numero_Habitacion, 
       Tipo:Tipo,
       Capacidad:Capacidad,
       Precio:Precio,
       Disponibilidad:Disponibilidad,
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
       const Disponibilidad = req.body.Disponibilidad;  
       const Id_Hotel = req.body.Id_Hotel;
   
       conexion.query(
           'UPDATE Habitaciones SET Numero_Habitacion = ?, Tipo = ?, Capacidad = ?, Precio = ?, Disponibilidad = ?, Id_Hotel = ? WHERE Id_Habitaciones = ?',
           [Numero_Habitacion, Tipo, Capacidad, Precio, Disponibilidad, Id_Hotel, id],
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
    const Id_Actividad = req.body.Id_Actividad || null;

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


