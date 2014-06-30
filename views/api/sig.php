 <style type="text/css">
  .mapCanvas1 {
    width:70%; 
    height:300px; 
    background-color:grey; 
    text-align:center; 
    font-size:12; 
    margin:5px;
  }
  </style>
 
	<link href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/MarkerCluster.css" />
	<link href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/MarkerCluster.Default.css" />
	       
	<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/leaflet.draw-src.js" type="text/javascript"></script> 
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/leaflet.draw.js" type="text/javascript"></script> 
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/leaflet.markercluster-src.js"></script>

<ul>  
	<li class="block" id="blockLogin">
		<div class="apiForm importData">
			<h4>> Importer les données indispensables au SIG</h4>
			<h5>Nom de la base de données à utiliser pour insérer les données : par defaut "pixelhumain" </h5>
			<input type="text" id="dbName" name="dbName" value="pixelhumain"/>	<br/>
			<a href="javascript:importData()">Importer les données</a><br/>
			<div id="importDataResult" class="result fss"></div>

		<script>
			function importData(){
				params = { 	"dbName" : $("#dbName").val() ,
							"app":"<?php echo $this::$moduleKey?>"  };
				testitpost("importDataResult", '/ph/<?php echo $this::$moduleKey?>/api/importData',params);
				$("#importDataResult").html("Le chargement des données est en cours, cela peut durer quelques minutes...");				
			}
			</script>
			
		</div>
	</li>
