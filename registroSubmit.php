<?php
require_once __DIR__.'/modelos/apikey.php';
require_once __DIR__.'/lib/funciones.php';

$apiKey = new ApiKey();
$apiKey->nombre = $_POST['nombre'];
$apiKey->clave = uuid();
$apiKey->insertar();

$tituloPagina = "Clave de API";
include __DIR__.'/include/cabecera.php';
?>
    <p>La nueva clave de API "<?= htmlentities($apiKey->nombre, ENT_QUOTES) ?>" es:</p>
    <p class="font-monospace">
        <span id="key"><?= htmlentities($apiKey->clave, ENT_QUOTES) ?></span>
        <a id="copy" href="#" title="Copiar"><i class="bi-copy"></i></a>
    </p>
    <p>Debes guardar esta clave e incluirla en la cabecera X-ClaveApi en todas tus llamadas</p>
    <p><a href="index.php">Volver</a></p>
   </div>
   <script>
      let key = document.getElementById("key");
      let copy = document.getElementById("copy");
      copy.addEventListener("click", function(e) {
        e.preventDefault();
        navigator.clipboard.writeText(key.textContent)
          .then(() => {
            alert("Clave copiada al portapapeles");
          });
      });
   </script>
    
<?php include __DIR__.'/include/pie.php'; ?>
