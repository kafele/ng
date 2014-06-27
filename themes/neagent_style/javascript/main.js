 



function gebi(id) { return document.getElementById(id); }

function imgov(obj) {
	if (obj != undefined) {
		var id = obj.id+'_ov';
		if (gebi(id)) obj.src = gebi(id).src;
	}
}

function imgou(obj) {
	if (obj != undefined) {
		var id = obj.id+'_ou';
		if (gebi(id)) obj.src = gebi(id).src;
	}
}





