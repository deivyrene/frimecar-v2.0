<?php

$conexion = new Conectar();
$link = $conexion->conectar();

Class Conectar

{
    public function __construct()
    {
        @define (SERVIDOR,"frimecar.com.ve");
        @define (USUARIO,"frimecar_frimeca");
        @define (CLAVE,"#net52**");
        @define (BASE_DE_DATOS,"frimecar_frimecar");
    }
    public function conectar()
    {
        $link=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BASE_DE_DATOS) or die("Error " . mysqli_error($link));
        
        return $link;
    }
}