<li class="block" id="blockLogin">
		<div class="fss">
			<h4>Test d'affichage de la carte</h4>
		</div>
		<div class="apiForm login">
			<div id="mapCanvas" class="mapCanvas1" >
			</br>Chargement de la carte ...
			</div>						
			<a href="javascript:addMarkerList()">Ajouter une liste de marker</a><br/>	
			<div id="loadResult" class="result fss"></div>
			<script>							
				//##
				function loadMap(canvasId){
					//initialisation des variables de départ de la carte
  					var map = L.map(canvasId).setView([51.505, -0.09], 4);
    		
    				L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png', {
    					subdomains: "1234",
    					attribution: "&copy; <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='http://www.openstreetmap.org/copyright' title='ODbL'>open license</a>. Tiles Courtesy of <a href='http://www.mapquest.com/'>MapQuest</a> <img src='http://developer.mapquest.com/content/osm/mq_logo.png'>"
         			}).addTo(map);
         		
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
    				.bindPopup(contentString)
    				.openPopup();
    	
    				return marker;
				}							
				//##
				//récupère le nom de l'icon en fonction du type de marker souhaité
				function getIcoMarker(type){
					if(type == "citoyen") 	return L.icon({ iconUrl: "/ph/images/sig/markers/user_h_black.png",
															iconSize: 		[19, 40],
										  					iconAnchor: 	[10, 40],
    									  					popupAnchor: 	[0, -40] });
					
					if(type == "city") 	return L.icon({ iconUrl: "/ph/images/sig/markers/city.png",
															iconSize: 		[32, 32],
										  					iconAnchor: 	[16, 32],
    									  					popupAnchor: 	[0, -32] });		
				}
													
				//##
				//ajouter une liste de marker sur la carte
				function addMarkerList(markerList){
					/*test*/
					var lat = 47; var lng = 3;
					var markerList = [	{ "lat" : lat,   "lng" : lng  , "type" : "citoyen", "contentInfoWin" : "N°1" }, 
										{ "lat" : lat+1, "lng" : lng+1, "type" : "citoyen", "contentInfoWin" : "N°2" }, 
										{ "lat" : lat+2, "lng" : lng+2, "type" : "citoyen", "contentInfoWin" : "N°3" }, 
										{ "lat" : lat+3, "lng" : lng+3, "type" : "citoyen", "contentInfoWin" : "N°4" }, 
										{ "lat" : lat+4, "lng" : lng+4, "type" : "citoyen", "contentInfoWin" : "N°5" } ];
					/*test*/	
					for(var i=0; i<markerList.length; i++){
						addMarker(laMap, markerList[i]);
					}
				}
				
				var laMap = loadMap("mapCanvas");
				
			</script>			
		</div>
	</li>

	<li class="block" id="blockLogin">
		<div class="fss">
			<h4>Enregistrement/modification de ma position en BD (when logged)</h4>
		</div>
		<div class="apiForm login">
			<div id="mapCanvasSavePosition" class="mapCanvas1">
			</br>Chargement de la carte ...
			</div>	
			<a href="javascript:initMapSavePos()">Afficher ma position</a><br/>			
			<a href="javascript:savePositionUser()">Enregistrer cette position</a><br/>			
			<div id="addPositionUserResult" class="result fss"></div>
			
			<script>
				var mapSavePosition;
				var newMarker;
					
				//##
				//initialise la carte qui sert à enregistrer la position de l'utilisateur connecté
				function initMapSavePos(){
					//recupere les données du citoyen connecté
					testitget("addPositionUserResult", baseUrl+'/<?php echo $this::$moduleKey?>/api/getCitoyenConnected/', 	
					function (data){
							if(data == null) { $("#addPositionUserResult").html ( "Vous devez être connecté pour enregistrer votre position"); }
							else 
							{
								var user = data['user'];      var city = data['city'];      var lat, lng = 0;
								
								var content = "<span style='text-align:center'>Votre code postal : " + user['cp']  + "<br/>";
								var position = null;
								
								if(user['geo'] != null) { //si l'utilisateur a deja enregistré sa position
								 content +=  "Pour modifier votre position, déplacez le curseur et cliquez sur :<br/>";
								 content += "<a id='' href='javascript:savePositionUser()'>> Enregistrer cette position</a></span>";
								
								lat = user['geo']['latitude'];
								lng = user['geo']['longitude'];
								} 
								else { //s'il n'a pas encore enregistré sa position, on affiche son marker aux coordonnées de sa ville
								 content += "Merci de placer votre silhouette à l'endroit où vous souhaitez apparaître, et cliquez sur :<br/>";
							 	 content += "<a id='' href='javascript:savePositionUser()'>Enregistrer cette position</a></span>";
							 	 
							 	 lat = city['geo']['latitude'];
								 lng = city['geo']['longitude'];
							 	}
							 	
							 	//crée le marker sur la carte
								newMarker = addMarker(mapSavePosition, { 	"lat":lat , 
																		    "lng":lng, 
																		    "type" : "citoyen", 
																		    "contentInfoWin":content });
								newMarker.dragging.enable();
								newMarker.openPopup();
								//centre la carte sur le nouveau marker
								mapSavePosition.panTo([lat, lng]);
								mapSavePosition.setZoom(11);		
				 			}
					});
						
				}
				
				//##
				//enregistre la position du marker
				function savePositionUser(){
					if(newMarker != null) {					
						var params = {  "lat" : newMarker.getLatLng().lat ,  "lng" : newMarker.getLatLng().lng };
						testitpost("addPositionUserResult",'/ph/<?php echo $this::$moduleKey?>/api/savePositionUser', params);

						var params = {  "lat" : newMarker.getPosition().lat() ,  "lng" : newMarker.getPosition().lng() };
						testitpost("addPositionUserResult", baseUrl+'/<?php echo $this::$moduleKey?>/api/savePositionUser', params);

						$("#addPositionUserResult").html("votre position a bien été enregistrée");
					}
				}				
				mapSavePosition = loadMap("mapCanvasSavePosition");
				
			</script>
			
		</div>
	</li>

	<li class="block" id="blockLogin">
		<h4>Afficher les villes</h4>
		<div class="fss">
			Afficher les villes de la BD<br/>
			+ Afficher les villes<br/>
		</div>
		<div class="apiForm login">
			<div id="mapCanvasCitoyens" class="mapCanvas1">
			</br>Chargement de la carte ...
			</div>	
			<a href="javascript:showCities()">Afficher les villes</a><br/>		
			<div id="showCitiesResult" class="result fss"></div>
			
			<script>
				var mapCitoyens = loadMap("mapCanvasCitoyens");
				var listCities = new Array();
							
				//##
				//affiche les villes qui possèdent des attributs lat, lng, depuis la BD
				function showCities(){ 
					testitget("showInsertMuserResult", baseUrl+'/<?php echo $this::$moduleKey?>/api/showCities/', 
						function (data){
							var nbCities=0;
						 	$.each(data, function() {
								//vérifie qu'on a bien les positions géographiques
								if(this['geo'] != null && 
									//et que la ville n'a pas déjà été affichée (pb CP grand villes avec des arrondissements)
									listCities[this["name"]] != this["habitants"]){	
				 					
				 					//crée le contenu de la bulle
				 					var content = "";
				 					if(this['name'] != null)  		content += 	"<b>" + this['name'] + "</b><br/>";
				 					if(this['cp'] != null)  		content += 	this['cp'] + "<br/>";
				 					if(this['habitants'] != null)  	content += 	"Nombre d'habitants : " + this['habitants'] + "<br/>";
				 					if(this['densite'] != null)  	content += 	"Densité : " + this['densite'] + "<br/>";
				 									
				 					var leMarker = addMarker(mapCitoyens, { "lat" : this['geo']['latitude'],   
				 															"lng" : this['geo']['longitude']  ,
				 															"type" : "city", 
				 															"contentInfoWin" : content });
				 					nbCities++;
				 					//garde le nom de la ville et le nb habitant en mémoire, pour n'afficher qu'une fois les villes qui ont plusieurs arrondissements
				 					listCities[this["name"]] = this['habitants'];
				 				}
							});
							$("#showCitiesResult").html(nbCities + " villes de plus de 100 000 habitants sur la carte");
						});
				}
			</script>	
		</div>
	</li>

	<li class="block" id="blockLogin">
		<div class="fss">
			<h4>Délimiter une zone de diffusion</h4>
		</div>
		<div class="apiForm login">
			<div id="mapCanvasBounds" class="mapCanvas1">
			</br>Chargement de la carte ...
			</div>	
			<a href="javascript:loadRectangleArea()">Afficher la zone</a><br/>		
			<a href="javascript:showBound()">Afficher les valeurs de la zone</a><br/>		
			<div id="showBoundsResult" class="result fss"></div>
			
			<script>
				var mapZone = loadMap("mapCanvasBounds");
				var RectangleArea;
				
				//##
				//affiche un rectangle sur la carte
				function loadRectangleArea()
				{
					var bounds = mapZone.getBounds();
					RectangleArea = L.rectangle(bounds, {
												color: "yellow", 
												weight: 2,
												fillOpacity: 0.3,
												clickable: true
											}).addTo(mapZone);
											
					RectangleArea.editing.enable();						
					mapZone.setZoom(mapZone.getZoom()-1);
				}
			
				//##
				//affiche les coordonnées correspondant aux limites du rectangle
				function showBound(){
					var bounds = RectangleArea.getBounds();
		
					$("#showBoundsResult").html ( "latMin : " + bounds.getSouthWest().lat + "<br/>" +
												  "lngMin : " + bounds.getSouthWest().lng + "<br/>" +
												  "latMax : " + bounds.getNorthEast().lat + "<br/>" +
												  "lngMax : " + bounds.getNorthEast().lng + "<br/>" );
				}
			</script>
			
		</div>
	</li>



