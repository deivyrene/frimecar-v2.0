<?php

$conexion = new Conectar();
$link = $conexion->conectar();

Class Conectar

{
    public function __construct()
    {
        @define (SERVIDOR,"remotemysql.com");
        @define (USUARIO,"tE8LjTvUPQ");
        @define (CLAVE,"EX1gJMCkR4");
        @define (BASE_DE_DATOS,"tE8LjTvUPQ");
    }
    public function conectar()
    {
        $link=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BASE_DE_DATOS) or die("Error " . mysqli_error($link));
        
        return $link;
    }
}