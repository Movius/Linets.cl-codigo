<div class="push-top">

<?php
	
	if(isset($_POST['pais']))
	{
		$pais = $_POST['pais'];
	}

	$ano_actual = date("Y");

	$mes_actual_real = date('m');
	$ano_actual = date('Y');


	$numero_recall = '';
	if(isset($_POST['numero_recall']))
	{
		$numero_recall = $_POST['numero_recall'];
	}

	if(isset($_POST['mes']))
	{
		$mes_actual = $_POST['mes'];
	}
	if(!isset($_POST['mes']))
	{
		$mes_actual = date('m');
	}

	if(isset($_POST['ano']))
	{
		$ano_actual = $_POST['ano'];
	}
	if(!isset($_POST['ano']))
	{
		$ano_actual = date('Y');
	}


?>

<form action="recall.php?recall=recall_informe" method="post">
	<h4>Buscar</h4>

	<?php if($poder == '2'): ?>	
		<div class="formulario">
			<label>País:</label>
			<select name="pais">
			<option value="#">Selecciona un País</option>

			<?php
			$pais_query = leerDB("SELECT * FROM menu_pais");	
			foreach($pais_query as $pais_query_row)
            {
                $select_pais = '';

                if(isset($_POST['pais']))
                {
                	if(@$pais == $pais_query_row['pais_ID'])
	                {
	                    $select_pais = 'selected="selected"';
	                }	
                }
              
                $pais_nombre = $pais_query_row['pais'];
                
                echo '<option '.$select_pais.' value="'.$pais_query_row['pais_ID'].'">'.$pais_nombre.'</option>';
            }
			?>

			</select>
		</div>
	<?php endif; ?>

	<div class="formulario">
		<label>Mes de Reporte:</label>
		<select name="mes">
			<option value="">Seleccione</option>
			<?php 
				for($i=1;$i<=12;$i++)
				{
					$mes_select = '';
					if(@$mes_actual == $i)
					{
						$mes_select = 'selected="selected"';
					}

					if($i == 1)
					{
						$nombre_mes = 'Enero';
					}
					if($i == 2)
					{
						$nombre_mes = 'Febrero';
					}
					if($i == 3)
					{
						$nombre_mes = 'Marzo';
					}
					if($i == 4)
					{
						$nombre_mes = 'Abril';
					}
					if($i == 5)
					{
						$nombre_mes = 'Mayo';
					}
					if($i == 6)
					{
						$nombre_mes = 'Junio';
					}
					if($i == 7)
					{
						$nombre_mes = 'Julio';
					}
					if($i == 8)
					{
						$nombre_mes = 'Agosto';
					}
					if($i == 9)
					{
						$nombre_mes = 'Septiembre';
					}
					if($i == 10)
					{
						$nombre_mes = 'Octubre';
					}
					if($i == 11)
					{
						$nombre_mes = 'Noviembre';
					}
					if($i == 12)
					{
						$nombre_mes = 'Diciembre';
					}
					if($i < 10)
					{
						$i = '0'.$i;
					}

					echo '<option '.$mes_select.' value="'.$i.'"> '.$nombre_mes.'</option>';
				}
			?>
		</select>
	</div>


	<?php
	$año_de_reporte = date("Y");
	?>

	<div class="formulario">
		<label>Año de Reporte:</label>
		<select name="ano">
			<option value="">Seleccione</option>
			<?php 
				for($i=2017;$i<=$año_de_reporte;$i++)
				{
					$ano_select = '';
					if(@$ano_actual == $i)
					{
						$ano_select = 'selected="selected"';
					}

					echo '<option '.$ano_select.' value="'.$i.'"> '.$i.'</option>';	
				}
			?>
		</select>
	</div>

	<div class="formulario">
		<label>N° Recall:</label>
		<input type="text" name="numero_recall" value="<?php echo @$numero_recall; ?>">
	</div>

	<input class="btn btn-sm btn-default" type="submit" value="Buscar">
</form>

<?php
$buscar_add = '';
$fecha_buscar = '/';




if(isset($_POST['tienda']))
{
	$tienda = $_POST['tienda'];
	if($tienda != '')
	{
		$buscar_add .= ' AND n_1 = '.$tienda;
	}
}

if(isset($_POST['mes']) AND !isset($_POST['ano']))
{
	$mes = $_POST['mes'];
	if($mes != '')
	{
		$fecha_buscar = '/'.$mes.'/';
		
		$buscar_add .= " AND momento_ingreso LIKE '%".$fecha_buscar."%' ";
	}
}

if(!isset($_POST['mes']) AND isset($_POST['ano']))
{
	$ano = $_POST['ano'];
	if($ano != '')
	{
		$fecha_buscar = $ano.'/';
		
		$buscar_add .= " AND momento_ingreso LIKE '%".$fecha_buscar."%' ";
	}
}

if(isset($_POST['mes']) AND isset($_POST['ano']))
{
	$ano = $_POST['ano'];
	$mes = $_POST['mes'];
	if($ano != '' AND $mes != '')
	{
		$fecha_buscar = $ano.'/'.$mes;
		
		$buscar_add .= " AND momento_ingreso LIKE '%".$fecha_buscar."%' ";
	}
}

if(isset($_POST['numero_recall']))
{
	$numero_recall = $_POST['numero_recall'];
	if($numero_recall != '')
	{
		$buscar_add .= " AND recall_ID = '".$numero_recall."'";
	}
}

