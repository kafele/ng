




var net = new Object(); // Namespacing object
net.READY_STATE_UNINITIALIZED = 0;
net.READY_STATE_LOADING = 1;
net.READY_STATE_LOADED = 2;
net.READY_STATE_INTERACTIVE = 3;
net.READY_STATE_COMPLETE = 4;
net.ContentLoader = function(key, method, url, params, onload, onerror, contentType, headers) { // Constructor
	this.hashKey = key;
	this.unrequestBrowser = false;
	this.req = null;
	this.onload = onload;
	this.onerror = (onerror) ? onerror : this.defaultError;
	this.loadXMLDoc(method, url, params, contentType, headers);
}
net.ContentLoader.prototype = { // Methods
	loadXMLDoc : function(method, url, params, contentType, headers) {
		if (!method) method="GET";
		if (!contentType && method=="POST") contentType='application/x-www-form-urlencoded';
		if (window.XMLHttpRequest) {
			this.req=new XMLHttpRequest(); 
		} else if (window.ActiveXObject){
			this.req=new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			this.unrequestBrowser = true;
			return;
		}
		if (this.req) {
			try {
				this.req.open(method,url,true);
				if (contentType){
					this.req.setRequestHeader('Content-Type', contentType);
				}
				if (headers) {
					for (var h in headers) {
						this.req.setRequestHeader(h,headers[h]);
					}
				}
				var loader=this;
				this.req.onreadystatechange=function() {
//					loader.onReadyState.call(loader);
				    /* Заглушка для	старых версий библиотеки JScript в IE */
				    req = loader.req;
                                    var ready=req.readyState;
                                    if (ready==net.READY_STATE_COMPLETE) {
                                        var httpStatus=req.status;
                                        if (httpStatus==200 || httpStatus==0) {
                                            loader.onload();
                                        } else {
                                            loader.onerror();
		                	}
				    }
				}
				this.req.send(params);
			} catch (err){
				this.onerror.call(this);
			}
		}
	},
	onReadyState : function() {
		var req=this.req;
		var ready=req.readyState;
		if (ready==net.READY_STATE_COMPLETE) {
			var httpStatus=req.status;
			if (httpStatus==200 || httpStatus==0) {
				this.onload.call(this);
			} else {
				this.onerror.call(this);
			}
		}
	},
	defaultError : function() {
		alert("error fetching data!"+"\n\nreadyState:"+this.req.readyState +"\nstatus: "+this.req.status+"\nheaders: "+this.req.getAllResponseHeaders());
	}
}
// Multy requests
var requestsHash = [];
function setAjaxRequest(method, url, params, onload, onerror, contentType, headers, _link) {
	// Check of necessary parameters
	if (!(url && params)) {
		alert("Necessary parameters are not specified");
		return;
	}
	requestsHash[requestsHash.length] = new net.ContentLoader(requestsHash.length, method, url, params, onload, onerror, contentType, headers);
	requestsHash[requestsHash.length] = (_link) ? _link : 0;
	return requestsHash[requestsHash.length - 2].unrequestBrowser;
}