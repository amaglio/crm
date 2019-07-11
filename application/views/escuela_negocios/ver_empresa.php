<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
<link rel='stylesheet' href='<?=base_url()?>assets/css/escuela_negocios/escuela_negocios.css' />
<link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />


<div class="content-wrapper">
 
  <section class="content-header">
    <h4>
        <i class="fa fa-handshake-o"></i>
        <span><a href="<?=base_url()?>index.php/escuela_negocios">Escuela de negocios</a></span>/ Empresa / <span><?=$datos_empresa['D_EMPRESA']?></span>
        
        <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver las acciones de la empresa">
            <a href="#" data-toggle="control-sidebar" data-target="acciones">
              <i class="fa fa-2x fa-history" style="padding-right:10px;"></i>Acciones de la empresa
            </a>
        </span>

        <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Buscar empresa">
          <a href="#" data-toggle="modal" data-target="#moda_buscar_empresa" data-whatever="" style="padding-right:20px;">
              <i class="fa  fa-2x fa-search" aria-hidden="true"></i>
              <span> Buscar empresa </span>
          </a>
        </span>
    </h4>


  </section>


  <div class="panel-body">
    
    <div class="row">
      
      
      <!-- Informacion empresa -->
      <div class="col-md-4">

        <?php  mensaje_resultado($mensaje); ?>

        <div class="box box-primary">

          <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
            <i class="fa fa-address-card" aria-hidden="true"></i> <h3 class="box-title">Informacion empresa</h3>
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
                      <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$datos_empresa['N_ID_EMPRESA']?>">
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
                      <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$datos_empresa['D_EMPRESA']?>"> 
                    </div>
                  </div>

                </div>

                <div class="col-md-6">
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">CUIT</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </div>
                      <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$datos_empresa['N_CUIT']?>"> 
                    </div>
                  </div>

                </div>

                <div class="col-md-6">
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Condicion IVA</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </div>
                      <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$datos_empresa['C_COND_IVA']?>"> 
                    </div>
                  </div>

                </div>

                <div class="col-md-12">
                      <a data-toggle="modal" data-target="#modal_alta_accion_empresa" data-whatever="">
                        <button data-toggle="tooltip" data-placement="top"
                                data-original-title="Da de alta una acción en la empresa" type="button" class="btn btn-primary">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                          <span> Agregar acción</span>
                        </button>
                      </a>
                </div>

            </div>
 
 

          </div>

        </div>
        
        <!-- Referentes -->
        <div class="box box-danger">

          <div class="box-header with-border">
            <i class="fa fa-users" aria-hidden="true"></i> <h3 class="box-title">Referentes de la empresa</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            </div>
          </div>

          <div class="box-body">

              <table id="referentes_empresa" class="display">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
               
              
              <?php  foreach ($referentes_empresa as $row): ?>
                    
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
                      data-original-title="Da de alta un nuevo referente de una empresa" type="button" class="btn btn-danger
                      ">
                <i class="fa fa-plus-square" aria-hidden="true"></i>
                <span>Agregar referente</span>
            </button>
          </a>

          </div>

        </div>

         <!-- Acuerdos -->
        <div class="box box-info">

          <div class="box-header with-border">
            <i class="fa fa-file" aria-hidden="true"></i> <h3 class="box-title">Acuerdos con la empresa</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            </div>
          </div>

          <div class="box-body">
            
            <?php if($acuerdo_empresa): ?>
                  
                  <form  name="form_modifica_acuerdo" id="form_modifica_acuerdo" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/modifica_acuerdo_empresa/" >
                    
                    <input type="hidden" class="form-control" id="id_empresa"  name="id_empresa" value="<?=$datos_empresa['N_ID_EMPRESA']?>" >

                    <div class="form-group">
                      <div class="input-group date">
                        <div class="input-group-addon">
                            <label for="exampleInputEmail1">Id</label> 
                        </div>
                        <input readonly="readonly" type="text" class="form-control pull-right" id="id_crm_empresa_acuerdo" name="id_crm_empresa_acuerdo" value="<?=$acuerdo_empresa['ID_CRM_EMPRESA_ACUERDO']?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group date">
                        <div class="input-group-addon">
                            <label for="exampleInputEmail1">¿ Está vigente ?</label> 
                        </div> 
 
                        <input  type="checkbox" name="vigente" id="vigente" value="1" <?php if( $acuerdo_empresa['VIGENTE'] == 1) echo "checked='checked'"; ?> >
                      </div>
                    </div>

                    <div class="form-group">
                      <textarea class="form-control" id="descripcion"  name="descripcion"><?=$acuerdo_empresa['DESCRIPCION']?></textarea>
                    </div>


                    <button type="submit" class="btn btn-info btn-s" data-toggle="tooltip" data-placement="top" data-original-title="Modificar el acuerdo"> <i class="fa fa-edit" aria-hidden="true"></i> Modificar</button>
                    <a type="submit" class="btn btn-danger pull-right" id="btn_eliminar_acuerdo" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar el acuerdo">  <i class="fa fa-close" aria-hidden="true"></i>  Eliminar</a>
                </form>
                      
            <?php else: ?> 

                  
                  <div class="alert alert-danger" role="alert">
                     La empresa no tiene acuerdos cargados.
                  </div>

                  <a data-toggle="modal" data-target="#modal_agregar_acuerdo" data-whatever="">
                    <button data-toggle="tooltip" data-placement="top"
                            data-original-title="Dajjajaja de alta un acuerdo para la empresa" type="button" class="btn btn-default">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                      <span> Agregar acuerdo</span>
                    </button>
                  </a>

            <?php endif; ?>
 
          </div>
        </div>
      </div>

      <!-- Empleados -->
      <div class="col-md-4">
        <div class="box box-success">

          <div class="box-header with-border">
            <i class="fa fa-users" aria-hidden="true"></i> <h3 class="box-title">Empleados</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            </div>
          </div>

          <div class="box-body">

              <table id="empleados_empresa" class="display">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
               
              
              <?php  foreach ($empleados_empresa as $row): ?>
                    
                    <tr>
                      <td><?=$row['NOMBRE']?></td>
                      <td><?=$row['APELLIDO']?></td>
                      <td>
                          <?php  if($row['ORIGEN'] == 'crm'): ?>
                            
                            <a href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$row['ID']?>">
                              <button type="button" class="btn btn-success btn-s btn-ver-referente">
                                <i class="fas fa-city"></i>
                                <span>Ver contacto CRM</span>
                              </button>
                            </a>

                          <?php   else: ?>
                              
                              <label>Esta en SIGEU</label>

                          <?php   endif; ?>
 
                      </td>
                    </tr>
                      

              <?php  endforeach; ?>

               </tbody>

            </table>
          </div>

        </div>
      </div>

       <!-- Alarmas -->
      <div class="col-md-4">
          
          <div class="box box-warning">
              <div class="box-header with-border">
                <i class="fa fa-bell" aria-hidden="true"></i> <h3 class="box-title">Alarmas de la empresa</h3>
              </div>
              <div class="box-body"> 
                    <table id="tabla_proximas_alarmas" class="display">
                      <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>Descripción</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($alarmas_empresa as $row): ?>

                          <tr>
                            <td><?=$row['FECHA_ACCION']?></td>
                            <td><?=$row['NOMBRE']?></td>
                            <td><?=$row['APELLIDO']?></td>
                            <td><?=$row['DESCRIPCION']?></td>
                            <td class="referente-ver">
                              
                              <?php if($row['ID_CRM_PERSONA']): ?>
                                
                                <a href="<?=base_url()?>index.php/escuela_negocios/ver_referente/<?=$row['ID_CRM_PERSONA']?>">
                                  <button type="button" class="btn btn-warning btn-s btn-ver-referente">
                                    <i class="fa fa-fw fa-edit"></i>
                                    <span>Ver referente</span>
                                  </button>
                                
                                </a>
                              <?php endif; ?>

                               <a data-toggle="modal" data-target="#modal_modifica_accion_empresa" data-whatever="<?=$row['ID_CRM_ACCION']?>">
                                  <button type="button" class="btn btn-warning btn-s btn-editar-alarma"   data-toggle="tooltip" data-placement="top"
                                  data-original-title="Editar alarma">
                                    <i class="fa fa-fw fa-edit"></i>
             
                                  </button>
                                </a>

                             
                            </td>
                          </tr>
                              
                        <?php endforeach; ?>
                      </tbody>
                    </table>
              </div>
          </div>
      </div>
      

 
    </div>
  

  </div>