function interval_date($init,$finish)
	{
	//formateamos las fechas a segundos tipo 1374998435
	$diferencia = strtotime($finish) - strtotime($init);

	//comprobamos el tiempo que ha pasado en segundos entre las dos fechas
	//floor devuelve el número entero anterior, si es 5.7 devuelve 5
	if($diferencia <= 60){
		$tiempo = floor($diferencia) . " segundos";
	}else if($diferencia >= 60 && $diferencia <= 3600){
		$tiempo = floor($diferencia/60) . " minutos'";
	}else if($diferencia >= 3600 && $diferencia <= 86400){
		$tiempo = floor($diferencia/3600) . " horas";
	}else if($diferencia >= 86400 && $diferencia <= 2592000){
		$tiempo = floor($diferencia/86400) . " días";
	}else if($diferencia >= 2592000 && $diferencia <= 31104000){
		$tiempo = floor($diferencia/2592000) . " meses";
	}else if($diferencia >= 31104000){
		$tiempo = floor($diferencia/31104000) . " años";
	}else{
		$tiempo = "error";
	}
	return $tiempo;
	}


$buscar = "SELECT * FROM recall_supermecados WHERE pais = '$pais' ".$buscar_add." ORDER BY recall_ID DESC";


$recall = leerDB($buscar);
?>

<table class="table table-condenced table-bordered">
<tr class="color_tr">
	<td><b>Número</b></td>
	<td><b>Proveedor</b></td>
	<td><b>Fecha Ingreso</b></td>
	<td><b>Tipo Recall</b></td>
	<td><b>Tiempo de Respuesta</b></td>
	<td><b>Ver</b></td>
</tr>

<?php
foreach($recall as $recall_row)
{
	$mostrar = '';
	$productos_noali = $recall_row['productos_noali'];
	$productos_ali = $recall_row['productos_ali'];
	$productos_jumbo = $recall_row['productos_jumbo'];
	$productos_jumboagro = $recall_row['productos_jumboagro'];
	$productos_sisa = $recall_row['productos_sisa'];


	if(@$user_super == 'sisa')
	{
		if($productos_sisa != '')
		{
			$mostrar = 'ok';
		}
	}
	if(@$user_super == 'jumbo')
	{
		if($productos_jumbo != '')
		{
			$mostrar = 'ok';
		}
	}
	if(@$user_super != 'jumbo' and @$user_super != 'sisa')
	{
		$mostrar = 'ok';
	}

	if($mostrar == 'ok')
	{
		echo '<tr>';

		echo '<td>';
		echo $recall_row['recall_ID'];
		echo '</td>';
		
		echo'<td>';

		if($productos_noali != '')
		{
			$proveedor_id = $recall_row['proveedor'];
			$ficha_proveedor = leerDB("SELECT * FROM proveedor WHERE proveedor_ID = '$proveedor_id'");
			foreach($ficha_proveedor as $ficha_proveedor_row)
			{
				echo $ficha_proveedor_row['nombre_fabricante_general'];

			}
		}

		if($productos_ali != '')
		{

			$proveedor_id = $recall_row['proveedor'];
			$ficha_proveedor = leerDB("SELECT * FROM proveedor WHERE proveedor_ID = '$proveedor_id'");
			foreach($ficha_proveedor as $ficha_proveedor_row)
			{
				echo $ficha_proveedor_row['nombre_fabricante_general'];	
			}
		}

		if($productos_jumbo != '')
		{

			$proveedor_rut = $recall_row['proveedor'];
			$ficha_proveedor = leerDB("SELECT * FROM db_jumbo_proveedor WHERE rut_proveedor = '$proveedor_rut'");
			foreach($ficha_proveedor as $ficha_proveedor_row)
			{
				echo $ficha_proveedor_row['nombre'];
			}
		}

		if($productos_jumboagro != '')
		{

			$proveedor_rut = $recall_row['proveedor'];
			$ficha_proveedor = leerDB("SELECT * FROM db_jumbo_proveedor WHERE rut_proveedor = '$proveedor_rut'");
			foreach($ficha_proveedor as $ficha_proveedor_row)
			{
				echo $ficha_proveedor_row['nombre'];
			}
		}


		if($productos_sisa != '')
		{

			$proveedor_rut = $recall_row['proveedor'];
			$ficha_proveedor = leerDB("SELECT * FROM db_sisa_proveedor WHERE rut_proveedor = '$proveedor_rut'");
			foreach($ficha_proveedor as $ficha_proveedor_row)
			{
				echo $ficha_proveedor_row['nombre'];
			}
		}


		
		echo'</td>';
		
		echo '<td>';
		echo $recall_row['momento_ingreso'];
		echo '</td>';
		
		$momento_ingreso = $recall_row['momento_ingreso'];
		$momento_final = $recall_row['momento_final'];
		
		$diferencia = strtotime($momento_ingreso) - strtotime($momento_final);
		
		$color_semaforo = 'rgb(0, 0, 0)';
		
		echo '<td>';
		echo $recall_row['recall'];
		echo '</td>';
		
		echo '<td>';
		echo $momento_final;
		echo '</td>';
		
		echo'<td>';
		echo '<a href="recall.php?id='.$recall_row['recall_ID'].'&recall=recall_informe&segunda_fase=recall_informe_fase"><span class="glyphicon glyphicon-list"></span></a>';
		echo'</td>';
		
		echo'</tr>';
	}

}
?>
</table>
</div>
