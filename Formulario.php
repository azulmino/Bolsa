<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bolsa_empleo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para sanitizar input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Manejar el envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_apellido = sanitize_input($_POST['nombreApellido']);
    $gmail = sanitize_input($_POST['correo']);
    $telefono = sanitize_input($_POST['telefono']);
    $direccion = sanitize_input($_POST['direccion']);
    $anio_egreso = sanitize_input($_POST['anoEgreso']);
    $tecnicatura_id = sanitize_input($_POST['tecnicatura']);
    $curso_id = sanitize_input($_POST['curso']);
    $pasantia_id = sanitize_input($_POST['empresaPasantias']);

    // Convert año_egreso to DATE format
    $anio_egreso = date('Y-m-d', strtotime("$anio_egreso-01-01"));

    // Preparar la consulta SQL
    $sql = "INSERT INTO formulario (nombre_apellido, gmail, telefono, direccion, anio_egreso, Tecnicatura_idTecnicatura, Curso_idCurso, Pasantias_idPasantias) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar y vincular parámetros
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssii", $nombre_apellido, $gmail, $telefono, $direccion, $anio_egreso, $tecnicatura_id, $curso_id, $pasantia_id);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>
                    alert('Registro exitoso!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>alert('Error al registrar: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error en la preparación de la consulta: " . $conn->error . "');</script>";
    }
}

// Fetch data for dropdowns
$cursos = $conn->query("SELECT * FROM curso");
$tecnicaturas = $conn->query("SELECT * FROM tecnicatura");
$empresas = $conn->query("SELECT * FROM pasantias");
$tutores = $conn->query("SELECT * FROM tutor");

$tutores = $conn->query("SELECT * FROM pasantias");
if (!$tutores) {
    die("Error fetching tutors: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Alumnos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    *{
        font-family: "Poppins" sans-serif;
    }
    /* Cambiar el fondo de la página */
    body {
        background: url(https://th.bing.com/th/id/OIP.Ur0rR7-Bx0gz0tFxXB04PQHaDt?rs=1&pid=ImgDetMain) no-repeat center;
    }

    /* Formulario */
    .form-container {
        background-color: #ffffff;
        border-radius: 10px; /* Bordes redondeados */
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        max-width: 80%; /* Limitar el ancho máximo */
        margin: 0 auto; /* Centrar el formulario */
    }

    .form-container .form-floating input, 
    .form-container .form-floating select {
        font-size: 0.9rem;
    }

    /* Boton Volver*/
    .navbar-form{
        margin: 20px;
        border-radius: 16px;
    }

    .volver-button{
        background-color: #009970;
        color: #fff;
        font-size: 14px;
        padding: 8px 20px;
        border-radius: 50px;
        text-decoration: none;
        transition: 0.3s background-color;
    }

    .volver-button:hover{
        background-color: #00b383;
    }

    /* Boton Volver*/
    .enviar-boton{
    margin-top: 6%;
    }

    .enviar-button {
        background-color: #009970;
        color: #fff;
        font-size: 14px;
        padding: 15px 100px;
        text-decoration: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .enviar-button:hover {
        background-color: #00b383;
    }
    </style>
</head>
<body>
    
    <nav class="navbar-form navbar-expand-lg">
        <div class="container-fluid">
            <a href="index.php" class="volver-button">Volver</a>
        </div>
    </nav>
    
    <div class="form-container">
        <h2 class="text-center mb-4">Formulario de Inscripción</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row">
                <!-- Columna 1 -->
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombreApellido" name="nombreApellido" placeholder="Nombre y Apellido" required>
                        <label for="nombreApellido">Nombre y Apellido</label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
                                <label for="direccion">Dirección</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" required>
                                <label for="correo">Correo</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                        <label for="telefono">Teléfono</label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="anoEgreso" name="anoEgreso" placeholder="Año de egreso" required>
                                <label for="anoEgreso">Año de Egreso</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="curso" name="curso" required>
                                    <option value="">Seleccionar curso</option>
                                    <?php while($row = $cursos->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['idCurso']; ?>"><?php echo $row['anio'] . '°' . $row['division']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="curso">Curso</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna 2 -->
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="tecnicatura" name="tecnicatura" required>
                            <option value="">Seleccionar tecnicatura</option>
                            <?php while($row = $tecnicaturas->fetch_assoc()) { ?>
                                <option value="<?php echo $row['idTecnicatura']; ?>"><?php echo $row['nombre']; ?></option>
                            <?php } ?>
                        </select>
                        <label for="tecnicatura">Tecnicatura</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="empresaPasantias" name="empresaPasantias" required>
                        <option value="">Seleccionar empresa</option>
                        <?php while($row = $empresas->fetch_assoc()) { ?>
                            <option value="<?php echo $row['idPasantias']; ?>"><?php echo $row['Nombre_Empresa']; ?></option>
                        <?php } ?>
                        </select>
                        <label for="empresaPasantias">Empresa Pasantías</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="mentor" name="mentor" required>
                            <option value="">Seleccionar mentor</option>
                            <?php while($row = $tutores->fetch_assoc()) { ?>
                                <option value="<?php echo $row['idPasantias']; ?>"><?php echo $row['tutor']; ?></option>
                            <?php } ?>
                        </select>
                        <label for="mentor">Mentor</label>
                    </div>

                    <div class="enviar-boton text-center mb-3">
                        <a href="index.php" class="enviar-button mt-4">Enviar</a>
                        <button class="navbar-toggler pe-0" type="submit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>