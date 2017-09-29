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
		$vCont = 1;
		$bDatos = FALSE;
		
		$tSilaok = "silaok".$_SESSION['sSilaano_aca'];	
		$tSilauna = "silauna".$_SESSION['sSilaano_aca'];	
			
		if(!empty($_POST['rAct1']) )
		{			
/*			$_SESSION["sSilaporcap1"] = $_POST['rCnt1'];
			$_SESSION["sSilaporcap2"] = $_POST['rCnt2'];
			$_SESSION["sSilacnt3"] = $_POST['rCnt3'];
			$_SESSION["sSilacnt4"] = $_POST['rCnt4'];*/
			
			/*$vPor_cap = 0;
			for ($ii = 1; $ii <= $_SESSION["sSilacan_una"]; $ii++)
			{
				$vPor_cap = $_POST['rPor_cap'.$ii];
				
			   	$vQuery = "update $tSilauna set por_cap = '{$vPor_cap}' where pln_est = '{$_SESSION['sSilapln_est']}' and ";
				$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
				$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
				$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
				$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' and ord_una = '$ii' ";
				
				if($cSila = fInupde($vQuery))
				{				
					$bDatos = TRUE;
				}			
			}*/
			$vQuery = "update $tSilaok set act1 = '{$_POST['rAct1']}' ";
			
			for($ii = 2; $ii <= $_SESSION["sSilacan_act2"]; $ii++)
			{
				$vAct = $_POST['rAct'.$ii];
				$vQuery .= ", act$ii = '$vAct' ";			
			}
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and  cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "cod_prf = '{$_SESSION['sUsercod_usu']}' ";
			if($cSila = fInupde($vQuery))
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
		<span class="wordi"><strong>EL SILABO HA SIDO GUARDADO DE FORMA CORRECTA ...! <BR></strong></span>
   	<?
		include "si2_viewcursosdata.php";
	}
?>