</div>



<!-- ################# MODALES ################# -->

<!-- MODAL ALTA ACCION 

<div class="modal fade " id="modal_alta_accion_empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar acción</h4>
      </div>

      <form  name="form_alta_accion" id="form_alta_accion" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_accion_empresa/" >

        <div class="modal-body clearfix d-flex" >
          

          <input type="hidden" class="form-control" id="id_empresa"  name="id_empresa" value="<?=$datos_empresa['N_ID_EMPRESA']?>" >
          
          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Fecha:</label>
              <div class="col-sm-10">
                <input type="text" value="<?=date('Y-m-d')?>" class="form-control" id="fecha_accion" name="fecha_accion" placeholder="Ingresar descripcion" readonly="readonly">
              </div>
          </div>

          <div class="form-group clearfix p-1">
            <label for="empresa" class="col-sm-2 control-label">Descripcion:</label>
            <div class="col-sm-10">
              <textarea class="form-control" class="form-control" id="descripcion" name="descripcion" placeholder="Agregue una desccripcion de la acción"></textarea>             
            </div>
          </div>
 
        </div>


        <div class="modal-footer">
           <button type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>

    </div>
  </div>
</div>-->

<div class="modal fade " id="modal_alta_accion_empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar accion</h4>
      </div>

      <form  name="form_alta_accion" id="form_alta_accion" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_accion_empresa/" >

        <div class="modal-body clearfix d-flex" >
 
           
          <input type="hidden" class="form-control" id="id_empresa" name="id_empresa" value="<?=$datos_empresa['N_ID_EMPRESA']?>">  
          
           <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Fecha:</label>
              <div class="col-sm-10">
                <input type="date" value="<?=date('Y-m-d')?>"  class="form-control" id="fecha_accion" name="fecha_accion" placeholder="Ingresar descripcion" style="padding-bottom: 35px;">
              </div>
          </div>

          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Descripcion:</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingresar descripcion"></textarea> 
              </div>
          </div>

          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Alarma:</label>
              <div class="col-sm-10">
                <input  type="checkbox" id="alarma" name="alarma"  >
              </div>
          </div>

        </div>


        <div class="modal-footer">
           <button type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>

    </div>
  </div>
