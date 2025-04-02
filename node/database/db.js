    const mysql = require('mysql');

    const conexion = mysql.createConnection({
        host: 'localhost',
        user: 'root',
      password: 'password',
         // password: 'P@ssw0rd',
        database: 'HotelCaliope'
    })

    conexion.connect((error)=>{
        if(error){
            console.error('El error de conexión es '+error);
        }

        console.log('conexion realizada')
    })

    module.exports = conexion;