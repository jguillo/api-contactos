# API REST de contactos 

Este proyecto implementa una API REST para gestionar listas de contactos en nombre de distintos usuarios.

Se trata de un proyecto educativo para dar apoyo a clases sobre desarrollo de clientes de APIs REST.

# Estructura del proyecto

El proyecto consta de:
- bd/api_contactos.sql: script de creación de la base de datos MySQL
- include: Archivos de cabecera/pie para las páginas visibles
- lib: Funciones de uso general
- modelos: Clases de modelo y acceso a datos
    - En bd.php se deben configurar los datos de conexión a la BD
- Páginas de UI:
    - index.php: Página principal de introducción y documentación
    - registro.php: Página de formulario para crear una clave de API
    - registroSubmit.php: Página de procesado del formulario
- Endpoints de API:
    - login.php: Recibe un usuario y contraseña y devuelve una clave de autorización para usar las operaciones de API
    - cuenta.php: Permite consultar, crear y modificar cuentas de usuario
    - contactos.php: Permite consultar, crear, modificar y borrar contactos de un usuario

# Uso de la API

## Clave de API
Para empezar a usar esta API necesitas una clave que tendrás que incluir en la cabecera `X-ClaveApi` de todas las llamadas que realices.

Los desarrolladores que quieran usar la API pueden crear una clave de API en el [formulario de registro de clave API](registro.php)

**ATENCIÓN**: La página de registro de claves API no tiene ningún mecanismo de seguridad y cualquiera puede crear una clave de API. Si publicas esta API es recomendable vigilar que las claves creadas pertenecen a los usuarios previstos y borrar los datos periódicamente. 

## Cuentas de usuario y autorizaciones

En la mayoría de operaciones de la API, se necesita incluir la cabecera `X-Auth` con la clave de autorización de una cuenta de usuario.

Las cuentas de usuario constan de los siguientes campos:
- *nombre*: Nombre completo del usuario
- *email*: Dirección e-mail
- *pwd*: Contraseña
- *authkey*: Clave de autorización (valor autogenerado)

Las cuentas de usuario se crean con la operacion `POST cuenta.php` indicando el nombre, email y pwd. La operación devuelve el usuario completo, incluyendo un nuevo authkey.

Cuando un usuario quiera acceder a tu app, utiliza la operación `POST login.php` para obtener su clave de autorización a partir de su e-mail y contraseña.

Si ya tienes el authkey de un usuario, puedes consultar sus datos con la operación `GET cuenta.php` o modificarlos con `PUT cuenta.php`

## Contactos

Los contactos tienen los siguientes campos:
- idContacto
- nombre
- email
- telefono
- direccion
- notas

Puedes consultar, añadir, modificar y borrar contactos con las siguientes operaciones: 
- `GET contactos.php` Devuelve la lista de contactos
- `POST contactos.php` Añade un contacto
- `GET contactos.php?id=123` Devuelve los datos del contacto 123
- `PUT contactos.php?id=123` Modifica los datos del contacto 123
- `DELETE contactos.php?id=123` Borra el contacto 123
     
## Errores

Si hay algún error en la petición, se devuelve un código de error HTTP 4XX y el texto del mensaje de error en el cuerpo de la petición (sin codificar en JSON)

### Errores comunes

**400- Sin cabecera X-ClaveApi**

No se ha incluido la cabecera X-ClaveApi

**400 - Cabecera X-ClaveApi no válida**

El valor de la cabecera X-ClaveApi no es válido o no existe en la BD

**400 - Sin cabecera X-Auth**

No se ha incluido la cabecera X-Auth y la operación lo requiere

**400 - Cabecera X-Auth no válida**

El valor de la cabecera X-Auth no es válido o no existe en la BD


## Operaciones de API

La [página index.php](index.php) muestra la documentación completa para los usuarios que vayan a utilizar la API.

### POST login.php

Acceso de usuario. No requiere cabecera X-Auth.

**Petición**
```
{
    "email": "user@example.com",
    "pwd": "123456"
}
```

**Respuesta**
```
{
    "auth": "4ef...76c"
}
```

**Errores**

- 400 - Usuario o contraseña incorrectos

### POST cuenta.php

Crear usuario. No requiere cabecera X-Auth.

**Petición**
```
{
    "nombre": "Usuario",
    "email": "user@example.com",
    "pwd": "123456"
}
```

**Respuesta**
```
{
    "idUsuario": 1,
    "nombre": "Usuario",
    "email": "user@example.com",
    "pwd": "XXX CIFRADA XXX"
    "auth": "4ef...76c"
}
 ```

**Errores**

- 409 - Ya existe un usuario con el mismo e-mail

### GET cuenta.php

Obtiene los datos del usuario correspondiente a la X-Auth

**Respuesta**
```
{
    "idUsuario": 1,
    "nombre": "Usuario",
    "email": "user@example.com",
    "pwd": "XXX CIFRADA XXX"
    "auth": "4ef...76c"
}
```

### PUT cuenta.php

Modifica los datos del usuario correspondiente a la X-Auth. 

Si no se indica pwd, se mantiene la que hay

**Petición**
```
{
    "nombre": "Usuario Modificado",
    "email": "user2@example.com",
    "pwd": "12345678"
}
```

**Respuesta**
```
{
    "idUsuario": 1,
    "nombre": "UsuarioModificado",
    "email": "user2@example.com",
    "pwd": "XXX CIFRADA XXX"
    "auth": "4ef...76c"
}
```

**Errores**

- 409 - Ya existe un usuario con el mismo e-mail

### GET contactos.php

Obtiene la lista de contactos del usuario.

**Respuesta**
```
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
```

### POST contactos.php

Crear contacto

**Petición**
```
{
    "nombre": "Contacto Nuevo",
    "email": "contactonuevo@example.com",
    "telefono": "654321987"
}
```

**Respuesta**
```
{
    "idContacto": 567,
    "nombre": "Contacto Nuevo",
    "email": "contactonuevo@example.com",
    "telefono": "654321987"
    "direccion": ""
    "notas": ""
}
```

### GET contactos.php?id=123

Obtiene los datos del contacto con el id indicado

**Respuesta**
```
{
    "idContacto": 123,
    "nombre": "Contacto 123",
    "email": "contacto123@example.com",
    "telefono": "12345678"
    "direccion": "C/ Mayor 5"
    "notas": "Amigo del trabajo"
}
```

**Errores**

- 404 - El contacto no existe o no pertenece al usuario

## PUT contactos.php?id=123

Modificar contacto

**Petición**
```
{
    "nombre": "Contacto 123 modificado",
    "email": "contacto123@example.com",
    "telefono": "654987321"
    "direccion": "",
    "notas": "Cuenta instagram: @contacto123"
}
```

**Respuesta**
```
{
    "idContacto": 123,
    "nombre": "Contacto 123 modificado",
    "email": "contacto123@example.com",
    "telefono": "654987321"
    "direccion": "",
    "notas": "Cuenta instagram: @contacto123"
}
```

**Errores**

- 404 - El contacto no existe o no pertenece al usuario

### DELETE contactos.php?id=123

Eliminar contacto

**Errores**

- 404 - El contacto no existe o no pertenece al usuario


