<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	if(fsafetylogin())
	{
?>
		<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
			    <td width="100">Plan de Est. </td>
			    <th width="350"><select name="rPln_est" id="rPln_est" onchange="sil_viewsemcurgrupln(this.value); return false;">
                  <?=fviewsiplan($_SESSION["sSilacod_car"], $_SESSION["sSilapln_est"])?>
                </select></th>
		      </tr>
			  <tr>
			    <td>Semestre :</td>
			    <th><select name="rSem_anu" id="rSem_anu" onchange="sil_viewsemcurso(this.value); return false;">
                  <?=fviewsisemestre($_SESSION["sSilacod_car"], $_SESSION["sSilapln_est"], $_SESSION["sSilasem_anu"])?>
                </select></th>
		      </tr>
			  <tr >
			    <td >Curso : </td>
			    <th id="dcurso"><select name="rCod_cur" id="rCod_cur" onchange="sil_viewmencion(this.value); return false;">
                  <?=fviewsicurso($_SESSION["sSilacod_car"], $_SESSION["sSilapln_est"], $_SESSION["sSilasem_anu"], $_SESSION["sSilacod_cur"])?>
                </select></th>
			  </tr>
			  <tr >
			    <td >Menci&oacute;n : </td>
			    <th id="dmencion"><?=fNomespcurso($_SESSION["sSilacod_car"], $_SESSION["sSilapln_est"], $_SESSION["sSilacod_cur"])?></th>
	      </tr>
			  <tr>
			    <td>Grupo : </td>
			    <th><select name="rSec_gru" id="rSec_gru">
                  <?=fviewsigrupo($_SESSION["sSilasec_gru"])?>
                </select></th>
		      </tr>
		</table>
<?	
	}
?>