<!doctype html>
<html lang="en">
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
        var allAddresses = ["Missing"];

        //Autocomplete for start address
        $( function() {
            
          $("#start").on("input", function(){
            getAddress($(this).val());
          })

          $( "#start" ).autocomplete({
            source: allAddresses
          });  
            
        } );

        //Autocomplete for end address
        $( function() {
          
          $("#end").on("input", function(){
            getAddress($(this).val());
          })
          
          $( "#end" ).autocomplete({
            source: allAddresses
          });
            
        } );

        //Obtains related addresses based on search, Openrouteservice API
        function getAddress(search){

            var request = new XMLHttpRequest();

            request.open('GET', 'https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf6248e38d3f64310c46ceb044c9b37ef563cd&text='+search+'&boundary.country=SE&sources=openstreetmap&layers=neighbourhood,address,venue');

            request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');

            request.onreadystatechange = function () {
              if (this.readyState === 4) {
                console.log('Status:', this.status);
                console.log('Headers:', this.getAllResponseHeaders());
                console.log('Body:', this.responseText);


                var response = JSON.parse(this.responseText);

                for (var i = 0; i < 10; i++){
                    var address = response.features[i].properties.label;
                    allAddresses[i] = address;

                }                      

              }
            };

            request.send();
        }
      </script>


      <!-- Two search fields, start and end address-->
      <div class="ui-widget">
        <label for="start">Start Address: </label>
        <input id="start">
        
        <br>  
          
        <label for="end">End Address: </label>
        <input id="end">
      </div>

    </body>

</html>
