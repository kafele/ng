function stopError() {
return true;
} 
stopError();
var URL='';
function selectURL(theurl)
{
	clear_rename();
	document.previewform.selected_url.value = theurl;
	try {
	document.getElementById('go').style.visibility = 'visible';
	} catch (e) { }
	DownloadContainer=document.getElementById('do_download');
	DownloadContainer.style.visibility = 'visible';
	DownloadContainer.innerHTML = '<a href=\"'+theurl+'\" target=\"_blank\"><button class="insert_link">download</button></a>';
}

function get_theurl(callback)
{
	var URL = document.previewform.selected_url.value;
	var cb = "window.opener." + callback + "('" + URL + "')";
	eval(cb);
 	window.close();
	return false;
}

function insert_theurl(){
	FileBrowserDialogue.mySubmit();
}
var FileBrowserDialogue = {
    init : function () {},
    mySubmit : function () {
		var URL = document.previewform.selected_url.value;
		var win = tinyMCEPopup.getWindowArg("window");
		// insert information now
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		// for image browsers: update image dimensions
		if (document.URL.indexOf('type=image') != -1)
		{
			if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
			if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
		}
		// close popup window
		tinyMCEPopup.close();
	}
}
/*
try {
	tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
} 
catch (e) {}
*/