<li class="block" id="blockLogin">
		<div class="fss">
			<h4>Afficher les citoyens avec les clusters</h4>
		</div>
		<div class="apiForm login">
			<div id="mapCanvasClusters" class="mapCanvas1">
			</br>Chargement de la carte ...
			</div>	
			<a href="javascript:showCitoyensClusters()">Afficher les citoyens avec cluster</a><br/>		
			<div id="showBoundsResult" class="result fss"></div>

		<script>				
				var mapClusters = loadMap("mapCanvasClusters");
				var markersLayer = new L.MarkerClusterGroup();
				mapClusters.addLayer(markersLayer);// add it to the map
				
				var geoJsonCollection = { type: 'FeatureCollection', features: new Array() };
				
				//##
				//affiche les citoyens qui possèdent des attributs geo.latitude, geo.longitude, depuis la BD
				function showCitoyensClusters(){ 
					
					geoJsonCollection = { type: 'FeatureCollection', features: new Array() };
					markersLayer.clearLayers();			
					
					testitget("showBoundsResult", baseUrl+'/<?php echo $this::$moduleKey?>/api/showCitoyens/', 
						function (data){
						 	$.each(data, function() {
								if(this['geo'] != null){
				 					var content = "";
				 					if(this['name'] != null)  content += 	"<b>" + this['name'] + "</b><br/>";
				 					if(this['email'] != null)  content += 	this['email'] + "<br/>";
				 					if(this['cp'] != null)     content += 	this['cp'] + "<br/>";
				 					if(this['phoneNumber'] != null)     content += 	this['phoneNumber'] + "<br/>";
				 					if(this['geo'] != null)     content += 	this['geo']['latitude'] + " - " + this['geo']['longitude'] + "<br/>";
				 					
				 					var properties = { 	title : this['name'], 
				 										icon : getIcoMarker("citoyen"),
				 										content: content };
				 					
				 					var marker = getGeoJsonMarker(properties, new Array(this['geo']['longitude'], this['geo']['latitude']));
				 					geoJsonCollection['features'].push(marker);				 					
				 				}
							});
							var points_rand = L.geoJson(geoJsonCollection, {
							onEachFeature: function (feature, layer) {
									layer.bindPopup(feature["properties"]["content"]);
									layer.setIcon(feature["properties"]["icon"]);
								}
							});
						
							markersLayer.addLayer(points_rand); 	// add it to the cluster group
							mapClusters.addLayer(markersLayer);// add it to the map
							mapClusters.fitBounds(markersLayer.getBounds()); //set view on the cluster extend					
						});
				}
				
				
				//##
				//créer un marker sur la carte, en fonction de sa position géographique
				function addMarkersCluster(thisMap, options){ //ex : lat = -34.397; lng = 150.644;			
					var contentString = options.contentInfoWin;
					if(options.contentInfoWin == null) contentString = "info window"; 
					
					var markerOptions = { icon : getIcoMarker(options.type),
										  draggable : true };
					
    				var geoJson = getGeoJsonMarker(markerOptions, [options.lat, options.lng]);
    				markersLayer.addLayer(geoJson);
    				return geoJson;
				}
								
				//##
				//créé une donnée geoJson
				function getGeoJsonMarker(properties/*json*/, coordinates/*array[lat, lng]*/) {
					return { "type": 'Feature',
							 "properties": properties,
							 "geometry": { type: 'Point',
							 			 coordinates: coordinates } };
				}
			</script>		
		</div>
	</li>



