// http://tednologia.com/tabs-css-simples-con-jquery/
// Tabs
$(document).ready(function()
{
	// Secciones Principales
	$(".tab_content").hide();
	$("ul.textNoIcon li:first").addClass("active").show();
	$(".tab_content:first").show();
	
	$("ul.textNoIcon li").click(function()
	   {
		$("ul.textNoIcon li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content").hide();

		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn();
		return false;
	});
});

// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.bibloTabs").tabs("div.bibloContent > div", "div > div#mainSectionList");
});