</div>



<!-- MODAL ALTA ACUERDO   -->

<div class="modal fade " id="modal_agregar_acuerdo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar acuerdo</h4>
      </div>

      <form  name="form_alta_acuerdo" id="form_alta_acuerdo" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_acuerdo_empresa/" >

        <div class="modal-body clearfix d-flex" >
          
          <input type="hidden" class="form-control" id="id_empresa"  name="id_empresa" value="<?=$datos_empresa['N_ID_EMPRESA']?>" >

          <div class="form-group clearfix p-1">
            <label for="empresa" class="col-sm-2 control-label">Descripcion:</label>
            <div class="col-sm-10">
              <textarea rows="7" class="form-control" class="form-control" id="descripcion" name="descripcion" placeholder="Agregue una desccripcion de la acción"></textarea>             
            </div>
          </div>

          <div class="form-group clearfix p-1">
            <label for="empresa" class="col-sm-2 control-label">Vigente:</label>
            <div class="col-sm-10">
              <input type="checkbox" name="vigente" id="vigente" value="1" checked="checked">
            </div>
          </div>
 
        </div>


        <div class="modal-footer">
           <button type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- BUSCAR EMPRESA -->

<div class="modal fade " id="moda_buscar_empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
         <div class="box box-warning">

          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-building"></i> Empresas</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>

          <div class="box-body">
              
            <table id="tabla_ultimas_empresas" class="display dataTable" style="width:100%">
              <thead>
                  <tr>
                      <th>Nombre</th>
                      <th> </th>
                  </tr>  
              </thead>
              <tfoot>
                  <tr>
                      <th>Nombre</th>
                      <th> </th>
                  </tr>
              </tfoot>
            </table>
   
          </div>

        </div>
    </div>
  </div>
  
