<?php
include ("conect.php");
extract($_POST);
if (isset($submit)) {
    echo "hola";

}

 ?>
<!DOCTYPE html>
<html lang="en">
    <?php include('head.php'); ?>
    <body>
        <?php include('script.php'); ?>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <?php include("navbarHeader.php"); include("sidebar.php"); ?>
            </nav>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <section class="container">
                        <div class="container-page">

                            <?php
                            extract($_GET);
                            $sql = @mysqli_query($link,"SELECT * FROM materias WHERE id_materia = '$id'");
                            $data = mysqli_fetch_array($sql);
                            $uni = @mysqli_query($link,"SELECT * FROM unidadescompetencia WHERE id_materia = '$id'");
                            $data1 = mysqli_fetch_array($uni);
                            $sql_ref_mat = mysqli_query($link, "SELECT * FROM referenciasxmateria WHERE id_materia = '$id' AND tipo_referencia = 'BASICA'");
                            $data2 = mysqli_fetch_array($sql_ref_mat);
                            $sql_ref = mysqli_query($link, "SELECT * FROM referencias WHERE id_referencia = '$data2[id_referencia]' ");
                            $data_ref = mysqli_fetch_array($sql_ref);

                            $sql_clases = mysqli_query($link, "SELECT id_materia FROM unidadescompetencia WHERE id_materia = '$id' ");
                            $clases = mysqli_num_rows($sql_clases);

                            $unidad = mysqli_query($link, "SELECT * FROM unidadescompetencia WHERE id_materia = '$id' ");
                            $sql_c = mysqli_query($link, "SELECT * FROM carreras WHERE id_carrera = '$data[id_carrera]' ");
                            $carr = mysqli_fetch_object($sql_c);
                            ?>


                            <form action="edit_save_pdf2.php?id= <?php echo $id; ?> &c= <?php echo $clases; ?> " method="POST" accept-charset="utf-8">

                                <div class="col-lg-10 col-md-8 col-sm-8 col-xs-12" id="firstStep">

                                    <h3 class="dark-grey">I. DATOS GENERALES:</h3>
                                      <div class="form-group col-lg-12 col-md-8">
                                        <label>Nombre Plan Estudios: </label>
                                        <select name="carrera" id="carrera" class="selectpicker" data-live-search="true">
                                           <option value="<?php echo $carr->id_carrera; ?>"><?php echo $carr->carrera; ?></option>
                                            <?php
                                            $tot_carr = mysqli_query($link, "SELECT * FROM carreras WHERE id_carrera NOT IN ($carr->id_carrera)");
                                            if ($tot_carr) {
                                                while ($id_c = mysqli_fetch_row($tot_carr)) {
                                                    echo "<option value='$id_c[0]'>$id_c[1]</option>";
                                                }
                                            }
                                             ?>
                                        </select>
                                    </div>




                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12">
                                        <label>Semestre / Cuatrimestre: </label>
                                        <input type="number" class="form-control" name="semestre" id="semestre" value="<?php echo $data['semestre'];?>">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12">
                                        <label>Nombre Unidad Aprendizaje: </label>
                                        <input type="text" name="unidad" class="form-control" id="unidad" value="<?php echo $data['nombreUnidad'];?>" >
                                    </div>


                                    <!-- <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12" required>
                                        <label>Núm. Clases: </label>
                                        <input type="number" name="num_clases" class="form-control" id="num_clases" placeholder="">
                                    </div> -->

                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12" required>
                                        <label>Ciclo: </label>
                                        <select name="ciclo" class="form-control">
                                            <option value="1">2017 - 2018</option>
                                            <option value="2">2018 - 2018</option>
                                            <option value="3">2018 - 2019</option>
                                            <option value="4">2019 - 2019</option>
                                            <option value="5">2019 - 2020</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12">
                                        <label>Fecha: </label>
                                        <input type="date" name="fecha" class="form-control" id="fecha" value="<?php echo $data['fecha'] ?>" ><br><br>
                                    </div>

                                        <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <input type="radio" id="in-category-20" name="category" value="LISTO"> <b>LISTO</b>
                                        <br><br>
                                        <button type="button" class="btn btn-info btn-lg" id="submit" onclick="$('#firstStep').hide(); $('#secondStep').show()" disabled>SEGUIR</button>
                                        <!-- <script>
                                        $("input[type='text'], input[type='number'], input[type='date']").on("keyup", function(){
                                        if($(this).val() != "" && $("input[type='date']").val() != "" && $("input[name='category']").is(":checked") == true){
                                        $("button[id='submit']").removeAttr("disabled");
                                        }
                                        });
                                        $("input[name='category']").on("change", function(){
                                        if($(this).val() != "" && $("input[type='text']").val() != "" && $("input[name='category']").is(":checked") == true){
                                        $("button[id='submit']").removeAttr("disabled");
                                        }
                                        });
                                        </script> -->

                                </div>
                                </div>

                                <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="secondStep" style="display:;">
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <h3 class="dark-grey">II. PROPÓSITO:</h3>
                                        <textarea class="form-control" name="proposito" placeholder="Escribe el propósito..." rows="5" cols="25" ><?php echo $data['proposito'];?></textarea><br><br>
                                        <input type="radio" id="in-category-20" name="category2" value="LISTO"> <b>LISTO</b>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#secondStep').hide(); $('#firstStep').show()" >ATRAS</button>
                                        <button type="button" id="submit2" class="btn btn-info btn-lg" onclick="$('#secondStep').hide(); $('#thirdStep').show()" disabled>SEGUIR</button>
                                        <!-- <script>
                                        $("textarea").on("keyup", function(){
                                        if($(this).val() != "" && $("textarea").val() != "" && $("input[name='category2']").is(":checked") == true){
                                        $("button[id='submit2']").removeAttr("disabled");
                                        }
                                        });
                                        $("input[name='category2']").on("change", function(){
                                        if($(this).val() != "" && $("textarea").val() != "" && $("input[name='category2']").is(":checked") == true){
                                        $("button[id='submit2']").removeAttr("disabled");
                                        }
                                        });
                                        </script> -->
                                    </div>
                                </div>


                                <!-- <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="temario" style="display:;">
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <h3 class="dark-grey">PEGA TU TEMARIO:</h3>
                                        <textarea class="form-control" name="temario" placeholder="<?php echo $data['temario'];?>" rows="20" cols="25" ></textarea><br><br>
                                        <input type="radio" id="in-category-20" name="category2_1" value="LISTO"> <b>LISTO</b>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#temario').hide(); $('#firstStep').show()" >ATRAS</button>
                                        <button type="button" id="submit2_1" class="btn btn-info btn-lg" onclick="$('#temario').hide(); $('#thirdStep').show()" disabled>SEGUIR</button>
                                        <script>
                                        $("textarea").on("keyup", function(){
                                        if($(this).val() != "" && $("textarea").val() != "" && $("input[name='category2_1']").is(":checked") == true){
                                        $("button[id='submit2_1']").removeAttr("disabled");
                                        }
                                        });
                                        $("input[name='category2_1']").on("change", function(){
                                        if($(this).val() != "" && $("textarea").val() != "" && $("input[name='category2_1']").is(":checked") == true){
                                        $("button[id='submit2_1']").removeAttr("disabled");
                                        }
                                        });
                                        </script>
                                    </div>
                                </div> -->




                                <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="thirdStep" style="display:;">
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <h3 class="dark-grey">III. COMPETENCIAS GENÉRICAS Y ESPECÍFICAS DE LA UNIDAD APRENDIZAJE:</h3>
                                        <textarea class="form-control" name="genericas" placeholder="GENÉRICAS" rows="5" cols="25" ><?php echo $data['competenciasGen'];?></textarea>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <textarea class="form-control" name="especificas" placeholder="ESPECÍFICAS" rows="5" cols="25" ><?php echo $data['competenciasEsp'];?></textarea><br><br>
                                        <input type="radio" id="in-category-20" name="category3" value="LISTO"> <b>LISTO</b>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#thirdStep').hide(); $('#secondStep').show()" >ATRAS</button>
                                        <button type="button" class="btn btn-info btn-lg" id="submit3" onclick="$('#thirdStep').hide(); $('#fourthStep').show()" disabled>SEGUIR</button>
                                        <script>
                                        $("textarea").on("keyup", function(){
                                        if($(this).val() != "" && $("textarea").val() != "" && $("input[name='category3']").is(":checked") == true){
                                        $("button[id='submit3']").removeAttr("disabled");
                                        }
                                        });
                                        $("input[name='category3']").on("change", function(){
                                        if($(this).val() != "" && $("textarea").val() != "" && $("input[name='category3']").is(":checked") == true){
                                        $("button[id='submit3']").removeAttr("disabled");
                                        }
                                        });
                                        </script>
                                    </div>
                                </div>

                                <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="fourthStep" style="display:;">
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <h3 class="dark-grey">IV. FECHAS DE EVALUACIONES SUMATIVAS:</h3>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12">
                                        <label>1ER Reporte:</label><input type="date" name="primer_rep" class="form-control" id="1reporte"  value="<?php echo $data['primeraEvaluacion'];?>">
                                        <br>
                                        <label>2DO Reporte:</label><input type="date" name="seg_rep" class="form-control" id="2reporte"  value="<?php echo $data['segundaEvaluacion'];?>" >
                                        <br>
                                        <label>3ER Reporte (FINAL):</label><input type="date" name="tercer_rep" class="form-control" id="3reporte" value="<?php echo $data['terceraEvaluacion'];?>"><br><br>

                                        <input type="radio" id="in-category-20" name="category4" value="LISTO"> <b>LISTO</b>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#fourthStep').hide(); $('#thirdStep').show()" >ATRAS</button>
                                        <button type="button" class="btn btn-info btn-lg" id="submit4" onclick="$('#fourthStep').hide(); $('#fifthStep').show()" disabled>SEGUIR</button>
                                        <!-- <script>
                                        $("input[type='date']").on("keyup", function(){
                                        if($(this).val() != "" && $("input[type='date']").val() != "" && $("input[name='category4']").is(":checked") == true){
                                        $("button[id='submit4']").removeAttr("disabled");
                                        }
                                        });
                                        $("input[name='category4']").on("change", function(){
                                        if($(this).val() != "" && $("input[type='date']").val() != "" && $("input[name='category4']").is(":checked") == true){
                                        $("button[id='submit4']").removeAttr("disabled");
                                        }
                                        });
                                        </script> -->
                                    </div>
                               </div>

                                <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="fifthStep" style="display:;">
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <h3 class="dark-grey">V. HORAS Y CALENDARIO DE SESIONES:</h3>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <label>Horas Totales de UNIDAD DE APRENDIZAJE:</label>
                                        <input type="number" value="<?php echo $data['horasUnidad'];?>" name="totalhoras" class="form-control" id="totalhoras">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <label>Horas Totales CON DOCENTE:</label>
                                        <input type="number" value="<?php echo $data['horasTeoDoc'];?>" name="docenteteoricas" class="form-control" id="totalhoras" value="" >
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <input type="number" value="<?php echo $data['horasPracDoc'];?>" name="docentepracticas" class="form-control" id="totalhoras" value="" >
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <label>Horas Totales INDEPENDIENTES:</label>
                                        <input type="number" value="<?php echo $data['horasTeoInd'];?>" name="indep_teo" class="form-control" id="indep_teo" value="" >
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <input type="number" value="<?php echo $data['horasPracInd'];?>" name="indep_pract" class="form-control" id="indep_pract" value="" ><br><br>
                                        <!-- <input type="radio" id="in-category-20" name="category5" value="LISTO"> <b>LISTO</b> -->
                                    </div>

                                         <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <input type="radio" id="in-category-20" name="category5" value="LISTO"> <b>LISTO</b>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#fifthStep').hide(); $('#fourthStep').show()" >ATRAS</button>
                                        <button type="button" class="btn btn-info btn-lg" id="submit5" onclick="$('#fifthStep').hide(); $('#sixthStep').show()" disabled>SEGUIR</button>
                                    <!-- <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#fifthStep').hide(); $('#fourthStep').show()" >ATRAS</button>
                                        <button type="button" class="btn btn-info btn-lg" id="submit5" onclick="$('#fifthStep').hide(); $('#sixthStep').show()" disabled>SEGUIR</button>
                                        <script>
                                        $("input[type='number']").on("keyup", function(){
                                        if($(this).val() != "" && $("input[type='number']").val() != "" && $("input[name='category5']").is(":checked") == true){
                                        $("button[id='submit5']").removeAttr("disabled");
                                        }
                                        });
                                        $("input[name='category5']").on("change", function(){
                                        if($(this).val() != "" && $("input[type='number']").val() != "" && $("input[name='category5']").is(":checked") == true){
                                        $("button[id='submit5']").removeAttr("disabled");
                                        }
                                        });
                                        </script>
                                    </div> -->
                                </div>
                                </div>

                                <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="sixthStep" style="display:;">
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12">
                                        <h3 class="dark-grey">VI. IDENTIFICACIÓN DEL GRUPO:</h3>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12">
                                        <label>Grupo:</label>
                                        <input type="text" value="<?php echo $data['grupo'];?>" name="grupo" class="form-control" id="grupo">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12">
                                        <label>Salón:</label>
                                        <input type="text" value="<?php echo $data['salon'];?>" name="salon" class="form-control" id="salon"  ><br><br>
                                        <!-- <input type="radio" id="in-category-20" name="category6" value="LISTO"> <b>LISTO</b> -->
                                    </div>
                                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-xs-12">
                                        <label>No. Alumnos:</label>
                                        <input type="number" value="<?php echo $data['numAlumnos'];?>" name="total_alumnos" class="form-control" id="total_alumnos" >
                                    </div>

                                        <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#sixthStep').hide(); $('#fifthStep').show()" >ATRAS</button>
                                        <button type="button" class="btn btn-info btn-lg" id="submit6" onclick="$('#sixthStep').hide(); $('#sevenStep').show()">SEGUIR</button>
                                        <!-- <script>
                                        $("input[type='text'], input[type='number']").on("keyup", function(){
                                        if($(this).val() != "" && $("input[type='number']").val() != "" && $("input[name='category6']").is(":checked") == true){
                                        $("button[id='submit6']").removeAttr("disabled");
                                        }
                                        });
                                        $("input[name='category6']").on("change", function(){
                                        if($(this).val() != "" && $("input[type='number']").val() != "" && $("input[name='category6']").is(":checked") == true){
                                        $("button[id='submit6']").removeAttr("disabled");
                                        }
                                        });
                                        </script> -->
                                    </div>

                                </div>


                                <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="sevenStep" style="display:;">
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12" >
                                        <h3 class="dark-grey">VII.UNIDADES DE COMPETENCIA:</h3>
                                        <div style="overflow-y: scroll; height:600px; width: 100%">
                                            <table id="unidades" class="table table-hover table-responsive table-bordered table-condensed">
                                                <tr class="info">
                                                    <th>Fecha</th>
                                                    <th>Tema</th>
                                                    <th>Aprendizajes esperados</th>
                                                    <th>Estrategias de aprendizaje</th>
                                                    <th>Recursos didácticos</th>
                                                    <th>Evidencias de aprendizaje</th>
                                                    <th>Tipos de evaluación</th>
                                                    <th>Instrumentos de evaluación</th>
                                                    <th>Criterios de evaluación y ponderación</th>
                                                </tr>
                                                <?php
                                                  $i = 0;
                                                  while ($row = mysqli_fetch_row($unidad)) {

                                                    ?>
                                                    <tr>
                                                        <td><input type="hidden" name="id_unidad<?php echo $i; ?>" value=" <?php echo $row[0]; ?> " >
                                                            <input type="date" class="form-control" name="fechaUnidades<?php echo $i; ?>"  value=" <?php echo $row[2]; ?> "></td>
                                                        <td><textarea id="2" name="temaUnidades<?php echo $i; ?>"><?php echo $row[3]; ?></textarea></td>
                                                        <td><textarea id="3" name="ap_esp<?php echo $i; ?>"><?php echo $row[4]; ?></textarea></td>
                                                        <td>
                                                            INICIO: <select class="selectpicker" data-live-search="true" name="inicio<?php echo $i; ?>[]">
                                                                <optgroup label="INICIO">
                                                                    <option value="Activacion de conocimientos previos">Activación de conocimientos previos</option>
                                                                    <option value="Anecdota">Anécdota</option>
                                                                    <option value="Liga con el tema anterior y/o posterior">Liga con el tema anterior y/o posterior</option>
                                                                    <option value="Presentacion del Tema">Presentación del Tema</option>
                                                                </optgroup>
                                                            </select>
                                                            DESARROLLO: <select class="selectpicker" data-live-search="true" name="est_ap<?php echo $i; ?>[]">
                                                                <optgroup label="TABLAS ACADÉMICAS">
                                                                    <option value="Matriz de inducción">1 Matriz de inducción</option>
                                                                    <option value="PNI (Positivo, Negativo, Interesante)">1 PNI (Positivo, Negativo, Interesante)</option>
                                                                    <option value=">QQQ (veo, no veo, infiero)">1 QQQ (veo, no veo, infiero)</option>
                                                                    <option value="RA-P-RP (resp-preg-resp)">1 RA-P-RP (resp-preg-resp)</option>
                                                                    <option value="SQA (Qué se, quiero saber, Aprendí)">1 SQA (Qué sé, quiero saber, Aprendí)</option>
                                                                </optgroup>
                                                                <optgroup label="TEXTOS ACADÉMICOS">
                                                                    <option value="Resumen">2 Resumen</option>
                                                                    <option value="Síntesis">2 Síntesis</option>
                                                                    <option value="Paráfrasis">2 Paráfrasis</option>
                                                                    <option value="Reporte">2 Reporte</option>
                                                                    <option value="Ensayo">2 Ensayo</option>
                                                                </optgroup>
                                                                <optgroup label="FORMATO ELECTRÓNICO">
                                                                    <option value="Hipertexto">Hipertexto</option>
                                                                    <option value="eBook">eBook</option>
                                                                </optgroup>
                                                                <optgroup label="DOCUMENTALES">
                                                                    <option value="Antología">Antología</option>
                                                                    <option value="Carteles">Carteles</option>
                                                                    <option value="Diario">Diario</option>
                                                                    <option value="Registros anecdoticos">Registros anecdóticos</option>
                                                                    <option value="Trpticos">Trípticos</option>
                                                                    <option value="Instructivos">Instructivos</option>
                                                                    <option value="Recetas">Recetas</option>
                                                                </optgroup>
                                                                <optgroup label="ORGANIZADORES GRÁFICOS">
                                                                    <option value="Mapa Cognitivo">Mapa Cognitivo</option>
                                                                    <option value="Mapa conceptual">Mapa conceptual</option>
                                                                    <option value="Mapa mental">Mapa mental</option>
                                                                    <option value="Red Semántica">Red Semántica</option>
                                                                    <option value="Línea de tiempo">Línea de tiempo</option>
                                                                    <option value="Espina de pescado">Espina de pescado</option>
                                                                    <option value="Cuadros sinópticos">Cuadros sinópticos</option>
                                                                    <option value="Diagrama de Flujo">Diagrama de Flujo</option>
                                                                </optgroup>
                                                                <optgroup label="DINÁMICAS GRUPALES">
                                                                    <option value="Phillips 666">Phillips 666</option>
                                                                    <option value="Rejillas">Rejillas</option>
                                                                    <option value="Foro">Foro</option>
                                                                    <option value="Mesa redonda">Mesa redonda</option>
                                                                    <option value="Lluvia de ideas">Lluvia de ideas</option>
                                                                    <option value="Rally">Rally</option>
                                                                </optgroup>
                                                                <optgroup label="DRAMATIZACIONES">
                                                                    <option value="Sociodrama">Sociodrama</option>
                                                                    <option value="Debate">Debate</option>
                                                                    <option value="Simulación">Simulación</option>
                                                                    <option value="Congreso">Congreso</option>
                                                                    <option value="Museo">Museo</option>
                                                                    <option value="Construcción de una historia">Construcción de una historia</option>
                                                                    <option value="Guión">Guión</option>
                                                                    <option value="Carta">Carta</option>
                                                                    <option value="Sketch">Sketch</option>
                                                                </optgroup>
                                                                <optgroup label="PERIODÍSTICAS">
                                                                    <option value="Periódico Mural">Periódico Mural</option>
                                                                    <option value="Diario">Diario</option>
                                                                    <option value="Crónica">Crónica</option>
                                                                    <option value="Reportaje">Reportaje</option>
                                                                    <option value="Entrevista">Entrevista</option>
                                                                    <option value="Historieta">Historieta</option>
                                                                    <option value="Cómic">Cómic</option>
                                                                </optgroup>
                                                                <optgroup label="MULTIMEDIA">
                                                                    <option value="Películas">Películas</option>
                                                                    <option value="Reportajes">Reportajes</option>
                                                                    <option value="Audios">Audios</option>
                                                                    <option value="Documentales">Documentales</option>
                                                                    <option value="Programas de radio">Programas de radio</option>
                                                                    <option value="Revista electrónica">Revista electrónica</option>
                                                                    <option value="Cartel electrónico">Cartel electrónico</option>
                                                                </optgroup>
                                                                <optgroup label="HABILIDADES">
                                                                    <option value="Solución de problemas">Solución de problemas</option>
                                                                    <option value="Juego de negocios">Juego de negocios</option>
                                                                    <option value="Toma de decisiones">Toma de decisiones</option>
                                                                    <option value="Basado en proyectos">Basado en proyectos</option>
                                                                    <option value="Laboratorio">Laboratorio</option>
                                                                </optgroup>
                                                                <optgroup label="DESTREZAS">
                                                                    <option value="Rompecabezas">Rompecabezas</option>
                                                                    <option value="Armado">Armado</option>
                                                                    <option value="Ensamblado">Ensamblado</option>
                                                                    <option value="Secuencias rítmicas">Secuencias rítmicas</option>
                                                                </optgroup>
                                                                <optgroup label="ORALES">
                                                                    <option value="Cátedra">Cátedra</option>
                                                                    <option value="Diálogo">Diálogo</option>
                                                                    <option value="Exposición">Exposición</option>
                                                                    <option value="Narración">Narración</option>
                                                                </optgroup>
                                                                <optgroup label="LECTURA">
                                                                    <option value="Individual">Individual</option>
                                                                    <option value="Rolada">Rolada</option>
                                                                    <option value="Comentada">Comentada</option>
                                                                    <option value="Fraccionada">Fraccionada</option>
                                                                    <option value="Modificada">Modificada</option>
                                                                    <option value="Coral">Coral</option>
                                                                </optgroup>
                                                                <optgroup label="JUEGO DE LETRAS">
                                                                    <option value="Acróstico">Acróstico</option>
                                                                    <option value="Crucigrama">Crucigrama</option>
                                                                    <option value="Mensaje cifrado">Mensaje cifrado</option>
                                                                    <option value="Sopa de letras">Sopa de letras</option>
                                                                    <option value="Telegrama">Telegrama</option>
                                                                    <option value="Ahorcado">Ahorcado</option>
                                                                    <option value="Palabras perdidas">Palabras perdidas</option>
                                                                </optgroup>
                                                                <optgroup label="PRODUCTOS">
                                                                    <option value="Proyecto">Proyecto</option>
                                                                    <option value="Estudio de Caso">Estudio de Caso</option>
                                                                    <option value="Practica en laboratorio">Práctica en laboratorio</option>
                                                                    <option value="Practica de campo">Práctica de Campo</option>
                                                                    <option value="Practica simulada">Práctica simulada</option>
                                                                    <option value="Solucion de problemas">Solución de problemas</option>
                                                                </optgroup>
                                                            </select>
                                                            CIERRE: <select class="selectpicker" name="cierre<?php echo $i; ?>[]" data-live-search="true">
                                                                <option value="Resumen">Resumen</option>
                                                                <option value="Conclusiones">Conclusiones</option>
                                                                <option value="Liga con el tema siguiente">Liga con el tema siguiente</option>
                                                                <option value="Analisis del desempeño">Análisis del desempeño</option>
                                                                <option value="Dinamica de cierre">Dinámica de cierre</option>
                                                            </select>
                                                        </td>
                                                        <td width="100">
                                                            <select name="material<?php echo $i; ?>[]" class="selectpicker" data-live-search="true" multiple>
                                                                <option value="Marcadores">Marcadores</option>
                                                                <option value="Pintarron">Pintarron</option>
                                                                <option value="Proyector">Proyector</option>
                                                                <option value="Computadora">Computadora</option>
                                                                <option value="Diapositivas">Diapositivas</option>
                                                                <option value="Videos">Videos</option>
                                                                <option value="Instrucciones">Instrucciones</option>
                                                                <option value="Internet">Internet</option>
                                                                <option value="Bocinas">Bocinas</option>
                                                                <option value="Cables">Cables</option>
                                                            </select>

                                                            <div class="checkbox">
                                                                <label>Otros<input type="text" class="form-control" name="otros<?php echo $i; ?>" placeholder="Ingresa otro"></label>
                                                            </div>
                                                        </td>
                                                        <td><textarea id="evid_ap" name="evid_ap<?php echo $i; ?>"><?php echo $row[7]; ?></textarea></td>
                                                        <td><select class="selectpicker" data-live-search="true" name="tipo_eval<?php echo $i; ?>">
                                                            <?php
                                                            include('conect.php');
                                                            mysql_query("SET NAMES 'utf8'", $link);
                                                            $inst = mysqli_query($link,"SELECT * FROM tiposevaluacion");
                                                            while ($c = mysqli_fetch_row($inst)) {
                                                            echo "<option value='$c[0]'>$c[1]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="selectpicker" data-live-search="true" name="inst_eval<?php echo $i; ?>">
                                                            <?php
                                                            include('conect.php');
                                                            $tip_eval = mysqli_query($link,"SELECT * FROM instrumentosevaluacion");
                                                            while ($d = mysqli_fetch_row($tip_eval)) {
                                                            echo "<option value='$d[0]'>$d[1]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><textarea id="9" name="criterio<?php echo $i; ?>"><?php echo $row[10]; ?></textarea></td>
                                                    <?php
                                                    $i++;
                                                    }
                                                    ?>
                                                </tr>

                                        </table><br><br>
                                    </div>
                                </div>
                                <!-- <center><input type="radio" id="in-category-20" name="category2" value="LISTO"> <b>LISTO</b></center> -->
                                <br><br>
                                <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                    <button type="button" class="btn btn-info btn-lg" onclick="$('#sevenStep').hide(); $('#sixthStep').show()" >ATRAS</button>
                                    <button type="button" class="btn btn-info btn-lg" onclick="$('#sevenStep').hide(); $('#eightStep').show()">SEGUIR</button>
                                </div>
                            </div>

                            <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="eightStep" style="display:;">
                                <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12" id="divAgrRef1">
                                    <h3 class="dark-grey">VIII. REFERENCIAS BÁSICAS:</h3>
                                    <h5>*Mediante el <b>"ISBN / NOMBRE"</b> busca la referencia.</h5>
                                    <select class="selectpicker" data-live-search="true" name="ref_bas[]" id="ref_bas">
                                        <optgroup label="REFERENCIAS (ISBN, AUTOR, FECHA, TÍTULO, EDITORIAL)">
                                            <?php
                                            include('conect.php');
                                            $ref = mysqli_query($link,"SELECT * FROM referencias");
                                            while ($r = mysqli_fetch_row($ref)) {
                                                echo "<option value='$r[0]'>$r[1], $r[2], $r[3], $r[4], $r[5]</option>";
                                            }
                                            ?>
                                        </optgroup>
                                    </select>
                                    <br><br>
                                    <a href="#agregarRef" class="btn btn-warning" data-toggle="modal">+ AGREGAR</a><br><br>
                                    <!-- <input type="radio" id="in-category-20" name="category8" value="LISTO"> <b>LISTO</b> -->
                                </div>
                                <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                    <button type="button" class="btn btn-info btn-lg" onclick="$('#eightStep').hide(); $('#sevenStep').show()" >ATRAS</button>
                                    <button type="button" class="btn btn-info btn-lg" id="submit8" onclick="$('#eightStep').hide(); $('#nineStep').show()" disabled>SEGUIR</button>

                                </div>

                            </div>

                                <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12" id="nineStep" style="display:;">
                                    <div class="form-group col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                        <h3 class="dark-grey">IX. REFERENCIAS COMPLEMENTARIAS:</h3>
                                        <select class="selectpicker" data-live-search="true" name="ref_com" id="ref_com">
                                        <optgroup label="REFERENCIAS (ISBN, AUTOR, FECHA, TÍTULO, EDITORIAL)">
                                            <?php
                                                include('conect.php');
                                                $ref = mysqli_query($link,"SELECT * FROM referencias");
                                                while ($r = mysqli_fetch_row($ref)) {
                                                    echo "<option value='$r[0]'>$r[1], $r[2], $r[3], $r[4], $r[5]</option>";
                                                }
                                            ?>
                                            </optgroup>
                                        </select>
                                        <br><br>
                                        <a href="#agregarRefComp" class="btn btn-warning" data-toggle="modal">+ AGREGAR</a><br><br>
                                        <!-- <input type="radio" id="in-category-20" name="category2" value="LISTO"> <b>LISTO</b> -->
                                    </div>
                                    <div class="form-group col-lg-12 col-md-8 col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#nineStep').hide(); $('#eightStep').show()" >ATRAS</button>
                                        <input type="submit" name="submit" class="btn btn-danger btn-lg" value="TERMINAR">
                                    </div>
                                </div>

                            </form>

                       <div id="agregarRef" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Agregar Referencia</h4>
                                        </div>
                                        <form id="agregarRefForm">
                                            <div class="modal-body" id="modalForm">
                                                <p>Formulario para agregar referencia.</p>
                                                <p class="text-warning"><small>Asegurese de buscar primero la referencia en las ya existentes.</small></p>
                                                <input type="text" placeholder="ISBN" name="isbn" class="form-control" id="isbnRef" value="" required><br>
                                                <input type="text" placeholder="Autor" name="autor" class="form-control" id="autorRef" value="" required><br>
                                                Fecha:
                                                <input type="date" id="fechaRef" required><br><br>
                                                <input type="text" placeholder="Titulo" name="titulo" class="form-control" id="tituloRef" value="" required><br>
                                                <input type="text" placeholder="Editorial" name="editorial" class="form-control" id="editorialRef" value="" required><br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary" id="agregarRefBtt" onclick="agrAjax()">Agregar</button>
                                           </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="agregarRefComp" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Agregar Referencia Complementaria</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Formulario para agregar referencia complementaria.</p>
                                            <p class="text-warning"><small>Asegurese de buscar primero la referencia en las ya existentes.</small></p>
                                            <input type="text" placeholder="ISBN" name="isbn" class="form-control" id="isbnRefComp" value="" ><br>
                                            <input type="text" placeholder="Autor" name="autor" class="form-control" id="autorRefComp" value="" ><br>
                                            Fecha:
                                            <input type="date" id="fechaRefComp"><br><br>
                                            <input type="text" placeholder="Titulo" name="titulo" class="form-control" id="tituloRefComp" value="" ><br>
                                            <input type="text" placeholder="Editorial" name="editorial" class="form-control" id="editorialRefComp" value="" ><br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-primary" id="agregarRefBtt" onclick="agrAjaxComp()">Agregar</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <script type="text/javascript">
                                            function agrAjax(){
                                                var isbn = $('#isbnRef').val();
                                                var autor = $('#autorRef').val();
                                                var fecha = $('#fechaRef').val();
                                                var titulo = $('#tituloRef').val();
                                                var editorial = $('#editorialRef').val();

                                                if(isbn == '' || autor == '' || fecha == '' || titulo == '' || editorial == ''){
                                                    alert("Favor de llenar todos los campos");
                                                }
                                                else{
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "agregarRef.php",
                                                        data: {isbn:isbn,autor:autor,fecha:fecha,titulo:titulo,editorial:editorial},
                                                        cache: true,
                                                        success: function(html){
                                                            alert(html);
                                                        }
                                                    });
                                                    $('#agregarRef').modal('hide');
                                                }
                                            };
                                            function agrAjaxComp(){
                                                var isbn = $('#isbnRefComp').val();
                                                var autor = $('#autorRefComp').val();
                                                var fecha = $('#fechaRefComp').val();
                                                var titulo = $('#tituloRefComp').val();
                                                var editorial = $('#editorialRefComp').val();

                                                if(isbn == '' || autor == '' || fecha == '' || titulo == '' || editorial == ''){
                                                    alert("Favor de llenar todos los campos");
                                                }
                                                else{
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "agregarRef.php",
                                                        data: {isbn:isbn,autor:autor,fecha:fecha,titulo:titulo,editorial:editorial},
                                                        cache: true,
                                                        success: function(html){
                                                            alert(html);
                                                        }
                                                    });
                                                    $('#agregarRefComp').modal('hide');
                                                }
                                            };
                                        </script>
                        </section>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /#page-wrapper -->
            </div>

        </body>
    </html>
