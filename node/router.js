const express = require('express');
const router = express.Router();
const conexion = require('./database/db');

const crud = require('./controllers/crud');
const { route } = require('express/lib/application');

module.exports = router;


//CLIENTES
router.get('/', (req,res) =>{
    conexion.query(
        `SELECT 
             c.Id_Client, c.Nom, c.Cognom, c.DNI, c.CorreuElectronic, 
             c.Telefon, c.Usuari, c.Password, p.Pais, c.Ciudad, c.CodigoPostal 
         FROM 
             Clients c 
         LEFT JOIN 
             Pais p 
         ON 
             c.Id_Pais = p.Id_Pais;`,
        (error, results) => {
            if (error) {
                throw error;
            } else {
                res.render('index', { results });
            }
        }
    );
    
})




//ruta para crear registros
router.get('/create', (req, res) => {
    const queryCountries = 'SELECT Id_Pais, Pais FROM Pais'; // Consulta para obtener los países
    conexion.query(queryCountries, (error, countryResults) => {
        if (error) {
            console.error('Error al obtener los países:', error.message);
            return res.status(500).send('Error en el servidor');
        }
        res.render('create', { countries: countryResults }); // Pasa la lista de países a la vista
    });
});


router.post('/save', crud.save)
router.post('/update', crud.update);

//ruta editar

