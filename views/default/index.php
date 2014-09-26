<?php 
$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app()->request->baseUrl. '/css/vis.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/api.js' , CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/vis.min.js' , CClientScript::POS_END);

$cs->registerCssFile("http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css");
$cs->registerCssFile($this->module->assetsUrl. '/css/leaflet.draw.css');
$cs->registerCssFile($this->module->assetsUrl. '/css/leaflet.draw.ie.css');
$cs->registerCssFile($this->module->assetsUrl. '/css/MarkerCluster.css');
$cs->registerCssFile($this->module->assetsUrl. '/css/MarkerCluster.Default.css');
$cs->registerCssFile($this->module->assetsUrl. '/css/sig.css');
//$cs->registerCssFile($this->module->assetsUrl. '/css/leaflet.awesome-markers.css');

$cs->registerScriptFile('http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js' , CClientScript::POS_END);
$cs->registerScriptFile($this->module->assetsUrl.'/js/leaflet.draw-src.js' , CClientScript::POS_END);
$cs->registerScriptFile($this->module->assetsUrl.'/js/leaflet.draw.js' , CClientScript::POS_END);
$cs->registerScriptFile($this->module->assetsUrl.'/js/leaflet.markercluster-src.js' , CClientScript::POS_END);
//$cs->registerScriptFile($this->module->assetsUrl.'/js/leaflet.awesome-markers.min.js' , CClientScript::POS_END);

$this->pageTitle=$this::moduleTitle;


?>
<style type="text/css">
 .mapCanvasSlider{
 	min-width:100%;
 	min-height:100%;
 	background-color:#425766;
 }
 
 #project .slide-content .mapCanvasSlider img{
 	border-radius:0px;
 	box-shadow: 0px 0px 0px 0px;
 }
 
 #project{
 	color:black;
 }
 
 .leaflet-popup-content-wrapper{
 	background-color:rgba(53, 61, 68, 0.7);
 	border-radius:10px;
 	color:white;
 	font-family: "Open Sans";
 }
 
 .leaflet-popup-tip{
 	background-color:rgba(53, 61, 68, 0.7);
 }
 
 .popup-img-profil{
 
 }

 .popup-info-profil{
 	width:100%;
 	text-align:center;
 	font-size:14px;
 }
 .popup-info-profil-username{
 	width:100%;
 	text-transform:capitalize;
 	text-align:center;
 	font-size:30px;
 	color:yellow;
 }
 .popup-info-profil-usertype{
 	width:100%;
 	text-transform:capitalize;
 	text-align:center;
 	font-size:18px;
 }
 .popup-info-profil-work{
 	width:100%;
 	text-align:center;
 	font-size:18px;
 	text-transform:capitalize;
 	
 }
 .popup-info-profil-url{
 	width:100%;
 	text-align:center;
 	font-size:13px;
 	color:#2aa0bd;
 }
 
</style>

	<script src="http://code.jquery.com/jquery.js"></script>
		
	
	
<!-- START PROJECT SECTION -->
<section id="project" class="section" >
	<span class="sequence-prev" ></span>
	<span class="sequence-next" ></span>
    <ul class="sequence-canvas">
    	<li style="background-color: #3b4a52; height:70%;">
        	<div class="slide-content" style="width:100%; left:0px; height:100%;">
            	<div class="mapCanvasSlider" id="mapCanvasSlide1">
            	</div>
        	</div>
    	</li>
    	<li style="background-color: #3b4a52; height:70%;">
        	<div class="slide-content" style="width:100%; left:0px; height:100%;">
        		<div class="mapCanvasSlider" id="mapCanvasSlide2">
            	</div>
        	</div>
    	</li>
    </ul>
	<ul class="sequence-pagination">
		<li>Pixels actifs</li>
		<li>Communectés</li>
	</ul>
</section>
<!-- END PROJECT SECTION -->

<script type="text/javascript">

