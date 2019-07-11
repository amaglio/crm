<?php 	
	// Medios de consulta 

	if(count($medios_consulta) > 0):

		$cadena_medio_consulta = '[';	

		foreach ($medios_consulta as $row) 
		{
			$color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
			
			$cadena_medio_consulta .= '{ value: '.$row['CANTIDAD'].' 
			,color:"#'.$color.'"
			,highlight: "#f56954"
			,label:"'.$row['DESCRIPCION'].'"},';
		}

		$cadena_medio_consulta .= ']';

	endif;

	// Periodo de ingreso 

	if(count($periodo_ingreso) > 0):

		$cadena_periodo_ingreso = '[';	

		foreach ($periodo_ingreso as $row) 
		{
			$color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
			
			$cadena_periodo_ingreso .= '{ value: '.$row['CANTIDAD'].' 
			,color:"#'.$color.'"
			,highlight: "#f56954"
			,label:"'.$row['DESCRIPCION'].'"},';
		}

		$cadena_periodo_ingreso .= ']';

	endif;

	// Informacion interes

	if(count($informacion_interes) > 0):

		$cadena_informacion_interes = '[';	

		foreach ($informacion_interes as $row) 
		{
			$color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
			
			$cadena_informacion_interes .= '{ value: '.$row['CANTIDAD'].' 
			,color:"#'.$color.'"
			,highlight: "#f56954"
			,label:"'.$row['DESCRIPCION'].'"},';
		}

		$cadena_informacion_interes .= ']';

	endif;

 
?>


<div class="content-wrapper">
    <section class="content-header">

      <h4>
        <i class="fa fa-pie-chart"></i> Estadisticas
      </h4>
	
	<?php  ?>
	
    </section>

    <div class="panel-body">
		
 

		<div class="col-md-4">
			<div class="box box-danger">
	            <div class="box-header with-border">
	              <h3 class="box-title">Medios de consulta</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	            </div>
	            <div class="box-body">
	              <canvas id="medios_consulta" style="height:250px"></canvas>
	            </div>
	            
	          </div>
		</div>
        
        <div class="col-md-4">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Perido de ingreso</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	            </div>
	            <div class="box-body">
	              <canvas id="periodo_ingreso" style="height:250px"></canvas>
	            </div>
	            
	          </div>
		</div>
 

		<div class="col-md-4">
			<div class="box box-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">Información de interés</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	            </div>
	            <div class="box-body">
	              <canvas id="informacion_interes" style="height:250px"></canvas>
	            </div>
	            
	          </div>
		</div>

    </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>

<script type="text/javascript">
	
//----------------------
// Medios de consulta 
//----------------------

    var medio_consulta = $("#medios_consulta").get(0).getContext("2d");
    var medioconsulta = new Chart(medio_consulta);

 	var PieData = <?=$cadena_medio_consulta?>;
    
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    medioconsulta.Doughnut(PieData, pieOptions);

//----------------------
// Periodo ingreso
//----------------------

    var piePeriodoingreso = $("#periodo_ingreso").get(0).getContext("2d");
    var periodo_ingreso = new Chart(piePeriodoingreso);

 	var PieData = <?=$cadena_periodo_ingreso?>;
    
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    periodo_ingreso.Doughnut(PieData, pieOptions);

//----------------------
// Informacion de interes
//----------------------

    var pieInformacionInteres = $("#informacion_interes").get(0).getContext("2d");
    var informacion_interes = new Chart(pieInformacionInteres);

 	var PieData = <?=$cadena_informacion_interes?>;
    
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    informacion_interes.Doughnut(PieData, pieOptions);

</script>