router.get('/edit/:id', (req, res) => {
    const Id_Client = req.params.id;
    const queryClient = 'SELECT * FROM Clients WHERE Id_Client = ?';
    const queryCountries = 'SELECT Id_Pais, Pais FROM Pais'; // Consulta para los países

    // Primera consulta: obtener los datos del cliente
    conexion.query(queryClient, [Id_Client], (error, clientResults) => {
        if (error) {
            console.error('Error al obtener el cliente:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (clientResults.length === 0) {
            return res.status(404).send('Cliente no encontrado');
        }

        // Segunda consulta: obtener los países
        conexion.query(queryCountries, (error, countryResults) => {
            if (error) {
                console.error('Error al obtener los países:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Renderizamos la vista y enviamos los datos necesarios
            res.render('edit', {
                user: clientResults[0], // Datos del cliente
                countries: countryResults, // Lista de países
            });
        });
    });
});


router.get('/delete/:id', (req, res) => {
    const id = req.params.id; 
    conexion.query('DELETE FROM Clients WHERE Id_Client = ?', [id], (error, results) => {
        if (error) {
            throw error;
        } else {
            res.redirect('/'); // Redirigimos al usuario a la página principal
        }
    });
});

//HABITACIONES

router.post('/savehab', crud.savehab)
router.post('/updatehab', crud.updatehab);
router.get('/habitaciones', (req, res) => {
    conexion.query(
        `SELECT 
             ha.Id_Habitaciones, ha.Numero_Habitacion, ha.Tipo, ha.Capacidad, ha.Precio, 
             ha.Disponibilidad, h.Nombre,
             IF(ha.Disponibilidad = 1, 'Disponible', 'No Disponible') AS Disponibilidad
         FROM 
             Habitaciones ha 
         LEFT JOIN 
             Hotel h 
         ON 
             ha.Id_Hotel = h.Id_Hotel;`,
        (error, results) => {
            if (error) {
                throw error;
            } else {
                // Usa la ruta relativa sin la barra inicial
                res.render('Habitaciones/habitaciones', { results });
            }
        }
    );
});

router.get('/createhab', (req, res) => {
    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel';

    // Primera consulta: obtener disponibilidades
   

        // Segunda consulta: obtener hoteles
        conexion.query(queryHotel, (error, hotelResults) => {
            if (error) {
                console.error('Error al obtener los hoteles:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Renderizamos la vista y enviamos los datos necesarios
            res.render('Habitaciones/createhab', {
               
                hoteles: hotelResults
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
    conexion.query('DELETE FROM Habitaciones WHERE Id_Habitaciones = ?', [id], (error, results) => {
        if (error) {
            throw error;
        } else {
            res.redirect('/habitaciones'); // Redirigimos al usuario a la página principal
        }
    });
});


//HOTEL

router.post('/saveh', crud.saveh)
router.post('/updateh', crud.updateh);
router.get('/hotel', (req, res) => {
    conexion.query(
        `SELECT 
            h.Id_Hotel,h.Nombre,h.CorreoElectronico,h.Telefono,h.Direccion,h.CodigoPostal,p.Pais,h.Ciudad,h.Estrellas        
        FROM Hotel h
        LEFT JOIN Pais p on h.Id_Pais = p.Id_Pais
        
        `,
        (error, results) => {
            if (error) {
                throw error;
            } else {
                // Usa la ruta relativa sin la barra inicial
                res.render('hotel/hotel', { results });
            }
        }
    );
});

router.get('/createh', (req, res) => {
    const queryCountries = 'SELECT Id_Pais, Pais FROM Pais'; // Consulta para obtener los países
    conexion.query(queryCountries, (error, countryResults) => {
        if (error) {
            console.error('Error al obtener los países:', error.message);
            return res.status(500).send('Error en el servidor');
        }
        res.render('hotel/createh', { countries: countryResults }); // Pasa la lista de países a la vista
    });
});

router.get('/edith/:id', (req, res) => {
    const Id_Hotel = req.params.id;
    const queryHotel = 'SELECT * FROM Hotel WHERE Id_Hotel = ?';
    const queryCountries = 'SELECT Id_Pais, Pais FROM Pais'; // Consulta para los países

    // Primera consulta: obtener los datos del cliente
    conexion.query(queryHotel, [Id_Hotel], (error, hotelResults) => {
        if (error) {
            console.error('Error al obtener el hotel:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (hotelResults.length === 0) {
            return res.status(404).send('Hotel no encontrado');
        }

        // Segunda consulta: obtener los países
        conexion.query(queryCountries, (error, countryResults) => {
            if (error) {
                console.error('Error al obtener los países:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Renderizamos la vista y enviamos los datos necesarios
            res.render('hotel/edith', {
                hotel: hotelResults[0], // Datos del cliente
                countries: countryResults, // Lista de países
            });
        });
    });
});



router.get('/deleteh/:id', (req, res) => {
    const id = req.params.id; 
    conexion.query('DELETE FROM Hotel WHERE Id_Hotel = ?', [id], (error, results) => {
        if (error) {
            throw error;
        } else {
            res.redirect('/hotel'); // Redirigimos al usuario a la página principal
        }
    });
});


//OFERTAS

 router.post('/saveo', crud.saveo)
router.post('/updateo', crud.updateo); 
router.get('/ofertas', (req, res) => {
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
            a.Actividad,
            IF(o.Estado = 1, 'Activo', 'Inactivo') AS Estado
        FROM Ofertas o
        LEFT JOIN Hotel h ON o.Id_Hotel = h.Id_Hotel
        LEFT JOIN Habitaciones ha ON o.Id_Habitacion = ha.Id_Habitaciones
        LEFT JOIN Actividades a ON o.Id_Actividad = a.Id_Actividades`,
        (error, results) => {
            if (error) {
                throw error;
            } else {
                res.render('ofertas/ofertas', { results });
            }
        }
    );
});


router.get('/createo', (req, res) => {
    // Consultas para obtener datos de Hotel, Habitaciones y Actividades
    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Actividad FROM Actividades';

    // Ejecutar las consultas en paralelo
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
            conexion.query(queryActividades, (error, actividadesResults) => {
                if (error) {
                    console.error('Error al obtener las actividades:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Renderizar la vista con los datos obtenidos
                res.render('ofertas/createo', { 
                    hoteles: hotelResults, 
                    habitaciones: habitacionResults, 
                    actividades: actividadesResults 
                });
            });
        });
    });
});


router.get('/edito/:id', (req, res) => {
    const Id_Oferta = req.params.id;
    const queryOferta = 'SELECT * FROM Ofertas WHERE Id_Oferta = ?';
    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    const queryHabitacion = 'SELECT Id_Habitaciones,Numero_Habitacion FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Actividad FROM Actividades';

    // Primera consulta: Obtener la oferta específica
    conexion.query(queryOferta, [Id_Oferta], (error, ofertaResults) => {
        if (error) {
            console.error('Error al obtener la oferta:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (ofertaResults.length === 0) {
            return res.status(404).send('Oferta no encontrada');
        }


        // Segunda consulta: Obtener los hoteles
        conexion.query(queryHotel, (error, hotelResults) => {
            if (error) {
                console.error('Error al obtener los hoteles:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Tercera consulta: Obtener las habitaciones
            conexion.query(queryHabitacion, (error, habitacionResults) => {
                if (error) {
                    console.error('Error al obtener las habitaciones:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Cuarta consulta: Obtener las actividades
                conexion.query(queryActividades, (error, actividadResults) => {
                    if (error) {
                        console.error('Error al obtener las actividades:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }

                    // Renderizamos la vista con todos los datos
                    res.render('ofertas/edito', {
                        oferta: ofertaResults[0],              // Datos de la oferta
                        hoteles: hotelResults,       // Lista de hoteles
                        habitaciones: habitacionResults, // Lista de habitaciones
                        actividades: actividadResults   // Lista de actividades
                    });
                });
            });
        });
    });
});




router.get('/deleteo/:id', (req, res) => {
    const id = req.params.id; 
    conexion.query('DELETE FROM Ofertas WHERE Id_Oferta = ?', [id], (error, results) => {
        if (error) {
            throw error;
        } else {
            res.redirect('/oferta'); // Redirigimos al usuario a la página principal
        }
    });
});


//ACTIVIDADES

//router.post('/savea', crud.savea)
//router.post('/updatea', crud.updatea); 
router.get('/actividades', (req, res) => {
    conexion.query(
        `SELECT 
            a.Id_Actividades, 
            a.Actividad,
            h.Nombre,
            a.Dia_Inicio,
            a.Dia_Fin,
            a.Hora_Inicio,
            a.Hora_Fin,
            a.Capacidad_Maxima,
            a.Ubicacion,
            a.Descripcion
        FROM Actividades a
        LEFT JOIN Hotel h ON a.Id_Hotel = h.Id_Hotel`,
        (error, results) => {
            if (error) {
                throw error;
            } else {
                res.render('actividades/actividades', { results });
            }
        }
    );
});


router.get('/createa', (req, res) => {
    // Consultas para obtener datos de Hotel, Habitaciones y Actividades
    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Actividad FROM Actividades';

    // Ejecutar las consultas en paralelo
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
            conexion.query(queryActividades, (error, actividadesResults) => {
                if (error) {
                    console.error('Error al obtener las actividades:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Renderizar la vista con los datos obtenidos
                res.render('actividades/createa', { 
                    hoteles: hotelResults, 
                    habitaciones: habitacionResults, 
                    actividades: actividadesResults 
                });
            });
        });
    });
});


router.get('/edita/:id', (req, res) => {
    const Id_Oferta = req.params.id;
    const queryOferta = 'SELECT * FROM Ofertas WHERE Id_Oferta = ?';
    const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
    const queryHabitacion = 'SELECT Id_Habitaciones,Numero_Habitacion FROM Habitaciones';
    const queryActividades = 'SELECT Id_Actividades, Actividad FROM Actividades';

    // Primera consulta: Obtener la oferta específica
    conexion.query(queryOferta, [Id_Oferta], (error, ofertaResults) => {
        if (error) {
            console.error('Error al obtener la oferta:', error.message);
            return res.status(500).send('Error en el servidor');
        }

        if (ofertaResults.length === 0) {
            return res.status(404).send('Oferta no encontrada');
        }


        // Segunda consulta: Obtener los hoteles
        conexion.query(queryHotel, (error, hotelResults) => {
            if (error) {
                console.error('Error al obtener los hoteles:', error.message);
                return res.status(500).send('Error en el servidor');
            }

            // Tercera consulta: Obtener las habitaciones
            conexion.query(queryHabitacion, (error, habitacionResults) => {
                if (error) {
                    console.error('Error al obtener las habitaciones:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                // Cuarta consulta: Obtener las actividades
                conexion.query(queryActividades, (error, actividadResults) => {
                    if (error) {
                        console.error('Error al obtener las actividades:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }

                    // Renderizamos la vista con todos los datos
                    res.render('actividades/edita', {
                        oferta: ofertaResults[0],              // Datos de la oferta
                        hoteles: hotelResults,       // Lista de hoteles
                        habitaciones: habitacionResults, // Lista de habitaciones
                        actividades: actividadResults   // Lista de actividades
                    });
                });
            });
        });
    });
});




router.get('/deletea/:id', (req, res) => {
    const id = req.params.id; 
    conexion.query('DELETE FROM Actividades WHERE Id_Actividades = ?', [id], (error, results) => {
        if (error) {
            throw error;
        } else {
            res.redirect('/actividades'); // Redirigimos al usuario a la página principal
        }
    });
});