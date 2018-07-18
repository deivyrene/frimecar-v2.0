<?php

$conexion = new Conectar();
$link = $conexion->conectar();

Class Conectar

{
    public function __construct()
    {
        @define (SERVIDOR,"mysql.hostinger.co");
        @define (USUARIO,"u790903361_frime");
        @define (CLAVE,"123456");
        @define (BASE_DE_DATOS,"u790903361_frime");
    }
    public function conectar()
    {
        $link=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BASE_DE_DATOS) or die("Error " . mysqli_error($link));
        
        return $link;
    }
}