</div>

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
                <div class="row">
                 <!--
                 <div class="col-sm-12 " style="padding:10px; float:center" >
                   <a class="btn btn-primary"  href="<?=base_url()?>index.php/escuela_negocios/ver_referente/" id="usar_referente" type="submit" class="btn btn-primary">Usar referente</a>
                 </div> -->
                </div>
              </div>
        </div>

            
          <hr noshade="noshade" />
 
        
            <div class="form-group  " id="div_empresa">
                <label  class="col-sm-2 control-label">Empresa</label>                
                <div class="col-sm-12">
                    <input readonly="readonly" type="text" class="form-control" id="id_empresa" name="id_empresa" value="<?=$datos_empresa['N_ID_EMPRESA']?>"> <br>
                    <input readonly="readonly" type="text" class="form-control" id="empresa_sigeu" name="empresa_sigeu" placeholder="Empresa Manual" value="<?=$datos_empresa['D_EMPRESA']?>"> <br>
                </div>
            </div>

            <div class="form-group clearfix p-1">
                <label for="cargo" class="col-sm-2 control-label">Cargo:</label>
                <div class="col-sm-12">
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


<!-- MODAL ALTA ACCION
<div class="modal fade " id="modal_alta_accion_empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar accion</h4>
      </div>

      <form  name="form_alta_accion" id="form_alta_accion" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_accion_empresa/" >

        <div class="modal-body clearfix d-flex" >
     
          <input type="hidden" class="form-control" id="id_crm_persona_empresa" name="id_crm_persona_empresa" value="<?=$id_crm_persona_empresa?>">
          <input type="hidden" class="form-control" id="id_empresa" name="id_empresa" value="<?=$ultima_empresa_referente->ID_EMPRESA?>">
          <input type="hidden" class="form-control" id="id_crm_persona" name="id_crm_persona" value="<?=$id_crm_persona?>">
          
           <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Fecha:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="fecha_accion" name="fecha_accion" placeholder="Ingresar descripcion" readonly="readonly">
              </div>
          </div>

          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Descripcion:</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingresar descripcion"></textarea> 
              </div>
          </div>

          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Alarma:</label>
              <div class="col-sm-10">
                <input  type="checkbox" id="alarma" name="alarma"  >
              </div>
          </div>

        </div>


        <div class="modal-footer">
           <button type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>

    </div>
  </div>
</div> -->

