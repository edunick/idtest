<?php 
$page=4;
$spage=4.2;
include(realpath("./inc_head.php"));

include(PATHADMINCLASS."suscripcion_class.php");
$ObjSuscripcion=new suscripcion_class();
$folderInmuebles=URLSITE."upload/inmuebles/";


//**************************CANCELAR**********************************
if($_GET["action"]=="cancelada" && $_GET["id"]!==""){
	if($ObjSuscripcion->UpdateSuscripcionEstado($_GET["id"],"cancelada",$db)){
		
		$ObjInmuebles->UpdatePendienteAprobacion($_GET["inmueble"],0,$db);
		$ObjInmuebles->UpdateSuscripcion($_GET["inmueble"],0,$db);
		
		$ObjLogs->NewLogs('',"El usuario <b>".$_SESSION["email"]."</b> registró la cancelación de la suscripcion DESTACADO #".$_GET["id"],$_SESSION["idUsers"],$db);
		
		$Redirect="<script>location.href='admin_destacado.php'</script>";
	}
	echo $Redirect;
}
//**************************FINALIZADA**********************************
if($_GET["action"]=="finalizada" && $_GET["id"]!==""){
	if($ObjSuscripcion->UpdateSuscripcionEstado($_GET["id"],"finalizada",$db)){
		
		$ObjInmuebles->UpdatePendienteAprobacion($_GET["inmueble"],0,$db);
		$ObjInmuebles->UpdateSuscripcion($_GET["inmueble"],0,$db);
		
		$ObjLogs->NewLogs('',"El usuario <b>".$_SESSION["email"]."</b> registró la finalización de la suscripcion DESTACADO #".$_GET["id"],$_SESSION["idUsers"],$db);
		$Redirect="<script>location.href='admin_destacado.php'</script>";
	}
	echo $Redirect;
}
?>


<link rel="stylesheet" href="js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
	<script src="js/jquery-ui/development-bundle/external/jquery.cookie.js"></script>
	<script src="js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="js/jquery-ui/development-bundle/ui/jquery.ui.tabs.js"></script>
	<script>
	$(function() {
		$( "#tabs" ).tabs();
		
		$("#pagination_C option[value="+<?php echo $pagination_C;?>+"]").attr("selected",true);
		
		oTable=$('#tbl1').dataTable({
		"bPaginate": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength":<?php echo PAGINATION;?>,
		"bStateSave": <?php echo USESAVE;?>
		});
	oTable.fnSetColumnVis( 0, false );
	
	
	oTable2=$('#tbl2').dataTable({
		"bPaginate": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength":<?php echo PAGINATION;?>,
		"bStateSave": <?php echo USESAVE;?>
		});
	
	
	oTable3=$('#tbl3').dataTable({
		"bPaginate": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength":<?php echo PAGINATION;?>,
		"bStateSave": <?php echo USESAVE;?>
		});
	oTable3.fnSetColumnVis( 0, false );
	oTable3.fnSetColumnVis( 5, false );
	oTable3.fnSetColumnVis( 6, false );
	
	oTable4=$('#tbl4').dataTable({
		"bPaginate": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength":<?php echo PAGINATION;?>,
		"bStateSave": <?php echo USESAVE;?>
		});
	oTable4.fnSetColumnVis( 0, false );
	oTable4.fnSetColumnVis( 5, false );
	oTable4.fnSetColumnVis( 6, false );
	
	
	
	});
	
	
	</script> 
       
<body>

