<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FERAL App - Dashboard</title>
</head>
<body>
    <?php require 'header.php'; ?>

    <div id="main-container">
        
        <div id="servicios-container" class="container">
        
            <div id="left-container">
                
                <div id="servicios-summary">
                    <div>
                        <h2>Bienvenido </h2>
                    </div>
                    <div class="cards-container">
                        <div class="card w-100">
                            <div class="total-budget">
                                <span class="total-budget-text">
                                    Balance General del Mes    
                                </span>
                            </div>
                            <div class="total-servicios">
                                

                    </div>
                </div>

                <div id="servicios-activo">
                    <h2>Servicio del mes por activo</h2>
                    <div id="activos-container">
                        
                    </div>
                </div>
            </div>

            <div id="right-container">
                <div class="transactions-container">
                    <section class="operations-container">
                        <h2>Operaciones</h2>  
                        
                        <button class="btn-main" id="new-servicio">
                            <i class="material-icons">add</i>
                            <span>Registrar nuevo servicio</span>
                        </button>
                        <a href="<?php echo constant('URL'); ?>user#budget-user-container">Definir<i class="material-icons">keyboard_arrow_right</i></a>
                    </section>

                    <section id="servicios-recents">
                    <h2>Registros más recientes</h2>
                    
                    </section>
                </div>
            </div>
            

        </div>

    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="public/js/dashboard.js"></script>
    
</body>
</html>