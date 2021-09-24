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
          function myPrint(){
              document.getElementById("demo").innerHTML = Math.random();
          }

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
            
            
          
            
                            
            function getAddress(search){
                
                var request = new XMLHttpRequest();

                //request.open('GET', 'https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf624886866da0e6fb41b5a3cb1b1f8f9954d7&text='+search+'&boundary.country=SE&sources=openstreetmap,openaddresses');

                request.open('GET', 'https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf6248e38d3f64310c46ceb044c9b37ef563cd&text='+search+'&boundary.country=SE&sources=openstreetmap&layers=neighbourhood,address,venue');
                
                request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');

                request.onreadystatechange = function () {
                  if (this.readyState === 4) {
                    console.log('Status:', this.status);
                    console.log('Headers:', this.getAllResponseHeaders());
                    console.log('Body:', this.responseText);
                      
                      
                    var response = JSON.parse(this.responseText);
                
                    //document.getElementById('demo').innerHTML = response.features[0].properties.name;
                      
                    var properties = response;
                    //document.getElementById('demo').innerHTML = count(properties);
                      
                    for (var i = 0; i < 10; i++){
                        var address = response.features[i].properties.label;
                        document.getElementById('demo').innerHTML = address;
                        allAddresses[i] = address;
                        
                    }                      
                      
                  }
                };

                //This crashes the shit
                request.send();
                
            }
            
              $("#start").on("input",function (){
                var search = $(this).val();
                document.write(search);
                getAddress(search);
                
            })
            getAddress("Majorna");
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
    

          <?php
        
        
            function getAddresses($search){

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf624886866da0e6fb41b5a3cb1b1f8f9954d7&text=".$search."&boundary.country=SE&sources=openstreetmap,openaddresses");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8"
                ));

                $response = curl_exec($ch);
                curl_close($ch);

                $decode = json_decode($response);
            

                $addresses = [];
                
                for($i = 0; $i < count($decode->features); $i++){
                    $address = $decode->features[$i]->properties->name;
                    echo $address, "<br>";
                    array_push($addresses, $address);
                }
                echo $addresses[0];
                return $addresses;
                
            }
            
        //getAddresses("Majorna");
            
                
        ?>

    </body>

</html>
