<?php
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	include "../include/funcoption.php";
	
	if(fsafetylogin())
	{
		$_SESSION['sSilaupload'] = FALSE;
	}
	else
	{
		$_SESSION['sIni'] = "";
		header("Location:../index.php");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/frame.css">
<link rel="stylesheet" href="../css/framelogin.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/calendar-green.css">
<title>Un@p.Net&reg; - Sistema Acad&eacute;mico via Web - UNA - Puno</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../js/ggw3.js"></script>
<script language="JavaScript" src="../js/function.js"></script>
<script language="JavaScript" src="../js/teacher.js"></script>
<script language="JavaScript" src="../js/calendar.js"></script>
<script language="JavaScript" src="../js/calendar-es.js"></script>
<script language="JavaScript">
	function enfocar()
	{
		maximizar();
	}

</script>
<SCRIPT type=text/javascript>
	var oldLink = null;

	function setActiveStyleSheet(link, title) 
	{
  		var i, a, main;
  		for(i=0; (a = document.getElementsByTagName("link")[i]); i++) 
		{
    		if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) 
			{
      			a.disabled = true;
      			if(a.getAttribute("title") == title) a.disabled = false;
    		}
  		}
  		if (oldLink) oldLink.style.fontWeight = 'normal';
  		oldLink = link;
		link.style.fontWeight = 'bold';
		return false;
	}

	function selected(cal, date) 
	{
  		cal.sel.value = date; 
  		if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
		cal.callCloseHandler();
	}

	function closeHandler(cal) 
	{
  		cal.hide();                        
	//  cal.destroy();
  		_dynarch_popupCalendar = null;
	}

	function showCalendar(id, format, showsTime, showsOtherMonths) 
	{
  		var el = document.getElementById(id);
  		if (_dynarch_popupCalendar != null) 
		{
    		_dynarch_popupCalendar.hide();                
  		} 
		else 
		{
    		var cal = new Calendar(1, null, selected, closeHandler);
    		if (typeof showsTime == "string") 
			{
      			cal.showsTime = true;
      			cal.time24 = (showsTime == "24");
    		}
    		if (showsOtherMonths) 
			{
      			cal.showsOtherMonths = true;
    		}
    		_dynarch_popupCalendar = cal;                 
    		cal.setRange(2007, 2009);        
    		cal.create();
  		}
  		_dynarch_popupCalendar.setDateFormat(format);  
  		_dynarch_popupCalendar.parseDate(el.value);    
  		_dynarch_popupCalendar.sel = el;               

  		_dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  		return false;
	}

	var MINUTE = 60 * 1000;
	var HOUR = 60 * MINUTE;
	var DAY = 24 * HOUR;
	var WEEK = 7 * DAY;

	function isDisabled(date) 
	{
  		var today = new Date();
  		return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
	}

	function flatSelected(cal, date) 
	{
  		var el = document.getElementById("preview");
  		el.innerHTML = date;
	}

	function showFlatCalendar() 
	{
  		var parent = document.getElementById("display");
	  	var cal = new Calendar(0, null, flatSelected);
		cal.weekNumbers = false;

  		cal.setDisabledHandler(isDisabled);
  		cal.setDateFormat("%A, %B %e");
  		cal.create(parent);
  		cal.show();
	}
</SCRIPT>
</head>

<body onLoad="enfocar();">
	<center>
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<? include "../include/header1.php"; ?>
			<? include "../include/menu1.php"; ?>
			
			<div id="dcontent">
				<table width="770" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tcontent">
				  <tr id="trcontent">
					
					<td valign="top" id="tdsubcontent"><div id="dsubcontent">
                      <center>
                        Un@p.Net&reg; - Sistema Acad&eacute;mico via Web - UNA - Puno <br>
                        <br>
                        <!-- <span class="wordi"><strong>EL INGRESO DE NOTAS V&Iacute;A INTERNET ES A PARTIR DEL <br>
                        DEL 26 AL 30 DE ENERO DEL 2009 Y LA IMPRESI&Oacute;N DE ACTAS ES<br>
                        EN EL PRIMER PISO DE LA OFICINA DE TECNOLOG&Iacute;A INFORM&Aacute;TICA
                        </strong></span> -->
<span class="wordi"><strong>COMUNICADO<br>
<br>
<!--POR DISPOSICI&Oacute;N DE VICERRECTORADO ACAD&Eacute;MICO:<br>
SEGUN MEMORANDO CIRCULAR NRO 083-2009-VRACAD-UNA, <br>
SE DISPONE QUE:
<br>
<br>
</strong>EL INGRESO DE NOTAS <strong>REGULARES</strong> V&Iacute;A INTERNET, IMPRESION DE ACTAS Y <br>
ENTREGA DE ACTAS FIRMADAS ES HASTA EL<strong> 14 DE AGOSTO DEL 2009.<br>
<br>
</strong>EL INGRESO DE NOTAS DE <strong>REEVALUACI&Oacute;N</strong>, IMPRESION DE ACTAS Y <br>
ENTREGA DE ACTAS FIRMADAS ES DEL<strong> 17 AL 21 DE AGOSTO DEL 2009 <br>
<br> -->
</strong></span>

<span class="wordi"><strong>
EL INGRESO DE SILABOS INICIA EL LUNES 07 DE SETIEMBRE <br>
  HASTA EL DOMINGO 20 DE SETIEMBRE A HORAS: 11:59 PM<br />
        TODO INGRESO FUERA DE ESTA FECHA NO SE REGISTRAR&Aacute;<br>
</strong></span><br>
<!--<b><a href = "manual_silabo.rar" title = "Manual de Silabo"> Haga Click Aqui para Obtener el MANUAL DEL INGRESO DE SILABO VIA INTERNET</a> </b> 
	<a href = "esquema_silabo.zip" title = "Manual de Silabo">Haga Click Aqui para Obtener el ESQUEMA DE SILABO</a><br>-->

                      <br>
                      <b><a href = "ejemplo_silabo2.zip" title = "Ejemplo de Silabo">Haga Click Aqui para Obtener un EJEMPLO DE SILABO 2009 </a> </b> <b> </b>
                      </center>
				    </div></td>
				  </tr>
				</table>    
			</div>
			<? include "../include/foot1.php"; ?>	
		</td>
	  </tr>
	</table>
	</center>
</body>
</html>
