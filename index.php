<?php
$tituloPagina = "Documentación";
include __DIR__.'/include/cabecera.php';
?>

<p>Esta API permite gestionar listas de contactos para distintos usuarios.</p>

<h2>Clave de API</h2>
<p>
    Para empezar a usar esta API necesitas una clave que tendrás que incluir 
    en la cabecera <strong>X-ClaveApi</strong> de todas las llamadas que realices.
</p>
<p>
    Puedes crear una clave de API en el siguiente enlace:
    <a href="registro.php">Crear clave de API</a>
</p>

<h2>Cuentas de usuario y autorizaciones</h2>
<p>
    En la mayoría de operaciones de la API, necesitas incluir la cabecera <strong>X-Auth</strong>
    con la clave de autorización de una cuenta de usuario.
</p>
<p>
    Las cuentas de usuario constan de los siguientes campos:
</p>
<ul>
    <li><b>nombre</b>: Nombre completo del usuario</li>
    <li><b>email</b>: Dirección e-mail</li>
    <li><b>pwd</b>: Contraseña</li>
    <li><b>authkey</b>: Clave de autorización (valor autogenerado)</li>
</ul>
<p>
    Puedes crear cuentas de usuario con la operacion <a href="#cuentaPOST">POST cuenta.php</a>
    indicando el nombre, email y pwd. La operación devuelve el usuario completo, 
    incluyendo un nuevo authkey.
</p>
<p>
    Cuando un usuario quiera acceder a tu app, utiliza la operación <a href="#loginPOST">POST login.php</a>
    para obtener su clave de autorización a partir de su e-mail y contraseña.
</p>
<p>
    Si ya tienes el authkey de un usuario, puedes consultar sus datos con la operación <a href="#cuentaGET">GET cuenta.php</a>
    o modificarlos con <a href="#cuentaPUT">PUT cuenta.php</a>
</p>

<h2>Contactos</h2>
<p>
    Los contactos tienen los siguientes campos:
</p>
<ul>
    <li><b>idContacto</b></li>
    <li><b>nombre</b></li>
    <li><b>email</b></li>
    <li><b>telefono</b></li>
    <li><b>direccion</b></li>
    <li><b>notas</b></li>
</ul>
<p>
    Puedes consultar, añadir, modificar y borrar contactos con las siguientes operaciones: 
</p>
<ul>
    <li><a href="#contactosGET">GET contactos.php</a> Devuelve la lista de contactos</li>
    <li><a href="#contactosPOST">POST contactos.php</a> Añade un contacto</li>
    <li><a href="#contactoGET">GET contactos.php?id=123</a> Devuelve los datos del contacto 123</li>
    <li><a href="#contactoPUT">PUT contactos.php?id=123</a> Modifica los datos del contacto 123</li>
    <li><a href="#contactoDELETE">DELETE contactos.php?id=123</a> Borra el contacto 123</li>
</ul>
     
<h2>Errores</h2>
<p>
    Si hay algún error en la petición, se devuelve un código de error HTTP 4XX 
    y el texto del mensaje de error en el cuerpo de la petición (sin codificar en JSON)
</p>
<h3>Errores comunes</h3>
<table class="table">
    <thead>
        <tr>
            <th>Código</th>
            <th>Mensaje</th>
            <th>Causa</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>400</td>
            <td>Sin cabecera X-ClaveApi</td>
            <td>No se ha incluido la cabecera X-ClaveApi</td>
        </tr>
        <tr>
            <td>400</td>
            <td>Cabecera X-ClaveApi no válida</td>
            <td>El valor de la cabecera X-ClaveApi no es válido o no existe en la BD</td>
        </tr>
        <tr>
            <td>400</td>
            <td>Sin cabecera X-Auth</td>
            <td>No se ha incluido la cabecera X-Auth y la operación lo requiere</td>
        </tr>
        <tr>
            <td>400</td>
            <td>Cabecera X-Auth no válida</td>
            <td>El valor de la cabecera X-Auth no es válido o no existe en la BD</td>
        </tr>
    </tbody>
</table>


