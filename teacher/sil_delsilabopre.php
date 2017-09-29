<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		if(!empty($_POST['rCod_car']) and !empty($_POST['rPln_est']) and !empty($_POST['rCod_cur']) and  !empty($_POST['rSec_gru']) and !empty($_POST['rMod_mat']))
		{
			$_SESSION["sSilacod_car"] = $_POST['rCod_car'];
			$_SESSION["sSilapln_est"] = $_POST['rPln_est'];
			$_SESSION["sSilacod_cur"] = $_POST['rCod_cur'];
			$_SESSION["sSilasec_gru"] = $_POST['rSec_gru'];
			$_SESSION["sSilamod_mat"] = $_POST['rMod_mat'];
			
			$vQuery = "select cur.nom_cur, esp.esp_nom, sem.sem_des, gru.sec_des, car.car_des ";
			$vQuery .= "from ( ";
			$vQuery .= "   select cod_car, pln_est, cod_cur, nom_cur, cod_esp, sem_anu, '{$_POST['rSec_gru']}' as sec_gru ";
			$vQuery .= "   from curso ";
			$vQuery .= "   where cod_car = '{$_POST['rCod_car']}' and pln_est = '{$_POST['rPln_est']}' and ";
			$vQuery .= "      cod_cur = '{$_POST['rCod_cur']}' ";
			$vQuery .= ") cur ";
			$vQuery .= "left join especial esp on cur.cod_car = esp.cod_car and ";
			$vQuery .= "cur.pln_est = esp.pln_est and cur.cod_esp = esp.cod_esp ";
			$vQuery .= "left join semestre sem on cur.sem_anu = sem.sem_anu ";
			$vQuery .= "left join grupo gru on cur.sec_gru = gru.sec_gru ";
			$vQuery .= "left join carrera car on cur.cod_car = car.cod_car ";
		
			$cResult = fQuery2($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$bDatos = TRUE;
			}
		}		
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
<center>
	
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Eliminar Silabo</th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<span class="wordi">¿ ESTAS SEGURO QUE DESEAS ELIMINAR EL SILABO ?</span>
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
			    <td>Curso : </td>
			    <th colspan="3"><?=$aResult['nom_cur']?></th>
		      </tr>
			  <tr>
			    <td>Menci&oacute;n : </td>
			    <th colspan="3"><?=$aResult['esp_nom']?></th>
		      </tr>
			  <tr>
			    <td>Escuela Prof : </td>
			    <th colspan="3"><?=$aResult['car_des']?></th>
		      </tr>
			  <tr>
			    <td width="75">Semestre :</td>
			    <th width="150"><?=$aResult['sem_des']?></th>
			    <td width="75">Grupo :</td>
			    <th width="150"><?=$aResult['sec_des']?></th>
		      </tr>
			</table>
		
		</td>
		<td background="../images/ven_mediumright.jpg"></td>
	  </tr>
	  <tr>
		<td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
		<td background="../images/ven_bottomcenter.jpg"></td>
		<td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
	  </tr>
	</table>
	
			<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>
					<div class="dboton"><a href="" onClick = "sil_delsilabo(); return false;" class="iok" title="Aceptar">Aceptar</a></div>
					<div class="dboton"><a href="" onClick = "clicksilabo();  return false;" class="icancel" title="Cancelar">Cancelar</a></div>
				</td>
			  </tr>
			</table>
</center>
<?
	}
?>