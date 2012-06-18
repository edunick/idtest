<?php 
$page=2;
$spage=2.5;
include(realpath("./inc_head.php"));
include(PATHADMINCLASS."caracteristicas_class.php");
$ObjCaracteristicas=new caracteristicas_class();

//**************************DELETE**********************************
if($_GET["action"]=="delete" && $_GET["id"]!==""){
	if($ObjCaracteristicas->DeleteCaracteristicas($_GET["id"],$db)){
		$Redirect="<script>location.href='".getPermalinks(RW,"admin/admin_caracteristicas.php","admin/admin-caracteristicas")."'</script>";
	}else{
		$Redirect = '<div class="notification note-error" style="width:380px;">
				<span class="icon"></span>
				<p><strong>Error:</strong> Ocurrio un error, no se pudo eliminar la Caracteristica.</p>
				</div>';
		
	}
	echo $Redirect;
}

?>
<body>
<div class="clear">
<?php include(PATHADMIN."inc_menu.php");?>
<script type="text/javascript">
$(document).ready(function() {
	
	oTable=$('#tbl1').dataTable({
		"bPaginate": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength":<?php echo PAGINATION;?>,
		"bStateSave": <?php echo USESAVE;?>
		});
	oTable.fnSetColumnVis( 0, false );
	oTable.fnSetColumnVis( 3, false );
	oTable.fnSetColumnVis( 4, false );
	oTable.fnSetColumnVis( 5, false );
} );
</script>

<style>
.datatable1{ clear: both; }
.datatable1 thead th{ cursor: pointer; }
</style>
<div class="main">
	<div class="main-wrap">
    	<?php include(PATHADMIN."inc_top.php");?>
	<div class="page clear">
		<h1>Administrar Caracteristicas <a href="#modal" class="modal-link"><img src="<?php echo URLSITE;?>admin/images/ico_help_32.png" class="help" alt="" /></a></h1>
		<p>Desde aqui puede administrar las caracteristicas que usa un inmueble.</p>
		<!-- MODAL WINDOW -->
		<div id="modal" class="modal-window">
		<!-- <div class="modal-head clear"><a onclick="$.fancybox.close();" href="javascript:;" class="close-modal">Close</a></div> -->
			<div class="notification note-info">
				<a href="#" class="close" title="Close notification"><span>cerrar</span></a>
				<span class="icon"></span>
				<p><strong>Informacion:</strong> Agregue, busque, ordene, elimine o edite las caracteristicas.</p>
			</div>
			<h2>Administrar Operación</h2>
			<p>Desde aqui puede administrar las caracteristicas que usa un inmueble.</p>
		</div>
			
		<!-- CONTENT MAIN -->
		<div class="content-box">
			<div class="box-header clear">
				<ul class="tabs clear">
					<li><a href="<?php echo getPermalinks(RW,"admin/new_caracteristicas.php","admin/new-caracteristicas");?>" class="selection" rel="shadowbox;width=430;height=250">Agregar Nueva Caracteristica</a></li>
				</ul>
				<h2>Listado de Caracteristicas</h2>
			</div>
			<div class="box-body clear">
				<!-- TABLE -->
				<div id="data-table">
				<form method="post" action="">
				<table id="tbl1"  class="datatable1">
					<thead>
					<tr>
						<th><!--<input type="checkbox" class="checkbox select-all" />--></th>
						<th>Id</th>
						<th>Nombre</th>
						<th></th>
                        <th></th>
						<th></th>
						<th>Acción</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						$db=$ObjCaracteristicas->ListCaracteristicas($db);
						while($rowCaracteristicas=$db->Row()){
							
					?>
                    
						<tr>
							<td><!--<input type="checkbox" class="checkbox" />--></td>
							<td><?php echo $rowCaracteristicas->id;?></td>
                            <td><?php echo htmlspecialchars($rowCaracteristicas->nombre);?></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<a href="<?php echo getPermalinks(RW,"admin/edit_caracteristicas.php?id=".$rowCaracteristicas->id,"admin/edit-caracteristicas/".$rowCaracteristicas->id);?>"  rel="shadowbox;width=430;height=250"><img src="<?php echo URLSITE;?>admin/images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
								<a href="javascript:void(0);" onClick="DelCaracteristicas('<?php echo $rowCaracteristicas->id;?>');"><img src="<?php echo URLSITE;?>admin/images/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>	
							</td>
						</tr>
                        
                        
					<?php }?>
					</tbody>
				</table>
				<div class="tab-footer clear fl">
					<div class="fl">
						<!--<select name="dropdown" class="fl-space">
							<option value="option1">choose action...</option>
							<option value="option2">Edit</option>
							<option value="option3">Delete</option>
						</select>
						<input type="submit" value="Apply" id="submit1" class="submit fl-space" />-->
					</div>
				</div>
				</form>
				</div><!-- /#table -->
			</div> <!-- end of box-body -->
		</div>
        <!-- END CONTENT MAIN -->
			<?php include(PATHADMIN."inc_footer.php");?>
	</div>
	</div>
</div>
</div>
<script>
function DelCaracteristicas(id){
		var url = 'admin_caracteristicas.php?id=' + id +'&action=delete'
		var result = confirm('WARNING: Esta a punto de eliminar una caracteristica, esto tambien eliminara todo lo asociado a la misma. Esta seguro?');
		if(result)
			self.location = url;
	}
</script>
</body>
</html>