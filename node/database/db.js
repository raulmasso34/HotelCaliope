const mysql = require('mysql');

const conexion = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'P@ssw0rd',
    database: 'HotelCaliope'
})

conexion.connect((error) => {
    if (error) {
        console.error('El error de conexión es: ' + error.message); // Mejor manejo de errores
        return;
    }
    console.log('Conexión realizada');
});

module.exports = conexion;