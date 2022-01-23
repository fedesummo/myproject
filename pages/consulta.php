<?php
// Si no se recibieron datos del formulario, se redirige a la página principal con un código de error.
if (!$_POST['dni']) {
    // Código de error por falta de datos -> error = 1.
    header("Location: ../index.html?error=1");
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Hoja de estilos del proyecto -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Título del documento -->
    <title>SN - Consulta de Trámite</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../imgs/favicon.ico" type="image/x-icon">
</head>

<body>

    <main class="vh-100 d-flex justify-content-center align-items-center" id="main-consulta">
        <div class="card text-center">
            <!-- Dentro de esta card JavaScript renderizará el contenido correspondiente -->
            <div class="card-body" id="card-body">
            </div>
        </div>
    </main>


<?php
// Datos de acceso a la base de datos.
$servername = "localhost";
$username = "id18327889_root";
$password = "oSvgFDW+1\|J~TGw";
$dbname = "id18327889_myproject";

// Se prepara la consulta a la base de datos.
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Se seleccionan todos los datos correspondientes al DNI recibido.
    $stmt = $conn->prepare("SELECT * FROM `driverslicense` WHERE `dni` = ${_POST['dni']}");
    // Se realiza la consulta.
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // Almaceno la información extraída de la base de datos en formato JSON.
    $myData = json_encode( $stmt->fetchAll() );
} catch(PDOException $e) {
    // En caso de producirse un error, lo renderizo en pantalla.
    echo "Error: " . $e->getMessage();
};

// Cierro la conexión a la base de datos.
$conn = null;
?>


    <script>
        // Paso la información extraída de la base de datos de PHP a JavaScript.
        let myData = JSON.parse('<?php echo $myData; ?>');

        // Consulto si se obtuvieron o no coincidencias.
        if( myData.length ) {
            
            // En caso de existir coincidencias, se completa el contenido de la card con el estado del trámite. 
            for (element of myData) {
                let card = document.getElementById('card-body');

                card.innerHTML = `<h1 class="card-title h2">Licencia Nacional de Conducir</h1>
                                <p class="card-text">Te informamos a continuación el estado de tu trámite.</p>
                                <div>
                                    <p>
                                        <b>DNI: </b><i>${element.dni}</i>
                                    </p>
                                    <p>
                                        <b>Nombre y Apellido: </b><i>${element.fullName}</i>
                                    </p>
                                    <p>
                                        <b>Estado del trámite: </b><i>${element.status}</i>
                                    </p>
                                    <p>
                                        <b>Descripción: </b><i>${element.description}</i>
                                    </p>
                                </div>
                                <a href="../index.html" class="btn btn-secondary">Volver a la página principal</a>`;

            }

        } else {
            
            // En caso de no existir coincidencias se completa la card sugieriendo al usuario que revise los datos ingresados.
            let card = document.getElementById('card-body');

            card.innerHTML = `<h1 class="card-title h2">Licencia Nacional de Conducir</h1>
                            <p class="card-text">Te informamos que no se encuentran trámites asociados al DNI ingresado.</p>
                            <p>Intente nuevamente o pongase en contacto a través de nuestras vías de comunicación.</p>
                            <a href="../index.html" class="btn btn-secondary">Volver a la página principal</a>`;

            
        };
    </script>
    
</body>

</html>