<h2>Operaciones de API</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>URL</th>
            <th>Método</th>
            <th>Requiere X-Auth</th>
            <th>Descripción</th>
            <th>Recibe</th>
            <th>Devuelve</th>
            <th>Errores</th>
        </tr>
    </thead>
    <tbody>
        <tr id="loginPOST">
            <td>login.php</td>
            <td>POST</td>
            <td>No</td>
            <td>Acceso de usuario</td>
            <td>
                <pre>
{
    "email": "user@example.com",
    "pwd": "123456"
}
                </pre>
            </td>
            <td>
                <pre>
{
    "auth": "4ef...76c"
}
                </pre>
            </td>
            <td>
                400 - Usuario o contraseña incorrectos
            </td>
        </tr>

        <tr id="cuentaPOST">
            <td>cuenta.php</td>
            <td>POST</td>
            <td>No</td>
            <td>Crear usuario</td>
            <td>
                <pre>
{
    "nombre": "Usuario",
    "email": "user@example.com",
    "pwd": "123456"
}
                </pre>
            </td>
            <td>
                <pre>
{
    "idUsuario": 1,
    "nombre": "Usuario",
    "email": "user@example.com",
    "pwd": "XXX CIFRADA XXX"
    "auth": "4ef...76c"
}
                </pre>
            </td>
            <td>
                409 - Ya existe un usuario con el mismo e-mail
            </td>
        </tr>

        <tr id="cuentaGET">
            <td>cuenta.php</td>
            <td>GET</td>
            <td>Sí</td>
            <td>Obtiene los datos del usuario correspondiente a la X-Auth</td>
            <td>
            </td>
            <td>
                <pre>
{
    "idUsuario": 1,
    "nombre": "Usuario",
    "email": "user@example.com",
    "pwd": "XXX CIFRADA XXX"
    "auth": "4ef...76c"
}
                </pre>
            </td>
            <td>
            </td>
        </tr>

        <tr id="cuentaPUT">
            <td>cuenta.php</td>
            <td>PUT</td>
            <td>Sí</td>
            <td>Modifica los datos del usuario correspondiente a la X-Auth. 
                Si no se indica pwd, se mantiene la que hay
            </td>
            <td>
                <pre>
{
    "nombre": "Usuario Modificado",
    "email": "user2@example.com",
    "pwd": "12345678"
}
                </pre>
            </td>
            <td>
                <pre>
{
    "idUsuario": 1,
    "nombre": "UsuarioModificado",
    "email": "user2@example.com",
    "pwd": "XXX CIFRADA XXX"
    "auth": "4ef...76c"
}
                </pre>
            </td>
            <td>
                409 - Ya existe un usuario con el mismo e-mail
            </td>
        </tr>

        <tr id="contactosGET">
            <td>contactos.php</td>
            <td>GET</td>
            <td>Sí</td>
            <td>Obtiene la lista de contactos del usuario</td>
            <td>
            </td>
            <td>
                <pre>
[
  {
    "idContacto": 123,
    "nombre": "Contacto 123",
    "email": "contacto123@example.com",
    "telefono": "12345678"
    "direccion": "C/ Mayor 5"
    "notas": "Amigo del trabajo"
  },
  {
    "idContacto": 234,
    "nombre": "Contacto 234",
    "email": "contacto234@example.com",
    "telefono": "666555444"
    "direccion": "Pza España 12"
    "notas": "Cumpleaños 12 de junio"
  },
  ...
]
                </pre>
            </td>
            <td>
            </td>
        </tr>

        <tr id="contactosPOST">
            <td>contactos.php</td>
            <td>POST</td>
            <td>Sí</td>
            <td>Crear contacto</td>
            <td>
                <pre>
{
    "nombre": "Contacto Nuevo",
    "email": "contactonuevo@example.com",
    "telefono": "654321987"
}
                </pre>
            </td>
            <td>
                <pre>
{
    "idContacto": 567,
    "nombre": "Contacto Nuevo",
    "email": "contactonuevo@example.com",
    "telefono": "654321987"
    "direccion": ""
    "notas": ""
}
                </pre>
            </td>
            <td>
            </td>
        </tr>

        <tr id="contactoGET">
            <td>contactos.php?id=123</td>
            <td>GET</td>
            <td>Sí</td>
            <td>Obtiene los datos del contacto con el id indicado</td>
            <td>
            </td>
            <td>
                <pre>
{
    "idContacto": 123,
    "nombre": "Contacto 123",
    "email": "contacto123@example.com",
    "telefono": "12345678"
    "direccion": "C/ Mayor 5"
    "notas": "Amigo del trabajo"
}
                </pre>
            </td>
            <td>
                404 - El contacto no existe o no pertenece al usuario
            </td>
        </tr>

        <tr id="contactoPUT">
            <td>contactos.php?id=123</td>
            <td>PUT</td>
            <td>Sí</td>
            <td>Modificar contacto</td>
            <td>
                <pre>
{
    "nombre": "Contacto 123 modificado",
    "email": "contacto123@example.com",
    "telefono": "654987321"
    "direccion": "",
    "notas": "Cuenta instagram: @contacto123"
}
                </pre>
            </td>
            <td>
                <pre>
{
    "idContacto": 123,
    "nombre": "Contacto 123 modificado",
    "email": "contacto123@example.com",
    "telefono": "654987321"
    "direccion": "",
    "notas": "Cuenta instagram: @contacto123"
}
                </pre>
            </td>
            <td>
                404 - El contacto no existe o no pertenece al usuario
            </td>
        </tr>

        <tr id="contactoDELETE">
            <td>contactos.php?id=123</td>
            <td>DELETE</td>
            <td>Sí</td>
            <td>Eliminar contacto</td>
            <td>
            </td>
            <td>
            </td>
            <td>
                404 - El contacto no existe o no pertenece al usuario
            </td>
        </tr>

    </tbody>
</table>

<?php include __DIR__.'/include/pie.php'; ?>