<!-- MODAL EDITAR ALARMA -->
<!-- MODAL MODIFICA ACCION -->
<div class="modal fade " id="modal_modifica_accion_empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header" style="background-color: #88be8b; border: 1px solid #859786;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar Acción</h4>
      </div>

      <form  name="form_modifica_accion" id="form_modifica_accion" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/modifica_accion_empresa/" >

        <div class="modal-body clearfix d-flex" >
      
          <input type="hidden" id="id_empresa" name="id_empresa" >
          <input type="hidden" id="id_crm_persona" name="id_crm_persona" >
          <input type="hidden" id="id_crm_accion" name="id_crm_accion"  >
          
          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Descripcion:</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingresar descripcion"></textarea> 
              </div>
          </div>

          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Alarma:</label>
              <div class="col-sm-10">
                <input  type="checkbox" id="alarma" name="alarma"  >
                <button  id="btn_finalizar_alarma" class="btn btn-default btn-xs" style="float:left;" >Finalizar Alarma</button>
              </div>
          </div>

          <div class="jumbotron " style="padding:10px 10px" id="div_agregar_resultado_alarma" >
            
            <div class="form-group">
              <label for="descripcion_finalizar_alarma">Resultado</label>
              <textarea class="form-control" id="descripcion_finalizar_alarma" name="descripcion_finalizar_alarma"></textarea> <br>
              <div id="sin_descripcion_finalizar">Debe escribir un resultado</div>
            </div>
            <div class="form-group">
              <button  id="agregar_resultado_accion" class="btn btn-info btn-xs" style="float:left;" >Aceptar</button>
              <button  id="cerrar_resultado_accion" class="btn btn-danger btn-xs" style="float:left; padding-left:10px;" >Cerrar</button>
            </div>

          </div>

          <div class="jumbotron " id="div_ver_resultado_alarma" style="padding:10px 10px">
            
          </div>
          

        </div>


        <div class="modal-footer" id="footer-acciones">
          <button id="btn_eliminar_accion" class="btn btn-danger" style="float:left;" >Eliminar</button>
          <button id="btn_cancelar_accion" type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button id="btn_guardar_accion" type="submit" class="btn btn-primary">Guardar</button>
          


        </div>

      </form>

    </div>
  </div>
</div>

<!-- ################### Librerias ################### -->

<link rel='stylesheet' href='<?=base_url()?>assets/css/escuela_negocios/escuela_negocios.css' />

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

 
<!-- VALIDAR -->
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js"></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">

    jq(function(){
      jq('#btn_eliminar_acuerdo').click(function(){
          
          if(confirm('¿Desea eliminar el acuerdo?'))
          {
 

              jq.ajax({

                  url: CI_ROOT+'index.php/escuela_negocios/baja_acuerdo_empresa',
                  data: { id_crm_empresa_acuerdo: jq('#id_crm_empresa_acuerdo').val()  },
                  async: true,
                  type: 'POST',
                  dataType: 'JSON',
                  success: function(data)
                  {
                    if(data.error == false)
                    {
                      alert("Se ha eliminado el acuerdo exitosamente");
                      location.reload();
                    }
                    else
                    {
                      alert("No se ha podido eliminar el acuerdo, intente mas tarde.");
                      location.reload();
                    }
                  },
                  error: function(x, status, error){
                    alert("error");
                  }

              });
          }

      });
    });
 
    jq(function(){

 
        jq('#form_alta_accion').validate({

            rules :{
                    desccripcion : {
                      required : true
                    } 

            },
            messages : {
                    
                    desccripcion : {
                        required : "Debe ingresar una acción o comentario"
                    } 
            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_accion').find(":submit").removeAttr('disabled');
            }

        });
    });


    jq(function(){

 
        jq('#form_alta_acuerdo').validate({

            rules :{
                    descripcion : {
                      required : true
                    } 

            },
            messages : {
                    
                    descripcion : {
                        required : "Debe ingresar las condiciones del acuerdo"
                    } 
            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_acuerdo').find(":submit").removeAttr('disabled');
            }

        });
    });


    jq(function(){

 
        jq('#form_modifica_acuerdo').validate({

            rules :{

                    id_crm_empresa_acuerdo : {
                      required : true
                    },
                    descripcion : {
                      required : true
                    } 

            },
            messages : {

                    id_crm_empresa_acuerdo : {
                        required : "Debe estar el ID de la empresa"
                    } ,
                    descripcion : {
                        required : "Debe ingresar las condiciones del acuerdo"
                    } 

            },
            invalidHandler: function(form, validator) {

                jq('#form_modifica_acuerdo').find(":submit").removeAttr('disabled');
            }

        });
    });


    jq(function(){
        // Modal alta referente

        jq('#modal_agregar_referente').on('show.bs.modal', function (event) {
        
            prueba.resetForm();
            jq('#label_es_referente').hide();
            jq('#nombre').prop( "disabled", false );
            jq('#apellido').prop( "disabled", false );
            jq('#email').prop( "disabled", false );
            jq('#telefono').prop( "disabled", false );
            jq('#empresa').prop( "disabled", false );
            jq('#id_empresa').prop( "disabled", false );
            jq('#empresa').prop('readonly', false);


            jq('#nombre').val('');
            jq('#apellido').val('');
            jq('#email').val('');
            jq('#telefono').val('');
            jq('#empresa').val('');
            jq('#cargo').val('');

            jq('#nombre_encontrado').val('');
            jq('#apellido_encontrado').val('');
            jq('#id_crm_persona_encontrado').val('');
            jq('#div_usuario_encontrado').hide();

            jq('#div_empresa_sigeu').hide();     
            jq('#id_empresa').val('');  
            jq('#empresa_sigeu').val('');  
                 
        });
    });


    jq(function(){

        jq('#form_alta_referente').validate({
            onkeyup: false, 
            onfocusout: false,
            rules :{

                    nombre : {
                        required : true
                    },
                    apellido: {
                        required : true
                    },
                    email: {
                        email : true
                    },
                    empresa : {
                      seleccion_empresa : true
                    } 

            },
            messages : {

                    nombre : {
                        required : "Debe ingresar el nombre del referente."
                    },
                    apellido: {
                        required : "Debe apellido del nombre del referente."
                    },
                    email: {
                        email : "El formato de email es incorrecto"
                    },
                    empresa : {
                        seleccion_empresa : "Debe seleccionar una empresa del listado emergente."
                    } 

            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_referente').find(":submit").removeAttr('disabled');
            }

        });

    });
