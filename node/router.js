        const express = require('express');
        const router = express.Router();
        const conexion = require('./database/db');
        const session = require('express-session');
        const bcrypt = require("bcrypt");
        const axios = require("axios");
        const cors = require("cors");
        const crud = require('./controllers/crud');
        const { route } = require('express/lib/application');
        const bodyParser = require("body-parser");
        
        module.exports = router;



        router.use(session({
            secret: 'tu_secreto',
            resave: false,
            saveUninitialized: true,
            cookie: { secure: false }  // Cambia a true si usas HTTPS
        }));
        
        // Otras configuraciones de Express
        router.use(express.urlencoded({ extended: true }));
        router.use(express.json());
//login

// Redirigir la raíz al login
router.get("/", (req, res) => {
    res.redirect("/login");
});

// Página de login
router.get("/login", (req, res) => {
    res.render("login/login", { error: null });
});

// Procesar login
router.get('/logout', (req, res) => {
    req.session.destroy((err) => {
        if (err) {
            console.error("Error al cerrar sesión:", err);
            return res.status(500).send("Error al cerrar sesión");
        }
        res.redirect('/login'); // Redirige al usuario a la página de login
    });
});

router.post("/login", (req, res) => {
    const { username, password } = req.body;

    // Buscar el usuario en la base de datos
    const sql = "SELECT * FROM Administrador WHERE Usuari = ?";
    conexion.query(sql, [username], async (error, results) => {
        if (error) {
            console.error("Error en la consulta:", error);
            return res.render("login/login", { error: "Error interno" });
        }

        // Verificar si el usuario existe
        if (results.length === 0) {
            return res.render("login/login", { error: "Usuario o contraseña incorrectos" });
        }

        const user = results[0];

        // Comparar la contraseña ingresada con la encriptada en la BD
        const passwordMatch = await bcrypt.compare(password, user.Password);

        if (!passwordMatch) {
            return res.render("login/login", { error: "Usuario o contraseña incorrectos" });
        }

        // Guardar la sesión temporal con los datos del usuario, incluyendo la palabra clave
        req.session.tempUser = {
            id: user.Id_Administrador,
            role: user.role,
            id_hotel: user.Id_hotel,
            pra: user.Paraula_verificacio // Guardamos la palabra clave de la base de datos
        };

        // Redirigir a la página de verificación de la palabra clave
        res.redirect("/clave");
    });
});

router.get("/clave", (req, res) => {
    res.render("login/clave", { error: null });
});
router.post("/verificar-clave", (req, res) => {
    const { clave } = req.body;

    // Verificar si la sesión temporal del usuario existe
    if (!req.session.tempUser) {
        return res.redirect("/login"); // Si no hay usuario temporal, redirigir al login
    }

    const user = req.session.tempUser;

    // Validar la palabra clave (comparar con la columna 'Paraula_verificacio' de la base de datos)
    if (clave !== user.pra) {
        return res.render("login/clave", { error: "Palabra clave incorrecta" });
    }

    // Guardar la sesión final del usuario
    req.session.user = user;
    delete req.session.tempUser; // Eliminar el usuario temporal

    // Redirigir al lugar correspondiente según el rol
    if (user.role === "Hotel") {
        res.redirect(`/hotel/${user.id_hotel}`); // Redirigir al hotel específico
    } else {
        res.redirect("/clientes"); // Redirigir al panel de clientes
    }
});




// CLIENTES: Mostrar listado de clientes (protegido con sesión)
// Ruta de clientes
router.get("/clientes", (req, res) => {
    const user = req.session.user;  // Obtener el usuario de la sesión

    if (!user) {
        return res.redirect('/login');  // Si no hay usuario logueado, redirigir a login
    }

    // Si el rol es 'Hotel', redirigir a la página de su hotel con su ID
    if (user.role === 'Hotel') {
        return res.redirect(`/hotel/${user.id_hotel}`);  
    }

    // Si el rol es 'General', mostrar la lista de clientes
   else if (user.role === 'General') {
        conexion.query(
            `SELECT 
                c.Id_Client, c.Nom, c.Cognom, c.DNI, c.CorreuElectronic, 
                c.Telefon, c.Usuari, c.Password, p.Pais, c.Ciudad, c.CodigoPostal 
            FROM Clients c 
            LEFT JOIN Pais p 
            ON c.Id_Pais = p.Id_Pais;`,
            (error, results) => {
                if (error) {
                    throw error;
                } else {
                    res.render("index", { results, user });  // Pasar los resultados y el usuario a la vista
                }
            }
        );
    } else {
        // Si el usuario tiene un rol desconocido, redirigirlo al login
        return res.redirect('/login');
    }
});





        router.use(cors()); // Permitir solicitudes desde el frontend

        router.get("/autocomplete", async (req, res) => {
            const query = req.query.q;
            if (!query) return res.status(400).json({ error: "Falta el parámetro q" });
        
            try {
                const response = await axios.get("https://nominatim.openstreetmap.org/search", {
                    params: {
                        q: query,
                        format: "json",
                        addressdetails: 1,
                        limit: 5
                    }
                });
        
                // Filtrar resultados asegurando que sean ciudades, pueblos o aldeas
                const cities = response.data
                    .filter(place => place.address.city || place.address.town || place.address.village)
                    .map(place => place.address.city || place.address.town || place.address.village)
                    .filter((value, index, self) => self.indexOf(value) === index); // Eliminar duplicados
        
                res.json(cities.slice(0, 5)); // Limitar a 5 resultados
            } catch (error) {
                res.status(500).json({ error: "Error al obtener datos" });
            }
        });
