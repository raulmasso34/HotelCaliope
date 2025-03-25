const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');  // Asegúrate de configurar Sequelize con tu base de datos

const Reserva = sequelize.define('Reserva', {
  Id_Reserva: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  Id_Cliente: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  Id_Actividad: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  Id_Habitacion: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  Id_Hotel: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  Id_Tarifa: {
    type: DataTypes.INTEGER,
    allowNull: true
  },
  Precio_Habitacion: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: true
  },
  Precio_Actividad: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: true
  },
  Precio_Tarifa: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: true
  },
  Precio_Total: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: true
  },
  Estado: {
    type: DataTypes.ENUM('Por pagar', 'Pagado', 'Cancelado'),
    allowNull: false,
    defaultValue: 'Por pagar'
  }
}, {
  tableName: 'Reservas',
  timestamps: false
});

module.exports = Reserva;
