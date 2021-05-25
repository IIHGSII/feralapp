<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="public/css/default.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <?php require 'header.php'; ?>

    <div id="main-container">
        <div id="dashboard-container" class="container">
            <div id="left-container">
                <div id="panels-container">
                    <div class="panel">
                        <div class="title">USUARIOS</div>
                        <div class="datum"></div>
                        <div class="description">Usuarios registrados</div>
                    </div>
                    <div class="panel">
                        <div class="title">Servicios</div>
                        <div class="datum"></div>
                        <div class="description">Transacciones</div>
                    </div>
                    <div class="panel">
                        <div class="title">Servicios</div>
                        <div class="datum">Gs</div>
                        <div class="description">Servicio máximo</div>
                    </div>
                    <div class="panel">
                        <div class="title">Servicios</div>
                        <div class="datum">Gs</div>
                        <div class="description">Servicio mínimo</div>
                    </div>
                    <div class="panel">
                        <div class="title">Activos</div>
                        <div class="datum"></div>
                        <div class="description">Activos creados</div>
                    </div>
                    <div class="panel">
                        <div class="title">Activos</div>
                        <div class="datum"></div>
                        <div class="description">Activos más usados</div>
                    </div>
                    <div class="panel">
                        <div class="title">Activos</div>
                        <div class="datum"></div>
                        <div class="description">Activos menos usados</div>
                    </div>
                </div>
            </div>
            <div id="right-container">
                <div class="transactions-container">
                    <section class="operations-container">
                        <h2>Operaciones</h2>  
                        
                        <button class="btn-main" id="new-activo">
                            <i class="material-icons">add</i>
                            <span>Registrar un nuevo activo</span>
                        </button>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="public/js/admin.js"></script>
</body>
</html>