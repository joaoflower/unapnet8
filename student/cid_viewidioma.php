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
		if(!empty($_POST['rCodigo']))
		{
			$_SESSION['sCidano'] = '2010';
			$_SESSION['sCidmes'] = '01';
			$_SESSION['sCidopen'] = FALSE;			// Cambiar para habilitar
			
			$vQuery .= "select des_mes from meses where cod_mes = '{$_SESSION['sCidmes']}' ";
			
			$cResult = fQueryi($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$_SESSION['sCiddes_mes'] = $aResult['des_mes'];
			}
			
			$_SESSION['sCidnum_mat'] = $_POST['rCodigo'];
			
			$vQuery = "select es.cod_esp, esp.des_esp, esp.dur_esp ";
			$vQuery .= "from estudiantes es left join especialidades esp on es.cod_esp = esp.cod_esp ";
			$vQuery .= "where codigo = '{$_SESSION['sCidnum_mat']}' ";
			
			$cResult = fQueryi($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{
				$_SESSION['sCidcod_esp'] = $aResult['cod_esp'];
				$_SESSION['sCiddes_esp'] = $aResult['des_esp'];
				$_SESSION['sCiddur_esp'] = $aResult['dur_esp'];
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
		<table width="750" border="0" cellpadding="0" cellspacing="0" id="tcontent">
		  <tr id="trcontent">
			<td width="90" valign="top" id="tdsubmenu">
			  <div id="dsubmenu">
					<div class="dcelmenu"><a href="" onClick="iclicknotas(); return false;" class="inotacid" title="Notas">Notas</a></div>
					<div class="dcelmenu"><a href="" onClick="iclickmatris(); return false;" class="imatriscid" title="Matr&iacute;culas">Matr&iacute;culas</a></div>
					<div class="dcelmenu"><a href="" onClick="iclickplan(); return false;" class="iplancid"title="Plan de estudio">Plan Estudio</a></div>
					<div class="dcelmenu"><a href="" onClick="iclickmatricular(); return false;" class="imatricid"title="Matricular">Matricular</a></div>
			  </div></td>
			<td valign="top" id="tdsubcontent2">
				<div id="dsubcontent2">
					<center>
					  	Centro de Idiomas - UNA - Puno<br />
						Idioma: <strong><?=$_SESSION['sCiddes_esp']?></strong>
					</center>
				</div></td>
		  </tr>
		</table>    

<?		
	}
?>
