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
		
		$vQuery = "update docente set cod_car = '{$_POST['rCod_car']}', tip_doc = '{$_POST['rTip_doc']}', num_doc = '{$_POST['rNum_doc']}',  ";
		$vQuery .= "fch_nac = '{$_POST['rFch_nac']}', sexo = '{$_POST['rSexo']}', est_civ = '{$_POST['rEst_civ']}', ";
		$vQuery .= "direc = '{$_POST['rDirec']}', fono = '{$_POST['rFono']}', celular = '{$_POST['rCelular']}', ";
		$vQuery .= "email = '{$_POST['rOemail']}', dat_upd = '1' ";
		$vQuery .= "where cod_prf = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
				
		$cEstudia = fInupde($vQuery);
		
		$vQuery = "update usudoc set cod_car = '{$_POST['rCod_car']}', oemail = '{$_POST['rOemail']}' ";
		$vQuery .= "where cod_prf = '{$_SESSION['sUsercod_usu']}' and cod_car = '{$_SESSION['sUsercod_car']}' ";
				
		$cEstudia = fInupde($vQuery);
		
		$_SESSION['sUsercod_car'] = $_POST['rCod_car'];
		
		$vQuery = "Select es.tip_doc, td.doc_des, es.sexo, if(es.sexo = '1', 'MASCULINO', 'FEMENINO') as des_sex, ";
		$vQuery .= "es.fch_nac, es.direc, es.fono, es.celular, es.est_civ, ec.est_des, es.cod_nac, ";
		$vQuery .= "es.cod_dep, es.cod_prv, es.cod_dis, ca.car_des ";
		$vQuery .= "from docente es left join tipodoc td on es.tip_doc = td.tip_doc ";
		$vQuery .= "left join estcivil ec on es.est_civ = ec.est_civ ";
		$vQuery .= "left join carrera ca on es.cod_car = ca.cod_car ";
		$vQuery .= "where es.cod_prf = '{$_SESSION['sUsercod_usu']}' and es.cod_car = '{$_SESSION['sUsercod_car']}' ";
		
		$cEstudia = fQuery($vQuery);
		if($aEstudia = mysql_fetch_array($cEstudia))
		{
			$bDatos = TRUE;
			$_SESSION['sUsercar_des'] = $aEstudia['car_des'];
		}

	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		//include "tch_viewmidatadata.php";
		include "act_viewcursos.php";
	}
?>