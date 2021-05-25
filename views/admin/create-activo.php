<link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/servicio.css">


<form id="form-expense-container" action="admin/newActivo" method="POST">
    <h3>Registrar nuevo Activo</h3>
    <div class="section">
        <label for="amount">Codigo de Activo</label>
        <input type="text" name="id" id="color" autocomplete="off" required>
    </div>
    
    <div class="center">
        <input type="submit" value="Registrar nuevo activo">
    </div>
</form>