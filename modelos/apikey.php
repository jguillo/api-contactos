<?php
require_once __DIR__.'/bd.php';

class ApiKey {
    public $idApiKey;
    public $nombre;
    public $clave;

    public function insertar() {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO apikey(nombre,clave) 
                VALUES (?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("ss", 
                $this->nombre, 
                $this->clave);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->idApiKey = $bd->insert_id;
        
        $st->close();
        $bd->close();
    }

    public static function carga($clave) {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM apikey
                WHERE clave=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("s", $clave);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $usuario = $res->fetch_object('ApiKey');
        $res->free();
        $st->close();
        $bd->close();
        return $usuario;
    }

}