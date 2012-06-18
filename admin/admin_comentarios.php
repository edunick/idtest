<?php 
$page=5;
$spage=5.1;
include(realpath("./inc_head.php"));

include(PATHADMINCLASS."comentarios_class.php");
$ObjComentarios=new comentarios_class();
$folderInmuebles=URLSITE."upload/inmuebles/";


//**************************publicado**********************************
if($_GET["action"]=="publicado" && $_GET["id"]!==""){
	if($ObjComentarios->UpdateEstadoComentarios($_GET["id"],"publicado",$db)){
		$ObjLogs->NewLogs('',"El usuario <b>".$_SESSION["email"]."</b> registró la publicación de el comentario #".$_GET["id"],$_SESSION["idUsers"],$db);
		
		$Redirect="<script>location.href='admin_comentarios.php'</script>";
	}
	echo $Redirect;
}

//**************************DELETE**********************************
if($_GET["action"]=="delete" && $_GET["id"]!==""){
	if($ObjComentarios->Delete($_GET["id"],$db)){
		$Redirect="<script>location.href='admin_comentarios.php'</script>";
		$ObjLogs->NewLogs('',"El usuario <b>".$_SESSION["email"]."</b> eliminó el comentario #".$_GET["id"],$_SESSION["idUsers"],$db);
	}else{
		$Redirect = '<div class="notification note-error" style="width:380px;">
				<span class="icon"></span>
				<p><strong>Error:</strong> Ocurrio un error, no se pudo eliminar el comentario.</p>
				</div>';
		
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
		oTable2.fnSetColumnVis( 0, false );
	
	});
	
	
	</script> 
       
<body>

<div class="clear">
<?php include("inc_menu.php");?>
<style>
.datatable1{ clear: both; }
.datatable1 thead th{ cursor: pointer; }
.datatable2{ clear: both; }
.datatable2 thead th{ cursor: pointer; }
</style>
<div class="main"> <!-- *** mainpage layout *** -->
<div class="main-wrap">
	<?php include("inc_top.php");?>            
	<div class="page clear">
		<h1>Administración de Comentarios</h1> 
		<div id="tabs" >
    	<ul>
			<li><a href="#tabs-1">Generados</a></li>
			<li><a href="#tabs-2">Publicados</a></li>
		</ul>
		<div id="tabs-1">
			<p>Comentarios "Generados".</p> 
			<div id="data-table">
				<table id="tbl1"  class="datatable1">
					<thead>
					<tr>
						<th><!--<input type="checkbox" class="checkbox select-all" />--></th>
						<th>Id</th>
                        <th>Inmueble</th>
						<th>Usuario</th>
						<th>Comentario</th>
						<th>Fecha</th>
						<th>Acción</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						$ArrayGenerado=$ObjComentarios->ListComentariosEstado("generado",$db);
						foreach($ArrayGenerado as $index => $value) {
							$imagen=$ObjInmuebles->getImageInmueble($value["inmueble"],$db);
					?>
                    
						<tr>
							<td><!--<input type="checkbox" class="checkbox" />--></td>
                            <td><?php echo $value["id"];?></td>
							<td><img src="timthumb.php?src=<?php echo $folderInmuebles.$imagen;?>&h=70&w=70" /><br><a href="edit_inmuebles.php?id=<?php echo $value["inmueble"];?>&inmobiliaria=<?php echo $value["inmobiliaria"];?>"><?php echo $value["inmueble"];?></a></td>
                            <td><?php echo $value["email"];?></td>
                            <td><?php echo $value["descripcion"];?></td>
							<td><?php echo $value["fechaf"];?></td>
							<td>
                            <a href="javascript:AprobarComentario('<?php echo $value["id"];?>')"><img src="images/ico_success_16.png" title="Aprobar Comentario" /></a>
                            <a href="javascript:EliminarComentario('<?php echo $value["id"];?>')"><img src="images/cancelar.png" title="Eliminar Comentario" /></a>
                            </td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
		</div>
		<div id="tabs-2">
			<p>Comentarios "Publicados".</p> 
			<div id="data-table">
				<table id="tbl2"  class="datatable2">
					<thead>
					<tr>
						<th><!--<input type="checkbox" class="checkbox select-all" />--></th>
						<th>Id</th>
                        <th>Inmueble</th>
						<th>Usuario</th>
						<th>Comentario</th>
						<th>Fecha</th>
						<th>Acción</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						$ArrayGenerado=$ObjComentarios->ListComentariosEstado("publicado",$db);
						foreach($ArrayGenerado as $index => $value) {
							$imagen=$ObjInmuebles->getImageInmueble($value["inmueble"],$db);
					?>
                    
						<tr>
							<td><!--<input type="checkbox" class="checkbox" />--></td>
                            <td><?php echo $value["id"];?></td>
							<td><img src="timthumb.php?src=<?php echo $folderInmuebles.$imagen;?>&h=70&w=70" /><br><a href="edit_inmuebles.php?id=<?php echo $value["inmueble"];?>&inmobiliaria=<?php echo $value["inmobiliaria"];?>"><?php echo $value["inmueble"];?></a></td>
                            <td><?php echo $value["email"];?></td>
                            <td><?php echo $value["descripcion"];?></td>
							<td><?php echo $value["fechaf"];?></td>
							<td>
                            <a href="javascript:EliminarComentario('<?php echo $value["id"];?>')"><img src="images/cancelar.png" title="Eliminar Comentario" /></a>
                            </td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
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
function AprobarComentario(id){
		var url = 'admin_comentarios.php?id=' + id +'&action=publicado'
		var result = confirm('Está por aprobar este comentario. Esta seguro?');
		if(result)
			self.location = url;
	}
function EliminarComentario(id){
		var url = 'admin_comentarios.php?id=' + id +'&action=delete'
		var result = confirm('Está por eliminar este comentario. Esta seguro?');
		if(result)
			self.location = url;
	}
</script>
</body>
</html>