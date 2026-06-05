<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Productos</title>
    <style>
        body {
            background-color: yellow;
            color: red;
            font-family: cursive;
            font-weight: 400;
            font-style: italic;
        }
        input, select{
            background-color: green;
            color: white;
            border-radius: 5px;
        }
        input::placeholder {
            color: white;
        }
        input:hover, select:hover{
            background-color: red;
            ba
        }
        input:focus, select:focus{
            background-color: blue;
        }
    </style>
</head>
<body>
    <header>
        <menu>
            <ul>
                <a href="./index.html"><button>Home</button></a>
                <a href="./altas.php"><button>Altas</button></a>
                <a href="./consultas.php"><button>Consultas</button></a>
            </ul>
        </menu>
        <hr>
        <h1>Altas Clientes</h1>
    </header>
    <form action="http://localhost/martes2/grabar.php" method="POST">
        <label>
            Nombre
            <input type="text" name="nombre" maxlength="100" placeholder="Ej: jaimito" required>
        </label>
        <br>
        <label>
            Apellidos
            <input type="text" name="apellidos" maxlength="100" placeholder="Ej: Martinez Perez" required>
        </label>
        <br>
        <label>
            Correo Electronico
            <input type="email" name="mail" placeholder="Ej: xxxxxx@xxx.xx" required>
        </label>
        <br>
        <label>
            Contraseña
            <input type="password" name="password" placeholder="Escribe tu contraseña" required>
        </label>
        <br>
        <label>
            Provincia
            <select name="provincia" id="">
                <option >A Coruña</option>
                <option >Lugo</option>
                <option >Ourense</option>
                <option >Pontevedra</option>
            </select>
        </label>
        <br>
        <label>
            Fecha de Nacimiento
            <input type="date" name="nacimiento" required>
        </label>
        <br>
        <label>
            Código Postal
            <input type="number" name="cp" placeholder="Ej: 15007" required>
        </label>
        <br>
        <br>

        <button>Enviar</button>
    </form>
</body>
</html>