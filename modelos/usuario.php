<?php
require_once __DIR__.'/bd.php';

class Usuario {
    public $idUsuario;
    public $nombre;
    public $email;
    public $pwd;
    public $authkey;
    public $idApiKey;

    public function insertar() {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO usuarios
                (nombre,email,pwd,authkey,idApiKey) 
                VALUES (?,?,?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("ssssi", 
                $this->nombre, 
                $this->email, 
                $this->pwd, 
                $this->authkey, 
                $this->idApiKey);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->idUsuario = $bd->insert_id;
        
        $st->close();
        $bd->close();
    }

    public function actualizar() {
        $bd = abrirBD();
        $st = $bd->prepare("UPDATE usuarios SET
                nombre=?, email=?, pwd=? 
                WHERE idUsuario=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("sssi", 
                $this->nombre, 
                $this->email, 
                $this->pwd,
                $this->idUsuario);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        
        $st->close();
        $bd->close();
    }

    public static function cargaLogin($email, $idApiKey) {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM usuarios
                WHERE email=? and idApiKey=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("si", $email, $idApiKey);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $usuario = $res->fetch_object('Usuario');
        $res->free();
        $st->close();
        $bd->close();
        return $usuario;
    }

    public static function cargaAuth($auth, $idApiKey) {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM usuarios
                WHERE authkey=? and idApiKey=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("si", $auth, $idApiKey);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $usuario = $res->fetch_object('Usuario');
        $res->free();
        $st->close();
        $bd->close();
        return $usuario;
    }
}