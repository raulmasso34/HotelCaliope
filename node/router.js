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


        //PAIS
       router.post('/savep', crud.savep)
       router.post('/updatep', crud.updatep);   
        router.get('/pais', (req,res)=> {
            conexion.query(
                `SELECT Id_Pais, Pais FROM Pais;`,
                (error, results) => {
                    if (error) {
                        throw error;
                    } else {
                        // Usa la ruta relativa sin la barra inicial
                        res.render('pais/pais', { results });
                    }
                }
            )
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
        



    //HABITACIONES

        router.post('/savehab', crud.savehab)
        router.post('/updatehab', crud.updatehab);
        router.get('/habitaciones', (req, res) => {
            conexion.query(
                `SELECT 
                    ha.Id_Habitaciones, ha.Numero_Habitacion, ha.Tipo, ha.Capacidad, ha.Precio, 
                     h.Nombre
                    
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


        //RESERVAS

        router.get('/reservas', (req, res) => {
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
                    res.render('reservas/reservas', { results });
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
                    a.Nombre as Actividad,
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
            const queryActividades = 'SELECT Id_Actividades,Id_Hotel,Dia_Inicio,Dia_Fin,Hora_Inicio,Hora_Fin,Capacidad_Maxima,Ubicacion,Descripcion,Precio,Nombre as Actividad FROM Actividades';

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
            const queryActividades = 'SELECT Id_Actividades,Id_Hotel,Dia_Inicio,Dia_Fin,Hora_Inicio,Hora_Fin,Capacidad_Maxima,Ubicacion,Descripcion,Precio,Nombre as Actividad FROM Actividades';

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
                    res.redirect('/ofertas'); // Redirigimos al usuario a la página principal
                }
            });
        });


        //ACTIVIDADES

        router.post('/savea', crud.savea)
        router.post('/updatea', crud.updatea); 
        router.get('/actividades', (req, res) => {
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
                        res.render('actividades/actividades', { results });
                    }
                }
            );
        });


        router.get('/createa', (req, res) => {
            // Consultas para obtener datos de Hotel, Habitaciones y Actividades
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
            const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';
            const queryActividades = 'SELECT Id_Actividades,Id_Hotel,Dia_Inicio,Dia_Fin,Hora_Inicio,Hora_Fin,Capacidad_Maxima,Ubicacion,Descripcion,Precio,Nombre as Actividad FROM Actividades';

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
            const Id_Actividades = req.params.id;
            const queryActividades = 'SELECT * FROM Actividades WHERE Id_Actividades = ?';
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
            const queryHabitacion = 'SELECT Id_Habitaciones,Numero_Habitacion FROM Habitaciones';
        

            // Primera consulta: Obtener la oferta específica
            conexion.query(queryActividades, [Id_Actividades], (error, actividadesResults) => {
                if (error) {
                    console.error('Error al obtener la oferta:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                if (actividadesResults.length === 0) {
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


                            // Renderizamos la vista con todos los datos
                            res.render('actividades/edita', {
                                actividades: actividadesResults [0],              // Datos de la oferta
                                hoteles: hotelResults,       // Lista de hoteles
                                habitaciones: habitacionResults, // Lista de habitaciones
                                // Lista de actividades
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


        //ACTIVIDADES

        router.post('/saves', crud.saves)
        router.post('/updates', crud.updates); 
        router.get('/servicio', (req, res) => {
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
                        res.render('servicio/servicio', { results });
                    }
                }
            );
        });


        router.get('/creates', (req, res) => {
            // Consultas para obtener datos de Hotel, Habitaciones y Actividades
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
            const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion FROM Habitaciones';
            const queryActividades = 'SELECT Id_Actividades,Id_Hotel,Dia_Inicio,Dia_Fin,Hora_Inicio,Hora_Fin,Capacidad_Maxima,Ubicacion,Descripcion,Precio,Nombre as Actividad FROM Actividades';

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
                        res.render('servicio/creates', { 
                            hoteles: hotelResults, 
                            habitaciones: habitacionResults, 
                            actividades: actividadesResults 
                        });
                    });
                });
            });
        });


        router.get('/edits/:id', (req, res) => {
            const Id_Servicio = req.params.id;
            const queryServicios = 'SELECT * FROM Servicio WHERE Id_Servicio = ?';
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
            const queryHabitacion = 'SELECT Id_Habitaciones,Numero_Habitacion FROM Habitaciones';
        

            // Primera consulta: Obtener la oferta específica
            conexion.query(queryServicios, [Id_Servicio], (error, serviciosResults) => {
                if (error) {
                    console.error('Error al obtener la oferta:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                if (serviciosResults.length === 0) {
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


                            // Renderizamos la vista con todos los datos
                            res.render('servicio/edits', {
                                servicio: serviciosResults [0],              // Datos de la oferta
                                hoteles: hotelResults,       // Lista de hoteles
                                habitaciones: habitacionResults, // Lista de habitaciones
                                // Lista de actividades
                            });
                        
                    });
                });
            });
        });

        router.get('/deletes/:id', (req, res) => {
            const id = req.params.id; 
            conexion.query('DELETE FROM Servicio WHERE Id_Servicio = ?', [id], (error, results) => {
                if (error) {
                    throw error;
                } else {
                    res.redirect('/servicio'); // Redirigimos al usuario a la página principal
                }
            });
        });


        //TARIFA

        router.post('/savet', crud.savet)
        router.post('/updatet', crud.updatet); 
        router.get('/tarifa', (req, res) => {
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
                        res.render('tarifa/tarifa', { results });
                    }
                }
            );
        });


        router.get('/createt', (req, res) => {
            // Consultas para obtener datos de Hotel, Habitaciones y Actividades
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
            const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion, Tipo FROM Habitaciones';
            const queryActividades = 'SELECT Id_Actividades,Id_Hotel,Dia_Inicio,Dia_Fin,Hora_Inicio,Hora_Fin,Capacidad_Maxima,Ubicacion,Descripcion,Precio,Nombre as Actividad FROM Actividades';
            const queryServicios = 'SELECT Id_Servicio,Id_Hotel, Servicio FROM Servicio';


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
                        conexion.query(queryServicios, (error, servicioResults) => {
                            if (error) {
                                console.error('Error al obtener las actividades:', error.message);
                                return res.status(500).send('Error en el servidor');
                            }

                        // Renderizar la vista con los datos obtenidos
                        res.render('tarifa/createt', { 
                            hoteles: hotelResults, 
                            habitaciones: habitacionResults, 
                            actividades: actividadesResults,
                            servicio: servicioResults 
                        });
                        });
                    });
                });
            });
        });


        router.get('/editt/:id', (req, res) => {
            const Id_Tarifa = req.params.id;
            const queryTarifas = 'SELECT * FROM Tarifa WHERE Id_Tarifa = ?';
            const queryHotel = 'SELECT Id_Hotel, Nombre FROM Hotel'; 
            const queryHabitacion = 'SELECT Id_Habitaciones, Numero_Habitacion, Tipo FROM Habitaciones';
            const queryActividad = 'SELECT Id_Actividades,Id_Hotel,Dia_Inicio,Dia_Fin,Hora_Inicio,Hora_Fin,Capacidad_Maxima,Ubicacion,Descripcion,Precio,Nombre as Actividad FROM Actividades';
            const queryServicios = 'SELECT Id_Servicio, Id_Hotel, Servicio FROM Servicio';

            // Primera consulta: Obtener la tarifa específica
            conexion.query(queryTarifas, [Id_Tarifa], (error, tarifasResults) => {
                if (error) {
                    console.error('Error al obtener la tarifa:', error.message);
                    return res.status(500).send('Error en el servidor');
                }

                if (tarifasResults.length === 0) {
                    return res.status(404).send('Tarifa no encontrada');
                }

                // Segunda consulta: Obtener los hoteles
                conexion.query(queryHotel, (error, hotelResults) => {
                    if (error) {
                        console.error('Error al obtener los hoteles:', error.message);
                        return res.status(500).send('Error en el servidor');
                    }

                    // Tercera consulta: Obtener las habitaciones con el tipo incluido
                    conexion.query(queryHabitacion, (error, habitacionResults) => {
                        if (error) {
                            console.error('Error al obtener las habitaciones:', error.message);
                            return res.status(500).send('Error en el servidor');
                        }

                        // Cuarta consulta: Obtener actividades
                        conexion.query(queryActividad, (error, actividadResults) => {
                            if (error) {
                                console.error('Error al obtener las actividades:', error.message);
                                return res.status(500).send('Error en el servidor');
                            }

                            // Quinta consulta: Obtener servicios
                            conexion.query(queryServicios, (error, servicioResults) => {
                                if (error) {
                                    console.error('Error al obtener los servicios:', error.message);
                                    return res.status(500).send('Error en el servidor');
                                }

                                // Renderizamos la vista con todos los datos
                                res.render('tarifa/editt', {
                                    tarifa: tarifasResults[0],       // Datos de la tarifa
                                    hoteles: hotelResults,           // Lista de hoteles
                                    habitaciones: habitacionResults, // Lista de habitaciones con tipo
                                    actividades: actividadResults,   // Lista de actividades
                                    servicios: servicioResults       // Lista de servicios
                                });
                            });
                        });
                    });
                });
            });
        });


        router.get('/deletet/:id', (req, res) => {
            const id = req.params.id; 
            conexion.query('DELETE FROM Tarifa WHERE Id_Tarifa = ?', [id], (error, results) => {
                if (error) {
                    throw error;
                } else {
                    res.redirect('/tarifa'); // Redirigimos al usuario a la página principal
                }
            });
        });

//Gestion de estados

  // Ruta para mostrar los estados de las reservas de un cliente
// Ruta para obtener los estados de las reservas de un cliente específico
router.get('/informacion/:id', (req, res) => {
    const clienteId = req.params.id;

    // Consulta SQL para obtener las reservas del cliente
    const query = `SELECT 
    r.Id_Reserva, c.Nom, a.Nombre as Actividad, hab.Tipo, h.Nombre, t.Temporada, 
    r.Precio_Habitacion, r.Precio_Actividad, r.Precio_Tarifa, r.Precio_Total,r.Checkin,r.Checkout,r.Numero_Personas,p.Pais, r.Estado
FROM Reservas r
LEFT JOIN Clients c ON r.Id_Cliente = c.Id_Client
LEFT JOIN Actividades a ON r.Id_Actividad = a.Id_Actividades
LEFT JOIN Habitaciones hab ON r.Id_Habitacion = hab.Id_Habitaciones
LEFT JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
LEFT JOIN Tarifa t ON r.Id_Tarifa = t.Id_Tarifa
LEFT JOIN Pais p ON r.Id_Pais = p.Id_Pais
WHERE r.Id_Cliente = ?;`;
    conexion.query(query, [clienteId], (error, results) => {
        if (error) {
            return res.status(500).send('Error al obtener los estados de las reservas');
        }
        res.render('informacion', { resultados: results, clienteId });
    });
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
    const hotelId = req.params.id;
    res.render('informacion/menu', { hotelId }); // Renderiza la vista con la ID del hotel
});
