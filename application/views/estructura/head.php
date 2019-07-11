<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>CRM UCEMA | Customer relationship management </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datepicker/datepicker3.css">
    <link href="<?=base_url()?>assets/dist/css/AdminLTE.min2.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
            CI_ROOT = "<?=base_url()?>";
    </script>
    <link type="text/css" href="<?php echo base_url(); ?>assets/css/head.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo base_url(); ?>assets/css/global.css" rel="stylesheet" />

  </head>
  <body class="skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">

      <header class="main-header">
        <a href="<?=base_url()?>index.php/home" class="logo">
          <span class="logo-mini"><img src="<?=base_url()?>assets/images/logo_mini.png"></span>
          <span class="logo-lg"> <img src="<?=base_url()?>assets/images/logo_solo.png"></span>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=base_url()?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?=$this->session->userdata('usuario_crm');?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <ul class="sidebar-menu">
            <li class="header">Menu de Navegacion</li>
            
            <li>
                <a href="<?=base_url()?>index.php/home"> <i class="fa fa-home"></i> <span>Home</span> </a>
            </li>
            
            <!-- CONSULTAS -->
            <?php  if( $this->Login_model->tiene_permiso('consulta') ): ?>

                <li class="treeview">
                  <a href="<?=base_url()?>index.php/consulta/index">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span>Consultas</span>  <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                     <li  class="active">
                        <a href="<?=base_url()?>index.php/consulta/mis_consultas">
                              <i class="fas fa-clipboard-check"></i> Mis consultas
                        </a>
                    </li>
                    <li  class="active">
                        <a href="<?=base_url()?>index.php/consulta">
                              <i class="fa  fa-search" aria-hidden="true"></i> Buscar consultas
                        </a>
                    </li>
                    <li  class="active">
                        <a href="<?=base_url()?>index.php/consulta/pipeline">
                              <i class="fa fa-road" aria-hidden="true"></i> Pipeline de estados
                        </a>
                    </li>
                    <li  class="active">
                        <a href="<?=base_url()?>index.php/consulta/ver_alta_consulta_1/">
                              <i class="fa fa-plus"></i> Cargar consulta
                        </a>
                    </li>
                     <li  class="active">
                        <a href="<?=base_url()?>index.php/consulta/asignar_consultas/">
                              <i class="fa fa-external-link-alt"></i> Asignar consultas
                        </a>
                    </li>
                     <li  class="active">
                        <a href="<?=base_url()?>index.php/consulta/mis_alarmas/">
                              <i class="fa fa-calendar"></i> Mis alarmas
                        </a>
                    </li>
                  </ul>
                </li>
            <?php  endif; ?>
            
            <!-- CONTACTOS/PERSONAS -->
            <?php  if( $this->Login_model->tiene_permiso('contacto') ): ?>
                <li class="treeview">
                  <a href="<?=base_url()?>index.php/contacto/index">
                    <i class="fas fa-users"></i>
                    <span>Personas</span>
                  </a>
                </li>
            <?php  endif; ?>
            
            <!-- IMPORTADOR -->
            <?php  if( $this->Login_model->tiene_permiso('importador') ): ?>
              <li class="treeview">
                <a href="#">
                 <i class="fas fa-exchange-alt"></i>
                  <span>Importador</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li  class="active">
                      <a href="<?=base_url()?>index.php/importador/index_web">
                         <i class="fas fa-globe"></i> Desde la Web
                      </a>
                  </li>
                  <li  class="active">
                      <a href="<?=base_url()?>index.php/importador/index_excel">
                          <i class="fas fa-file-excel" aria-hidden="true"></i>Desde un excel
                      </a>
                  </li>
                </ul>
              </li>
            <?php  endif; ?>
            
            <!-- EVENTO -->
            <?php  if( $this->Login_model->tiene_permiso('evento') ): ?>
              <li class="treeview">
                <a href="<?=base_url()?>index.php/evento/index">
                  <i class="fas fa-ticket-alt"></i>
                  <span>Eventos</span>
                </a>
              </li>
            <?php  endif; ?>

            <!-- ESCUELA DE NEGOCIOS -->
            <?php  if( $this->Login_model->tiene_permiso('escuela_negocios') ): ?>

              <li class="treeview">
                <a href="<?=base_url()?>index.php/escuela_negocios">
                  <i class="fas fa-handshake"></i>
                  <span>Escuela de negocios</span>
                </a>
              </li> 
            <?php  endif; ?>
            
            <!-- CONFIGURACION -->
            <?php  if( $this->Login_model->tiene_permiso('configuracion') ): ?>
                <li class="treeview">
                  <a href="#">
                    <i class="fas fa-cogs"></i>
                    <span>Configuracion</span>  <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li  class="active">
                        <a href="<?=base_url()?>index.php/configuracion/programas">
                            <i class="fas fa-graduation-cap"></i>Mis programas
                        </a>
                    </li>
                    <li  class="active">
                        <a href="<?=base_url()?>index.php/configuracion/emails">
                            <i class="fas fa-envelope"></i>Tipos de emails
                        </a>
                    </li>
                    <li  class="active">
                        <a href="<?=base_url()?>index.php/configuracion/eventos">
                            <i class="fas fa-ticket-alt"></i>Tipos de evento
                        </a>
                    </li>
                  </ul>
                </li>
            <?php  endif; ?>
            
            <!-- ESTADISTICAS -->
            <?php  if( $this->Login_model->tiene_permiso('estadisticas') ): ?>
                <li class="treeview">
                  <a href="<?=base_url()?>index.php/estadisticas/index">
                    <i class="fas fa-chart-pie"></i>
                    <span>Estadisticas</span>
                  </a>
                </li>
            <?php  endif; ?>
            

            <li class="treeview">
              <a href="<?=base_url()?>index.php/ayuda/manual_usuario">
                <i class="fas fa-question"></i>
                <span>Ayuda </span>
              </a>
            </li>

            <li>
                <a href="<?=base_url()?>index.php/login/logout"> <i class="fas fa-power-off"></i> <span>Salir</span> </a>
            </li>
          </ul>
        </section>
      </aside>