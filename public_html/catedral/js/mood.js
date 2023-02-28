var moodjs = {
	_moodjs_gmap_loaded: false,
	_markers:[],
	map:0,
	myLatlng: 0,
	googlemap: function(div, markers, zoom, openmark){
		$.getScript('https://maps.google.com/maps/api/js?key=AIzaSyDckW-N1NSxLfBWeOQ874Sfu5w3zNtuoOs&callback=moodjs.MapApiLoaded');
		var intervalo = setInterval(
			function(){
				if(_moodjs_gmap_loaded) { 
					if(moodjs.loadmap(div, markers, zoom, openmark) !== false){ clearInterval(intervalo); }
				}
		},1000);
	},
	MapApiLoaded: function() { _moodjs_gmap_loaded = true; },

	loadmap: function(div, markers, zoom, openmark) {
		this._markers=markers;
		marker_list=[];
		marker_delete=[];
		var mapLoaded = true;
		try{ myLatlng = new google.maps.LatLng(markers[0].lat,markers[0].lng);
		}catch(err){ mapLoaded = false; }
		if(mapLoaded) {
			var mapOptions = {
				zoom: zoom,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById(div), mapOptions);
			this.setmarker(this._markers);
			if(openmark!=undefined) { moodjs.gomarker(openmark); }
		} else { alert("no se cargo el mapa"); }
		return mapLoaded;
    },

     setmarker:function(obj){
     	lugar = obj;
     	marker_list.length = 0;
     	//if(obj!=undefined){ lugar = obj; }
     	//else { lugar = this._markers; }
     	$(lugar).each(function(i, row) {
			var image = row.img;
			var pos = new google.maps.LatLng(row.lat, row.lng);
			marker = new google.maps.Marker({
			   position: pos,
			   map: map,
			   title: row.nombre,
			   draggable: false,
			   icon: image
			});

			google.maps.event.addListener(map, 'mousedown', function(){
				  if(typeof infowindow != 'undefined'){ infowindow.close(); }
				  if(typeof infowindow2 != 'undefined'){ infowindow2.close(); }
			});

			google.maps.event.addListener(marker, 'click', function() {
				google.maps.event.trigger(map, 'mousedown');
				infowindow2 = new google.maps.InfoWindow({content: row.info});
				infowindow2.open(map, this);
			});

			marker_list.push(marker);
			marker_delete.push(marker);

		});

     },

     gomarker: function(n){ //center to a location
       if(typeof infowindow != 'undefined'){ infowindow.close();}
       if(typeof infowindow2 != 'undefined'){ infowindow2.close();}
       var pos = new google.maps.LatLng(markers[n].lat,markers[n].lng);
       infowindow = new google.maps.InfoWindow({position: pos, title: markers[n].nombre, content: markers[n].info});
       infowindow.open(map, marker_list[n]);
       map.setCenter(pos);
    },

    deletemarkers:function(delmark){
    	if(delmark==undefined){
		    for (var i = 0; i<marker_delete.length; i++) {
	            marker_delete[i].setMap(null);
	        }
        } else {
        	marker_delete[delmark].setMap(null);
        }
        //this._markers = new Array();
    },

    listavertical: function(obj, activo) {
    	$(obj).click(function() {
		    $(this).parent().siblings().children("ul").slideUp(300);
		    $(this).siblings("ul").slideToggle(300);
		    //agregar clase activo
		    $(this).parent().siblings().children("a").removeClass(activo);
		    $(this).toggleClass(activo);
		    return false;
		});
    },

    igualheight: function(obj){
    	var highestBox = 0;
	    $(obj, this).each(function(){ if($(this).height() > highestBox) highestBox = $(this).height(); });  
	    $(obj).height(highestBox);
    },

    /************* Verifica /redirecciona si es mobile *************/
    getmobile: function (MobileURL, Home) {
	    try {
	        // avoid loops within mobile site
	        if (document.getElementById("dmRoot") != null) { return; }
	        var CurrentUrl = location.href;
	        var noredirect = document.location.search;
	        if (noredirect.indexOf("no_redirect=true") < 0) {
	            if ((navigator.userAgent.match(/(iPhone|iPod|BlackBerry|Android.*Mobile|BB10.*Mobile|webOS|Windows CE|IEMobile|Opera Mini|Opera Mobi|HTC|LG-|LGE|SAMSUNG|Samsung|SEC-SGH|Symbian|Nokia|PlayStation|PLAYSTATION|Nintendo DSi)/i))) {
	                if (Home) { location.replace(MobileURL); }
	                else { location.replace(MobileURL + "?url=" + encodeURIComponent(CurrentUrl)); }
	            }
	        }
	    }
	    catch (err) { }
	}

}