<div class="clear">
<?php include("inc_menu.php");?>
<script type="text/javascript">
$(document).ready(function() {
	
	
} );
</script>
<style>
.datatable1{ clear: both; }
.datatable1 thead th{ cursor: pointer; }
.datatable2{ clear: both; }
.datatable2 thead th{ cursor: pointer; }
.datatable3{ clear: both; }
.datatable3 thead th{ cursor: pointer; }
.datatable4{ clear: both; }
.datatable4 thead th{ cursor: pointer; }
</style>
<div class="main"> <!-- *** mainpage layout *** -->
<div class="main-wrap">
	<?php include("inc_top.php");?>            
	<div class="page clear">
		<h1>Administración de Suscripciones Destacadas <img src="images/silver.png" /></h1>
		<div id="tabs" >
    	<ul>
			<li><a href="#tabs-1">Pendientes</a></li>
			<li><a href="#tabs-2">Vigentes</a></li>
			<li><a href="#tabs-3">Canceladas</a></li>
        	<li><a href="#tabs-4">Finalizadas</a></li>
		</ul>
		<div id="tabs-1">
			<p>Suscripciones Destacadas "Pendientes".</p> 
			<div id="data-table">
				<table id="tbl1"  class="datatable1">
					<thead>
					<tr>
						<th><!--<input type="checkbox" class="checkbox select-all" />--></th>
						<th>Inmueble</th>
                        <th>Inmobiliaria</th>
						<th>Servicio</th>
						<th>Monto</th>
						<th>Periodo de Pago</th>
						<th>Acción</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						$db=$ObjSuscripcion->ListSuscripcionEstado("pendiente",1,$db);
						while($rowPendiente=$db->Row()){
							$imagen=$ObjInmuebles->getImageInmueble($rowPendiente->id,$db1);
					?>
                    
						<tr>
							<td><!--<input type="checkbox" class="checkbox" />--></td>
							<td><img src="timthumb.php?src=<?php echo $folderInmuebles.$imagen;?>&h=70&w=70" /><br><a href="edit_inmuebles.php?id=<?php echo $rowPendiente->id;?>&inmobiliaria=<?php echo $rowPendiente->inmobiliaria;?>"><?php echo $rowPendiente->calle;?>, <?php echo $rowPendiente->numero;?></a></td>
                            <td><?php echo $rowPendiente->nombreInmobiliaria;?></td>
                            <td><?php echo $rowPendiente->descripcionServicio;?></td>
							<td><?php echo number_format($rowPendiente->montoServicio,2);?></td>
							<td><?php echo $rowPendiente->fecha_compra;?>-<?php echo $rowPendiente->fecha_cierre;?></td>
							<td>
                            <a href="pagar_suscripcion.php?id=<?php echo $rowPendiente->idSuscripcion;?>"  rel="shadowbox;width=430;height=300"><img src="images/vigente.png" title="Registrar Pago" /></a>
                            <a href="javascript:CancelarSuscripcion('<?php echo $rowPendiente->idSuscripcion;?>','<?php echo $rowPendiente->id; ?>')"><img src="images/cancelar.png" title="Cancelar Suscripción" /></a>
                            </td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
		</div>
		<div id="tabs-2">
			<p>Suscripciones Destacadas "Vigentes".</p> 
			<div id="data-table">
				<table id="tbl2"  class="datatable2">
					<thead>
					<tr>						
						<th>Inmueble</th>
                        <th>Inmobiliaria</th>
						<th>Servicio</th>
						<th>Monto</th>
						<th>Desde</th>
                        <th>Hasta</th>
						<th>Dias</th>
                        <th>Acción</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						$db=$ObjSuscripcion->ListSuscripcionEstado("vigente",1,$db);
						while($rowVigente=$db->Row()){
							$imagen=$ObjInmuebles->getImageInmueble($rowVigente->id,$db1);
					?>
                    
						<tr>
							<td><img src="timthumb.php?src=<?php echo $folderInmuebles.$imagen;?>&h=70&w=70" /><br><a href="edit_inmuebles.php?id=<?php echo $rowVigente->id;?>&inmobiliaria=<?php echo $rowVigente->inmobiliaria;?>"><?php echo $rowVigente->calle;?>, <?php echo $rowVigente->numero;?></a></td>
                            <td><?php echo $rowVigente->nombreInmobiliaria;?></td>
                            <td><?php echo $rowVigente->descripcionServicio;?></td>
							<td><?php echo number_format($rowVigente->montoServicio,2);?></td>
							<td><?php echo $rowVigente->fecha_inicio;?></td>
							<td><?php echo $rowVigente->fecha_fin;?></td>
                            <td><?php echo $rowVigente->dias;?></td>
                            <td><a href="javascript:FinalizarSuscripcion('<?php echo $rowVigente->idSuscripcion;?>','<?php echo $rowVigente->id; ?>')"><img src="images/finalizar.png" title="Finalizar Suscripción" /></a></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
		</div>
		<div id="tabs-3">
			<p>Suscripciones Destacadas "Canceladas".</p> 
			<div id="data-table">
				<table id="tbl3"  class="datatable3">
					<thead>
					<tr>
						<th><!--<input type="checkbox" class="checkbox select-all" />--></th>
						<th>Inmueble</th>
                        <th>Inmobiliaria</th>
						<th>Servicio</th>
						<th>Monto</th>
						<th></th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php 
						$db=$ObjSuscripcion->ListSuscripcionEstado("cancelada",1,$db);
						while($rowCancelada=$db->Row()){
							$imagen=$ObjInmuebles->getImageInmueble($rowCancelada->id,$db1);
					?>
                    
						<tr>
							<td><!--<input type="checkbox" class="checkbox" />--></td>
							<td><img src="timthumb.php?src=<?php echo $folderInmuebles.$imagen;?>&h=70&w=70" /><br><a href="edit_inmuebles.php?id=<?php echo $rowCancelada->id;?>&inmobiliaria=<?php echo $rowCancelada->inmobiliaria;?>"><?php echo $rowCancelada->calle;?>, <?php echo $rowCancelada->numero;?></a></td>
                            <td><?php echo $rowCancelada->nombreInmobiliaria;?></td>
                            <td><?php echo $rowCancelada->descripcionServicio;?></td>
							<td><?php echo number_format($rowCancelada->montoServicio,2);?></td>							
							<td></td>
							<td></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>	
		</div>
    	<div id="tabs-4">
			 <p>Suscripciones Destacadas "Finalizadas".</p> 
			<div id="data-table">
				<table id="tbl4"  class="datatable4">
					<thead>
					<tr>
						<th><!--<input type="checkbox" class="checkbox select-all" />--></th>
						<th>Inmueble</th>
                        <th>Inmobiliaria</th>
						<th>Servicio</th>
						<th>Monto</th>
						<th></th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php 
						$db=$ObjSuscripcion->ListSuscripcionEstado("finalizada",1,$db);
						while($rowFinalizada=$db->Row()){
							$imagen=$ObjInmuebles->getImageInmueble($rowFinalizada->id,$db1);
					?>
                    
						<tr>
							<td><!--<input type="checkbox" class="checkbox" />--></td>
							<td><img src="timthumb.php?src=<?php echo $folderInmuebles.$imagen;?>&h=70&w=70" /><br><a href="edit_inmuebles.php?id=<?php echo $rowFinalizada->id;?>&inmobiliaria=<?php echo $rowFinalizada->inmobiliaria;?>"><?php echo $rowFinalizada->calle;?>, <?php echo $rowFinalizada->numero;?></a></td>
                            <td><?php echo $rowFinalizada->nombreInmobiliaria;?></td>
                            <td><?php echo $rowFinalizada->descripcionServicio;?></td>
							<td><?php echo number_format($rowFinalizada->montoServicio,2);?></td>							
							<td></td>
							<td></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>              
		</div>
		</div>
	</div>
<?php include("inc_footer.php");?>
</div>
</div>        
</div>
</div>
<script>
function CancelarSuscripcion(id,inmueble){
		var url = 'admin_destacado.php?id=' + id +'&action=cancelada&inmueble=' + inmueble
		var result = confirm('Está por cancelar esta suscripción. Esta seguro?');
		if(result)
			self.location = url;
	}
function FinalizarSuscripcion(id,inmueble){
		var url = 'admin_destacado.php?id=' + id +'&action=finalizada&inmueble=' + inmueble
		var result = confirm('Está por finalizar esta suscripción. Esta seguro?');
		if(result)
			self.location = url;
	}
</script>
</body>
</html>