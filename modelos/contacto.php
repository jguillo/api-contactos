<?php
require_once __DIR__.'/bd.php';

class Contacto {
    public $idContacto;
    public $idUsuario;
    public $nombre;
    public $email;
    public $telefono;
    public $direccion;
    public $foto;
    public $notas;

    public function insertar() {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO contactos
                (nombre,email,telefono,direccion,foto,notas,idUsuario) 
                VALUES (?,?,?,?,?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("ssssssi", 
                $this->nombre, 
                $this->email, 
                $this->telefono, 
                $this->direccion, 
                $this->foto, 
                $this->notas, 
                $this->idUsuario);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->idContacto = $bd->insert_id;
        
        $st->close();
        $bd->close();
    }

    public function actualizar() {
        $bd = abrirBD();
        $st = $bd->prepare("UPDATE contactos SET
                nombre=?, email=?, telefono=?, direccion=?, foto=?, notas=? 
                WHERE idContacto=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("ssssssi", 
                $this->nombre, 
                $this->email, 
                $this->telefono, 
                $this->direccion, 
                $this->foto, 
                $this->notas, 
                $this->idContacto);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        
        $st->close();
        $bd->close();
    }

    public function guardar() {
        if ($this->idContacto) {
            $this->actualizar();
        }
        else {
            $this->insertar();
        }
    }

    public static function carga($idContacto) {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM contactos
                WHERE idContacto=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("i", $idContacto);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $usuario = $res->fetch_object('Contacto');
        $res->free();
        $st->close();
        $bd->close();
        return $usuario;
    }

    public static function borrar($idContacto) {
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM contactos WHERE idContacto=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("i", $idContacto);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function listado($idUsuario) {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM contactos
                WHERE idUsuario=? ORDER BY nombre");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("i", $idUsuario);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $contactos = [];
        while ($contacto = $res->fetch_assoc()) {
            $contactos[] = $contacto;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $contactos;
    }
}