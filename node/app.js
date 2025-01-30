const express = require('express');
const app = express();

app.set('view engine', 'ejs');

// Middleware para datos del formulario y JSON
app.use(express.urlencoded({ extended: false }));
app.use(express.json());

app.use('/', require('./router'));

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server corriendo en http://localhost:${PORT}`);
});