router.get('/create', (req, res) => {

    const user = req.session.user;

    if (user.role === 'General'){
    const queryCountries = 'SELECT Id_Pais, Pais FROM Pais'; // Consulta para obtener los países
    conexion.query(queryCountries, (error, countryResults) => {
        if (error) {
            console.error('Error al obtener los países:', error.message);
            return res.status(500).send('Error en el servidor');
        }
        res.render('create', { countries: countryResults, user:user }); // Pasa la lista de países a la vista
    });
}else{
    res.redirect('/login'); 
}
});


        router.post('/save', crud.save)
        router.post('/update', crud.update);

        //ruta editar

        router.get('/edit/:id', (req, res) => {
            const user = req.session.user;
            if (!user) {
                return res.redirect('/login'); // Si no hay usuario, redirigir a login
            }
        
            const Id_Client = req.params.id;
            const queryClient = 'SELECT * FROM Clients WHERE Id_Client = ?';
            const queryCountries = 'SELECT Id_Pais, Pais FROM Pais';
        
            if (user.role === 'General') {
                // Obtener datos del cliente
                conexion.query(queryClient, [Id_Client], (error, clientResults) => {
                    if (error) {
                        console.error('Error al obtener el cliente:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }
        
                    if (clientResults.length === 0) {
                        return res.status(404).send('Cliente no encontrado');
                    }
        
                    // Obtener la lista de países
                    conexion.query(queryCountries, (error, countryResults) => {
                        if (error) {
                            console.error('Error al obtener los países:', error.message);
                            return res.status(500).send('Error en el servidor');
                        }
        
                        // Renderizar la vista correctamente
                        res.render('edit', {
                            client: clientResults[0],  // Datos del cliente
                            countries: countryResults, // Lista de países
                            user: user  // Usuario logueado (para verificar el rol en la vista)
                        });
                    });
                });
            } else {
                res.redirect('/login'); // Redirigir si el usuario no tiene permisos
            }
        });
        


        router.get('/delete/:id', (req, res) => {
            
            const id = req.params.id; 
            conexion.query('DELETE FROM Clients WHERE Id_Client = ?', [id], (error, results) => {
                if (error) {
                    throw error;
                } else {
                    res.redirect('/login'); // Redirigimos al usuario a la página principal
                }
            });
        });

        //HABITACIONES

        router.post('/savehab', crud.savehab)
        router.post('/updatehab', crud.updatehab);
        router.get('/habitaciones/:Id_Hotel', (req, res) => {
            const user = req.session.user;
            if (!user) {
                return res.redirect('/login'); // Si no hay usuario, redirigir a login
            }
            const Id_Hotel = req.params.Id_Hotel;
        
            conexion.query(
                `SELECT 
                    ha.Id_Habitaciones, ha.Numero_Habitacion, ha.Tipo, ha.Capacidad, ha.Precio, 
                    h.Nombre
                FROM 
                    Habitaciones ha 
                LEFT JOIN 
                    Hotel h 
                ON 
                    ha.Id_Hotel = h.Id_Hotel
                WHERE 
                    ha.Id_Hotel = ?;`,
                [Id_Hotel],
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        // Obtener el nombre del hotel si hay resultados
                        const NombreHotel = results.length > 0 ? results[0].Nombre : "Hotel no encontrado";
                        
                        res.render('Habitaciones/habitaciones', { 
                            results, 
                            Id_Hotel,
                            NombreHotel,user // Pasamos el nombre del hotel a la vista
                        });
                    }
                }
            );
        });
        
        

        router.get('/createhab/:id_hotel', (req, res) => {
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel';
            const idHotel = req.params.id_hotel; // Obtenemos el ID del hotel desde la URL
        
            conexion.query(queryHotel, (error, hotelResults) => {
                if (error) {
                    console.error('Error al obtener los hoteles:', error.message);
                    return res.status(500).send('Error en el servidor');
                }
        
                res.render('Habitaciones/createhab', {
                    hoteles: hotelResults,
                    idHotel: idHotel // Pasamos el ID del hotel a la vista
                });
            });
        });
        
        
        

        router.get('/edithab/:id', (req, res) => {
            const Id_Habitaciones = req.params.id;

            // Consultas SQL
            const queryHabitacion = 'SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?';
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel';

            // Primera consulta: obtener los datos de la habitación
            conexion.query(queryHabitacion, [Id_Habitaciones], (error, habitacionesResults) => {
                if (error) {
                    console.error('Error al obtener la habitación:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                if (habitacionesResults.length === 0) {
                    return res.status(404).send('Habitación no encontrada');
                }

                // Segunda consulta: obtener las disponibilidades

                    // Tercera consulta: obtener los hoteles
                    conexion.query(queryHotel, (error, hotelResults) => {
                        if (error) {
                            console.error('Error al obtener los hoteles:', error.message);
                            return res.status(500).send('Error en el servidor');
                        }

                        // Renderizamos la vista con los datos obtenidos
                        res.render('Habitaciones/edithab', {
                            habitacion: habitacionesResults[0], // Datos de la habitación
                            hoteles: hotelResults, // Lista de hoteles
                        });
                    });
                });
        });



        router.get('/deletehab/:id', (req, res) => {
            const id = req.params.id;
        
            // Obtener el Id_Hotel de la habitación antes de eliminarla
            conexion.query('SELECT Id_Hotel FROM Habitaciones WHERE Id_Habitaciones = ?', [id], (error, results) => {
                if (error) {
                    console.error('Error al obtener el hotel de la habitación:', error.message);
                    return res.status(500).send('Error en el servidor');
                }
        
                if (results.length === 0) {
                    return res.status(404).send('Habitación no encontrada');
                }
        
                const Id_Hotel = results[0].Id_Hotel; // Obtener el Id_Hotel de la habitación
        
                // Ahora eliminamos la habitación
                conexion.query('DELETE FROM Habitaciones WHERE Id_Habitaciones = ?', [id], (error) => {
                    if (error) {
                        console.error('Error al eliminar la habitación:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }
        
                    // Redirigir a la página de habitaciones del hotel correspondiente
                    res.redirect(`/habitaciones/${Id_Hotel}`);
                });
            });
        });
        

        //HOTEL

        router.post('/saveh', crud.saveh)
        router.post('/updateh', crud.updateh);
      // Ruta con parámetro Id_Hotel
// Ruta para mostrar todos los hoteles (solo para 'General')
router.get('/hoteles', (req, res) => {
    const user = req.session.user;  // Obtener el usuario de la sesión

    if (!user) {
        return res.redirect('/login');  // Redirigir si el usuario no está logueado
    }

    // Si el rol es 'General', mostrar todos los hoteles
    if (user.role === 'General') {
        conexion.query(
            `SELECT 
                h.Id_Hotel, h.Nombre, h.CorreoElectronico, h.Telefono, h.Direccion, h.CodigoPostal, 
                p.Pais, h.Ciudad, h.Estrellas        
            FROM Hotel h
            LEFT JOIN Pais p ON h.Id_Pais = p.Id_Pais`,
            (error, results) => {
                if (error) {
                    throw error;
                } else {
                    // Mostrar todos los hoteles
                    res.render('hotel/hotel', { results, user });
                }
            }
        );
    } else {
        res.redirect('/login');  // Si el rol no es 'General', redirigir al login
    }
});

// Ruta para mostrar información de un hotel específico (solo para 'Hotel')
router.get('/hotel/:id', (req, res) => {
    const user = req.session.user;  // Obtener el usuario de la sesión
    const hotelId = req.params.id;  // Obtener el Id_Hotel de la URL

    if (!user) {
        return res.redirect('/login');  // Redirigir si el usuario no está logueado
    }

    // Si el rol es 'Hotel', filtrar por Id_Hotel del usuario
    if (user.role === 'Hotel') {
        // Si el Id en la URL coincide con el Id del hotel del usuario, mostrar los detalles del hotel
        if (hotelId == user.id_hotel) {
            conexion.query(
                `SELECT 
                    h.Id_Hotel, h.Nombre, h.CorreoElectronico, h.Telefono, h.Direccion, h.CodigoPostal, 
                    p.Pais, h.Ciudad, h.Estrellas        
                FROM Hotel h
                LEFT JOIN Pais p ON h.Id_Pais = p.Id_Pais
                WHERE h.Id_Hotel = ?`,
                [hotelId],  // Usamos el Id_Hotel de la URL
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        // Mostrar solo la información del hotel del usuario
                        res.render('hotel/hotel', { results, user });
                    }
                }
            );
        } else {
            // Si el hotelId no coincide con el Id del hotel del usuario, mostrar error o redirigir
            return res.render('hotel/error', { error: "Acceso no autorizado a este hotel." });
        }
    } else {
        res.redirect('/login');  // Si el rol no es 'Hotel', redirigir al login
    }
});



        router.get('/createh', (req, res) => {
            const user = req.session.user;
            if(user.role === 'General' || user.role === 'Hotel'){
            const queryCountries = 'SELECT Id_Pais, Pais FROM Pais'; // Consulta para obtener los países
            conexion.query(queryCountries, (error, countryResults) => {
                if (error) {
                    console.error('Error al obtener los países:', error.message);
                    return res.status(500).send('Error en el servidor');
                }
                res.render('hotel/createh', { countries: countryResults , user:user}); // Pasa la lista de países a la vista
            });
        }else{
            res.redirect('/login');  // Si el rol no es 'Hotel', redirigir al login
        }
        });

        router.get('/edith/:id', (req, res) => {
            const user = req.session.user;
            const Id_Hotel = req.params.id;
        
            if (!user) {
                return res.redirect('/login'); // Redirigir si no hay usuario logueado
            }
        
            let queryHotel;
            let queryParams = [];
        
            if (user.role === 'General') {
                queryHotel = 'SELECT * FROM Hotel WHERE Id_Hotel = ?';
                queryParams = [Id_Hotel]; // Tomamos el ID de la URL
            } else if (user.role === 'Hotel') {
                queryHotel = 'SELECT * FROM Hotel WHERE Id_Hotel = ?';
                queryParams = [user.id_hotel]; // Forzamos a que solo pueda editar su propio hotel
            } else {
                return res.redirect('/login'); // Redirigir si el rol no es válido
            }
        
            const queryCountries = 'SELECT Id_Pais, Pais FROM Pais'; // Consulta para obtener países
        
            // Obtener los datos del hotel
            conexion.query(queryHotel, queryParams, (error, hotelResults) => {
                if (error) {
                    console.error('Error al obtener el hotel:', error.message);
                    return res.status(500).send('Error en el servidor');
                }
        
                if (hotelResults.length === 0) {
                    return res.status(404).send('Hotel no encontrado');
                }
        
                // Obtener la lista de países
                conexion.query(queryCountries, (error, countryResults) => {
                    if (error) {
                        console.error('Error al obtener los países:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }
        
                    // Renderizar la vista con los datos obtenidos
                    res.render('hotel/edith', {
                        hotel: hotelResults[0],  // Datos del hotel
                        countries: countryResults, // Lista de países
                        user: user // Pasamos el usuario a la vista
                    });
                });
            });
        });
        


        router.get('/deleteh/:id', (req, res) => {
            const user = req.session.user;
            const id = req.params.id; 
            if(user.role === 'General'){
            conexion.query('DELETE FROM Hotel WHERE Id_Hotel = ?', [id], (error, results) => {
                if (error) {
                    throw error;
                } else {
                    res.redirect('/hotel'); // Redirigimos al usuario a la página principal
                }
            });
         } else {
                res.redirect('/login');  // Si el rol no es 'General', redirigir al login
            }
        });


        //OFERTAS

        router.post('/saveo', crud.saveo)
        router.post('/updateo', crud.updateo); 
        router.get('/ofertas', (req, res) => {
            const user = req.session.user; 

              if (user.role === 'General') {
            conexion.query(
                `SELECT 
                    o.Id_Oferta, 
                    o.Nombre,
                    o.Descripcion,
                    o.Tipo,
                    o.Dia_Inicio,
                    o.Dia_Fin,
                    o.Precio_Original,
                    o.Precio_Oferta,
                    o.Estado,
                    h.Nombre AS Nombre_Hotel,
                    ha.Numero_Habitacion,
                    a.Nombre as Actividad,
                    IF(o.Estado = 1, 'Activo', 'Inactivo') AS Estado_Descripcion
                FROM Ofertas o
                LEFT JOIN Hotel h ON o.Id_Hotel = h.Id_Hotel
                LEFT JOIN Habitaciones ha ON o.Id_Habitacion = ha.Id_Habitaciones
                LEFT JOIN Actividades a ON o.Id_Actividad = a.Id_Actividades`,
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        res.render('ofertas/ofertas', { results, user });
                    }
                }
            );
        }else {res.redirect('/login');}
        });
        
        router.get('/oferta/:id', (req, res) => {
            const user = req.session.user;  // Obtener el usuario de la sesión
            const hotelId = req.params.id;  // Obtener el Id_Hotel de la URL
        
            if (!user) {
                return res.redirect('/login');  // Redirigir si el usuario no está logueado
            }
        
            if (user.role === 'Hotel') {
                // Si el usuario intenta acceder a otro hotel, lo redirigimos al suyo
                if (hotelId != user.id_hotel) {
                    return res.redirect(`/oferta/${user.id_hotel}`);
                }
        
                // Mostrar las ofertas solo del hotel del usuario
                conexion.query(
                    `SELECT 
                        o.Id_Oferta, 
                        o.Nombre,
                        o.Descripcion,
                        o.Tipo,
                        o.Dia_Inicio,
                        o.Dia_Fin,
                        o.Precio_Original,
                        o.Precio_Oferta,
                        o.Estado,
                        h.Nombre AS Nombre_Hotel,
                        ha.Numero_Habitacion,
                        a.Nombre as Actividad,
                        IF(o.Estado = 1, 'Activo', 'Inactivo') AS Estado_Descripcion
                    FROM Ofertas o
                    LEFT JOIN Hotel h ON o.Id_Hotel = h.Id_Hotel
                    LEFT JOIN Habitaciones ha ON o.Id_Habitacion = ha.Id_Habitaciones
                    LEFT JOIN Actividades a ON o.Id_Actividad = a.Id_Actividades
                    WHERE h.Id_Hotel = ?`,
                    [hotelId],  
                    (error, results) => {
                        if (error) {
                            throw error;
                        } else {
                            res.render('ofertas/ofertas', { results, user });
                        }
                    }
                );
            } else {
                // Si el usuario no tiene rol "Hotel", lo enviamos a la lista general de ofertas
                return res.redirect('/login');
            }
        });
        

       // Ruta para crear una oferta
router.get('/createo', (req, res) => {
    const user = req.session.user;

    if (!user) {
        return res.redirect('/login'); // Si no está autenticado, redirige al login
    }

    let queryHotel;
    let queryParams = [];

    if (user.role === 'General') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    } else if (user.role === 'Hotel') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel WHERE Id_Hotel = ?';
        queryParams = [user.id_hotel]; // Solo su hotel
    } else {
        return res.redirect('/login'); // Si el rol es inválido
    }

    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre as Actividad FROM Actividades';

    // Ejecutar consultas en paralelo
    conexion.query(queryHotel, queryParams, (error, hotelResults) => {
        if (error) {
            console.error('Error al obtener los hoteles:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        conexion.query(queryHabitacion, (error, habitacionResults) => {
            if (error) {
                console.error('Error al obtener las habitaciones:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            conexion.query(queryActividades, (error, actividadesResults) => {
                if (error) {
                    console.error('Error al obtener las actividades:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Renderizar la vista con los datos obtenidos
                res.render('ofertas/createo', { 
                    hoteles: hotelResults, 
                    habitaciones: habitacionResults, 
                    actividades: actividadesResults,
                    user:user 
                });
            });
        });
    });
});

// Ruta para editar una oferta
router.get('/edito/:id', async (req, res) => {
    const user = req.session.user;
    const Id_Oferta = req.params.id;

    if (!user) {
        return res.redirect('/login');
    }

    try {
        const queryOferta = user.role === 'Hotel' 
            ? 'SELECT * FROM Ofertas WHERE Id_Oferta = ? AND Id_Hotel = ?' 
            : 'SELECT * FROM Ofertas WHERE Id_Oferta = ?';
        const queryParamsOferta = user.role === 'Hotel' ? [Id_Oferta, user.id_hotel] : [Id_Oferta];

        const ofertaResults = await new Promise((resolve, reject) => {
            conexion.query(queryOferta, queryParamsOferta, (error, results) => {
                if (error) return reject(error);
                resolve(results);
            });
        });

        if (ofertaResults.length === 0) {
            return res.status(404).send('Oferta no encontrada o no tienes permiso para editarla');
        }

        const queryHotel = user.role === 'General' 
            ? 'SELECT Id_Hotel, Nombre FROM Hotel' 
            : 'SELECT Id_Hotel, Nombre FROM Hotel WHERE Id_Hotel = ?';
        const queryParamsHotel = user.role === 'Hotel' ? [user.id_hotel] : [];

        const hotelResults = await new Promise((resolve, reject) => {
            conexion.query(queryHotel, queryParamsHotel, (error, results) => {
                if (error) return reject(error);
                resolve(results);
            });
        });

        const habitacionResults = await new Promise((resolve, reject) => {
            conexion.query('SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones', (error, results) => {
                if (error) return reject(error);
                resolve(results);
            });
        });

        const queryActividades = user.role === 'Hotel'
            ? 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre as Actividad FROM Actividades WHERE Id_Hotel = ?'
            : 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre as Actividad FROM Actividades';

        const queryParamsActividades = user.role === 'Hotel' ? [user.id_hotel] : [];

        const actividadResults = await new Promise((resolve, reject) => {
            conexion.query(queryActividades, queryParamsActividades, (error, results) => {
                if (error) return reject(error);
                resolve(results);
            });
        });

        res.render('ofertas/edito', {
            oferta: ofertaResults[0],       
            hoteles: hotelResults,       
            habitaciones: habitacionResults, 
            actividades: actividadResults,
            user: user   
        });

    } catch (error) {
        console.error('Error en la consulta:', error);
        return res.status(500).send('Error en el servidor');
    }
});


// Ruta para eliminar una oferta
router.get('/deleteo/:id', (req, res) => {
    const user = req.session.user;
    const id = req.params.id; 

    if (!user) {
        return res.redirect('/login');
    }

    let queryDelete;
    let queryParams = [];

    if (user.role === 'General' || user.role === 'Hotel') {
        queryDelete = 'DELETE FROM Ofertas WHERE Id_Oferta = ?';
        queryParams = [id];
    } else {
        return res.redirect('/login');
    }

    conexion.query(queryDelete, queryParams, (error, results) => {
        if (error) {
            console.error('Error al eliminar la oferta:', error.message);
            return res.status(500).send('Error en el servidor');
        }
    else if(user.role === 'General'){
        res.redirect('/ofertas/');
    }else if(user.role === 'Hotel'){
     res.redirect(`/oferta/${user.id_hotel}`)
    }
    
    });
});



        //ACTIVIDADES

        router.post('/savea', crud.savea)
        router.post('/updatea', crud.updatea); 
        router.get('/actividades', (req, res) => {

            const user = req.session.user;  // Obtener el usuario de la sesión
            if (user.role === 'General') {
            conexion.query(
                `SELECT 
                    a.Id_Actividades, 
                    h.Nombre,
                    a.Dia_Inicio,
                    a.Dia_Fin,
                    a.Hora_Inicio,
                    a.Hora_Fin,
                    a.Capacidad_Maxima,
                    a.Ubicacion,
                    a.Descripcion,
                    a.Nombre as Actividad
                FROM Actividades a
                LEFT JOIN Hotel h ON a.Id_Hotel = h.Id_Hotel;`,
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        res.render('actividades/actividades', { results, user });
                    }
                }
            );
        } else {
            // Si el usuario no tiene rol "Hotel", lo enviamos a la lista general de ofertas
            return res.redirect('/login');
        }
        });

        router.get('/actividad/:id', (req, res) => {
            const user = req.session.user;  // Obtener el usuario de la sesión
            const hotelId = req.params.id;  // Obtener el Id_Hotel de la URL
        
            if (!user) {
                return res.redirect('/login');  // Redirigir si el usuario no está logueado
            }
        
            if (user.role === 'Hotel') {
                // Si el usuario intenta acceder a otro hotel, lo redirigimos al suyo
                if (hotelId != user.id_hotel) {
                    return res.redirect(`/oferta/${user.id_hotel}`);
                }
        
                // Mostrar las ofertas solo del hotel del usuario
                conexion.query(
                    `SELECT 
                    a.Id_Actividades, 
                    h.Nombre,
                    a.Dia_Inicio,
                    a.Dia_Fin,
                    a.Hora_Inicio,
                    a.Hora_Fin,
                    a.Capacidad_Maxima,
                    a.Ubicacion,
                    a.Descripcion,
                    a.Nombre as Actividad
                FROM Actividades a
                LEFT JOIN Hotel h ON a.Id_Hotel = h.Id_Hotel
                    WHERE h.Id_Hotel = ?`,
                    [hotelId],  
                    (error, results) => {
                        if (error) {
                            throw error;
                        } else {
                            res.render('actividades/actividades', { results, user });
                        }
                    }
                );
            } else {
                // Si el usuario no tiene rol "Hotel", lo enviamos a la lista general de ofertas
                return res.redirect('/login');
            }
        });

     // Ruta para crear una actividad
