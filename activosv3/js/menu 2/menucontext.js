
function showToolbar()
{
// AddItem(id, text, hint, location, alternativeLocation);
// AddSubItem(idParent, text, hint, location);



	menu = new Menu();
	menu.addItem("searchengineid", "Buscadores", "Buscadores",  null, null);


	menu.addItem("buscaing", "Buscadores Inglés", "Buscadores Inglés",  null, null);
	menu.addItem("Súper", "Súperpáginas", "Súperpáginas",  null, null);
	menu.addItem("webmasterid", "Creación de Webs", "Creación de Webs",  null, null);
	menu.addItem("newsid", "Nuevos Sites", "Nuevos Sites",  null, null);
	menu.addItem("freedownloadid", "Descargas gratis", "Descargas gratis",  null, null);
	menu.addItem("miscid", "Miscelánea", "Miscelánea",  null, null);

	menu.addSubItem("Súper", "Web del Programador", "Web del Programador",  "http://www.lawebdelprogramador.com/");
	menu.addSubItem("Súper", "Help Site", "Help Site",  "http://help-site.com");
	menu.addSubItem("Súper", "Tucows", "Tucows",  "http://www.tucows.com/");
	menu.addSubItem("Súper", "Home about", "Home about",  "http://home.about.com/compute/index.htm");
	menu.addSubItem("Súper", "VB Web", "Vb Web",  "http://www.vb-web-directory.com");

	menu.addSubItem("searchengineid", "Ya", "Ya",  "http://www.ya.com/");
	menu.addSubItem("searchengineid", "Yahoo Es", "Infoseek",  "http://www.es.yahoo.com/");
	menu.addSubItem("searchengineid", "Ole", "Ole", "http://www.ole.es");
	menu.addSubItem("searchengineid", "Voila", "Voila",  "http://www.es.voila.com");
	menu.addSubItem("searchengineid", "Ozú Es", "Ya",  "http://www.ozu.com/");
	menu.addSubItem("searchengineid", "Ozú Inter", "Infoseek",  "http://www.ozu.com/");
	menu.addSubItem("searchengineid", "El índice", "El índice", "http://www.elindice.com");
	menu.addSubItem("searchengineid", "Biwe", "Biwe",  "http://www.biwe.cesat.es");
	menu.addSubItem("searchengineid", "Yupi", "Ya",  "http://www.yupi.com/");
	menu.addSubItem("searchengineid", "Elcano", "Elcano",  "http://www.elcano.com");
	menu.addSubItem("searchengineid", "Piraña", "Piraña", "http://www.piranha.com.ve");
	menu.addSubItem("searchengineid", "Biwe", "Biwe",  "http://www.biwe.cesat.es");
	menu.addSubItem("searchengineid", "Cercat", "Cercat",  "http://http://www.cercat.com");

	menu.addSubItem("buscaing", "Yahoo", "Yahoo",  "http://www.yahoo.com");
	menu.addSubItem("buscaing", "Infoseek", "Infoseek",  "http://www.infoseek.com");
	menu.addSubItem("buscaing", "Excite", "Excite", "http://www.excite.com");
	menu.addSubItem("buscaing", "HotBot", "HotBot",  "http://www.hotbot.com");
	menu.addSubItem("buscaing", "Galaxy", "Galaxy",  "http://www.galaxy.tradewave.com");
	menu.addSubItem("buscaing", "Magellan", "Magellan", "http://www.magellan.excite.com");
	menu.addSubItem("buscaing", "Webcrawler", "Webcrawler",  "http://www.webcrawler.com");


	menu.addSubItem("webmasterid", "Dynamic Drive", "Dynamic Drive",  "http://www.dynamicdrive.com/");
	menu.addSubItem("webmasterid", "Website Abstraction", "Website Abstraction",  "http://www.wsabstract.com/");
	menu.addSubItem("webmasterid", "Web Review", "Web Review",  "http://www.webreview.com/");
	menu.addSubItem("webmasterid", "Developer.com", "Developer.com",  "http://www.developer.com/");
	menu.addSubItem("webmasterid", "Freewarejava.com", "Freewarejava.com",  "http://www.freewarejava.com/");
	menu.addSubItem("webmasterid", "Web Monkey", "Web Monkey",  "http://www.webmonkey.com/");
	menu.addSubItem("webmasterid", "Jars", "Jars",  "http://www.jars.com/");
	menu.addSubItem("webmasterid", "Intro DHTML Guide", "Intro DHTML Guide",  "http://members.tripod.com/~toolmandavid");

	menu.addSubItem("newsid", "CNN", "CNN",  "http://www.cnn.com");
	menu.addSubItem("newsid", "ABC News", "ABC News",  "http://www.abcnews.com");
	menu.addSubItem("newsid", "MSNBC", "MSNBC",  "http://www.msnbc.com");
	menu.addSubItem("newsid", "CBS news", "CBS News",  "http://www.cbsnews.com");
	menu.addSubItem("newsid", "News.com", "News.com",  "http://news.com");
	menu.addSubItem("newsid", "Wired News", "Wired News",  "http://www.wired.com");
	menu.addSubItem("newsid", "TechWeb", "TechWeb",  "http://www.techweb.com");

	menu.addSubItem("freedownloadid", "Dynamic Drive", "Dynamic Drive",  "http://www.dynamicdrive.com/");
	menu.addSubItem("freedownloadid", "Download.com", "Download.com",  "http://download.com/");
    menu.addSubItem("freedownloadid", "Jumbo", "Jumbo",  "http://www.jumbo.com/");
	menu.addSubItem("freedownloadid", "Tucows", "Tucows",  "http://tucows.com/");
    menu.addSubItem("freedownloadid", "WinFiles.com", "WinFiles.com",  "http://winfiles.com/");

	menu.addSubItem("miscid", "Hitbox.com", "Hitbox.com",  "http://www.hitbox.com/");
	menu.addSubItem("miscid", "Cnet", "Cnet",  "http://www.cnet.com/");
	menu.addSubItem("miscid", "Andover.net", "Andover.net",  "http://www.andover.net/");
	menu.addSubItem("miscid", "RealAudio", "RealAudio",  "http://www.realaudio.com/");
	menu.addSubItem("miscid", "MP3.com", "MP3.com",  "http://www.mp3.com/");

	menu.showMenu();
}