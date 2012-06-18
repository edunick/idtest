<?php
include (realpath ( "./inc_class.php" ));
include (PATHSIC . "security.php");
$page = "new_inmueble";
include (PATHSICCLASS . "inmobiliarias_class.php");
include (PATHSICCLASS . "barrios_class.php");
include (PATHSICCLASS . "tipopropiedad_class.php");
include (PATHSICCLASS . "operacion_class.php");
include (PATHSICCLASS . "actualidad_class.php");
include (PATHSICCLASS . "caracteristicas_class.php");
include (PATHSICCLASS . "ambientes_class.php");
include (PATHSICCLASS . "perfiles_class.php");
include (PATHSICCLASS . "agentes_class.php");
include (PATHSICCLASS . "inmuebles_class.php");

$ObjInmobiliarias = new inmobiliarias_class ();
$ObjBarrios = new barrios_class ();
$ObjTipoPropiedad = new tipopropiedad_class ();
$ObjOperacion = new operacion_class ();
$ObjActualidad = new actualidad_class ();
$ObjCaracteristicas = new caracteristicas_class ();
$ObjAmbientes = new ambientes_class ();
$ObjPerfiles = new perfiles_class ();
$ObjAgentes = new agentes_class ();
$ObjInmuebles = new inmuebles_class ();

$id = genRandomString ();

if ($_POST ["action"] == "newInmueble") {
	
	$id = $_POST ["id"];
	$barrio = $_POST ["barrio"];
	$calle = ucwords ( strtolower ( $_POST ["calle"] ) );
	$numero = $_POST ["numero"];
	$piso = $_POST ["piso"];
	$depto = strtoupper ( $_POST ["depto"] );
	$descripcion = $_POST ["descripcion"];
	$operacion = $_POST ["operacion"];
	$tipo = $_POST ["tipo"];
	$estadoinmueble = 1; // GENERADO
	$precio = $_POST ["precio"];
	$habitaciones = $_POST ["habitaciones"];
	$banios = $_POST ["banios"];
	$sqf = $_POST ["sqf"];
	$antiguedad = $_POST ["antiguedad"];
	$actualidad = $_POST ["actualidad"];
	$inmobiliaria = $_SESSION ["idSIC"];
	$direccion = $calle . " " . $numero . " " . $piso . " " . $depto . ", B° " . $ObjBarrios->getNombre ( $barrio, $db );
	$moneda = $_POST ["moneda"];
	$zoom = $_POST ["zoom"];
	$lat = $_POST ["lat"];
	$long = $_POST ["long"];
	$periodoalquiler = $_POST ["periodoalquiler"];
	if ($operacion == 1) {
		$periodoalquiler = "";
	}
	//$ObjInmuebles->NewInmueble($id,$direccion,$barrio,$calle,$numero,$piso,$depto,$descripcion,$operacion,$tipo,$estadoinmueble,$precio,$habitaciones,$banios,$sqf,$antiguedad,$actualidad,$inmobiliaria,$moneda,$db);
	$ObjInmuebles->NewInmueble ( $id, $direccion, $barrio, $calle, $numero, $piso, $depto, $descripcion, $operacion, $tipo, $estadoinmueble, $precio, $habitaciones, $banios, $sqf, $antiguedad, $actualidad, $inmobiliaria, $moneda, $zoom, $lat, $long, $periodoalquiler, $db );
	$inmueble = $id;
	
	for($i = 0; $i < sizeof ( $_POST ["caracteristicas"] ); $i ++) {
		if ($_POST ["caracteristicas"] [$i]) {
			$ObjInmuebles->NewDetalleCaracteristicas ( $_POST ["caracteristicas"] [$i], $inmueble, $db );
		}
	}
	for($i = 0; $i < sizeof ( $_POST ["ambientes"] ); $i ++) {
		if ($_POST ["ambientes"] [$i]) {
			$ObjInmuebles->NewDetalleAmbientes ( $_POST ["ambientes"] [$i], $inmueble, $db );
		}
	}
	
	for($i = 0; $i < sizeof ( $_POST ["perfiles"] ); $i ++) {
		if ($_POST ["perfiles"] [$i]) {
			$ObjInmuebles->NewDetallePerfiles ( $_POST ["perfiles"] [$i], $inmueble, $db );
		}
	}
	
	for($i = 0; $i < sizeof ( $_POST ["agentes"] ); $i ++) {
		if ($_POST ["agentes"] [$i]) {
			$ObjInmuebles->NewAgentesAsignados ( $_POST ["agentes"] [$i], $inmueble, $db );
		}
	}
	
	/****codigo que agrega un thumbnail de 100x75 y agrega al registro del inmueble la imagen principal*/
	include (PATHSICCLASS . "snapshot.class.php");
	$folderInmuebles="../upload/inmuebles/";
	$imagen=$ObjInmuebles->getImageInmueble($inmueble,$db);
	$myimage = new ImageSnapshot;
	$myimage->ImageFile=$folderInmuebles.$imagen;
	$myimage->Width = "100";
	$myimage->Height =  "75";
	$myimage->Resize = "true";
	$myimage->ResizeScale = "100";
	$myimage->Position = "center";
	$myimage->Compression = 80;
	if ($myimage->SaveImageAs($folderInmuebles."100_75_".$imagen)) {
		$ObjInmuebles->updateImagen($inmueble, $imagen, $db);
	}

}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>SIC</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" href="css/styles.css" type="text/css" media="all">
    
    <?php
				include ("inc_js.php");
				?>
    
    
	<link type="text/css" rel="stylesheet"
	href="js/wizard/css/jquery.stepy.css" />