</script>
 
<!-- MODAL -->
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script> 
<script type="text/javascript">
    
    jq('#modal_alta_accion_empresa').on('show.bs.modal', function (event) { });

</script>
 


<!-- DataTables plugin -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- DataTables config -->
<script src='<?=base_url()?>assets/js/escuela_negocios/datatables.js'></script>



<script type="text/javascript">
  
 jq(function(){

        jq('#modal_modifica_accion_empresa').on('show.bs.modal', function (event) {
            var button = jq(event.relatedTarget)
            var id_crm_accion = button.data('whatever')

            jq('#modal_modifica_accion_empresa #id_empresa').val('');
            jq('#modal_modifica_accion_empresa #id_crm_persona').val('');
            jq('#modal_modifica_accion_empresa #id_crm_accion').val('');
            jq('#modal_modifica_accion_empresa #descripcion_finalizar_alarma').val('');
            jq('#modal_modifica_accion_empresa #div_agregar_resultado_alarma').hide();
            jq('#modal_modifica_accion_empresa #btn_eliminar_accion').attr("disabled", false);
            jq('#modal_modifica_accion_empresa #btn_cancelar_accion').attr("disabled", false);
            jq('#modal_modifica_accion_empresa #btn_guardar_accion').attr("disabled", false);
           
            
            jq.ajax({
                url: CI_ROOT+'index.php/escuela_negocios/get_informacion_accion',
                data: { id_crm_accion: id_crm_accion },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  console.log(data);

                  if(data.error == false)
                  {   
                      console.log(data);
                      jq('#modal_modifica_accion_empresa #id_empresa').val(data.id_empresa);
                      jq('#modal_modifica_accion_empresa #id_crm_persona').val(data.id_crm_persona);
                      jq('#modal_modifica_accion_empresa #id_crm_accion').val(data.id_crm_accion);
                      jq('#modal_modifica_accion_empresa #descripcion').val(data.descripcion);

                      if( data.alarma == 1)
                          jq('#modal_modifica_accion_empresa #alarma').attr('checked',true);
                      else
                          jq('#modal_modifica_accion_empresa #alarma').attr('checked',false);

                      jq('#modal_modifica_accion_empresa #btn_finalizar_alarma').show();


                  }
                  else
                  {
                    //alert("No se ha eliminado la accion, intente mas tarde.");
                    //location.reload();
                  }
                },
                error: function(x, status, error){
                  alert(error);
                }
            });  
             
        });
    });
    
    jq(function(){

       jq('#btn_finalizar_alarma').click(function(event){

          event.preventDefault();

          jq('#div_agregar_resultado_alarma').css("display", "block");
          jq('#btn_eliminar_accion').attr("disabled", "disabled");
          jq('#btn_cancelar_accion').attr("disabled", "disabled");
          jq('#btn_guardar_accion').attr("disabled", "disabled");

       });
    });


    jq(function(){

       jq('#cerrar_resultado_accion').click(function(event){

          event.preventDefault();

          jq('#btn_eliminar_accion').attr("disabled", false);
          jq('#btn_cancelar_accion').attr("disabled", false);
          jq('#btn_guardar_accion').attr("disabled", false);

          jq('#descripcion_finalizar_alarma').val('');
          jq('#div_agregar_resultado_alarma').hide();
       });
    });


    jq(function(){

       jq('#agregar_resultado_accion').click(function(event){

          event.preventDefault();
          //alert(jq('textarea#descripcion_finalizar_alarma').val());

          if( !jq('textarea#descripcion_finalizar_alarma').val() )
          { 
              console.log("Text area vacio");
              jq('#sin_descripcion_finalizar').show();
              return false;
          }
          else
          {
              console.log("Text area NO vacio");
              jq('#sin_descripcion_finalizar').hide();
          }
 
          jq.ajax({
              url: CI_ROOT+'index.php/escuela_negocios/alta_accion_resultado',
              data: { descripcion_finalizar_alarma: jq('#descripcion_finalizar_alarma').val(),  
                      id_crm_accion: jq('#id_crm_accion').val(),
                      id_crm_persona: jq('#id_crm_persona').val() },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  //alert("Se ha eliminado la accion exitosamente");
                  location.reload();
                }
                else
                {
                  //alert("No se ha eliminado la accion, intente mas tarde.");
                  location.reload();
                }
              },
              error: function(x, status, error){
                alert(error);
              }
          }); 

       });
    });

