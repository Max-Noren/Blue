<!doctype html>
<html>
  <!-- 
      TEST
      26.09.2021
       This code have been tested manualy. We have tested and compared our results with google maps an we have gotten the same answer. 

       Problem: The characters ÅÄÖ can not be used to find coordinates...
  -->

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>ADDRESS INPUT</title>

      <!-- jQuery Widgets -->
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="/resources/demos/style.css">

      <!-- jQuery Autocomplete -->
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    </head>
    <body>
        
      <!-- Temporary -->
      <p id='demo'></p>

      <script>

        //Global array for available addresses
        const allAddresses = ["N/A"];

        //Autocomplete for start address
        $( function() {
            
          $("#start").on("input", function(){ //Calls on the getAddress function every keystroke
            getAddress($(this).val(), "start");
          })

          $( "#start" ).autocomplete({
            source: allAddresses //The array from line 81
          });  
            
        } );

        //Autocomplete for end address
        $( function() {
          
          $("#end").on("input", function(){ //Calls on the getAddress function every keystroke
            getAddress($(this).val(), "end");
          })
          
          $( "#end" ).autocomplete({
            source: allAddresses //The array from line 81
          });
            
        } );

        //Obtains related addresses based on search, Openrouteservice API
        function getAddress(search, startOrEnd){
            var request = new XMLHttpRequest();

            request.open('GET', 'https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf6248e38d3f64310c46ceb044c9b37ef563cd&text='+search+'&boundary.country=SE&sources=openstreetmap&layers=neighbourhood,address,venue');

            request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');

            request.onreadystatechange = function () {
              if (this.readyState === 4) {
                //console.log('Status:', this.status);
                //console.log('Headers:', this.getAllResponseHeaders());
                //console.log('Body:', this.responseText);


                var response = JSON.parse(this.responseText);
                while (allAddresses.length) { allAddresses.pop(); } // Empty array
                response.features.map(feature => feature.properties.label).forEach(label => allAddresses.push(label));  // Filter our label from response and push to allAddresses

                if(startOrEnd == "start") {
                  $("#startLat").val(response.features[0].geometry.coordinates[1]);
                  $("#startLng").val(response.features[0].geometry.coordinates[0]);
                } else if(startOrEnd == "end") {
                  $("#endLat").val(response.features[0].geometry.coordinates[1]);
                  $("#endLng").val(response.features[0].geometry.coordinates[0]);
                } else {
                  console.warn("Invalid startOrEnd arg", startOrEnd);
                }
              }
            };

            request.send();
        }
      </script>


      <!-- Two search fields, start and end address-->

      <div class="ui-widget">
        <form>
        
          <label for="start">Start Address: </label>
          <input id="start" name="start" >

          <br>

          <label for="end">End Address: </label>
          <input id="end" name="end" >
            
          <br>
          <input style="display: none;" id="startLat" name="startLat" >
          <input style="display: none;" id="startLng" name="startLng" >
          <input style="display: none;" id="endLat" name="endLat" >
          <input style="display: none;" id="endLng" name="endLng" >


          <input type="submit" name="btn_submit" value="My Carbon Footprint" />
            
        </form> 
      </div>   
        
      <?php
        // Displayes coordinates from the search
        if(isset($_GET['btn_submit']))
        {

			    $start = $_GET['start'];
          $end = $_GET['end'];
          $startLat = $_GET['startLat'];
          $endLat = $_GET['endLat'];
			    $startLng = $_GET['startLng'];
          $endLng = $_GET['endLng'];
			
            echo "<br>Start : ", $start, "<br>";
            echo "Latitude : ", $startLat, "<br>";
            echo "Longitude : ", $startLng, "<br>";

            echo "<br>End : ", $end, "<br>";
            echo "Latitude : ", $endLat, "<br>";
            echo "Longitude : ", $endLng, "<br>";
        }
      ?>
    </body>
</html>
