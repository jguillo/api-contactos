<?php
$tituloPagina = "Registrar clave de API";
include __DIR__.'/include/cabecera.php';
?>
    <form action="registroSubmit.php" method="POST" class="row">
        <div class="col-md-8">
            <label class="form-label" for="nombre">
                Indica un nombre para la clave
            </label>
            <input type="text" id="nombre" name="nombre" required
                class="form-control" />
        </div>
        <div class="col-md-4">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">Crear clave de API</button>
        </div>
    </form>
    
<?php include __DIR__.'/include/pie.php'; ?>