- SmartMenu v1.1 (30 July 1999) cross-browser edition
- Copyright by Constantin Kuznetsov Jr.
- EMail: GoldenFox@bigfoot.com
 
** New futures of SmartMenu v1.1 **
Now SmartMenu works with Netscape Communicator

To install this script, do the following 3 steps:

1) Add the following code inside the <HEAD> section of your page:

<style>
<!--
all.clsMenuItemNS{font: bold x-small Verdana; color: white; text-decoration: none;}
.clsMenuItemIE{text-decoration: none; font: bold xx-small Verdana; color: white; cursor: hand;}
A:hover {color: red;}
-->
</style>


2) Copy and paste the below code into your webpage, RIGHT AFTER the <body> tag 
(proceeding any other tags):

<script language="JavaScript" src="menu.js">
/*
Static Top Menu Script
By Constantin Kuznetsov Jr. (GoldenFox@bigfoot.com) 
Featured on Dynamicdrive.com
For full source code and installation instructions to this script, visit Dynamicdrive.com
*/
</script>
<script language="JavaScript" src="menucontext.js"></script>
<script language="JavaScript">
showToolbar();
</script>
<script language="JavaScript">
function UpdateIt(){
if (document.all){
document.all["MainTable"].style.top = document.body.scrollTop;
setTimeout("UpdateIt()", 200);
}
}
UpdateIt();
</script>


3) Upload the files "menu.js" and "menucontext.js" into your webpage directory 
(along with the above webpage, of course), and you're done!

The contents of the menu is stored inside "menucontext.js" To edit them, simply open 
up "menucontext.js" using any text editor, and change the links/text to your own. 
Save the modified file, and reupload it.

If you wish the menu to push right up against the edges of your browser screen, 
add the following code into the <BODY> tag itself, like this:

<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">

