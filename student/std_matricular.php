<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcoption.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	if(fsafetylogin())
	{
		$bDatos = FALSE;
		$bCurso = FALSE;
		
		if($_SESSION['sEstumat_okse'] == TRUE and $_SESSION['sEstumat_ya'] == FALSE)
		{
			if(!empty($_POST['rCod_cur']) and !empty($_POST['rSec_gru']) and !empty($_POST['rCrd_cur']))
			{
				$vCont = 1;				
				
				$vCan_cur = 0;
				$vCod_cur = "";
				$vSec_gru = "";
				$vTot_crd = 0;
				
				$sSelcurso = "";
				$sModcurso = "";
				$sPoscurso = "";
				
				$vCan_cur = strlen($_POST['rCod_cur']) / 3;
				if($vCan_cur > 0)
				{					
				//--------------Verificación de cursos---------------------------------
					$tCurmat = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sEstuano_aca'];
					$tNota = "nota".$_SESSION['sUsercod_car'];
					$tHabicurso = "habicurso".$_SESSION['sFrameano_aca'];
					$tCurmath = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
					
					//------------- Cursos Habiles ------------------------------------------------------
					$sHabicurso = "";
					$vQuery = "select ha.cod_cur, ha.sec_gru, if(isnull(cc.canti), ha.can_vac, ha.can_vac - cc.canti) as vaca ";
					$vQuery .= "from $tHabicurso ha left join ";
					$vQuery .= "(  select pln_est, cod_cur, sec_gru, count(*) as canti ";
					$vQuery .= "   from $tCurmath ";
					$vQuery .= "   where ano_aca = '{$_SESSION['sFrameano_aca']}' and per_aca = '{$_SESSION['sFrameper_aca']}' and ";
					$vQuery .= "         pln_est = '{$_SESSION['sEstupln_est']}' group by pln_est, cod_cur, sec_gru ) cc ";
					$vQuery .= "on ha.pln_est = cc.pln_est and ha.cod_cur = cc.cod_cur and ha.sec_gru = cc.sec_gru ";
					$vQuery .= "where ha.cod_car = '{$_SESSION['sUsercod_car']}' and ha.per_aca = '{$_SESSION['sFrameper_aca']}' and ";
					$vQuery .= "ha.pln_est = '{$_SESSION['sEstupln_est']}' and (ha.can_vac > cc.canti or isnull(cc.canti)) and ";
					$vQuery .= "ha.cod_cur not in ";
					$vQuery .= "(select cod_cur from $tNota ";
					$vQuery .= "where num_mat = '{$_SESSION['sUsercod_usu']}' and pln_est = '{$_SESSION['sEstupln_est']}' and not_cur > 10) ";
					$vQuery .= "order by ha.cod_cur, ha.sec_gru desc ";
					
					$cHabicurso = fQuery($vQuery);	
					while($aHabicurso = mysql_fetch_array($cHabicurso))
					{
						$sHabicurso[$aHabicurso['cod_cur']]['cod_cur'] = TRUE;
						$sHabicurso[$aHabicurso['cod_cur']]['sec_gru'] = $aHabicurso['sec_gru'];
						$sHabicurso[$aHabicurso['cod_cur']]['can_vac'] = $aHabicurso['vaca'];
						$sHabicurso[$aHabicurso['cod_cur'].$aHabicurso['sec_gru']]['cur_gru'] = TRUE;
					}
					//----------------------------------------------------------------------------------
					
					//-----------------Veces que desaprobo los cursos---------
					$vQuery = "Select no.cod_cur, count(*) as veces ";
					$vQuery .= "from $tNota no left join curso cu on ";
					$vQuery .= "no.cod_car = cu.cod_car and no.pln_est = cu.pln_est and no.cod_cur = cu.cod_cur ";
					$vQuery .= "where no.pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "no.num_mat = '{$_SESSION['sUsercod_usu']}' and no.not_cur < 11 and ";
					$vQuery .= "(no.mod_not != '13' and no.mod_not != '08') and ";
					$vQuery .= "(cu.tip_cur = '01' or cu.tip_cur = '03') and ";
					$vQuery .= "(cu.cod_esp = '00' or cu.cod_esp = '{$_SESSION['sEstucod_esp']}') and ";
					$vQuery .= "cu.con_cur = '1' and no.cod_cur not in ";
					$vQuery .= "(Select cod_cur from $tNota where pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) group by cod_cur order by veces desc";
				
					$cResult = fQuery($vQuery);
					while($aResult = mysql_fetch_array($cResult))
						$sModcurso[$aResult['cod_cur']] = fModcurso($aResult['veces']);
	
					//------------------Cursos a matricularse-------------------
					$vQuery = "Select distinct cd.cod_cur, cu.crd_cur, cu.crd_prq ";
					$vQuery .= "from ";
					$vQuery .= "( ";
					$vQuery .= "   (select sr.cod_cur from ";
					$vQuery .= "      (select cod_cur from curso ";
					$vQuery .= "       where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and con_cur='1' and cod_cur not in ";
					$vQuery .= "          (select cod_cur from requ where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}') ";
					$vQuery .= "      ) sr ";
					$vQuery .= "    where sr.cod_cur not in ";
					$vQuery .= "      (Select cod_cur from $tNota where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "       num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) ";
					$vQuery .= "   ) union ";
					$vQuery .= "   (Select tr.cod_cur from ";
					$vQuery .= "      (select re.cod_cur from $tNota no ";
					$vQuery .= "       left join requ re on no.cod_car = re.cod_car and no.pln_est = re.pln_est and ";
					$vQuery .= "          no.cod_cur = re.cur_pre ";
					$vQuery .= "       where no.cod_car = '{$_SESSION['sUsercod_car']}' and no.pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "          no.num_mat = '{$_SESSION['sUsercod_usu']}' and no.not_cur > 10 and not isnull(re.cod_cur) ";
					$vQuery .= "      ) tr ";
					$vQuery .= "    where tr.cod_cur not in ";
					$vQuery .= "    (select cod_cur from requ where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "        cur_pre not in ";
					$vQuery .= "        (select cod_cur from $tNota where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "         num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) ";
					$vQuery .= "    ) and tr.cod_cur not in ";
					$vQuery .= "    (Select cod_cur from $tNota where cod_car = '{$_SESSION['sUsercod_car']}' and pln_est = '{$_SESSION['sEstupln_est']}' and ";
					$vQuery .= "     num_mat = '{$_SESSION['sUsercod_usu']}' and not_cur > 10) ";
					$vQuery .= "   ) ";
					$vQuery .= ") cd ";
					$vQuery .= "left join curso cu on cd.cod_cur = cu.cod_cur ";
					$vQuery .= "where cu.cod_car = '{$_SESSION['sUsercod_car']}' and cu.pln_est = '{$_SESSION['sEstupln_est']}' and cu.con_cur = '1' and ";
					$vQuery .= "      (cu.cod_esp = '00' or cu.cod_esp = '{$_SESSION['sEstucod_esp']}') and cu.crd_prq <= '{$_SESSION['sEstuall_crd']}' ";
					
					$cResult = fQuery($vQuery);
					if(!empty($sHabicurso)) while($aResult = mysql_fetch_array($cResult))
					{
						if($sHabicurso[$aResult['cod_cur']]['cod_cur'] == TRUE)
						{
							$sPoscurso[$aResult['cod_cur']] = $aResult['crd_cur'];
						}
					}
				//---------------------------------------------------------------------
					
					//----------- Comparar Cursos seleccionados con cursos posibles --------
					for($ii = 0; $ii < $vCan_cur; $ii++)
					{
						$vCod_cur = substr($_POST['rCod_cur'], 3 * $ii, 3);
						$vSec_gru = substr($_POST['rSec_gru'], 2 * $ii, 2);
						
						if($sPoscurso[$vCod_cur] > 0)
						{
							if($sHabicurso[$vCod_cur.$vSec_gru]['cur_gru'] == TRUE)
							{
								$sSelcurso[$vCod_cur]['cod_cur'] = $vCod_cur;
								$sSelcurso[$vCod_cur]['sec_gru'] = $vSec_gru;
								$sSelcurso[$vCod_cur]['mod_mat'] = (empty($sModcurso[$vCod_cur])?'01':$sModcurso[$vCod_cur]);
								$vTot_crd += $sPoscurso[$vCod_cur];
								$bCurso = TRUE;
							}
							else
							{
								$bCurso = FALSE;
								break;
							}
						}
						else
						{
							$bCurso = FALSE;
							break;
						}
					}
					if($bCurso == TRUE and $vTot_crd == $_POST['rCrd_cur'] and $vTot_crd <= $_SESSION['sEstumax_crd'])
						$bDatos = TRUE;
					else
						$bDatos = FALSE;
					//---------------------------------------------------------------
				}
			}			
		}
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		$tEstumat = "estumat".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
		$tCurmat = "curmat".$_SESSION['sUsercod_car'].$_SESSION['sFrameano_aca'];
		
		$vQuery = "insert into $tEstumat (num_mat, cod_car, pln_est, niv_est, sec_gru, tur_est, ano_aca, per_aca, cod_esp, mod_mat, ";
		$vQuery .= "fch_mat, cod_usu, num_rcb, obs_est, tot_crd, max_crd, tip_mat) values ";
		$vQuery .= "('{$_SESSION['sUsercod_usu']}', '{$_SESSION['sUsercod_car']}', '{$_SESSION['sEstupln_est']}', ";
		$vQuery .= "'{$_SESSION['sEstusem_anu']}', '01', '1', '{$_SESSION['sFrameano_aca']}', '{$_SESSION['sFrameper_aca']}', ";
		$vQuery .= "'{$_SESSION['sEstucod_esp']}', '{$_SESSION['sEstumod_mat']}', now(), '{$_SESSION['sUsercod_usu']}', ";
		$vQuery .= "'', 'AHORRE TIEMPO Y DINERO, CONSULTE SUS NOTAS, HORARIOS Y REALIZAR SU MATRÍCULA VÍA INTERNET, http://www.unap.edu.pe, MATRICULA VIA INTERNET DESDE: {$_SESSION['sUserip']}', '$vTot_crd', '{$_SESSION['sEstumax_crd']}', '04') ";
		
		$cEstumat = fInupde($vQuery);
		if($cEstumat)
		{
		
			if(!empty($sSelcurso)) foreach($sSelcurso as $vCod_cur => $aCurmat)
			{
				$vQuery = "insert into $tCurmat (num_mat, cod_car, pln_est, cod_cur, sec_gru, tur_est, ano_aca, per_aca, ";
				$vQuery .= "mod_mat, cod_usu, cur_obli) values ";
				$vQuery .= "('{$_SESSION['sUsercod_usu']}', '{$_SESSION['sUsercod_car']}', '{$_SESSION['sEstupln_est']}', ";
				$vQuery .= "'{$aCurmat['cod_cur']}', '{$aCurmat['sec_gru']}', '1', '{$_SESSION['sFrameano_aca']}', ";
				$vQuery .= "'{$_SESSION['sFrameper_aca']}', '{$aCurmat['mod_mat']}', '{$_SESSION['sUsercod_usu']}', '') ";
				
				$cCurmat = fInupde($vQuery);
			}
			
			//------------------------------
			$_SESSION['sEstusem_anu'] = "";
			$_SESSION['sEstusem_des'] = "";
			$_SESSION['sEstumod_mat'] = "";
			$_SESSION['sEstumod_des'] = "";
			
			$_SESSION['sEstumax_crd'] = 0.00;
			$_SESSION['sEstumat_ok'] = FALSE;
			$_SESSION['sEstumat_okse'] = FALSE;
			$_SESSION['sEstumat_deu'] = FALSE;
			$_SESSION['sEstumat_pag'] = FALSE;
			
			$_SESSION['sEstutot_crd'] = 0.00;
			//------------------------------

			$_SESSION['sEstumat_ya'] = TRUE;
?>
<center>
	<span class="wordi"><strong>FELICIDADES, USTED HA REALIZADO SU MATR&Iacute;CULA V&Iacute;A INTERNET. <br />
  APERSONECE A SU COORDINACI&Oacute;N ACAD&Eacute;MICA EN EL PERIODO DE RATIFICACI&Oacute;N<br />
  PARA RECOGER SU FICHA DE MATR&Iacute;CULA.
	</strong></span>
</center>
<?
			
			include "std_viewmatri.php";
						
		}
?>
<?
	}
	else
	{
?>
	<center>
	<span class="wordi"><strong>LA MATR&Iacute;CULA TIENE DATOS INCORRECTOS<br />
	INTENTE DE NUEVO &Oacute;
	<br />
	EL SISTEMA SE CERRARA </strong></span>
	</center>
<?
//		session_unset();
//		header("Location:../index.php");
	}
?>