<li class="block">
<h4>Create/Update user with postion (facultatif)</h4><br/>
<div class="fss">
	url : /ph/<?php echo $this::$moduleKey?>/api/saveUser<br/>
	method type : POST <br/>
	Form inputs : email,postalcode,pwd,phoneNumber(is optional)<br/>
	return json object {"result":true || false}
</div>
<div class="apiForm createUser">
	name : <input type="text" name="nameSaveUser" id="nameSaveUser" value="<?php echo $this::$moduleKey?> User" /><br/>
	email* : <input type="text" name="emailSaveUser" id="emailSaveUser" value="<?php echo $this::$moduleKey?>@<?php echo $this::$moduleKey?>.com" /><br/>
	pwd* : <input type="text" name="pwdSaveUser" id="pwdSaveUser" value="1234" /><br/>
	phoneNumber : <input type="text" name="phoneNumberSaveUser" id="phoneNumberSaveUser" value="1234" />(for SMS)<br/>
	cp* : <input type="text" name="postalcodeSaveUser" id="postalcodeSaveUser" value="17000" /><br/>

	<a href="javascript:initPosNewUser()">Je souhaite indiquer ma position sur la carte</a><br/>

	<div id="mapCanvasInsLoader"></div>	
	
	type : 	<select name="typeSaveUser" id="typeSaveUser">
	<option value="<?php echo $this::$moduleKey?>">Participant</option>
	<option value="admin<?php echo $this::$moduleKey?>">admin<?php echo $this::$moduleKey?></option>
			</select><br/>

	<a href="javascript:addUser()">Valider l'inscription</a><br/>
	<div id="createUserResult" class="result fss"></div>
	<script>
	function addUser(){
		params = { 
			"email" : $("#emailSaveUser").val() ,
			"name" : $("#nameSaveUser").val() ,
			"cp" : $("#postalcodeSaveUser").val() ,
			"pwd":$("#pwdSaveUser").val() ,
			"type" : $("#typeSaveUser").val(),
			"phoneNumber" : $("#phoneNumberSaveUser").val(),
			"app":"<?php echo $this::$moduleKey?>" };

		if(markerNewUser != null)
		params['geo'] = {  "latitude" : markerNewUser.getLatLng().lat ,  "longitude" : markerNewUser.getLatLng().lng };

		//alert(JSON.stringify(params));
		testitpost("createUserResult", baseUrl+'/<?php echo $this::$moduleKey?>/api/saveUser',params);
	}
	
	var mapIns;
	/*$(document).ready(function () {  //charger la carte au chargement de la page
	mapIns = loadMap("mapCanvasIns");
	});
	*/

	//$( "#postalcodeSaveUser" ).change(function() {
	//if(($("#postalcodeSaveUser").val()).length >= 4)
	//});

	var markerNewUser;
	function initPosNewUser(){
		$('#mapCanvasInsLoader').html('<div id="mapCanvasIns" class="mapCanvas1"> </br>Chargement de la carte ... </div>');
		
		if(mapIns == null)
		mapIns = loadMap("mapCanvasIns");
		testitget("createUserResult", baseUrl+'/<?php echo $this::$moduleKey?>/api/getPositionCp/cp/'+$("#postalcodeSaveUser").val(), 	
				function (data){
					if(data == null) { $("#createUserResult").html ( "pas de réponse"); }
					else {
						var options = { 	"lat":data['lat'] , 
											"lng":data['lng'], 
											"type" : "citoyen", 
											"contentInfoWin": "Déplacez le curseur pour indiquer une autre position si vous le souhaitez." 
										};
								
						markerNewUser= addMarker(mapIns, options);	
						//centre la carte sur le nouveau marker
						mapSavePosition.panTo([data['lat'], data['lng']]);
					}							
				});
	}
</script>
</div>