</script>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"  >
    
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Línea de tiempo con las acciones del empresa</h3>
        </div>
        <div class="box-body">
          <div class="callout callout-info">
            <p> <strong>La línea de tiempo</strong> muestra las acciones tomadas en esta empresa
            </p>
          </div>

          <div class="nav-tabs-custom">

              <ul class="timeline">

                  <?php  foreach ($acciones_empresa as $row_log): ?>
                      
                      <?php if($row_log['ID_CRM_PERSONA']){
                              $clase="accion_con_referente";
                              $con_refente = 1;
                            } 
                            else{
                              $clase="";
                              $con_refente = 0;
                            }
                      ?>

                      <li class="<?=$clase?>">

                          <?php if($con_refente == 1 ): ?>

                                  <i class="fa fa-user" style="color:#0097bc"></i> 

                          <?php else: ?>

                                  <i class="fa fa-building"></i> 

                          <?php endif; ?>
                          
                          <span style="padding-left:65px; font-weight:bold" class="datos" >
                            <?=$row_log['FECHA']?>  
                            
                            <?php if($row_log['ID_CRM_PERSONA']): ?>
                                      <span> 
                                           - <?=$row_log['NOMBRE'].", ".$row_log['APELLIDO']?>
                                      </span>
                            <?php endif; ?>

                          </span>
                          <div class="timeline-item">
                              <span class="time" style="font-size:10px" ><i class="fa fa-user"> <?=$row_log['C_USUARIOALT']?></i></span>
                              <h3 class="timeline-header" style="font-size:12px !important;"> <?=$row_log['DESCRIPCION']?> </h3>
                                <?php if( $row_log['FECHA_RESULTADO']  ): ?>
                                  
                                  <div style="padding: 10px; background-color: #80808033; font-size: 12px;">
                                        <strong> <?=$row_log['FECHA_RESULTADO']?> </strong> -   <?=$row_log['DESCRIPCION_RESULTADO']?>
                                  </div>

                              <?php endif; ?>

                          </div>
                      </li>

                  <?php   endforeach; ?>


              </ul>

          </div>

        </div>
    </div>

</aside>
 