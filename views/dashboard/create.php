<link rel="stylesheet" href="public/css/servicio.css">
<form id="form-expense-container" action="servicios/newServicio" method="POST">
    <h3>Registrar nuevo servicio</h3>
    <div class="section">
        <label for="amount">Cantidad</label>
        <input type="number" name="amount" id="amount" autocomplete="off" required>
    </div>
    <div class="section">
        <label for="title">Descripción</label>
        <div><input type="text" name="title" autocomplete="off" required></div>
    </div>
    
    <div class="section">
        <label for="date">Fecha de servicio</label>
        <input type="date" name="date" id="" required>
    </div>    
    <div class="section">
        <label for="activo">Activo</label>
            <select name="activo" id="" required>
            </select>
    </div>    
    <div class="center">
        <input type="submit" value="Nuevo servicio">
    </div>
</form>