$(document).ready( function() 
{ 
	
	function loadMap(canvasId){
		//initialisation des variables de départ de la carte
		var map = L.map(canvasId).setView([51.505, -0.09], 4);

		L.tileLayer('http://{s}.tile.stamen.com/toner/{z}/{x}/{y}.png', {
			attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
			subdomains: 'abcd',
			minZoom: 0,
			maxZoom: 20
		}).setOpacity(0.4).addTo(map);
	
		map.on('click', function(e) {
    		//alert(map.getCenter());
		});
		
		
		
		return map;
	}								
	//##
	//créer un marker sur la carte, en fonction de sa position géographique
	function addMarker(thisMap, options){ //ex : lat = -34.397; lng = 150.644;
	
		var contentString = options.contentInfoWin;
		if(options.contentInfoWin == null) contentString = "info window"; 
		
		var markerOptions = { icon : getIcoMarker(options.type),
							  draggable : true };
		
		var marker = L.marker([options.lat, options.lng], markerOptions).addTo(thisMap)
		.bindPopup(contentString);
		//.openPopup();
			
		return marker;
	}							
	//##
	//récupère le nom de l'icon en fonction du type de marker souhaité
	function getIcoMarker(type){
		/*
		if(type == "citoyen")
		return L.AwesomeMarkers.icon({ prefixe:'fa', icon: 'fa-circle', iconColor:"white" });
  		
		if(type == "pixelactif")
		return L.AwesomeMarkers.icon({ prefixe:'fa', icon: 'fa-circle', iconColor:"white" });
  		
		if(type == "partenaire")
		return L.AwesomeMarkers.icon({ prefixe:'fa', icon: 'lightbulb-o', iconColor:"white" });
  		*/ 
  		
		if(type == "citoyen") 	return L.icon({ iconUrl: "<?php echo $this->module->assetsUrl.'/image/markers/02_ICON_CITOYENS.png'; ?>",
												iconSize: 		[14, 14],
												iconAnchor: 	[7, 7],
												popupAnchor: 	[0, -10] });
												
		
		if(type == "pixelActif") 		return L.icon({ iconUrl: "/ph/images/sig/markers/02_ICON_PIXEL_ACTIF.png",
												iconSize: 		[14, 14],
												iconAnchor: 	[7, 7],
												popupAnchor: 	[0, -10] });	
												
		if(type == "partnerPH") 	return L.icon({ iconUrl: "/ph/images/sig/markers/02_ICON_PARTENAIRES.png",
												iconSize: 		[14, 16],
												iconAnchor: 	[7, 7],
												popupAnchor: 	[0, -10] });						  						
	}
										
	//##
	//ajouter une liste de marker sur la carte
	function addMarkerList(map){
		/*test*/
		var lat = 47; var lng = 3;
		var markerList = [	{ "lat" : lat,   "lng" : lng  , "type" : "citoyen", "contentInfoWin" : "N°1" }, 
							{ "lat" : lat+1, "lng" : lng+1, "type" : "citoyen", "contentInfoWin" : "N°2" }, 
							{ "lat" : lat+2, "lng" : lng+2, "type" : "citoyen", "contentInfoWin" : "N°3" }, 
							{ "lat" : lat+3, "lng" : lng+3, "type" : "citoyen", "contentInfoWin" : "N°4" }, 
							{ "lat" : lat+4, "lng" : lng+4, "type" : "citoyen", "contentInfoWin" : "N°5" } ];
		/*test*/	
		for(var i=0; i<markerList.length; i++){
			addMarker(map, markerList[i]);
		}
	}
	
	
	

				
				//##
				//affiche les citoyens qui possèdent des attributs geo.latitude, geo.longitude, depuis la BD
				function showCitoyensClusters(mapClusters, origine){ 
					
					var markersLayer = new L.MarkerClusterGroup();
					mapClusters.addLayer(markersLayer);
	
					var geoJsonCollection = { type: 'FeatureCollection', features: new Array() };
					//markersLayer.clearLayers();			
					
					var bounds = mapClusters.getBounds();
					var params = {};
					params["latMinScope"] = bounds.getSouthWest().lat;
					params["lngMinScope"] = bounds.getSouthWest().lng;
					params["latMaxScope"] = bounds.getNorthEast().lat;
					params["lngMaxScope"] = bounds.getNorthEast().lng;
				
					testitpost("showCitoyensResult", '/ph/<?php echo $this::$moduleKey?>/api/' + origine, params,
						function (data){ //alert(JSON.stringify(data));
							//var listItemMap = "";
						 	$.each(data, function() {  	
								if(this['geo'] != null){
								
									//préparation du contenu de la bulle
									
									//THUMB PHOTO PROFIL
				 					var content = "";
				 					if(this['thumb_path'] != null)   
				 					content += 	"<img src='" + this['thumb_path'] + "' height=70 class='popup-info-profil-thumb'>";
				 					
				 					//NOM DE L'UTILISATEUR
				 					if(this['name'] != null)   
				 					content += 	"<div class='popup-info-profil-username'>" + this['name'] + "</div>";
				 					
				 					//TYPE D'UTILISATEUR (CITOYEN, ASSO, PARTENAIRE, ETC)
				 					var typeName = this['type'];
				 					if(this['type'] == null)  typeName = "Citoyen";
				 					if(this['name'] == null)  typeName += " anonyme";
				 					
				 					content += 	"<div class='popup-info-profil-usertype'>" + typeName + "</div>";
				 					
				 					//WORK - PROFESSION
				 					if(this['work'] != null)     
				 					content += 	"<div class='popup-info-profil-work'>" + this['work'] + "</div>";
				 					
				 					//URL
				 					if(this['url'] != null)     
				 					content += 	"<div class='popup-info-profil-url'>" + this['url'] + "</div>";
				 					
				 					//CODE POSTAL
				 					if(this['cp'] != null)     
				 					content += 	"<div class='popup-info-profil'>" + this['cp'] + "</div>";
				 					
				 					//VILLE ET PAYS
				 					var place = this['city'];
				 					if(this['city'] != null && this['country'] != null) place += ", ";
				 					place += this['country'];
				 					
				 					if(this['city'] != null)     
				 					content += 	"<div class='popup-info-profil'>" + place + "</div>";
				 					
				 					//NUMÉRO DE TEL
				 					if(this['phoneNumber'] != null)     
				 					content += 	"<div class='popup-info-profil'>" + this['phoneNumber'] + "<div/>";
				 					
				 					
				 					//création de l'icon sur la carte
				 					var type;
				 					if(this['type'] != null) type = this['type'];
				 					else if(this['tags'] != null) type = this['tags'];
				 					else type = "citoyen";
				 					
				 					var properties = { 	title : this['name'], 
				 										icon : getIcoMarker(type),
				 										content: content };
				 					
				 					var marker = getGeoJsonMarker(properties, new Array(this['geo']['longitude'], this['geo']['latitude']));
				 					geoJsonCollection['features'].push(marker);	
				 					
				 					//crée la liste à afficher à droite de la carte
				 					//listItemMap += "<div class='itemMapList'>" + this['name'] + "</div>";	 								 					
				 				}
							});
							
							//affiche la liste d'éléments à droite de la carte
							//$('#mapListItems').html(listItemMap);
							
							var points = L.geoJson(geoJsonCollection, {
							onEachFeature: function (feature, layer) {				   //Sur chaque marker
									layer.bindPopup(feature["properties"]["content"]); //ajoute la bulle d'info avec les données
									layer.setIcon(feature["properties"]["icon"]);	   //et affiche l'icon demandé
									layer.on('mouseover', function(e) {
										layer.openPopup();
									});
									layer.on('mouseout', function(e) {
										layer.closePopup();
									});
								}
							});
						
							markersLayer.addLayer(points); 	// add it to the cluster group
							mapClusters.addLayer(markersLayer);		// add it to the map
							//mapClusters.fitBounds(markersLayer.getBounds()); //set view on the cluster extend					
						});
				}
								
								
				//##
				//créé une donnée geoJson
				function getGeoJsonMarker(properties/*json*/, coordinates/*array[lat, lng]*/) {
					return { "type": 'Feature',
							 "properties": properties,
							 "geometry": { type: 'Point',
							 			 coordinates: coordinates } };
				}
	
	
	var map1 = loadMap("mapCanvasSlide1");
	map1.setView([30.29702, -21.97266], 3);
	showCitoyensClusters(map1, "getPixelActif");
	//addMarkerList(map1);
	
		
		
	
	var map2 = loadMap("mapCanvasSlide2");
	map2.setView([-21.13318, 55.5314], 10);
	showCitoyensClusters(map2, "getCommunected");


});


</script>
