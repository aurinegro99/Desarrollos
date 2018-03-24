//©Xara Ltd
if(typeof(loc)=="undefined"||loc==""){var loc="";if(document.body&&document.body.innerHTML){var tt=document.body.innerHTML;var ml=tt.match(/["']([^'"]*)dimpletab.js["']/i);if(ml && ml.length > 1) loc=ml[1];}}

var bd=0
document.write("<style type=\"text/css\">");
document.write("\n<!--\n");
var tr="filter:alpha(opacity=99);-moz-opacity:0.99;";if(IE5) tr="";
document.write(".dimpletab_menu {"+tr+"z-index:999;border-color:#000000;border-style:solid;border-width:"+bd+"px 0px "+bd+"px 0px;background-color:#000066;position:absolute;left:0px;top:0px;visibility:hidden;}");
document.write(".dimpletab_plain, a.dimpletab_plain:link, a.dimpletab_plain:visited{text-align:left;background-color:#000066;color:#ffffff;text-decoration:none;border-color:#000000;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("a.dimpletab_plain:hover, a.dimpletab_plain:active{background-color:#99ccff;color:#000000;text-decoration:none;border-color:#000000;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("a.dimpletab_l:link, a.dimpletab_l:visited{text-align:left;background:#000066 url("+loc+"dimpletab_l.gif) no-repeat right;color:#ffffff;text-decoration:none;border-color:#000000;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("a.dimpletab_l:hover, a.dimpletab_l:active{background:#99ccff url("+loc+"dimpletab_l2.gif) no-repeat right;color: #000000;text-decoration:none;border-color:#000000;border-style:solid;border-width:0px "+bd+"px 0px "+bd+"px;padding:2px 0px 2px 0px;cursor:hand;display:block;font-size:9pt;font-family:Arial, Helvetica, sans-serif;font-weight:bold;}");
document.write("\n-->\n");
document.write("</style>");

var fc=0x000000;
var bc=0x99ccff;
if(typeof(frames)=="undefined"){var frames=6;if(frames>0)animate();}

startMainMenu("",0,0,2,0,0)
mainMenuItem("dimpletab_b1",".gif",24,165,"javascript:;","","",2,2,"dimpletab_plain");
mainMenuItem("dimpletab_b2",".gif",24,165,"javascript:;","","Links",2,2,"dimpletab_plain");
mainMenuItem("dimpletab_b3",".gif",24,165,"javascript:;","","Downloads",2,2,"dimpletab_plain");
mainMenuItem("dimpletab_b4",".gif",24,165,"index.php","","Home",2,2,"dimpletab_plain");
endMainMenu("",0,0);

startSubmenu("dimpletab_b1_1_1","dimpletab_menu",91);
submenuItem("- Paises","paises_new.php","","dimpletab_plain");
submenuItem("- Tipo Equipos","tipo_equipo.php","","dimpletab_plain");
submenuItem("&copy;Xara","http://www.xara.com/products/MenuMaker/mmtrialmenu.asp","","dimpletab_plain");
endSubmenu("dimpletab_b1_1_1");

startSubmenu("dimpletab_b1_1","dimpletab_menu",126);
mainMenuItem("dimpletab_b1_1_1","Datos Generales",0,0,"javascript:;","","",1,1,"dimpletab_l");
submenuItem("&copy;Xara","http://www.xara.com/products/MenuMaker/mmtrialmenu.asp","","dimpletab_plain");
endSubmenu("dimpletab_b1_1");

startSubmenu("dimpletab_b1","dimpletab_menu",168);
mainMenuItem("dimpletab_b1_1","Configuración Maestros",0,0,"javascript:;","","",1,1,"dimpletab_l");
submenuItem("dato2","javascript:;","","dimpletab_plain");
submenuItem("dato3","javascript:;","","dimpletab_plain");
submenuItem("&copy;Xara","http://www.xara.com/products/MenuMaker/mmtrialmenu.asp","","dimpletab_plain");
endSubmenu("dimpletab_b1");

loc="";
