<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
<link rel='stylesheet' href='<?=base_url()?>assets/css/escuela_negocios/escuela_negocios.css' />
<link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />


<div class="content-wrapper">
 
  <section class="content-header">
    <h4>
        <i class="fa fa-handshake-o"></i>
        <span><a href="<?=base_url()?>index.php/escuela_negocios">Escuela de negocios</a></span>/ Camara / <span><?=$datos_camara['NOMBRE']?></span>
        
        <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver las acciones de la camara">
            <a href="#" data-toggle="control-sidebar" data-target="acciones">
              <i class="fa fa-2x fa-history" style="padding-right:10px;"></i>Acciones de la camara
            </a>
        </span>
 
    </h4>
  </section>


  <div class="panel-body">
    
    <div class="row" style="padding-bottom:20px;">
      
      <div class="col-md-12">
 
          <a data-toggle="modal" data-target="#modal_alta_accion_camara" data-whatever="">
            <button data-toggle="tooltip" data-placement="top"
                    data-original-title="Da de alta una acción en la camara" type="button" class="btn btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i>
              <span> Agregar acción</span>
            </button>
          </a>

          <a data-toggle="modal" data-target="#modal_alta_accion_camara" data-whatever="">
            <button data-toggle="tooltip" data-placement="top"
                    data-original-title="Da de alta una acción en la camara" type="button" class="btn btn-danger">
              <i class="fa fa-plus" aria-hidden="true"></i>
              <span> Agregar refente</span>
            </button>
          </a>

           <a data-toggle="modal" data-target="#modal_alta_accion_camara" data-whatever="">
            <button data-toggle="tooltip" data-placement="top"
                    data-original-title="Da de alta una acción en la camara" type="button" class="btn btn-warning">
              <i class="fa fa-plus" aria-hidden="true"></i>
              <span> Agregar empresa</span>
            </button>
          </a>
 
      </div>

    </div>

    <div class="row">
      
      <!-- Informacion camara -->
      <div class="col-md-4">

        <?php  mensaje_resultado($mensaje); ?>

        <div class="box box-primary">

          <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
            <i class="fa fa-address-card" aria-hidden="true"></i> <h3 class="box-title">Informacion camara</h3>
          </div>


          <div class="box-body">


            <div  class="row">
                
                
                <div class="col-md-6">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Id</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </div>
                      <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$datos_camara['ID_CAMARA']?>">
                    </div>
                  </div>

                </div>


                <div class="col-md-6">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </div>
                      <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$datos_camara['NOMBRE']?>"> 
                    </div>
                  </div>

                </div>

 

                

            </div>
 
 

          </div>

        </div>
        
      

         <!-- Empresas -->
        <div class="box box-info">

          <div class="box-header with-border">
            <i class="fa fa-file" aria-hidden="true"></i> <h3 class="box-title">Acuerdos con la camara</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            </div>
          </div>

          <div class="box-body">
            
            <?php if($acuerdo_camara): ?>
                  
                  <form  name="form_modifica_acuerdo" id="form_modifica_acuerdo" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/modifica_acuerdo_camara/" >
                    
                    <input type="hidden" class="form-control" id="id_camara"  name="id_camara" value="<?=$datos_camara['N_ID_camara']?>" >

                    <div class="form-group">
                      <div class="input-group date">
                        <div class="input-group-addon">
                            <label for="exampleInputEmail1">Id</label> 
                        </div>
                        <input readonly="readonly" type="text" class="form-control pull-right" id="id_crm_camara_acuerdo" name="id_crm_camara_acuerdo" value="<?=$acuerdo_camara['ID_CRM_camara_ACUERDO']?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group date">
                        <div class="input-group-addon">
                            <label for="exampleInputEmail1">¿ Está vigente ?</label> 
                        </div> 
 
                        <input  type="checkbox" name="vigente" id="vigente" value="1" <?php if( $acuerdo_camara['VIGENTE'] == 1) echo "checked='checked'"; ?> >
                      </div>
                    </div>

                    <div class="form-group">
                      <textarea class="form-control" id="descripcion"  name="descripcion"><?=$acuerdo_camara['DESCRIPCION']?></textarea>
                    </div>


                    <button type="submit" class="btn btn-info btn-s" data-toggle="tooltip" data-placement="top" data-original-title="Modificar el acuerdo"> <i class="fa fa-edit" aria-hidden="true"></i> Modificar</button>
                    <a type="submit" class="btn btn-danger pull-right" id="btn_eliminar_acuerdo" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar el acuerdo">  <i class="fa fa-close" aria-hidden="true"></i>  Eliminar</a>
                </form>
                      
            <?php else: ?> 

                  
                  <div class="alert alert-danger" role="alert">
                     La camara no tiene acuerdos cargados.
                  </div>

                  <a data-toggle="modal" data-target="#modal_agregar_acuerdo" data-whatever="">
                    <button data-toggle="tooltip" data-placement="top"
                            data-original-title="Dajjajaja de alta un acuerdo para la camara" type="button" class="btn btn-default">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                      <span> Agregar acuerdo</span>
                    </button>
                  </a>

            <?php endif; ?>
 
          </div>
        </div>
      </div>
 
      <div class="col-md-4">
          <!-- Referentes -->
          <div class="box box-danger">

            <div class="box-header with-border">
              <i class="fa fa-users" aria-hidden="true"></i> <h3 class="box-title">Referentes de la camara</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            </div>
            </div>

            <div class="box-body">

                <table id="referentes_camara" class="display">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                 
                
                <?php  foreach ($referentes_camara as $row): ?>
                      
                      <tr>
                        <td><?=$row['NOMBRE']?></td>
                        <td><?=$row['APELLIDO']?></td>
                        <td>
                            <a href="<?=base_url()?>index.php/escuela_negocios/ver_referente/<?=$row['ID_CRM_PERSONA']?>">
                              <button type="button" class="btn btn-danger btn-s btn-ver-referente" data-toggle="tooltip" data-placement="top"
                                  data-original-title="Ver al referente">
                                <i class="fa fa-search"></i>
                                <span> Ver referente</span>
                              </button>
                            </a>

   

                            <a href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$row['ID_CRM_PERSONA']?>">
                              <button type="button" class="btn btn-danger btn-s btn-ver-referente"  data-toggle="tooltip" data-placement="top"
                                  data-original-title="Ver a la persona">
                                <i class="fa fa-search"></i>
                                <span>Ver persona</span>
                              </button>
                            </a>

                        </td>
                      </tr>
                        

                <?php  endforeach; ?>

                  </tbody>

                </table>

               <a data-toggle="modal" data-target="#modal_agregar_referente" data-whatever="">
                <button data-toggle="tooltip" data-placement="top"
                        data-original-title="Da de alta un nuevo referente de una camara" type="button" class="btn btn-danger
                        ">
                  <i class="fa fa-plus-square" aria-hidden="true"></i>
                  <span>Agregar referente</span>
              </button>
            </a>

            </div>

          </div>
      </div>

    </div>
  

  </div>

