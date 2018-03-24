_menuCloseDelay=100        // The time delay for menus to remain visible on mouse out
_menuOpenDelay=7500000      // The time delay before menus open on mouse over
_subOffsetTop=5              // Sub menu top offset
_subOffsetLeft=-5          // Sub menu left offset


//alert("menu_data");

with(menuStyle=new mm_style())
{
	styleid=5;
	bordercolor="#ffffff";
	borderstyle="solid";
	borderwidth=1;
	fontfamily="Verdana, Tahoma, Arial";
	fontsize="100%";
	fontstyle="bold";
	fontweight="bold";
	offbgcolor="#FFFF99";  //  fondo
	offcolor="#666666";   // letras
	onbgcolor="#000099";
	oncolor="#ffff00";
	padding=3;
	subimage="../img/icono075.gif";
	separatorsize="1";
	separatorcolor="#666666";
	openonclick=1;
	overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color='#000000', Direction=135, Strength=5)";
    outfilter="randomdissolve(duration=0.2)";
}


with(milonic=new menuname("Main Menu")){
style=menuStyle;
top=5;
left=300;
alwaysvisible=1;
orientation="horizontal";

//aI("text=RMMP;url=javascript:enviar('');status=Inicio RMMP;");
aI("text=Mantencion;showmenu=manten;");
aI("text=Ingreso;showmenu=ingreso;");
aI("text=Informes;showmenu=informe;");
aI("text=Otros Procesos;showmenu=otros;");

}


with(milonic=new menuname("otros")){
style=menuStyle;
overflow="scroll";
margin=5;
//aI("text=Genera Outlook Inversiones;url=\\activosv2\\otros\\outlook_inversiones_02.php");
//
//aI("text=Genera Presupuesto Inversiones;url=\\activosv3\\otros\\presupuesto_inversiones.php");
//aI("text=Informe Presupuesto Inversiones;url=\\activosv3\\otros\\informe_presupuesto_inversiones.php");
//aI("text=Informe Outlook Inversiones;url=\\activosv2\\otros\\informe_outlook_inversiones_02.php");

aI("text=Subir Datos Activación;url=\\activosv3\\accesos\\valida_acceso.php?id=401");
aI("text=Subir Datos Compra;url=\\activosv3\\accesos\\valida_acceso.php?id=402");    

}





with(milonic=new menuname("informe")){
style=menuStyle;
overflow="scroll";    
margin=5;
//aI("text=Informe Presupuesto;url=\\pcpweb\\listados\\informe_presupuesto.php;");
//aI("text=Resumen General Inversiones;url=\\activosv2\\consultas\\consulta_general_inversion.php");
aI("text=Detalle Inversión x Faena;url=\\activosv3\\listados\\informe_detalle_compras_faenas.php");
//aI("text=Consulta Activo Fijo;url=\\activosv2\\consultas\\consulta_activo_fijo.php");
//aI("text=Consulta Solicitud;url=\\activosv2\\consultas\\consulta_formulario.php");
//aI("text=Consulta C�digo Inversi�n;url=\\activosv2\\consultas\\consulta_codigo_inversion.php");
//aI("text=Detalle Inversi�n x Periodo;url=\\activosv2\\listados\\detalle_compras_periodo.php");
aI("text=Presupuesto Inversión x Faena;url=\\activosv3\\listados\\informe_presupuesto_inversion.php");
aI("text=Avance Presupuesto;url=\\activosv3\\listados\\informe_avance_presupuesto.php");
//aI("text=Consulta WorkFlow;url=\\activosv2\\consultas\\consulta_workflow.php");




}


with(milonic=new menuname("manten")){
style=menuStyle;
overflow="scroll";
margin=5;

aI("text=Terminar Sesión;url=\\activosv3\\mantencion\\termino_sesion.php");



}






with(milonic=new menuname("ingreso")){
style=menuStyle;
overflow="scroll";
margin=5;

//aI("text=Ingreso Solicitud ;url=\\activosv3\\solicitud\\crear_solicitud_activo.php");

aI("text=Ingreso Solicitud;url=\\activosv3\\accesos\\valida_acceso.php?id=201");

//aI("text=Ingreso Solicitud ;url=\\activosv2\\creacion\\crear_solicitud.php");

aI("text=Genera WorkFlow Aprobación;url=\\activosv3\\accesos\\valida_acceso.php?id=202");
aI("text=Modificar Datos Solicitud;url=\\activosv3\\accesos\\valida_acceso.php?id=203");
//aI("text=Ingresar Activo Fijo;url=\\activosv3\\accesos\\valida_acceso.php?id=204");


}

drawMenus();

