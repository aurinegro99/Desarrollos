<html>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />

<html>
<head>
	<title>Sistema Control An�lisis Aceite SCAA  Komatsu Chile S.A.</title>
<style>
/* CoolMenus 4 - default styles - do not edit */
.clCMAbs{position:absolute; visibility:hidden; left:0; top:0}
/* CoolMenus 4 - default styles - end */
  
/*Style for the background-bar*/
.clBar{position:absolute; width:10; height:10; background-color:Navy; layer-background-color:Navy; visibility:hidden}

/*Styles for level 0*/
.clLevel0,.clLevel0over{position:absolute; padding:2px; font-family:tahoma,arial,helvetica; font-size:12px; font-weight:bold}
.clLevel0{background-color:Navy; layer-background-color:Navy; color:white;}
.clLevel0over{background-color:#336699; layer-background-color:#336699; color:Yellow; cursor:pointer; cursor:hand; }
.clLevel0border{position:absolute; visibility:hidden; background-color:#006699; layer-background-color:#006699}

/*Styles for level 1*/
.clLevel1, .clLevel1over{position:absolute; padding:2px; font-family:tahoma, arial,helvetica; font-size:11px; font-weight:bold}
.clLevel1{background-color:Navy; layer-background-color:Navy; color:white;}
.clLevel1over{background-color:#336699; layer-background-color:#336699; color:Yellow; cursor:pointer; cursor:hand; }
.clLevel1border{position:absolute; visibility:hidden; background-color:#006699; layer-background-color:#006699}

/*Styles for level 2*/
.clLevel2, .clLevel2over{position:absolute; padding:2px; font-family:tahoma,arial,helvetica; font-size:10px; font-weight:bold}
.clLevel2{background-color:Navy; layer-background-color:Navy; color:white;}
.clLevel2over{background-color:#0099cc; layer-background-color:#0099cc; color:Yellow; cursor:pointer; cursor:hand; }
.clLevel2border{position:absolute; visibility:hidden; background-color:#006699; layer-background-color:#006699}
</style>
<script language="JavaScript1.2" src="js/coolmenus4.js">
/*****************************************************************************
Copyright (c) 2001 Thomas Brattli (webmaster@dhtmlcentral.com)

DHTML coolMenus - Get it at coolmenus.dhtmlcentral.com
Version 4.0_beta
This script can be used freely as long as all copyright messages are
intact.

Extra info - Coolmenus reference/help - Extra links to help files **** 
CSS help: http://coolmenus.dhtmlcentral.com/projects/coolmenus/reference.asp?m=37
General: http://coolmenus.dhtmlcentral.com/reference.asp?m=35
Menu properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=47
Level properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=48
Background bar properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=49
Item properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=50
******************************************************************************/
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script>

/*** 
This is the menu creation code - place it right after you body tag
Feel free to add this to a stand-alone js file and link it to your page.
**/

//Menu object creation
oCMenu=new makeCM("oCMenu") //Making the menu object. Argument: menuname

oCMenu.frames = 0

//Menu properties   
oCMenu.pxBetween=30
oCMenu.fromLeft=20 
oCMenu.fromTop=90   
oCMenu.rows=1 
oCMenu.menuPlacement="center"
                                                             
oCMenu.offlineRoot="file:///C|/Inetpub/wwwroot/dhtmlcentral/projects/coolmenus/examples/" 
oCMenu.onlineRoot="/scaa/komatsu/" 
oCMenu.resizeCheck=1 
oCMenu.wait=1000 
oCMenu.fillImg="cm_fill.gif"
oCMenu.zIndex=0

//Background bar properties
oCMenu.useBar=1
oCMenu.barWidth="760"
oCMenu.barHeight="menu" 
oCMenu.barClass="clBar"
oCMenu.barX=130 
oCMenu.barY=90
oCMenu.barBorderX=0
oCMenu.barBorderY=0
oCMenu.barBorderClass=""

//Level properties - ALL properties have to be spesified in level 0
oCMenu.level[0]=new cm_makeLevel() //Add this for each new level
oCMenu.level[0].width=110
oCMenu.level[0].height=25 
oCMenu.level[0].regClass="clLevel0"
oCMenu.level[0].overClass="clLevel0over"
oCMenu.level[0].borderX=1
oCMenu.level[0].borderY=1
oCMenu.level[0].borderClass="clLevel0border"
oCMenu.level[0].offsetX=0
oCMenu.level[0].offsetY=0
oCMenu.level[0].rows=0
oCMenu.level[0].arrow=0
oCMenu.level[0].arrowWidth=0
oCMenu.level[0].arrowHeight=0
oCMenu.level[0].align="bottom"

//EXAMPLE SUB LEVEL[1] PROPERTIES - You have to specify the properties you want different from LEVEL[0] - If you want all items to look the same just remove this
oCMenu.level[1]=new cm_makeLevel() //Add this for each new level (adding one to the number)
oCMenu.level[1].width=oCMenu.level[0].width-2
oCMenu.level[1].height=22
oCMenu.level[1].regClass="clLevel1"
oCMenu.level[1].overClass="clLevel1over"
oCMenu.level[1].borderX=1
oCMenu.level[1].borderY=1
oCMenu.level[1].align="right" 
oCMenu.level[1].offsetX=-(oCMenu.level[0].width-2)/2+20
oCMenu.level[1].offsetY=0
oCMenu.level[1].borderClass="clLevel1border"


//EXAMPLE SUB LEVEL[2] PROPERTIES - You have to spesify the properties you want different from LEVEL[1] OR LEVEL[0] - If you want all items to look the same just remove this
oCMenu.level[2]=new cm_makeLevel() //Add this for each new level (adding one to the number)
oCMenu.level[2].width=150
oCMenu.level[2].height=20
oCMenu.level[2].offsetX=0
oCMenu.level[2].offsetY=0
oCMenu.level[2].regClass="clLevel2"
oCMenu.level[2].overClass="clLevel2over"
oCMenu.level[2].borderClass="clLevel2border"


/******************************************
Menu item creation:
myCoolMenu.makeMenu(name, parent_name, text, link, target, width, height, regImage, overImage, regClass, overClass , align, rows, nolink, onclick, onmouseover, onmouseout) 
*************************************/
oCMenu.makeMenu('top0','','&nbsp;Mantenci�n','','',160,0)
  oCMenu.makeMenu('sub00','top0','Configuraci�n Maestros','','',160,0)
    oCMenu.makeMenu('sub001','sub00','Datos Generales','','',160,0)
        oCMenu.makeMenu('sub0001','sub001','- Paises','paises_new.php','',160,0)
     	oCMenu.makeMenu('sub0002','sub001','- Tipo Equipo','tipo_equipo.php','',160,0)
	    oCMenu.makeMenu('sub0003','sub001','- Componentes','componentes.php','',160,0)
	    oCMenu.makeMenu('sub0004','sub001','- Posiciones','posiciones.php','',160,0) 
    oCMenu.makeMenu('sub002','sub00','Datos Especificos','','',160,0)
		oCMenu.makeMenu('sub0005','sub002','- Compa�ias','companias.php','',160,0)
     	oCMenu.makeMenu('sub0006','sub002','- Clientes','clientes.php','',160,0)
	    oCMenu.makeMenu('sub0007','sub002','- Faenas','faenas.php','',160,0)
	    oCMenu.makeMenu('sub0008','sub002','- Modelo Equipos','modelos.php','',160,0) 
		oCMenu.makeMenu('sub0009','sub002','- Equipos','equipos.php','',160,0) 
	oCMenu.makeMenu('sub003','sub00','Asociaci�n Maestros','','',160,0)
		oCMenu.makeMenu('sub0010','sub003','- Componente/Modelo','componentemodelo.php','',160,0)
     	oCMenu.makeMenu('sub0011','sub003','- Modelos x Faena','modelofaena.php','',160,0)
	    oCMenu.makeMenu('sub0012','sub003','- Equipos x Faena','equiposfaena.php','',160,0)
	   
		
  oCMenu.makeMenu('sub01','top0','Gesti�n Usuario','','',160,0)
  oCMenu.makeMenu('sub02','top0','Configuraci�n SCAA','','',160,0)
    oCMenu.makeMenu('sub021','sub02','Datos Generales','','',160,0)
	    oCMenu.makeMenu('sub00211','sub021','- Maestro Elementos An�lisis','elementos.php','',175,0)
		oCMenu.makeMenu('sub00212','sub021','- Laboratorios An�lisis','laboratorios.php','',175,0)
		oCMenu.makeMenu('sub00213','sub021','- Maestro Aceites','aceites.php','',175,0)
		oCMenu.makeMenu('sub00214','sub021','- Unidades Medida Laboratorios','medidas_laboratorio.php','',175,0)
		oCMenu.makeMenu('sub00215','sub021','- Flotas Faena','paises_new.php','',175,0)
	oCMenu.makeMenu('sub022','sub02','Asociaci�n Datos SCAA','','',160,0)
	    oCMenu.makeMenu('sub00221','sub022','- Laboratorios x Faena','paises_new.php','',190,0)
		oCMenu.makeMenu('sub00222','sub022','- Componentes x Aceite','paises_new.php','',190,0)
		oCMenu.makeMenu('sub00223','sub022','- Componentes x Elemento An�lisis','paises_new.php','',190,0)
		oCMenu.makeMenu('sub00224','sub022','- Criterios x Faena','paises_new.php','',190,0)
		oCMenu.makeMenu('sub00225','sub022','- Asignar Equipos a Flotas','paises_new.php','',190,0)
	
oCMenu.makeMenu('top1','','&nbsp;Scripts','/scripts/index.asp')
	oCMenu.makeMenu('sub10','top1','New scripts','/scripts/index.asp?show=new')
	oCMenu.makeMenu('sub11','top1','All scripts','/scripts/index.asp?show=all')
	oCMenu.makeMenu('sub12','top1','Popular scripts','/scripts/index.asp?show=pop')
	
oCMenu.makeMenu('top2','','&nbsp;Articles','/articles/index.asp')
	oCMenu.makeMenu('sub21','top2','Tutorials','/tutorials/index.asp')
		oCMenu.makeMenu('sub210','sub21','New tutorials','/tutorials/index.asp')
		oCMenu.makeMenu('sub211','sub21','Tutorials archive','/tutorials/archive.asp')
	oCMenu.makeMenu('sub22','top2','Other articles','/articles/index.asp')
		oCMenu.makeMenu('sub220','sub22','New articles','/articles/index.asp?show=new')
		oCMenu.makeMenu('sub221','sub22','Article archive','/articles/archive.asp')

oCMenu.makeMenu('top3','','&nbsp;Forums','http://www.sdf.sdf.sdf/')
	oCMenu.makeMenu('sub30','top3','General','/forums/forum.asp?FORUM_ID=6&CAT_ID=1&Forum_Title=General+DHTML+issues')
	oCMenu.makeMenu('sub31','top3','Scripts','/forums/forum.asp?FORUM_ID=4&CAT_ID=1&Forum_Title=DHTML+Scripts')
	oCMenu.makeMenu('sub32','top3','Crossbrowser','/forums/forum.asp?FORUM_ID=3&CAT_ID=1&Forum_Title=Crossbrowser+DHTML')
	oCMenu.makeMenu('sub33','top3','CoolMenus','/forums/forum.asp?FORUM_ID=2&CAT_ID=1&Forum_Title=CoolMenus')
	oCMenu.makeMenu('sub34','top3','dhtmlcentral.com','/forums/forum.asp?FORUM_ID=5&CAT_ID=1&Forum_Title=dhtmlcentral%2Ecom')
	oCMenu.makeMenu('sub35','top3','Cool sites','/forums/forum.asp?FORUM_ID=1&CAT_ID=1&Forum_Title=Cool+sites')

oCMenu.makeMenu('top5','','&nbsp;CoolMenus','mailto:test.html')
	oCMenu.makeMenu('sub50','top5','Examples','/coolmenus/examples.asp')
		oCMenu.makeMenu('sub500','sub50','With frames','/coolmenus/examples.asp?show=with')
		oCMenu.makeMenu('sub501','sub50','Without frames','/coolmenus/examples.asp?show=without')
	oCMenu.makeMenu('sub51','top5','Download','/coolmenus/download.asp')
		oCMenu.makeMenu('sub510','sub51','Download the source code to this menu','/coolmenus/download.asp','',150,40)
	oCMenu.makeMenu('sub52','top5','Tutorial','/coolmenus/tutorial.asp')
		oCMenu.makeMenu('sub520','sub52','Learn how to set up the menu','/coolmenus/tutorial.asp','',150,40)
	oCMenu.makeMenu('sub53','top5','MenuMaker','','',0,0,'','','','','','','','window.open("/coolmenus/maker/","","width=800,height=600")')
		oCMenu.makeMenu('sub530','sub53','Use the menuMaker to make the menu code for you','','',150,40,'','','','','','','','window.open("/coolmenus/maker/","","width=800,height=600")')
	oCMenu.makeMenu('sub54','top5','FAQ','/coolmenus/faq.asp')
		oCMenu.makeMenu('sub540','sub54','Frequently asked questions','coolmenus/faq.asp','',150,40)
	oCMenu.makeMenu('sub55','top5','Help forum','/forums/forum.asp?FORUM_ID=2&CAT_ID=1&Forum_Title=CoolMenus')
		oCMenu.makeMenu('sub550','sub55','Go to this forum and post you problems or suggestions regarding the CoolMenus','/forum/forum.asp?forum_id=2','',150,40)

//Leave this line - it constructs the menu
oCMenu.construct()		



</script>

</body>




<body>

<table width=760 border=0 align="center">
<tr>
<td>
<img src="diseno/header-1.gif">
</td>
</tr>

<tr>
</table>
<br>
<br>
<table width="760" height="250" border=0 align="center">
<tr>
<td valign="top">

