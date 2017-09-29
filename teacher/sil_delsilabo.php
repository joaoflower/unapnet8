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
		$_SESSION['sSilaend_ing'] = 'F';
		$vCont = 1;
		$bDatos = TRUE;
		if(fFechad(fFecha()) == '10/03/2008')
		{
			$bDatos = TRUE;
			$_SESSION['sSilaend_ing'] = 'T';
		}

		$tSilabo = "silabo".$_SESSION['sSilaano_aca'];

		$vQuery = "delete from $tSilabo ";
		$vQuery .= "where pln_est = '{$_SESSION['sSilapln_est']}' and cod_cur = '{$_SESSION['sSilacod_cur']}' and ";
		$vQuery .= "sec_gru = '{$_SESSION['sSilasec_gru']}' and mod_mat = '{$_SESSION['sSilamod_mat']}' and ";
		$vQuery .= "cod_car = '{$_SESSION['sSilacod_car']}' and ano_aca = '{$_SESSION['sSilaano_aca']}' and ";
		$vQuery .= "per_aca = '{$_SESSION['sSilaper_aca']}' and cod_prf = '{$_SESSION['sUsercod_usu']}' ";
		
		$cResult = fInupde2($vQuery);
	
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
		include "sil_viewcursosdata.php";
	}
?>