</div>
 

<!-- BUSCAR camara -->
<!-- MODAL ALTA REFERENTE -->
<div class="modal fade " id="modal_agregar_referente" tabindex="-1" role="dialog" aria-labelledby="modal_agregar_referente">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar referente</h4>
      </div>

      <form  name="form_alta_referente" id="form_alta_referente" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_referente/" >

        <div class="modal-body clearfix d-flex" >

          <div class="form-group clearfix p-1">
            <label for="nombre" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre">
            </div>
          </div>
          <div class="form-group clearfix p-1">
            <label for="apellido" class="col-sm-2 control-label">Apellido:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresar apellido">
            </div>
          </div>
           <div class="form-group clearfix p-1">
            <label for="email" class="col-sm-2 control-label">Email:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar email">
            </div>
          </div>
          <div class="form-group clearfix p-1">
            <label for="telefono" class="col-sm-2 control-label">Teléfono:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresar teléfono">
            </div>
          </div>
          
          <div id="div_usuario_encontrado">
              <input type="hidden" name="flag_es_referente" id="flag_es_referente" value="0">  
              <input type="hidden" name="flag_no_es_referente" id="flag_no_es_referente"  value="0"> 

              <div class="form-group clearfix p-1">
                <h4> <i onclick="cerrar_div_existe_email()" class="fa fa-window-close" aria-hidden="true">
                    </i> El email ya existe en CRM para el siguiente usuario: 
                    
                    <span id="label_es_referente">( el usuario ya es referente ) </span> 
                </h4>  
                
              </div>
              <input type="hidden" class="form-control" id="id_crm_persona_encontrado" name="id_crm_persona_encontrado"  readonly="readonly">
              
              <div class="form-group clearfix p-1">
                <div class="row">
                  <label for="apellido" class="col-sm-2 control-label">Apellido:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="apellido_encontrado" name="apellido_encontrado" placeholder="Ingresar nombre" readonly="readonly">
                  </div>

                  <label for="apellido" class="col-sm-2 control-label">Nombre:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombre_encontrado" name="nombre_encontrado" placeholder="Ingresar nombre" readonly="readonly">
                  </div>
              
                </div>
                 
              </div>
        </div>

            
          <hr noshade="noshade" />
          
 
        
            <div class="form-group clearfix p-1" id="div_camara">
                <label  class="col-sm-2 control-label">Camara</label>                
                <div class="col-sm-8">
                    <input readonly="readonly" type="text" class="form-control" id="id_camara" name="id_camara" value="<?=$datos_camara['ID_CAMARA']?>"> <br>
                    <input readonly="readonly" type="text" class="form-control" id="camara" name="camara" value="<?=$datos_camara['NOMBRE']?>" > <br>
                </div>
            </div>

            <div class="form-group clearfix p-1">
                <label for="cargo" class="col-sm-2 control-label">Cargo:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Ingresar cargo">
                </div>
            </div>

        </div>

        <div class="modal-footer">
          <button  type="submit" class="btn btn-primary">Aceptar</button>
        </div>

      </form>

        

    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- Validar -->
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js"></script>
<script src='<?=base_url()?>assets/js/escuela_negocios/camaras.js'></script>

 