<script type="text/javascript" src="js/wizard/js/jquery.stepy.js"></script>

<link href="js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/uploadify/swfobject.js"></script>
<script type="text/javascript"
	src="js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>

<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/validation/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>



<script>
	$(function() {		
		
		$('#newSic').stepy({
					back: function(index) {
						//alert('Going to step ' + index + '...');
					}, next: function(index) {
						//alert('Going to step ' + index + '...');
						if(index==4){
							var dire=$("#calle").attr("value") + " " + $("#numero").attr("value") + " <?php
							echo ADDR;
							?>";
							$("#address").attr("value",dire);
								if (map == undefined){
									initialize();
								}
								codeAddress();
								
							}
					}, finish: function(index) {
						//alert('Finishing on step ' + index + '...');
					},
					backLabel:	'Anterior',
					block:		true,
					errorImage:	true,
					nextLabel:	'Siguiente',
					titleClick:	true,
					validate:	true
				});
				
				$('#file_upload').uploadify({
				
		'fileExt'        : '*.jpg;*.gif;*.png',
  		'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
        'uploader'  : 'js/uploadify/uploadify.swf',
        'script'    : 'js/uploadify/uploadify-imagenesinmuebles.php',
        'folder'    : '../upload/inmuebles/',
		'cancelImg'   : 'js/uploadify/cancel.png',
		'buttonText'  : 'Cargar imagenes',
		'multi'          : true,
		'auto'      : true,
		'onSelect': function() {
			$('#file_upload').uploadifySettings('scriptData',{'inmueble':'<?php
			echo $id;
			?>'});			
		},
		'onAllComplete': function() {
			var poststr="inmueble=" + encodeURI('<?php
			echo $id;
			?>');
			$.ajax({ type: "POST", url: 'ajax/ajax_getimagesinmueble.php',data: poststr, success: 
				function(html){
					$("#gallery").html(html).hide();
					$("#gallery").addClass("contentimg");
					$("#gallery").fadeIn('slow');
  				}
			});
		}
      	});
				
		
	var opciones= {
		beforeSubmit: showRequest, //funcion que se ejecuta antes de enviar el form
		success: showResponse //funcion que se ejecuta una vez enviado el formulario
		};
		function showRequest(){   
			
			$('#content-wrapper').block({ 
				message: '<img src="images/ajax-loader.gif" /><p>Por favor espere, se está creando el inmueble!!!</p>', 
				css: { border: '4px solid #C30', padding:'10px' } 
			});
			
        };
		function showResponse (){
			$('#top-static-main').fadeOut(500,'linear', function(){$('#msjOk').fadeIn(500, function(){$('#content-wrapper').unblock();});});
		};
	$('#newSic').validate({
					submitHandler: function(form) {	
						jQuery(form).ajaxSubmit(opciones) ;
					},
					errorPlacement: function(error, element) {
						$('#newSic div.stepy-error').append(error);

					},
					errorContainer: $('#newSic div.stepy-error'),
					errorLabelContainer: $("ol", $('#newSic div.stepy-error')),
		wrapper: 'li',
		meta: "validate",
					
					rules: {
						calle:{required:true},
						operacion:{required:true},
						tipo:{required:true},
						actualidad:{required:true},
						precio:{
							required:true,
							number:true,
							maxlength: 10
						},
						numero:{
							required:true,
							number:true,
							maxlength: 6
						},
						barrio:{required:true},
						descripcion:{required:true}
					},
					messages: {
						calle:{required: 'Ingrese la Calle.'},
						operacion:{required: 'Seleccione el tipo de operación.'},
						tipo:{required: 'Seleccione el tipo de inmueble.'},
						actualidad:{required: 'Seleccione el estado del inmueble.'},
						precio: {required:'Ingrese el precio.', number: 'Ingrese un precio válido.', maxlength:'El precio debe tener 6 cifras como máximo.'},
						numero: {required:'Ingrese el número.', number: 'Ingrese un número válido.', maxlength:'El número debe tener 6 caracteres como máximo.'},
						barrio:{required: 'Seleccione el barrio.'},
						descripcion:{required: 'Ingrese una descripción.'}
						
					}
				});

		
	$('#wrapper').fadeIn(1000);
	$('#pa').hide();
	$('#operacion').change(function(){
		var v=$(this).val();
		$('#pa').hide();
		if(v==1){
			$('#pa').hide();
		}
		if(v==2){
			$('#pa').show();
		}
		if(v==3){
			$('#pa').show();
		}
		

	});
	
	  
	});
	</script>

</head>
<body id="support">
<!--[if IE 5]><div id="ie5" class="ie"><![endif]-->
<!--[if IE 6]><div id="ie6" class="ie"><![endif]-->
<!--[if IE 7]><div id="ie7" class="ie"><![endif]-->
<div id="wrapper" style="display: none;">
<?php
include ("inc_menu.php");
?>
	<div id="content-wrapper">
<div id="content">
<div class="content-top"></div>
<div class="content">﻿
<div id="top-static">
<div id="top-static-header">
<h1>Nuevo Inmueble</h1>
<p class="intro">Agregue su inmueble en 4 pasos.</p>
</div>
<div id="msjOk" style="display: none">
<h2>El inmueble se genero correctamente.</h2>
<p>Los datos cargados recientemente del inmueble serán verificados por
el administrador en un plazo de 24hs y estarán disponibles para la
b&uacute;squeda en el sistema VORTICE.</p>
</div>
<div id="top-static-main" style="width: 830px;">
<div id="wizard">
<form id="newSic" name="newSic" action="new_inmueble.php" method="post">

<fieldset title="Paso 1"
	style="border: 0; border-top: 1px solid #039; width: 800px;"><legend
	style="display: none;">Cargue los datos</legend>
<div class="contentstep">
<div style="width: 130px; float: left;"><label>Operación:</label> <select
	name="operacion" id="operacion" style="width: 120px;">
	<option value=""></option>
                        <?php
																								$db = $ObjOperacion->ListOperacion ( $db );
																								while ( $rowOperacion = $db->Row () ) {
																									?>
			          <option value="<?php
																									echo $rowOperacion->id;
																									?>"><?php
																									echo $rowOperacion->nombre;
																									?></option>
          				<?php
																								}
																								?>
                    </select></div>

<div class="contentstepr"><label>Tipo de Inmueble:</label> <select
	name="tipo" id="tipo" style="width: 130px;">
	<option value=""></option>
                        <?php
																								$db = $ObjTipoPropiedad->ListTipoPropiedad ( $db );
																								while ( $rowTipoPropiedad = $db->Row () ) {
																									?>
			          <option value="<?php
																									echo $rowTipoPropiedad->id;
																									?>"><?php
																									echo $rowTipoPropiedad->nombre;
																									?></option>
          				<?php
																								}
																								?>
                    </select></div>
<div class="contentstepr"><label>Estado del Inmueble:</label> <select
	name="actualidad" id="actualidad">
	<option value=""></option>
                        <?php
																								$db = $ObjActualidad->ListActualidad ( $db );
																								while ( $rowActualidad = $db->Row () ) {
																									?>
			          <option value="<?php
																									echo $rowActualidad->id;
																									?>"><?php
																									echo $rowActualidad->nombre;
																									?></option>
          				<?php
																								}
																								?>
                    </select></div>
<div style="width: 110px; float: left;"><label>Moneda:</label> <select
	name="moneda" id="moneda" style="width: 60px;">
                    	<?php
																					echo OPTMONEDA;
																					?>
                    </select></div>
<div class="contentstepr"><label>Precio:</label> <input name="precio"
	type="text" id="precio" value="<?php
	echo $precio;
	?>" size="10"
	autocomplete="off" /></div>
<div id="pa" style="width: 100px; float: right; margin-top: -45px;"><label>Periodo:</label>
<select name="periodoalquiler" id="periodoalquiler" style="width: 80px;">
                    	<?php
																					echo OPTPERIODOALQUILER;
																					?>
                    </select></div>


<div class="contentstepl"><label>Calle:</label> <input name="calle"
	type="text" id="calle" value="<?php
	echo $calle;
	?>"
	style="width: 200px;" autocomplete="off" />&nbsp;(*)</div>
<div class="contentstepr"><label>Número:</label> <input name="numero"
	type="text" id="numero" value="<?php
	echo $numero;
	?>" size="10"
	autocomplete="off" /></div>
<div class="contentstepr"><label>Piso:</label> <input name="piso"
	type="text" id="piso" value="<?php
	echo $piso;
	?>" size="10"
	autocomplete="off" /></div>
<div class="contentstepr"><label>Depto:</label> <input name="depto"
	type="text" id="depto" value="<?php
	echo $depto;
	?>" size="10"
	autocomplete="off" /></div>
<div class="contentstepl"><label>Barrio:</label> <select name="barrio"
	style="width: 200px;" id="barrio">
	<option value=""></option>
						<?php
						$db = $ObjBarrios->ListBarrios ( $db );
						while ( $rowBarrios = $db->Row () ) {
							?>
			          <option value="<?php
							echo $rowBarrios->id;
							?>"><?php
							echo $rowBarrios->nombre;
							?></option>
          				<?php
						}
						?>
			        </select>&nbsp;(*)</div>
<div class="contentstepr"><label>Cant. Habitaciones:</label> <select
	name="habitaciones" id="habitaciones">
	<option value="">Cualquiera</option>
                        <?php
																								echo OPTHABITACIONES;
																								?>			          	
                    </select></div>

<div class="contentstepr"><label>Cant. Baños:</label> <select
	name="banios" id="banios">
	<option value="">Cualquiera</option>
                        <?php
																								echo OPTBANIOS;
																								?>			          	
                    </select></div>

<div class="contentstepr"><label>Mts Cuadrados:</label> <select
	name="sqf" id="sqf">
	<option value="">Cualquiera</option>
                        <?php
																								echo OPTSQF;
																								?>			          	
                    </select></div>
<div class="contentstepr"><label>Año de construcción:</label> <select
	name="antiguedad" id="antiguedad">
	<option value="">Indistinto</option>
                        <?php
																								for($i = date ( "Y" ); $i > OPTANTIGUEDAD; $i --) {
																									?>
                        <option value="<?php
																									echo $i;
																									?>"><?php
																									echo $i;
																									?></option>
                        <?php
																								}
																								?>
                    </select></div>


<div class="clearfix"></div>



<div class="clearfix"></div>
<label>Descripción del inmueble:</label> <textarea id="descripcion"
	name="descripcion" style="width: 700px;" rows="4"></textarea></div>

</fieldset>

<fieldset title="Paso 2"
	style="border: 0; border-top: 1px solid #039; width: 800px;"><legend
	style="display: none;">Seleccione los filtros</legend>
<div class="contentstep">
<h2 style="margin-left: 10px;">Catacteristicas</h2>
                    <?php
																				$db = $ObjCaracteristicas->ListCaracteristicas ( $db );
																				while ( $rowCaracteristicas = $db->Row () ) {
																					?>
                        <div class="contentstepr"
	style="text-align: right;"><label><?php
																					echo $rowCaracteristicas->nombre;
																					?><input
	name="caracteristicas[]" id="caracteristicas[]" type="checkbox"
	value="<?php
																					echo $rowCaracteristicas->id;
																					?>"></label></div>
          				<?php
																				}
																				?>
                        <div class="clearfix"></div>
<h2 style="margin-left: 10px;">Ambientes</h2>
                    <?php
																				$db = $ObjAmbientes->ListAmbientes ( $db );
																				while ( $rowAmbientes = $db->Row () ) {
																					?>
                        <div class="contentstepr"
	style="text-align: right;"><label><?php
																					echo $rowAmbientes->nombre;
																					?><input
	name="ambientes[]" id="ambientes[]" type="checkbox"
	value="<?php
																					echo $rowAmbientes->id;
																					?>"></label></div>
          				<?php
																				}
																				?>
                        <div class="clearfix"></div>
<h2 style="margin-left: 10px;">Perfiles</h2>
                    <?php
																				$db = $ObjPerfiles->ListPerfiles ( $db );
																				while ( $rowPerfiles = $db->Row () ) {
																					?>
                        <div class="contentstepr"
	style="text-align: right;"><label><?php
																					echo $rowPerfiles->nombre;
																					?><input
	name="perfiles[]" id="perfiles[]" type="checkbox"
	value="<?php
																					echo $rowPerfiles->id;
																					?>"></label></div>
          				<?php
																				}
																				?>
                        <div class="clearfix"></div>
<h2 style="margin-left: 10px;">Agentes</h2>
                    <?php
																				$db = $ObjAgentes->ListAgentesInmobiliariasPagination ( $_SESSION ["idSIC"], "", $db, "" );
																				while ( $rowAgentes = $db->Row () ) {
																					?>
                        <div class="contentstepr"
	style="text-align: right;"><label><?php
																					echo $rowAgentes->nombre . ", " . $rowAgentes->apellido;
																					?><input
	name="agentes[]" id="agentes[]" type="checkbox"
	value="<?php
																					echo $rowAgentes->id;
																					?>"></label></div>
          				<?php
																				}
																				?>
                    
                    </div>
</fieldset>

<fieldset title="Paso 3"
	style="border: 0; border-top: 1px solid #039; width: 800px;"><legend
	style="display: none;">Agregue imagenes</legend>
<div class="contentstep">
<h2 style="margin-left: 10px;">Galeria de Imagenes</h2>



<div id="gallery"></div>

<div class="clearfix"></div>
<div class="contentstepl" style="margin-left: 10px;"><input
	id="file_upload" name="file_upload" type="file" /></div>
</div>
</fieldset>

<fieldset title="Paso 4"
	style="border: 0; border-top: 1px solid #039; width: 800px;">
                <?php
																include ("inc_gmaps/inc_new.php");
																?>
                		<input type="hidden" id="zoom" name="zoom"
	value="<?php
	echo $zoom;
	?>"> <input type="hidden" id="lat" name="lat"
	value="<?php
	echo $lat;
	?>"> <input type="hidden" id="long" name="long"
	value="<?php
	echo $long;
	?>"> <legend style="display: none;">Seleccione
la ubicación</legend> <input type="text" id="address" readonly disabled
	style="background: none; border: none; font-size: 16px; width: 500px;" />
<div class="contentstep">
<div id="map_canvas"
	style="border: 4px solid #ccc; width: 720px; height: 400px; margin-top: 20px; margin-left: 20px;"></div>

<div class="clearfix"></div>
</div>
</fieldset>
<input type="hidden" name="action" id="action" value="newInmueble" /> <input
	type="hidden" name="id" id="id" value="<?php
	echo $id;
	?>" /> <input
	type="submit" class="finish" value="Finalizar" /></form>
</div>
</div>
<!-- /main --></div>
<!-- top-static --></div>
<!-- class-content--></div>
<!-- id-content --></div>
<!-- content-wrapper -->
<?php
include ("inc_footer.php");
?>
</div>
<!-- wrapper -->
</body>
</html>