router.get('/createa', (req, res) => {
    const user = req.session.user;

    if (!user) {
        return res.redirect('/login'); // Si no está autenticado, redirige al login
    }

    let queryHotel;
    let queryParams = [];

    if (user.role === 'General') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    } else if (user.role === 'Hotel') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel WHERE Id_Hotel = ?';
        queryParams = [user.id_hotel]; // Solo su hotel
    } else {
        return res.redirect('/login');
    }

    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre as Actividad FROM Actividades';

    // Obtener hoteles
    conexion.query(queryHotel, queryParams, (error, hotelResults) => {
        if (error) {
            console.error('Error al obtener los hoteles:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        // Obtener habitaciones
        conexion.query(queryHabitacion, (error, habitacionResults) => {
            if (error) {
                console.error('Error al obtener las habitaciones:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Obtener actividades
            conexion.query(queryActividades, (error, actividadesResults) => {
                if (error) {
                    console.error('Error al obtener las actividades:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Renderizar la vista con los datos obtenidos
                res.render('actividades/createa', { 
                    hoteles: hotelResults, 
                    habitaciones: habitacionResults, 
                    actividades: actividadesResults,
                    user:user 
                });
            });
        });
    });
});

// Ruta para editar una actividad
router.get('/edita/:id', (req, res) => {
    const user = req.session.user;
    const Id_Actividades = req.params.id;

    if (!user) {
        return res.redirect('/login');
    }

    let queryActividad;
    let queryParams = [Id_Actividades];

    if (user.role === 'General') {
        queryActividad = 'SELECT * FROM Actividades WHERE Id_Actividades = ?';
    } else if (user.role === 'Hotel') {
        queryActividad = 'SELECT * FROM Actividades WHERE Id_Actividades = ? AND Id_Hotel = ?';
        queryParams.push(user.id_hotel); // Solo puede editar actividades de su hotel
    } else {
        return res.redirect('/login');
    }

    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel';
    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';

    // Obtener actividad específica
    conexion.query(queryActividad, queryParams, (error, actividadesResults) => {
        if (error) {
            console.error('Error al obtener la actividad:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (actividadesResults.length === 0) {
            return res.status(404).send('Actividad no encontrada');
        }

        // Obtener hoteles
        conexion.query(queryHotel, (error, hotelResults) => {
            if (error) {
                console.error('Error al obtener los hoteles:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Obtener habitaciones
            conexion.query(queryHabitacion, (error, habitacionResults) => {
                if (error) {
                    console.error('Error al obtener las habitaciones:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Renderizar la vista con los datos obtenidos
                res.render('actividades/edita', {
                    actividades: actividadesResults[0],     
                    hoteles: hotelResults,       
                    habitaciones: habitacionResults,
                    user:user 
                });
            });
        });
    });
});

// Ruta para eliminar una actividad
router.get('/deletea/:id', (req, res) => {
    const user = req.session.user;
    const id = req.params.id;

    if (!user) {
        return res.redirect('/login');
    }

    let queryDelete;
    let queryParams = [id];

    if (user.role === 'General' || user.role === 'Hotel') {
        queryDelete = 'DELETE FROM Actividades WHERE Id_Actividades = ?';
    } else {
        return res.redirect('/login');
    }

    conexion.query(queryDelete, queryParams, (error, results) => {
        if (error) {
            console.error('Error al eliminar la actividad:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        else if(user.role === 'General'){
            res.redirect('/actividades/');
        }else if(user.role === 'Hotel'){
         res.redirect(`/actividad/${user.id_hotel}`)
        }// Redirigir a la lista de actividades
    });
});



        //SERVICIOS

        router.post('/saves', crud.saves)
        router.post('/updates', crud.updates); 
        router.get('/servicio', (req, res) => {
            const user = req.session.user; 

            if (user.role === 'General') {
            conexion.query(
                `SELECT 
                    s.Id_Servicio, 
                    h.Nombre,
                    s.Servicio,
                    s.Descripcion,
                    s.Precio
                FROM Servicio s
                LEFT JOIN Hotel h ON s.Id_Hotel = h.Id_Hotel`,
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        res.render('servicio/servicio', { results, user });
                    }
                }
            );
        }else{
            return res.redirect('/login');

        }
        });

        router.get('/servicios/:id', (req, res) => {
            const user = req.session.user;  // Obtener el usuario de la sesión
            const hotelId = req.params.id;  // Obtener el Id_Hotel de la URL
        
            if (!user) {
                return res.redirect('/login');  // Redirigir si el usuario no está logueado
            }
        
            if (user.role === 'Hotel') {
                // Si el usuario intenta acceder a otro hotel, lo redirigimos al suyo
                if (hotelId != user.id_hotel) {
                    return res.redirect(`/servicios/${user.id_hotel}`);
                }
        
                // Mostrar las ofertas solo del hotel del usuario
                conexion.query(
                    `SELECT 
                    a.Id_Actividades, 
                    h.Nombre,
                    a.Dia_Inicio,
                    a.Dia_Fin,
                    a.Hora_Inicio,
                    a.Hora_Fin,
                    a.Capacidad_Maxima,
                    a.Ubicacion,
                    a.Descripcion,
                    a.Nombre as Actividad
                FROM Actividades a
                LEFT JOIN Hotel h ON a.Id_Hotel = h.Id_Hotel
                    WHERE h.Id_Hotel = ?`,
                    [hotelId],  
                    (error, results) => {
                        if (error) {
                            throw error;
                        } else {
                            res.render('actividades/actividades', { results, user });
                        }
                    }
                );
            } else {
                // Si el usuario no tiene rol "Hotel", lo enviamos a la lista general de ofertas
                return res.redirect('/login');
            }
        });

      // Ruta para crear un servicio
router.get('/creates', (req, res) => {
    const user = req.session.user;

    if (!user) {
        return res.redirect('/login'); // Si no está autenticado, redirige al login
    }

    let queryHotel;
    let queryParams = [];

    if (user.role === 'General') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    } else if (user.role === 'Hotel') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel WHERE Id_Hotel = ?';
        queryParams = [user.id_hotel]; // Solo su hotel
    } else {
        return res.redirect('/login');
    }

    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre as Actividad FROM Actividades';

    // Obtener hoteles
    conexion.query(queryHotel, queryParams, (error, hotelResults) => {
        if (error) {
            console.error('Error al obtener los hoteles:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        // Obtener habitaciones
        conexion.query(queryHabitacion, (error, habitacionResults) => {
            if (error) {
                console.error('Error al obtener las habitaciones:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Obtener actividades
            conexion.query(queryActividades, (error, actividadesResults) => {
                if (error) {
                    console.error('Error al obtener las actividades:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Renderizar la vista con los datos obtenidos
                res.render('servicio/creates', { 
                    hoteles: hotelResults, 
                    habitaciones: habitacionResults, 
                    actividades: actividadesResults,
                    user:user 
                });
            });
        });
    });
});

// Ruta para editar un servicio
router.get('/edits/:id', (req, res) => {
    const user = req.session.user;
    const Id_Servicio = req.params.id;

    if (!user) {
        return res.redirect('/login');
    }

    let queryServicio;
    let queryParams = [Id_Servicio];

    if (user.role === 'General') {
        queryServicio = 'SELECT * FROM Servicio WHERE Id_Servicio = ?';
    } else if (user.role === 'Hotel') {
        queryServicio = 'SELECT * FROM Servicio WHERE Id_Servicio = ? AND Id_Hotel = ?';
        queryParams.push(user.id_hotel); // Solo puede editar servicios de su hotel
    } else {
        return res.redirect('/login');
    }

    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel';
    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';

    // Obtener el servicio específico
    conexion.query(queryServicio, queryParams, (error, servicioResults) => {
        if (error) {
            console.error('Error al obtener el servicio:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (servicioResults.length === 0) {
            return res.status(404).send('Servicio no encontrado');
        }

        // Obtener hoteles
        conexion.query(queryHotel, (error, hotelResults) => {
            if (error) {
                console.error('Error al obtener los hoteles:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Obtener habitaciones
            conexion.query(queryHabitacion, (error, habitacionResults) => {
                if (error) {
                    console.error('Error al obtener las habitaciones:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Renderizar la vista con los datos obtenidos
                res.render('servicio/edits', {
                    servicio: servicioResults[0],     
                    hoteles: hotelResults,       
                    habitaciones: habitacionResults,
                    user:user 
                });
            });
        });
    });
});

// Ruta para eliminar un servicio
router.get('/deletes/:id', (req, res) => {
    const user = req.session.user;
    const id = req.params.id;

    if (!user) {
        return res.redirect('/login');
    }

    let queryDelete;
    let queryParams = [id];

    if (user.role === 'General') {
        queryDelete = 'DELETE FROM Servicio WHERE Id_Servicio = ?';
    } else if (user.role === 'Hotel') {
        queryDelete = 'DELETE FROM Servicio WHERE Id_Servicio = ? AND Id_Hotel = ?';
        queryParams.push(user.id_hotel); // Solo puede eliminar servicios de su hotel
    } else {
        return res.redirect('/login');
    }

    conexion.query(queryDelete, queryParams, (error, results) => {
        if (error) {
            console.error('Error al eliminar el servicio:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        else if(user.role === 'General'){
            res.redirect('/servicio/');
        }else if(user.role === 'Hotel'){
         res.redirect(`/servicios/${user.id_hotel}`)
        } // Redirigir a la lista de servicios
    });
});



 //PAIS
 router.post('/savep', crud.savep)
 router.post('/updatep', crud.updatep);   
  router.get('/pais', (req,res)=> {
    const user = req.session.user;  
    if (user.role === 'Hotel') {
        return res.redirect(`/hotel/${user.id_hotel}`);  
    } else if(user.role === 'General'){
      conexion.query(
          `SELECT Id_Pais, Pais FROM Pais ORDER BY Pais desc;`,
          (error, results) => {
              if (error) {
                  throw error;
              } else {
                  // Usa la ruta relativa sin la barra inicial
                  res.render('pais/pais', { results,user });
              }
          }
      )
    }
  });
  
  //Añadir pais

  router.get('/createp', (req, res) => {
      // Consulta para obtener los países
      const queryPais = 'SELECT Id_Pais, Pais FROM Pais'; 
  
      // Ejecutar la consulta
      conexion.query(queryPais, (error, paisResults) => {
          if (error) {
              console.error('Error al obtener los países:', error.message);
              return res.status(500).send('Error en el servidor');
          }
  
          // Renderizar la vista con los datos obtenidos
          res.render('pais/createp', { 
              paises: paisResults
          });
      });
  });

  //EDITAR PAIS
  

  router.get('/editp/:id', (req, res) => {
      const Id_Pais = req.params.id;
      const queryPais = 'SELECT * FROM Pais WHERE Id_Pais = ?';
  
      // Primera consulta: Obtener el país específico
      conexion.query(queryPais, [Id_Pais], (error, paisResults) => {
          if (error) {
              console.error('Error al obtener el pais:', error.message);
              return res.status(500).send('Error en el servidor');
          }

          if (paisResults.length === 0) {
              return res.status(404).send('Pais no encontrado');
          } 
          res.render('pais/editp', {
              pais: paisResults[0], // Datos de la habitación
              
          });
      });
  });

  //ELIMINAR PAIS

  router.get('/deletep/:id', (req, res) => {
      const id = req.params.id; 
      conexion.query('DELETE FROM Pais WHERE Id_Pais = ?', [id], (error, results) => {
          if (error) {
              throw error;
          } else {
              res.redirect('/pais'); // Redirigimos al usuario a la página principal
          }
      });
  });




       //RESERVAS

       router.get('/reservas', (req, res) => {
        const user = req.session.user;  // Obtener el usuario de la sesión
        if (user.role === 'General') {
        const query = `
            SELECT 
                r.*, 
                c.Nom AS Nombre, 
                c.Cognom AS Apellido,
                a.Nombre AS Actividad,
                h.Numero_Habitacion AS Habitacion,
                ho.Nombre AS Hotel
            FROM Reservas r
            LEFT JOIN Clients c ON r.Id_Cliente = c.Id_Client 
            LEFT JOIN Actividades a on r.Id_Actividad = a.Id_Actividades
            LEFT JOIN Habitaciones h on r.Id_Habitacion = h.Id_Habitaciones
            LEFT JOIN Hotel ho on r.Id_Hotel = ho.Id_Hotel
        `;
    
        conexion.query(query, (error, results) => {
            if (error) {
                throw error;
            } else {
                res.render('reservas/reservas', { results,user });
            }
        });
    }else{
        return res.redirect('/login');

    }
    });



    router.get('/reserva/:id', (req, res) => {
        const user = req.session.user;  // Obtener el usuario de la sesión
        const hotelId = req.params.id;  // Obtener el Id_Hotel de la URL
    
        if (!user) {
            return res.redirect('/login');  // Redirigir si el usuario no está logueado
        }
    
        if (user.role === 'Hotel') {
            // Si el usuario intenta acceder a otro hotel, lo redirigimos al suyo
            if (hotelId != user.id_hotel) {
                return res.redirect(`/reserva/${user.id_hotel}`);
            }
    
            // Mostrar las ofertas solo del hotel del usuario
            conexion.query(
                `  SELECT 
                r.*, 
                c.Nom AS Nombre, 
                c.Cognom AS Apellido,
                a.Nombre AS Actividad,
                h.Numero_Habitacion AS Habitacion,
                ho.Nombre AS Hotel
                

            FROM Reservas r

            LEFT JOIN Clients c ON r.Id_Cliente = c.Id_Client 
            LEFT JOIN Actividades a on r.Id_Actividad = a.Id_Actividades
            LEFT JOIN Habitaciones h on r.Id_Habitacion = h.Id_Habitaciones
            LEFT JOIN Hotel ho on r.Id_Hotel = ho.Id_Hotel
                WHERE h.Id_Hotel = ?`,
                [hotelId],  
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        res.render('reservas/reservas', { results, user });
                    }
                }
            );
        } else {
            // Si el usuario no tiene rol "Hotel", lo enviamos a la lista general de ofertas
            return res.redirect('/login');
        }
    });
    
        //TARIFA

        router.post('/savet', crud.savet)
        router.post('/updatet', crud.updatet); 

        
    router.get('/tarifas/:id', (req, res) => {
        const user = req.session.user;  // Obtener el usuario de la sesión
        const hotelId = req.params.id;  // Obtener el Id_Hotel de la URL
    
        if (!user) {
            return res.redirect('/login');  // Redirigir si el usuario no está logueado
        }
    
        if (user.role === 'Hotel') {
            // Si el usuario intenta acceder a otro hotel, lo redirigimos al suyo
            if (hotelId != user.id_hotel) {
                return res.redirect(`/tarifas/${user.id_hotel}`);
            }
    
            // Mostrar las ofertas solo del hotel del usuario
            conexion.query(
                ` SELECT 
                    t.Id_Tarifa, 
                    h.Nombre,
                    hab.Numero_Habitacion,
                    a.Nombre as Actividad,
                    s.Servicio,
                    t.Tipo_Habitacion,
                    t.Temporada,
                    t.Precio
                FROM Tarifa t
                LEFT JOIN Hotel h ON t.Id_Hotel = h.Id_Hotel
                LEFT JOIN Habitaciones hab ON t.Id_Habitacion = hab.Id_Habitaciones 
                LEFT JOIN Actividades a ON t.Id_Actividad = a.Id_Actividades
                LEFT JOIN Servicio s ON t.Id_Servicios = s.Id_Servicio
                WHERE h.Id_Hotel = ?`,
                [hotelId],  
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        res.render('tarifa/tarifa', { results, user });
                    }
                }
            );
        } else {
            // Si el usuario no tiene rol "Hotel", lo enviamos a la lista general de ofertas
            return res.redirect('/login');
        }
    });
    

        router.get('/tarifa', (req, res) => {
            const user = req.session.user;  // Obtener el usuario de la sesión

            if (user.role === 'General') {
            conexion.query(
                `SELECT 
                    t.Id_Tarifa, 
                    h.Nombre,
                    hab.Numero_Habitacion,
                    a.Nombre as Actividad,
                    s.Servicio,
                    t.Tipo_Habitacion,
                    t.Temporada,
                    t.Precio
                FROM Tarifa t
                LEFT JOIN Hotel h ON t.Id_Hotel = h.Id_Hotel
                LEFT JOIN Habitaciones hab ON t.Id_Habitacion = hab.Id_Habitaciones 
                LEFT JOIN Actividades a ON t.Id_Actividad = a.Id_Actividades
                LEFT JOIN Servicio s ON t.Id_Servicios = s.Id_Servicio`,
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        res.render('tarifa/tarifa', { results, user });
                    }
                }
            );
        } else {
            // Si el usuario no tiene rol "Hotel", lo enviamos a la lista general de ofertas
            return res.redirect('/login');
        }
        });
        router.get('/seleccionhabitacion/:id_hotel', (req, res) => {
            const idHotel = req.params.id_hotel;
            const query = 'SELECT Id_Habitaciones, Numero_Habitacion, Tipo FROM Habitaciones WHERE Id_Hotel = ?';
          
            conexion.query(query, [idHotel], (error, results) => {
              if (error) {
                console.error('Error al obtener las habitaciones:', error.message);
                return res.status(500).json({ error: 'Error en el servidor' });
              }
              res.json(results); // Devuelve las habitaciones en formato JSON
            });
          });
          

       // Ruta para crear una tarifa
router.get('/createt', (req, res) => {
    const user = req.session.user;

    if (!user) {
        return res.redirect('/login');
    }

    let queryHotel;
    let queryParams = [];

    if (user.role === 'General') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    } else if (user.role === 'Hotel') {
        queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel WHERE Id_Hotel = ?';
        queryParams = [user.id_hotel];
    } else {
        return res.redirect('/login');
    }

    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion, Tipo FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre as Actividad FROM Actividades';
    const queryServicios = 'SELECT Id_Servicio, Id_Hotel, Servicio FROM Servicio';

    // Ejecutar todas las consultas en paralelo para mejorar la eficiencia
    conexion.query(queryHotel, queryParams, (error, hotelResults) => {
        if (error) {
            console.error('Error al obtener los hoteles:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        conexion.query(queryHabitacion, (error, habitacionResults) => {
            if (error) {
                console.error('Error al obtener las habitaciones:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            conexion.query(queryActividades, (error, actividadesResults) => {
                if (error) {
                    console.error('Error al obtener las actividades:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                conexion.query(queryServicios, (error, servicioResults) => {
                    if (error) {
                        console.error('Error al obtener los servicios:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }

                    res.render('tarifa/createt', { 
                        hoteles: hotelResults, 
                        habitaciones: habitacionResults, 
                        actividades: actividadesResults,
                        servicio: servicioResults,
                        user:user 
                    });
                });
            });
        });
    });
});

// Ruta para editar una tarifa
router.get('/editt/:id', (req, res) => {
    const user = req.session.user;
    const Id_Tarifa = req.params.id;

    if (!user) {
        return res.redirect('/login');
    }

    let queryTarifa;
    let queryParams = [Id_Tarifa];

    if (user.role === 'General') {
        queryTarifa = 'SELECT * FROM Tarifa WHERE Id_Tarifa = ?';
    } else if (user.role === 'Hotel') {
        queryTarifa = 'SELECT * FROM Tarifa WHERE Id_Tarifa = ? AND Id_Hotel = ?';
        queryParams.push(user.id_hotel);
    } else {
        return res.redirect('/login');
    }

    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel';
    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion, Tipo FROM Habitaciones';
    const queryActividad = 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre as Actividad FROM Actividades';
    const queryServicios = 'SELECT Id_Servicio, Id_Hotel, Servicio FROM Servicio';

    // Obtener la tarifa específica
    conexion.query(queryTarifa, queryParams, (error, tarifaResults) => {
        if (error) {
            console.error('Error al obtener la tarifa:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (tarifaResults.length === 0) {
            return res.status(404).send('Tarifa no encontrada');
        }

        // Ejecutar las demás consultas en paralelo
        conexion.query(queryHotel, (error, hotelResults) => {
            if (error) {
                console.error('Error al obtener los hoteles:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            conexion.query(queryHabitacion, (error, habitacionResults) => {
                if (error) {
                    console.error('Error al obtener las habitaciones:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                conexion.query(queryActividad, (error, actividadResults) => {
                    if (error) {
                        console.error('Error al obtener las actividades:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }

                    conexion.query(queryServicios, (error, servicioResults) => {
                        if (error) {
                            console.error('Error al obtener los servicios:', error.message);
                            return res.status(500).send('Error en el servidor');
                        }

                        res.render('tarifa/editt', {
                            tarifa: tarifaResults[0],     
                            hoteles: hotelResults,       
                            habitaciones: habitacionResults, 
                            actividades: actividadResults,   
                            servicios: servicioResults,
                            user:user      
                        });
                    });
                });
            });
        });
    });
});

// Ruta para eliminar una tarifa
router.get('/deletet/:id', (req, res) => {
    const user = req.session.user;
    const id = req.params.id;

    if (!user) {
        return res.redirect('/login');
    }

    let queryDelete;
    let queryParams = [id];

    if (user.role === 'General') {
        queryDelete = 'DELETE FROM Tarifa WHERE Id_Tarifa = ?';
    } else if (user.role === 'Hotel') {
        queryDelete = 'DELETE FROM Tarifa WHERE Id_Tarifa = ? AND Id_Hotel = ?';
        queryParams.push(user.id_hotel);
    } else {
        return res.redirect('/login');
    }

    conexion.query(queryDelete, queryParams, (error, results) => {
        if (error) {
            console.error('Error al eliminar la tarifa:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        else if(user.role === 'General'){
            res.redirect('/tarifa/');
        }else if(user.role === 'Hotel'){
         res.redirect(`/tarifas/${user.id_hotel}`)
        } // Red
    });
});


//Gestion de estados

  // Ruta para mostrar los estados de las reservas de un cliente
// Ruta para obtener los estados de las reservas de un cliente específico
router.get('/informacion/:id', (req, res) => {

    const user = req.session.user;
    const clienteId = req.params.id;


    if(user.role === 'General'){

    // Consulta para obtener el nombre del cliente
    const queryCliente = `SELECT Nom FROM Clients WHERE Id_Client = ?`;

    conexion.query(queryCliente, [clienteId], (error, clienteResult) => {
        if (error) {
            console.error('Error al obtener el cliente:', error);
            return res.status(500).send('Error al obtener el cliente');
        }

        if (clienteResult.length === 0) {
            return res.status(404).send('Cliente no encontrado');
        }

        const Nom = clienteResult[0].Nom; // Nombre del cliente

        // Ahora obtenemos sus reservas
        const queryReservas = `
            SELECT 
                r.Id_Reserva, a.Nombre AS Actividad, hab.Tipo, h.Nombre, t.Temporada, 
                r.Precio_Habitacion, r.Precio_Actividad, r.Precio_Tarifa, r.Precio_Total,
                r.Checkin, r.Checkout, r.Numero_Personas, p.Pais, r.Estado
            FROM Reservas r
            LEFT JOIN Actividades a ON r.Id_Actividad = a.Id_Actividades
            LEFT JOIN Habitaciones hab ON r.Id_Habitacion = hab.Id_Habitaciones
            LEFT JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
            LEFT JOIN Tarifa t ON r.Id_Tarifa = t.Id_Tarifa
            LEFT JOIN Pais p ON r.Id_Pais = p.Id_Pais
            WHERE r.Id_Cliente = ?;
        `;

        conexion.query(queryReservas, [clienteId], (error, reservasResults) => {
            if (error) {
                console.error('Error al obtener las reservas:', error);
                return res.status(500).send('Error al obtener las reservas');
            }

            res.render('informacion', { resultados: reservasResults, clienteId, Nom });
        });
    });
}else{
    res.redirect('/login'); 
}
});


// Ruta para actualizar el estado de una reserva
router.post('/cliente/:id/estado/:reservaId', (req, res) => {
    const clienteId = req.params.id;
    const reservaId = req.params.reservaId;
    const nuevoEstado = req.body.estado; // El estado enviado en el formulario

    // Actualización del estado en la base de datos
    const query = 'UPDATE Reservas SET Estado = ? WHERE Id_Reserva = ? AND Id_Cliente = ?';
    conexion.query(query, [nuevoEstado, reservaId, clienteId], (error, results) => {
        if (error) {
            return res.status(500).send('Error al actualizar el estado de la reserva');
        }
        res.redirect(`/informacion/${clienteId}`);  // Redirige al cliente a la vista de estados
    });
});



//editar reserva
router.post('/updatereserva', crud.updatereserva)
router.post('/editareserva/:id', (req, res) => {
    const Id_Reserva = req.params.id;  // Obtener el Id_Reserva de los parámetros

    // Consultas necesarias
    const queryReserva = 'SELECT * FROM Reservas WHERE Id_Reserva = ?';
    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion, Tipo FROM Habitaciones';
    const queryActividad = 'SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre AS Actividad FROM Actividades';
    const queryServicios = 'SELECT Id_Servicio, Id_Hotel, Servicio FROM Servicio';
    const queryTarifa = 'SELECT Id_Tarifa, Id_Hotel, Id_Habitacion,Id_Actividad,Id_Servicios,Tipo_Habitacion,Temporada FROM Tarifa';

    // Consultar la reserva por Id_Reserva
    conexion.query(queryReserva, [Id_Reserva], (error, reservasResults) => {
        if (error) {
            console.error('Error al obtener la reserva:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (reservasResults.length === 0) {
            return res.status(404).send('Reserva no encontrada');
        }

        // Consultar los hoteles disponibles
        conexion.query(queryHotel, (error, hotelResults) => {
            if (error) {
                console.error('Error al obtener los hoteles:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Consultar las habitaciones disponibles
            conexion.query(queryHabitacion, (error, habitacionResults) => {
                if (error) {
                    console.error('Error al obtener las habitaciones:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                conexion.query(queryTarifa, (error, tarifaResults) => {
                    if (error) {
                        console.error('Error al obtener las tarifas:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }

                // Consultar las actividades disponibles
                conexion.query(queryActividad, (error, actividadResults) => {
                    if (error) {
                        console.error('Error al obtener las actividades:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }

                    // Consultar los servicios disponibles
                    conexion.query(queryServicios, (error, servicioResults) => {
                        if (error) {
                            console.error('Error al obtener los servicios:', error.message);
                            return res.status(500).send('Error en el servidor');
                        }

                        // Renderizar la vista de edición de reserva
                        res.render("editareserva", {
                            reserva: reservasResults[0],       // Datos de la reserva
                            hoteles: hotelResults,             // Lista de hoteles
                            habitaciones: habitacionResults,   // Lista de habitaciones
                            actividades: actividadResults,     // Lista de actividades
                            servicios: servicioResults,
                            tarifas: tarifaResults    // Lista de servicios
                        });
                    });
                });
                });
            });
        });
    });
});





//informacion hotel


router.get('/menu/:id', (req, res) => {
    const user = req.session.user;
    const hotelId = req.params.id;
    const query = 'SELECT Nombre FROM Hotel WHERE Id_Hotel = ?';

    conexion.query(query, [hotelId], (error, results) => {
        if (error || results.length === 0) {
            return res.status(500).send('Error al obtener el nombre del hotel');
        }

        const nombreHotel = results[0].Nombre; // Extrae el nombre del hotel
        res.render('hotel/informacion/menu', { hotelId, nombreHotel,user });
    });
});

router.get('/menu-estadistica-hotel/:id', (req, res) => {
    const hotelId = req.params.id;
    const query = 'SELECT Nombre FROM Hotel WHERE Id_Hotel = ?';

    conexion.query(query, [hotelId], (error, results) => {
        if (error || results.length === 0) {
            return res.status(500).send('Error al obtener el nombre del hotel');
        }

        const nombreHotel = results[0].Nombre; // Extrae el nombre del hotel
        res.render('hotel/informacion/estadistica/porhotel/menu-hotel', { hotelId, nombreHotel });
    });
});

router.get('/estadisticas/Actividades/:id', (req, res) => {
    const hotelId = req.params.id;

    const query = `
        SELECT a.Nombre AS actividad, COUNT(r.Id_Reserva) AS total_reservas 
        FROM Reservas r
        left join Actividades a on r.Id_Actividad = a.Id_Actividades
        WHERE r.Id_Hotel = ? 
        GROUP BY actividad
    `;

    conexion.query(query, [hotelId], (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados);  // Verifica los resultados aquí

        // Renderizamos la vista con los datos
        res.render('hotel/informacion/estadistica/porhotel/actividad-reserva', { hotelId: hotelId, datos: resultados });
    });
});





router.get('/estadisticas/Reservas-del-mes/:id', (req, res) => {
    const hotelId = req.params.id;

    const query = `
        SELECT 
            MONTH(r.Checkin) AS mes, 
            COUNT(r.Id_Reserva) AS total_reservas 
        FROM Reservas r
        WHERE r.Id_Hotel = ? 
        GROUP BY mes
        ORDER BY mes;
    `;

    conexion.query(query, [hotelId], (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados);  // Verifica los datos en la consola

        // Renderizar la vista con los datos
        res.render('hotel/informacion/estadistica/porhotel/mes', { hotelId: hotelId, datos: resultados });
    });
});






//estadistica servicios
router.get('/estadisticas/Servicios/:id', (req, res) => {
    const hotelId = req.params.id;

    const query = `
      SELECT 
    COALESCE(s.Servicio, 'No se ha reservado ningún servicio') AS Servicio, 
    COUNT(r.Id_Reserva) AS total_reservas
FROM Reservas r
LEFT JOIN Servicio s ON r.Id_Servicio = s.Id_Servicio
WHERE r.Id_Hotel = ? 
GROUP BY s.Servicio;

    `;

    conexion.query(query, [hotelId], (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados);  // Verifica los resultados aquí

        // Renderizamos la vista con los datos
        res.render('hotel/informacion/estadistica/porhotel/servicio-reserva', { hotelId: hotelId, datos: resultados });
    });
});

//esadistica tipo habitacion
router.get('/estadisticas/Habitaciones/:id', (req, res) => {
    const hotelId = req.params.id;

    const query = `
      SELECT 
    COALESCE(h.Tipo, 'No se ha reservado ningúna Habitacion') AS Tipo, 
    COUNT(r.Id_Reserva) AS total_reservas
FROM Reservas r
LEFT JOIN Habitaciones h ON r.Id_Habitacion = h.Id_Habitaciones
WHERE r.Id_Hotel = ? 
GROUP BY h.Tipo;

    `;

    conexion.query(query, [hotelId], (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados);  // Verifica los resultados aquí

        // Renderizamos la vista con los datos
        res.render('hotel/informacion/estadistica/porhotel/tiipo_habitacion', { hotelId: hotelId, datos: resultados });
    });
});


router.get('/estadisticas/Temporadas/:id', (req, res) => {
    const hotelId = req.params.id;

    const query = `
        SELECT 
            CASE 
                WHEN (MONTH(r.CheckIn) BETWEEN 12 AND 12 OR MONTH(r.CheckIn) BETWEEN 1 AND 3) THEN 'Invierno'
                WHEN (MONTH(r.CheckIn) BETWEEN 3 AND 6) THEN 'Primavera'
                WHEN (MONTH(r.CheckIn) BETWEEN 6 AND 9) THEN 'Verano'
                WHEN (MONTH(r.CheckIn) BETWEEN 9 AND 12) THEN 'Otoño'
                ELSE 'Desconocido'
            END AS Temporada,
            COUNT(r.Id_Reserva) AS total_reservas
        FROM Reservas r
        WHERE r.Id_Hotel = ? 
        GROUP BY Temporada
        ORDER BY FIELD(Temporada, 'Invierno', 'Primavera', 'Verano', 'Otoño');
    `;

    conexion.query(query, [hotelId], (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas por temporada:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados);  // Verifica los resultados en consola

        // Renderiza la vista con los datos de temporadas
        res.render('hotel/informacion/estadistica/porhotel/Temporada', { hotelId, datos: resultados });
    });
});

router.get('/estadisticas/Todas-las-reservas/:id', (req, res) => {
    const hotelId = req.params.id;

    const query = `
  SELECT 
    year AS year,
    COUNT(r.Id_Reserva) AS total_reservas
FROM (
    SELECT YEAR(CheckIn) AS year FROM Reservas WHERE Id_Hotel = ?
    UNION
    SELECT YEAR(CheckOut) AS year FROM Reservas WHERE Id_Hotel = ?
) AS años
LEFT JOIN Reservas r
    ON YEAR(r.CheckIn) <= años.year 
    AND YEAR(r.CheckOut) >= años.year
    AND r.Id_Hotel = ?
GROUP BY años.year
ORDER BY años.year;


    `;

    conexion.query(query, [hotelId, hotelId, hotelId], (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas por año:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados);  // Verifica que la columna se llame 'year'

        // Renderiza la vista con los datos de reservas por año
        res.render('hotel/informacion/estadistica/porhotel/reservageneral', { hotelId, datos: resultados });
    });
});

//ESTADISTICAS POR HOTELES

// Ruta que recibe el hotelId en la URL
// Si usas un archivo de rutas como routes/estadisticas.js
router.get('/estadisticas-cadena-hoteles', (req, res) => {
    const user = req.session.user;

    
    // Si no hay sesión o no tiene un rol, redirige al login
    if (user.role === 'Hotel') {
        // Si el usuario intenta acceder a otro hotel, lo redirigimos al suyo
    
            return res.redirect(`/`);
        }

    // Si pasa, renderiza la vista
    res.render('hotel/informacion/estadistica/todoshoteles/menu-todos', { user: user });
});


    
router.post('/estadisticas/Actividades-CadenaHotel', (req, res) => {

    const query = `
        SELECT 
            h.Nombre AS hotel, 
            COUNT(r.Id_Reserva) AS total_reservas
        FROM Reservas r
        JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
        WHERE r.Id_Actividad IS NOT NULL  
        GROUP BY h.Nombre
        ORDER BY total_reservas DESC;
    `;

    conexion.query(query, (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        res.render('hotel/informacion/estadistica/todoshoteles/actividad-hoteles', { datos: resultados});
    });
});



router.post('/estadisticas/Reservas-del-mes-CadenaHotel', (req, res) => {
   
    const query = `
        SELECT 
            h.Nombre AS hotel,
            DATE_FORMAT(r.Checkin, '%Y-%m') AS mes, 
            COUNT(r.Id_Reserva) AS total_reservas
        FROM Reservas r
        JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
        GROUP BY hotel, mes
        ORDER BY mes ASC, total_reservas DESC;
    `;

    conexion.query(query, (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados); // Para verificar los datos en consola

        // Renderiza la vista con los datos agrupados por mes y hotel
        res.render('hotel/informacion/estadistica/todoshoteles/mes-hoteles', { datos: resultados });
    });
});

router.post('/estadisticas/Servicios-CadenaHotel', (req, res) => {

    const query = `
        SELECT 
    h.Nombre AS hotel, 
    COUNT(r.Id_Reserva) AS total_reservas
FROM Reservas r
JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
WHERE r.Id_Servicio IS NOT NULL  -- Asegura que solo cuente reservas con servicios
GROUP BY h.Nombre
ORDER BY total_reservas DESC;

    `;

    conexion.query(query, (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados); // Verifica los resultados en consola

        // Renderiza la vista con los datos de todos los hoteles
        res.render('hotel/informacion/estadistica/todoshoteles/servicio-hoteles', { datos: resultados});
    });
});


router.post('/estadisticas/Habitaciones-CadenaHotel', (req, res) => {
  
    const query = `
        SELECT 
            h.Nombre AS hotel, 
            hab.Tipo AS tipo_habitacion, 
            COUNT(r.Id_Reserva) AS total_reservas
        FROM Reservas r
        JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
        JOIN Habitaciones hab ON r.Id_Habitacion = hab.Id_Habitaciones
        WHERE r.Id_Habitacion IS NOT NULL
        GROUP BY h.Nombre, hab.Tipo
        ORDER BY h.Nombre, total_reservas DESC;
    `;

    conexion.query(query, (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados); // Para verificar los datos en consola
        res.render('hotel/informacion/estadistica/todoshoteles/tipohab-hoteles', { datos: resultados});
    });
});


router.post('/estadisticas/Temporadas-CadenaHotel', (req, res) => {
    
    const query = `
        SELECT 
            h.Nombre AS hotel,
            CASE 
                WHEN MONTH(r.Checkin) IN (12, 1, 2) THEN 'Invierno'
                WHEN MONTH(r.Checkin) IN (3, 4, 5) THEN 'Primavera'
                WHEN MONTH(r.Checkin) IN (6, 7, 8) THEN 'Verano'
                WHEN MONTH(r.Checkin) IN (9, 10, 11) THEN 'Otoño'
            END AS temporada,
            COUNT(r.Id_Reserva) AS total_reservas
        FROM Reservas r
        JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
        WHERE r.Checkin IS NOT NULL
        GROUP BY h.Nombre, temporada
        ORDER BY h.Nombre, temporada;
    `;

    conexion.query(query, (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados); // Verifica los datos en consola

        // Renderiza la vista con los datos de reservas por temporada
        res.render('hotel/informacion/estadistica/todoshoteles/temporada-hoteles', { datos: resultados });
    });
});

router.post('/estadisticas/Todas-las-reservas-CadenaHotel', (req, res) => {
   
    const query = `
        SELECT 
            h.Nombre AS hotel,
            YEAR(r.Checkin) AS anio,
            COUNT(r.Id_Reserva) AS total_reservas
        FROM Reservas r
        JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
        WHERE r.Checkin IS NOT NULL
        GROUP BY h.Nombre, anio
        ORDER BY h.Nombre, anio;
    `;

    conexion.query(query, (error, resultados) => {
        if (error) {
            console.error('Error al obtener estadísticas:', error);
            return res.status(500).send('Error en el servidor');
        }

        console.log(resultados); // Verifica los datos en consola

        // Renderiza la vista con los datos de reservas por año
        res.render('hotel/informacion/estadistica/todoshoteles/reservas-hoteles', { datos: resultados });
    });
});

// estado reserva hoy

router.get('/estados-reservas/:hotelId', (req, res) => {
    const hotelId = req.params.hotelId;

    // Primero, obtenemos el nombre del hotel
    const queryHotel = 'SELECT Nombre FROM Hotel WHERE Id_Hotel = ?';

    conexion.query(queryHotel, [hotelId], (error, hotelResults) => {
        if (error || hotelResults.length === 0) {
            return res.status(500).send('Error al obtener el nombre del hotel');
        }

        const nombreHotel = hotelResults[0].Nombre; // Extraemos el nombre del hotel

        // Ahora, obtenemos las reservas para el hotel
        const queryReservas = `
            SELECT r.Id_Reserva, c.Nom, r.Checkin, r.EstadoLlegada
            FROM Reservas r
            LEFT JOIN Clients c ON r.Id_Cliente = c.Id_Client
            WHERE r.Id_Hotel = ? AND DATE(r.Checkin) = CURDATE();
        `;
        
        conexion.query(queryReservas, [hotelId], (error, resultados) => {
            if (error) {
                console.error('Error al obtener reservas:', error);
                return res.status(500).send('Error en el servidor');
            }
            
            // Filtramos las reservas para clasificarlas en "Llegaron" y "No Llegaron"
            const reservasLlegaron = resultados.filter(reserva => reserva.EstadoLlegada === 'Llego');
            const reservasNoLlegaron = resultados.filter(reserva => reserva.EstadoLlegada !== 'Llego');
            
            res.render('hotel/informacion/estados/reservas-clientes', {
                reservasLlegaron,
                reservasNoLlegaron,
                hotelId,
                nombreHotel // Pasamos el nombre del hotel a la vista
            });
        });
    });
});


router.post('/estados/actualizar-llegada', (req, res) => {
    const { idReserva, estado } = req.body;
    
    const query = `UPDATE Reservas SET EstadoLlegada = ? WHERE Id_Reserva = ?`;
    
    conexion.query(query, [estado, idReserva], (error) => {
        if (error) {
            console.error('Error al actualizar estado de llegada:', error);
            return res.status(500).send('Error en el servidor');
        }
        
        // Recarga la página después de actualizar el estado
        res.redirect('back');
    });
});


