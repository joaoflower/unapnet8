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
		
		$vCont = 1;
		$vCan_not = 0;
		
		$vNum_mat = "";
		$vNot_cur = "";

		if(!empty($_POST['rNum_mat']) and strlen($_POST['rNot_cur']) > 0)
		{
			$vCan_not = strlen($_POST['rNum_mat']) / 8;
			if($vCan_not > 0)
			{
				if($_SESSION["sActatip_not"] == 'e')
				{
					for($ii = 0; $ii < $vCan_not; $ii++)
					{
						$vNum_mat = substr($_POST['rNum_mat'], 8 * $ii, 8);
						$vNot_cur = substr($_POST['rNot_cur'], 3 * $ii, 3);
	
						$vQuery = "update matriculas set escrito = '$vNot_cur' ";
						$vQuery .= "where num_mat = '$vNum_mat' "; //and cod_gpo = '{$_SESSION['sActacod_gpo']}' and ";
						//$vQuery .= "anio = '{$_SESSION['sFrameano_acai']}' and cod_mes = '{$_SESSION['sFramecod_mesi']}' ";
							
						$cResult = fInupdei($vQuery);
					}
				}
				else if($_SESSION["sActatip_not"] == 'o')
				{
					for($ii = 0; $ii < $vCan_not; $ii++)
					{
						$vNum_mat = substr($_POST['rNum_mat'], 8 * $ii, 8);
						$vNot_cur = substr($_POST['rNot_cur'], 3 * $ii, 3);
	
						$vQuery = "update matriculas set oral = '$vNot_cur' ";
						$vQuery .= "where num_mat = '$vNum_mat' "; 
							
						$cResult = fInupdei($vQuery);
					}
				}
			}
			$bDatos = TRUE;
		}
		
		
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{	
		$_SESSION["sActatip_not"] = "";
		$_SESSION["sActaord_not"] = "";
		include "act_viewestunotai.php";
	}
?>