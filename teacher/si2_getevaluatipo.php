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
	include "../include/funcoption.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		$tSilaeva = "silaeva".$_SESSION['sSilaano_aca'];	

		if(!empty($_POST['rIns_upd']) and !empty($_POST['rUni_pro']) and !empty($_POST['rTip_eva']) and !empty($_POST['rFch_eva']))
		{
			$_SESSION["sSilaiut_eva"] = $_POST['rIns_upd'];
			$_SESSION["sSilatip_eva"] = $_POST['rUni_pro'].$_POST['rTip_eva'].$_POST['rFch_eva'];
		
			$vQuery = "select uni_pro, tip_eva, des_eva, fch_eva, por_eva from $tSilaeva ";
			$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and ";
			$vQuery .= "cod_cur = '{$_SESSION['sSilacod_cur']}' and sec_gru = '{$_SESSION['sSilasec_gru']}' and ";
			$vQuery .= "mod_mat = '{$_SESSION['sSilamod_mat']}' and cod_car = '{$_SESSION['sSilacod_car']}' and ";
			$vQuery .= "ano_aca = '{$_SESSION['sSilaano_aca']}' and per_aca = '{$_SESSION['sSilaper_aca']}' and ";
			$vQuery .= "uni_pro = '{$_POST['rUni_pro']}' and tip_eva = '{$_POST['rTip_eva']}' and ";
			$vQuery .= "fch_eva = '{$_POST['rFch_eva']}' ";
		
			$cResult = fQuery($vQuery);
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
		include "si2_getevaluatipodata.php";
	}
?>