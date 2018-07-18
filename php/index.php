<?php
    session_start();
    require('helpers.php');
    require('conectar.php');

    $sql = "select * from tbl_empresa";
    $re = mysqli_query($link, $sql);

    $fila = mysqli_fetch_array($re);

?>
<!DOCTYPE html>
<html>

<body>

    <?php $helpers->menu();?>
    
        <!-- Page Content -->
        <div class="container">
    

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
        <div class="row">
            <div class="col-md-12" align="center">
                 <h2><?= $fila['nombre_empresa']?></h2>
                 <h3><?= $fila['rif_empresa']?></h3>
            </div>
        </div>
        </header>

        

        
        <?php $helpers->footer();?>

    </div>



    
</body>

</html>
