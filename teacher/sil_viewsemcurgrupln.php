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
		if(!empty($_POST['rPln_est']))
		{
			$_SESSION["sSilapln_est"] = $_POST['rPln_est'];
			$_SESSION["sSilacod_cur"] = "999";
			$_SESSION["sSilasec_gru"] = "01";
			$_SESSION["sSilamod_mat"] = "01";
			$_SESSION["sSilasem_anu"] = "01";
			$bDatos = TRUE;
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		include "sil_viewsemcurgrudata.php";
	}
?>