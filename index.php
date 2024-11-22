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

// Modify the add_pasantia section
if (isset($_POST['add_pasantia'])) {
  $empresa = $_POST['agregarEmpresa'];
  $tutor = $_POST['agregarTutor'];
  $telefono = $_POST['agregarTutorTelefono'];

  $sql = "INSERT INTO pasantias (Nombre_Empresa, tutor, telefono) VALUES ('$empresa', '$tutor', '$telefono')";
  if ($conn->query($sql) === TRUE) {
      echo "Pasantía agregada correctamente";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Agregar tecnicatura a la base de datos
if (isset($_POST['add_tecnicatura'])) {
    $tecnicatura = $_POST['agregarTecnicatura'];

    $sql = "INSERT INTO tecnicaturas (nombre_tecnicatura) VALUES ('$tecnicatura')";
    if ($conn->query($sql) === TRUE) {
        echo "Tecnicatura agregada correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Agregar curso a la base de datos
if (isset($_POST['add_curso'])) {
    $anio = $_POST['agregarAnio'];
    $division = $_POST['agregarDivision'];

    $sql = "INSERT INTO cursos (anio, division) VALUES ('$anio', '$division')";
    if ($conn->query($sql) === TRUE) {
        echo "Curso agregado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Consulta SQL para obtener los datos
$sql = "SELECT f.idFormulario, f.nombre_apellido, f.gmail, f.telefono, f.direccion, f.anio_egreso, 
               t.nombre AS tecnicatura, c.anio, c.division, p.Nombre_Empresa
        FROM formulario f
        LEFT JOIN tecnicatura t ON f.Tecnicatura_idTecnicatura = t.idTecnicatura
        LEFT JOIN curso c ON f.Curso_idCurso = c.idCurso
        LEFT JOIN pasantias p ON f.Pasantias_idPasantias = p.idPasantias";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolsa de Empleo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        * {
            font-family: "Poppins", sans-serif;
        }

        .navbar {
            background-color: #fff;
            height: 80px;
            margin: 20px;
            border-radius: 16px;
            padding: 0.5rem;
        }

        .navbar-brand {
            font-weight: 500;
            color: #009970;
            font-size: 24px;
            transition: 0.3s color;
        }

        .login-button {
            background-color: #009970;
            color: #fff;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s background-color;
        }

        .login-button:hover {
            background-color: #00b383;
        }

        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
        }

        .navbar-toggler:focus, .btn-close:focus {
            box-shadow: none;
            outline: none;
        }

        .nav-link {
            color: #666777;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: #000;
        }

        @media (min-width: 991px) {
            .nav-link::before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 0%;
                height: 2px;
                background-color: #009970;
                visibility: hidden;
                transition: 0.3s ease-in-out;
            }

            .nav-link:hover::before, .nav-link.active::before {
                width: 100%;
                visibility: visible;
            }
        }

        .hero-section {
            background: url(https://th.bing.com/th/id/OIP.Ur0rR7-Bx0gz0tFxXB04PQHaDt?rs=1&pid=ImgDetMain) no-repeat center;
            background-size: cover;
            width: 100%;
            height: 100vh;
        }

        .hero-section::before {
            background-color: rgba(0, 0, 0, 0.6);
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .hero-section .container {
            height: 100vh;
            z-index: 1;
            position: relative;
        }

        .table {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand me-auto" href="#datos_completos">Logo</a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Logo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" aria-current="page" href="#datos_completos">Datos Completos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" data-bs-toggle="modal" data-bs-target="#pasantiaModal" href="#">Pasantias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" data-bs-toggle="modal" href="#tecnicaturaModal">Tecnicaturas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" data-bs-toggle="modal" href="#cursoModal">Cursos</a>
                    </li>
                </ul>
            </div>
        </div>
        <a href="Formulario.php" class="login-button">Formulario</a>
        <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<section class="hero-section" id="datos_completos">
    <div class="container d-flex align-items-center justify-content-center fs-6 text-white flex-column">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Gmail</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Año de Egreso</th>
                    <th scope="col">Tecnicatura</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Empresa Pasantía</th>
                    <th scope="col">Tutor</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['idFormulario']}</td>
                                <td>{$row['nombre_apellido']}</td>
                                <td>{$row['gmail']}</td>
                                <td>{$row['telefono']}</td>
                                <td>{$row['direccion']}</td>
                                <td>{$row['anio_egreso']}</td>
                                <td>{$row['tecnicatura']}</td>
                                <td>{$row['anio']}° {$row['division']}</td>
                                <td>{$row['Nombre_Empresa']}</td>
                                <td>{$row['tutor']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Pasantias -->
<div class="modal fade" id="pasantiaModal" tabindex="-1" aria-labelledby="pasantiaModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="pasantiaModalLabel">Agregar Pasantias</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST">
            <div class="modal-body">
              <div class="col-md-12">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="agregarEmpresa" name="agregarEmpresa" placeholder="Nombre de la Empresa" required>
                  <label for="agregarEmpresa">Nombre de la Empresa</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="agregarTutor" name="agregarTutor" placeholder="Nombre del Tutor" required>
                  <label for="agregarTutor">Nombre del Tutor</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="tel" class="form-control" id="agregarTutorTelefono" name="agregarTutorTelefono" placeholder="Teléfono del Tutor" required>
                  <label for="agregarTutorTelefono">Teléfono del Tutor</label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" name="add_pasantia" class="btn btn-primary">Agregar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<!-- Modal Tecnicaturas -->
<div class="modal fade" id="tecnicaturaModal" tabindex="-1" aria-labelledby="tecnicaturaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tecnicaturaModalLabel">Agregar Tecnicatura</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="col-md-12">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="agregarTecnicatura" name="agregarTecnicatura" placeholder="Nombre de la Tecnicatura" required>
              <label for="agregarTecnicatura">Nombre de la Tecnicatura</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="add_tecnicatura" class="btn btn-primary">Agregar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Cursos -->
<div class="modal fade" id="cursoModal" tabindex="-1" aria-labelledby="cursoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cursoModalLabel">Agregar Curso</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="col-md-12">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="agregarAnio" name="agregarAnio" placeholder="Año" required>
              <label for="agregarAnio">Año</label>
            </div>
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="agregarDivision" name="agregarDivision" placeholder="División" required>
              <label for="agregarDivision">División</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" name="add_curso" class="btn btn-primary">Agregar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
$conn->close();
?>