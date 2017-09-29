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
		
		$vQuery = "update estudiante set tip_doc = '{$_POST['rTip_doc']}', num_doc = '{$_POST['rNum_doc']}',  ";
		$vQuery .= "fch_nac = '{$_POST['rFch_nac']}', sexo = '{$_POST['rSexo']}', est_civ = '{$_POST['rEst_civ']}', ";
		$vQuery .= "direc = '{$_POST['rDirec']}', fono = '{$_POST['rFono']}', celular = '{$_POST['rCelular']}', ";
		$vQuery .= "email = '{$_POST['rOemail']}' ";
		$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
				
		$cEstudia = fInupde($vQuery);
		
		$vQuery = "update usuest set oemail = '{$_POST['rOemail']}' ";
		$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
				
		$cEstudia = fInupde($vQuery);
		
		$vQuery = "Select es.tip_doc, td.doc_des, es.sexo, if(es.sexo = '1', 'MASCULINO', 'FEMENINO') as des_sex, ";
		$vQuery .= "es.fch_nac, es.direc, es.fono, es.celular, es.est_civ, ec.est_des, es.cod_nac, ";
		$vQuery .= "es.cod_dep, es.cod_prv, es.cod_dis ";
		$vQuery .= "from estudiante es left join tipodoc td on es.tip_doc = td.tip_doc ";
		$vQuery .= "left join estcivil ec on es.est_civ = ec.est_civ ";
		$vQuery .= "where es.num_mat = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
		
		$cEstudia = fQuery($vQuery);
		if($aEstudia = mysql_fetch_array($cEstudia))
		{
			$bDatos = TRUE;
		}

	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		include "std_viewmidatadata.php";
	}
?>