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

        <script>

          //Place to put all addresses!
          function addressFunc(){
              
              var addresses = [
                "Chalmers",
                "Mölndal",
                "Centralstation",
                "Haga",
                "Majorna",
                "Sävedalen",
                "Kållered",
                "Kåltorp",
                "Linné",
                "Järntorget",
                "Saltholmen",
                "Askim"
              ];
            return addresses;
          }
          function myPrint(){
              document.getElementById("demo").innerHTML = Math.random();
          }

            //Autocomplete for start address
          $( function() {
            $( "#start" ).autocomplete({
              source: addressFunc()
            });  
          } );

              //Autocomplete for end address
          $( function() {
            $( "#end" ).autocomplete({
              source: addressFunc()
            });
          } );
          </script>

        
        
        <!-- Two input fields -->
        <div class="ui-widget">
          <label for="start">Start Address: </label>
          <input id="start">
        </div>

        <div class="ui-widget">
          <label for="end">End Address : </label>
          <input id="end">
        </div>
        
             <!-- Make a search request!-->
        <script>

          //  $("#search").on("input", function(){

            var request = new XMLHttpRequest();

            request.open('GET', 'https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf624886866da0e6fb41b5a3cb1b1f8f9954d7&text=Gothenburg&focus.point.lon=57.70960871267081&focus.point.lat=57.70960871267081&boundary.rect.min_lon=11.516305134685421&boundary.rect.min_lat=57.57487381798023&boundary.rect.max_lon=12.100816210899202&boundary.rect.max_lat=57.86290599685986&boundary.country=SE&sources=openstreetmap,openaddresses&layers=address,neighbourhood');

            request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');

            request.onreadystatechange = function () {
              if (this.readyState === 4) {
                console.log('Status:', this.status);
                console.log('Headers:', this.getAllResponseHeaders());
                console.log('Body:', this.responseText);
              }
            };

            request.send();

            //});

        </script>

    </body>

</html>
