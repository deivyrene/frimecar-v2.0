<?php

$conexion = new Conectar();
$link = $conexion->conectar();

Class Conectar

{
    public function __construct()
    {
        @define (SERVIDOR,"remotemysql.com");
        @define (USUARIO,"N3m1WsLwPN");
        @define (CLAVE,"Ib7yiFcqWL");
        @define (BASE_DE_DATOS,"N3m1WsLwPN");
    }
    public function conectar()
    {
        $enlace = mysqli_connect("remotemysql.com:3306", "N3m1WsLwPN", "Ib7yiFcqWL", "N3m1WsLwPN") or die("Error No" . mysqli_error($link));
        //$link=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BASE_DE_DATOS) or die("Error " . mysqli_error($link));
        
        return $enlace;
    }
}