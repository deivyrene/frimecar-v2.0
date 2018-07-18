<?php
    session_start();
    require('helpers.php');
    require('conectar.php');

?>
<!DOCTYPE html>
<html lang="en">

<body>

    <?php $helpers->menu();?>
    
    <!-- Page Content -->
    <div class="container">
      <header class="jumbotron hero-spacer">
        <div class="row">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h3> Reportes </h3>
                </div>
            </div>
            <div class="col-md-12" align="center" >

            <div class="col-md-3"></div>

            <div class="col-md-6" >
                  <select class="form-control" id="registro_tipo" onchange="mostrar_tipos()" >
                    <option value="">--Panel--</option>
                    <option value="nomina_gen">Nómina General Activa</option>
                    <option value="nomina_quincenal_">Nómina Quincenal</option>
                    <option value="nomina_mensual_">Nómina Mensual</option>
                    <option value="arc">AR-C</option>
                    <option value="islr">Retención ISLR</option>
                    <option value="aporte_parafiscal">Aportes Parafiscal</option>
                    <option value="ret_islr_salario">Archivo XML ISLR Sueldos y Salarios</option>
                  </select>
            </div>

            <div class="col-md-3"></div>

            <br>
            <br><br>
            <br><br>
            </div>
          
        </div>

        
        <div id="nomina_quincenal_" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Nómina Quincenal </h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_grado" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-1 control-label">Tipo: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">
                              <select class="form-control" id="tipo"  >
                                <option value="">--Seleccione--</option>
                                <option value="ADMINISTRATIVO">Administrativo</option>
                                <option value="OBRERO">Obrero</option>
                                <option value="CONTRATADO">Contratado</option>
                                <option value="1-2-3">Páez-Efectivo</option>
                                <option value="4">Ayacucho-Cta.Nómina</option>
                                <option value="5">Fijos</option>
                              </select>
                            </div>
                            <label class="col-md-2 control-label">Quincena: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">
                              <select class="form-control" id="quincena_nomina" >
                                <option value="">--Seleccione--</option>
                                <option value="1RA ENERO">1RA ENERO</option>
                                <option value="2DA ENERO">2DA ENERO</option>
                                <option value="1RA FEBRERO">1RA FEBRERO</option>
                                <option value="2DA FEBRERO">2DA FEBRERO</option>
                                <option value="1RA MARZO">1RA MARZO</option>
                                <option value="2DA MARZO">2DA MARZO</option>
                                <option value="1RA ABRIL">1RA ABRIL</option>
                                <option value="2DA ABRIL">2DA ABRIL</option>
                                <option value="1RA MAYO">1RA MAYO</option>
                                <option value="2DA MAYO">2DA MAYO</option>
                                <option value="1RA JUNIO">1RA JUNIO</option>
                                <option value="2DA JUNIO">2DA JUNIO</option>
                                <option value="1RA JULIO">1RA JULIO</option>
                                <option value="2DA JULIO">2DA JULIO</option>
                                <option value="1RA AGOSTO">1RA AGOSTO</option>
                                <option value="2DA AGOSTO">2DA AGOSTO</option>
                                <option value="1RA SEPTIEMBRE">1RA SEPTIEMBRE</option>
                                <option value="2DA SEPTIEMBRE">2DA SEPTIEMBRE</option>
                                <option value="1RA OCTUBRE">1RA OCTUBRE</option>
                                <option value="2DA OCTUBRE">2DA OCTUBRE</option>
                                <option value="1RA NOVIEMBRE">1RA NOVIEMBRE</option>
                                <option value="2DA NOVIEMBRE">2DA NOVIEMBRE</option>
                                <option value="1RA DICIEMBRE">1RA DICIEMBRE</option>
                                <option value="2DA DICIEMBRE">2DA DICIEMBRE</option>
                              </select>
                            </div>

                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_quincena" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['id_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a href="#"  onclick="reportes('quincenal')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_grado" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>


        <div id="nomina_mensual_" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Nómina Mensual</h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_grado" class="form-horizontal" role="form">
                          <div class="form-group">
                            
                            <label class="col-md-3 control-label">Mes: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">

                              <select class="form-control" id="mes_mensual" >
                                <option value="">--Seleccione--</option>
                                <option value="1">ENERO</option>
                                
                                <option value="2">FEBRERO</option>
                          
                                <option value="3">MARZO</option>
                      
                                <option value="4">ABRIL</option>
                      
                                <option value="5">MAYO</option>
                    
                                <option value="6">JUNIO</option>
                      
                                <option value="7">JULIO</option>
                      
                                <option value="8">AGOSTO</option>
                        
                                <option value="9">SEPTIEMBRE</option>
                                
                                <option value="10">OCTUBRE</option>
                          
                                <option value="11">NOVIEMBRE</option>
                              
                                <option value="12">DICIEMBRE</option>
                              
                              </select>
                            </div>

                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_mensual" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['id_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a href="#"  onclick="reportes('mensual')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_grado" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>


        <!-- Formulario para CONSULTA AR-C -->
        <div id="arc" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Reporte AR-C </h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_grado" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-3 control-label">Cédula: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">
                              <input type="text" class="form-control"  required maxlength="9" placeholder="V12345675" autocomplete="off"   id="cedula_arc" >
                            </div>
                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_arc" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['ano_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a type="submit" onclick="reportes('arc')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_grado" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>

        <!-- Formulario para CONSULTA NOMINA GENERAL-->
        <div id="nomina_gen" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Nómina General</h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_grado" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label  class="col-md-5 control-label">Período: </label>
                            <div class="col-md-3" style="margin-top: 8px">
                              <select class="form-control" id="periodo_nomina" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['ano_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a href="#" onclick="reportes('nomina_general')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_grado" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>

        <!-- Formulario para consultar aporte parafiscal-->
        <div id="aporte_parafiscal" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
             <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Aporte Parafiscal</h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_parafiscal" class="form-horizontal" role="form">
                          <div class="form-group">
                            
                            <label class="col-md-3 control-label">Mes: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">

                              <select class="form-control" id="mes_parafiscal" >
                                <option value="">--Seleccione--</option>
                                <option value="1">ENERO</option>
                                
                                <option value="2">FEBRERO</option>
                          
                                <option value="3">MARZO</option>
                      
                                <option value="4">ABRIL</option>
                      
                                <option value="5">MAYO</option>
                    
                                <option value="6">JUNIO</option>
                      
                                <option value="7">JULIO</option>
                      
                                <option value="8">AGOSTO</option>
                        
                                <option value="9">SEPTIEMBRE</option>
                                
                                <option value="10">OCTUBRE</option>
                          
                                <option value="11">NOVIEMBRE</option>
                              
                                <option value="12">DICIEMBRE</option>
                              
                              </select>
                            </div>

                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_parafiscal" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['id_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a href="#"  onclick="reportes('aporte_parafiscal')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_parafiscal" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>

        <!-- Formulario para consultar archivo xml-->
        <div id="ret_islr_salario" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
             <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Descargar Archivo XML ISLR Sueldos y Salarios</h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_xml" class="form-horizontal" role="form">
                          <div class="form-group">
                            
                            <label class="col-md-3 control-label">Mes: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">

                              <select class="form-control" id="mes_xml" >
                                <option value="">--Seleccione--</option>
                                <option value="1">ENERO</option>
                                
                                <option value="2">FEBRERO</option>
                          
                                <option value="3">MARZO</option>
                      
                                <option value="4">ABRIL</option>
                      
                                <option value="5">MAYO</option>
                    
                                <option value="6">JUNIO</option>
                      
                                <option value="7">JULIO</option>
                      
                                <option value="8">AGOSTO</option>
                        
                                <option value="9">SEPTIEMBRE</option>
                                
                                <option value="10">OCTUBRE</option>
                          
                                <option value="11">NOVIEMBRE</option>
                              
                                <option value="12">DICIEMBRE</option>
                              
                              </select>
                            </div>

                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_xml" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['ano_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a href="#"  onclick="reportes('descargar_xml')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_xml" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>


        <!-- Formulario para CONSULTA RETENCION ISLR-->
        <div id="islr" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Retención ISLR </h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_grado" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-2 control-label">Cédula: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">
                              <input type="text" class="form-control" id="cedula_islr"  required maxlength="9" placeholder="V12345675" autocomplete="off" >
                            </div>

                            <label class="col-md-1 control-label">Mes: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">

                              <select class="form-control" id="mes_islr" >
                                <option value="">--Seleccione--</option>
                                <option value="1">ENERO</option>
                                
                                <option value="2">FEBRERO</option>
                          
                                <option value="3">MARZO</option>
                      
                                <option value="4">ABRIL</option>
                      
                                <option value="5">MAYO</option>
                    
                                <option value="6">JUNIO</option>
                      
                                <option value="7">JULIO</option>
                      
                                <option value="8">AGOSTO</option>
                        
                                <option value="9">SEPTIEMBRE</option>
                                
                                <option value="10">OCTUBRE</option>
                          
                                <option value="11">NOVIEMBRE</option>
                              
                                <option value="12">DICIEMBRE</option>
                              
                              </select>
                            </div>

                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_islr" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['ano_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a type="submit" onclick="reportes('islr')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_grado" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>

        <!-- Formulario para Registro Detallado Inventario-->
        <div id="inventario" class="ventana" style="background-color: #FFFFFF; border-radius: 2px 2px 2px 2px">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> Registro Detallado Inventario </h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_grado" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-2 control-label">Descripción: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">
                              <select class="form-control" id="descripcion_inv" >
                                <option value="">--Seleccione--</option>
                                <option value="CUEROS">CUEROS</option>
                                
                                <option value="MATANZA">MATANZA</option>
                          
                                <option value="MONDONGO">MONDONGO</option>

                                <option value="CHINCHURRIA">CHINCHURRIA</option>

                                <option value="CARNE-CUERO">CARNE CUERO</option>
                              
                              </select>
                            </div>

                            <label class="col-md-1 control-label">Mes: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">

                              <select class="form-control" id="mes_inv" >
                                <option value="">--Seleccione--</option>
                                <option value="1-ENERO">ENERO</option>
                                
                                <option value="2-FEBRERO">FEBRERO</option>
                          
                                <option value="3-MARZO">MARZO</option>
                      
                                <option value="4-ABRIL">ABRIL</option>
                      
                                <option value="5-MAYO">MAYO</option>
                    
                                <option value="6-JUNIO">JUNIO</option>
                      
                                <option value="7-JULIO">JULIO</option>
                      
                                <option value="8-AGOSTO">AGOSTO</option>
                        
                                <option value="9-SEPTIEMBRE">SEPTIEMBRE</option>
                                
                                <option value="10-OCTUBRE">OCTUBRE</option>
                          
                                <option value="11-NOVIEMBRE">NOVIEMBRE</option>
                              
                                <option value="12-DICIEMBRE">DICIEMBRE</option>
                              
                              </select>
                            </div>

                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_inv" >
                                <option value="">--Seleccione--</option>
                                <?php 

                                    $re = mysqli_query($link, "select * from tbl_periodo");

                                    while($fil = mysqli_fetch_array($re))
                                    {

                                      $periodo = $fil['id_periodo']."-".$fil['ano_periodo'];
                                ?>
                                      <option value="<?= $periodo; ?>"><?= $fil['ano_periodo'];?></option>
                                <?php
                                    }
                                ?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a type="submit" onclick="reportes('inventario')" class="btn btn-md btn-primary">Generar</a>
                            </div>
                          </div>
                        </form>
                </div>
            </div>
        </div>
        </header>
        <hr>

        <?php $helpers->footer();?>

    </div>



    
</body>

</html>
