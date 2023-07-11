

<div id="inicialimage" style="display: none">
                    
                    </div>
                    <div id="finalimage" style="display: none">
                    <button type="" name="" id="reload" class="trigger" onclick="location.reload()"
                                 style="display: none">You Lose! Click to Play Again</button>      
                    </div>
                <?php
                    if( isset($_SESSION["user_id"]) 
                    ){
                        
                        echo'
                        <div id="youwin">
                        <form  id="result" method="post" action="game.php">
                                <input type="hidden" name="game" value="' .$games[0]["game_id"]. '">
                                <input type="hidden" name="game_time" id="finaltime" value="" />      
                                <button type="submit" name="subscribe" id="startgame" class="trigger"
                                 style="display: none">You Win!!! Congratulations !!!</button>
                        </form>
                        </div>
                        ';        
                    }          
                ?>
                   <section>
                       <!-- page.content-->
                    <div class="gamecontent"> 
                    
                        
                        <div class="headergame">
                            <div class="coor">
                                <p>
                                    lat : <span id="lat"></span>°<br />
                                    lng : <span id="lon"></span>° <br />
                                </p>
                            </div>
                            <div class="vel">
                                vel: <span id="vel"></span>Kph <br />
                                dist/to End : <span id="distend"></span>m <br />
                                
                            </div>
                            <div class="time">
                                
                                time: <span id="clock"></span> <br />
                            </div>
                        </div>
                
                        <div id="map"> </div>
                       
                        <div class="flex" id="startinfo" style="display: block">
                        <div class="row">
                            <div class="img">
                                <img src="../images/games/tomatos.png" alt="">
                            </div>
                            <div class="parag">
                                    <p class="a">We are waiting for you at Tivoli!!</p>
                                    <p class="b" id="startinfob" style="visibility: hidden">Follow the red line !!</p><!---->
                                    <p class="c" id="startinfoc" style="visibility: hidden">Click on map and press any </p>
                                    <p class="d" id="startinfod" style="visibility: hidden">direction key to start !!</p>
                            </div>
                        </div>
                        </div>
                
                        <div class="flex" id="gamestopinfo" style="display: none">
                        <div class="row">
                            <div class="img">
                                <img src="../images/games/tomatos.png" alt="">
                            </div>
                            <div class="parag">
                                    <p class="gamestop">HURRY UP!! Don`t STOP!!</p>
                            </div>
                        </div>
                        </div>
                
                        <div class="flex" id="turboinfo" style="display: none">       
                            <div class="row">
                                <div class="img">
                                    <img src="../images/games/keepgoing.png" alt="">
                                </div>
                                <div class="parag">
                                        <p class="turbokeep">THAT`S IT!! Keep going!!</p>
                                </div>
                            </div>
                            <div class="blink" id="turbomode" style="display: none">
                            <p >TURBO !!</p>
                            </div>
                        </div>
                
                        <div class="" id="enemi" style="display: none">       
                            <div class="row">
                                <div class="img">
                                    <img src="../images/veggie.png" alt="">
                                </div>
                                <div class="parag">
                                        <p class="eneminfo">Be careful!!</p>
                                </div>
                            </div>
                        </div>
                
                        <div class="blink" id="turbomodeoff" style="display: none">
                                <p> Hold spacebar for turbo !!</p>
                        </div>
                  
                    </div>
                    </section>
                <script>
                
                
                    $(document).ready(function() {
                        
                        var lat = <?php echo $games[0]["lat1"]; ?>, lng = <?php echo $games[0]["lon1"]; ?>;
                        var lat2 = <?php echo $games[0]["lat2"]; ?>, lng2 = <?php echo $games[0]["lon2"]; ?>;
                        var v1 = <?php echo $games[0]["vel1"]; ?>;
                        var v2 = <?php echo $games[0]["vel2"]; ?>;
                        var lat3 = lat2;
                        var lng3 = lng2;
                        
                        var map = L.map('map', {
                        //zommControl : false
                        }).setView([lat, lng], 17);
                        //street view day
                        var streetLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 17,
                            minZoom: 17,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        });
                        //street view night
                        var nightVisionLayer = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/navigation-night-v1/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2hqb3J0aGRrIiwiYSI6ImNsMGk2ZHg3YjAxMjMzaXBjajNqN2VrYjAifQ.luNBB8yfwYGRrIHw2qscyg', {
                            opacity: 0.7
                        });
                
                        streetLayer.addTo(map);
                
                        //marker with a custom icon Tomato
                        const issIcon = L.icon({
                            iconUrl: '../images/tomato.png',
                            iconSize: [32, 32],
                            iconAnchor: [25, 16]
                        });
                
                        //marker with a custom icon Pineapple
                        const issIcon2 = L.icon({
                            iconUrl: '../images/veggie.png',
                            iconSize: [32, 32],
                            iconAnchor: [25, 16]
                        });
                
                        //marker with a custom icon family
                        const issIcon3 = L.icon({
                            iconUrl: '../images/games/tomatos.png',
                            iconSize: [32, 32],
                            iconAnchor: [25, 16]
                        });
                
                        var latlngs = [
                            [lat, lng],
                            /*GPS coordinates of Tivoli Gardens, 
                            Denmark. Latitude: 55.67466865 Longitude: 12.56571160.*/
                            //[lat2, lng2]exec A tomato is standing at Nørreport. 
                            //It wants to go to Næstved(55.232816,11.767130)
                            [lat2, lng2]
                        ];
                
                        // A dashed line pattern
                        var customStyle = {
                        color: 'red',
                        weight: 4,
                        opacity: 0.8,
                        dashArray: '5, 10' 
                        };
                
                        var polyline = L.polyline(latlngs, customStyle).addTo(map);
                
                        //move when press key
                        var up, down, left, right = false; 
                        
                        let marker2;
                        let marker3;
                        var p = 1;
                        var currentPos = map.getCenter();
                        let START_TIME = false;
                        let GAME = true;
                        let CLOSE = false;
                        let STOP = false;
                        let WIN = false;
                        let NIGHT = false;
                        
                        function setPosition(p){
                            movval1 = 0.000000429*p;
                            movval2 = 0.00000622*p;
                        }
                
                        //Game information functions
                        function showgamestopinfo(){       
                            let stop = document.getElementById("gamestopinfo");           
                            if( stop.style.display === "none" 
                            ){           
                                stop.style.display = "block";  
                            }
                              
                        }
                        /*in jquery example
                        function showgamestopinfo() {
                            let stop = $("#gamestopinfo");
                            if (stop.css("display") === "none") {
                                stop.css("display", "block");
                            }
                        }*/
                
                        function hidegamestopinfo(){
                            let stop = document.getElementById("gamestopinfo");           
                            if( stop.style.display === "block" 
                            ){           
                                stop.style.display = "none";  
                            }
                        }
                
                        function hidegameturboinfo(){
                            let turbooff = document.getElementById("turbomodeoff"); 
                            let turbo = document.getElementById("turbomode");           
                            let turboimage = document.getElementById("turboinfo");           
                            if( turbooff.style.display === "block" 
                            ){           
                                turbooff.style.display = "none";  
                            }
                            if( turbo.style.display === "block" && turboimage.style.display === "block"
                            ){           
                                turbo.style.display = "none";
                                turboimage.style.display = "none";   
                            }
                        }
                
                        function turbomodeOn(){
                            let turbo = document.getElementById("turbomode"); 
                            let turboimage = document.getElementById("turboinfo");    
                            let turbooff = document.getElementById("turbomodeoff");        
                            let start = document.getElementById("startinfo");        
                            if( turbo.style.display === "none" && turboimage.style.display === "none"
                            ){           
                                turbo.style.display = "block";
                                turbo.style.zIndex = "2"; 
                                turboimage.style.display = "block";
                                turboimage.style.zIndex = "2"; 
                                start.style.display = "none";   
                                turbooff.style.display = "none";   
                            }
                        }
                
                        function turbomodeOf(){
                            let turbo = document.getElementById("turbomode");
                            let turboimage = document.getElementById("turboinfo"); 
                            let turbooff = document.getElementById("turbomodeoff");  
                            let start = document.getElementById("startinfo");                     
                            if( turbooff.style.display === "none" && START_TIME === true
                            ){           
                                turbooff.style.display = "block";
                                turbooff.style.zIndex = "2";
                                start.style.display = "none";
                            }
                            if( turbo.style.display === "block" && turboimage.style.display === "block"
                            ){           
                                turbo.style.display = "none";
                                turboimage.style.display = "none";
                            }
                        } 
                
                        function closenemi(){
                            let enemi = document.getElementById("enemi");
                            
                            if(CLOSE == true){         
                                if( enemi.style.display === "none" 
                                ){             
                                    enemi.style.display = "block";
                                }
                            
                            } else if(CLOSE == false){  
                                if( enemi.style.display === "block" 
                                ){              
                                    enemi.style.display = "none";
                                } 
                            } 
                            
                        }
                
                        //End game animation function
                        function confettiFalling() {
                            var box = document.getElementById("inicialimage");
                            var colors = ['red', 'green', 'blue', 'yellow', 'purple', 'orange', 'pink'];
                            for (var i = 0; i < 200; i++) { 
                                // Create 200 DIV elements for confetti
                                var div = document.createElement("div");
                                div.classList.add("confetti");
                                box.appendChild(div);
                            }
                            var confetti = document.querySelectorAll('.confetti');
                            for (var i = 0; i < confetti.length; i++) {         
                                var size = Math.random() * 0.01 * [i];
                                confetti[i].style.width = 2 + size + 'px';
                                confetti[i].style.height = 8 + size + 'px';
                                confetti[i].style.left = Math.random() * innerWidth + 'px';
                
                                var background = colors[Math.floor(Math.random() * colors.length)];
                                confetti[i].style.backgroundColor = background;
                                box.children[i].style.transform = "rotate("+ size*[i] +"deg)";
                            }
                        }
                        //Game info settimeout function
                        setTimeout(function startinfop(){
                            let infopb = document.getElementById("startinfob");   
                            infopb.style.visibility = "visible";
                            setInterval(function (){        
                            let infopc = document.getElementById("startinfoc");     
                            infopc.style.visibility = "visible";
                            },2000);
                            setInterval(function (){        
                            let infopd = document.getElementById("startinfod");     
                            infopd.style.visibility = "visible";
                            },4000);
                            
                        },2000);
                
                        //Game key press mov
                        var keys = {37: false, 38: false, 39: false, 40: false, 32: false};
                       
                        $("#map").keydown(function(e) {
                
                            if ((e.keyCode in keys)) {
                                keys[e.keyCode] = true;
                                STOP = false;
                                if( GAME == true ){
                               if (keys[32] && keys[40] || keys[32] && keys[39] ||
                                keys[32] && keys[38] || keys[32] && keys[37]) {
                                    
                                    setPosition(p=5);                  
                                    turbomodeOn();
                                    hidegamestopinfo();
                                    document.getElementById('vel').textContent = v2;
                                    
                                }
                                if ((keys[40] || keys[39] || keys[38] || keys[37]) && !keys[32]) {         
                                    document.getElementById('vel').textContent = v1;                  
                                                 
                                   setPosition(p=1);
                                   turbomodeOf();
                                   hidegamestopinfo();
                                   START_TIME = true;
                                }
                                if (keys[40]) {            
                                    map.panTo([
                                    lat -= movval2,
                                    lng -= movval1,
                                              
                                ]);updateTorchPosition("down");
                                }
                                if (keys[39]) {              
                                    map.panTo([
                                    lat += movval1,
                                    lng += movval2,  
                                ]);updateTorchPosition("right");
                                }
                                if (keys[38]) {                
                                    map.panTo([
                                    lat += movval2,
                                    lng += movval1,  
                                ]);updateTorchPosition("up");
                                }
                                if (keys[37]) {                 
                                    map.panTo([
                                    lat -= movval1,
                                    lng -= movval2,   
                                ]);updateTorchPosition("left");
                                }
                                }
                            }
                            update();
                        }).keyup(function(e) {
                            if (e.keyCode in keys) {
                                keys[e.keyCode] = false;
                                document.getElementById('vel').textContent = 0;
                                STOP = true;
                                if(GAME == true){
                                    
                                showgamestopinfo();
                                    
                                     hidegameturboinfo();
                                }
                                
                            }
                        });
                
                        //End game info
                        let formSubmitted = false;
                
                        function youwin() {
                        if (WIN == true && !formSubmitted) {
                            let inicialimage = document.getElementById("inicialimage");
                            let starrtgame = document.getElementById("startgame");
                
                            if (
                            inicialimage.style.display === "none" &&
                            starrtgame.style.display === "none"
                            ) {
                            inicialimage.style.display = "block";
                            inicialimage.style.zIndex = "2";
                            starrtgame.style.display = "block";
                            starrtgame.style.zIndex = "2";
                            }
                
                            START_TIME = false;
                            GAME = false;
                
                            hidegamestopinfo();
                            hidegameturboinfo();
                            confettiFalling();
                
                            setTimeout(() => {
                            document.getElementById("result").submit();
                            }, 4000);
                
                            formSubmitted = true; // Move this line inside the setTimeout function if needed
                        }
                        }
                
                        function gameover(){
                            let finalimage = document.getElementById("finalimage");
                            let reload = document.getElementById("reload");
                            
                            if( finalimage.style.display === "none" 
                                && reload.style.display === "none"
                            ){           
                                finalimage.style.display = "block";
                                finalimage.style.zIndex = "2"      
                                reload.style.display = "block";
                                reload.style.zIndex = "2"         
                            }
                            START_TIME = false;
                            GAME = false;
                            
                            hidegamestopinfo();
                            hidegameturboinfo()
                            
                        }
                  
                        //Time Game function   
                        const timeMinutes = 0;
                        let time = timeMinutes * 60;
                        const minutes = Math.floor(time / 60);
                        let seconds = time % 60; 
                        var clock = ('0' + minutes +":"+ '0' + seconds);
                
                        setInterval(() => {
                            if(START_TIME == true ){
                            
                                if(time >= 0){
                                    time++;   
                                }
                
                                const minutes = Math.floor(time / 60);
                                
                                let seconds = time % 60;
                
                                if(minutes < 10){
                                clock = seconds < 10 ? '0' + minutes +":"+ '0' + seconds :  
                                '0' + minutes +":" + seconds;
                                }else{
                                    clock = seconds < 10 ? minutes +":"+ '0' + seconds :  
                                minutes +":" + seconds;
                                }
                            }              
                            document.getElementById('clock').textContent = clock;
                            document.getElementById('finaltime').value = time;                     
                        }, 1000);
                        //
                        
                        //Draw marks in map
                        function draw(){
                            document.getElementById('lat').textContent = lat.toFixed(8);
                            document.getElementById('lon').textContent = lng.toFixed(8);
                
                            marker4 = L.marker([lat2, lng2], { icon: issIcon3 }).addTo(map);
                
                            if (marker2) {
                                map.removeLayer(marker2);  
                            }/**/
                            marker2 = L.marker([lat, lng], { icon: issIcon }).addTo(map);
                
                           let veggiecircle;
                           
                            setInterval(() => {      
                                ///Pineapple circle 
                                if (marker3) {
                                    map.removeLayer(marker3);  
                                }
                
                                 setInterval(() => {
                                 if (veggiecircle) {
                                    map.removeLayer(veggiecircle);  
                                
                                 }
                                }, 100);
                                  
                                if(GAME == true){
                                    
                                 marker3 = L.marker([lat3+=0.0000012, lng3+=0.000001], { icon: issIcon2 }).addTo(map);
                
                                 veggiecircle = L.circleMarker([lat3+=0.0000012, lng3+=0.000001], {
                                    
                                    radius: 50,
                                    color: '#f5fd08',
                                    fillOpacity: 0.1,
                                    }).addTo(map);
                                }
                            
                            }, 1000);
                           
                        }
                
                        // Calculate the torch position based on the direction of movement
                        function updateTorchPosition(direction) {
                  
                            if(NIGHT == true){
                                var torchCoordinates = [];
                                switch (direction) {
                                    case "up":
                                    torchCoordinates = [
                                        [lat + 0.01, lng - 0.005],
                                        [lat, lng],
                                        [lat + 0.01, lng + 0.005]
                                    ];
                                    break;
                                    case "right":
                                    torchCoordinates = [
                                        [lat - 0.005, lng + 0.01],
                                        [lat, lng],
                                        [lat + 0.005, lng + 0.01]
                                    ];
                                    break;
                                    case "down":
                                    torchCoordinates = [
                                        [lat - 0.01, lng - 0.005],
                                        [lat, lng],
                                        [lat - 0.01, lng + 0.005]
                                    ];
                                    break;
                                    case "left":
                                    torchCoordinates = [
                                        [lat - 0.005, lng - 0.01],
                                        [lat, lng],
                                        [lat + 0.005, lng - 0.01]
                                    ];
                                    break;
                                }
                                // Update the torch polygon coordinates
                                torch.setLatLngs(torchCoordinates);
                            }
                        }
                        
                        function update(){
                            draw();
                            setInterval(() => { 
                            var markerLatLng = L.latLng(lat, lng);
                            var circleCenterLatLng = L.latLng(lat2, lng2);
                            var circleCenterLatLngveggie = L.latLng(lat3, lng3);
                            var circleRadius = 50;
                            var distend = markerLatLng.distanceTo(circleCenterLatLng);
                            var distendveggie = markerLatLng.distanceTo(circleCenterLatLngveggie);
                
                            if ( distend <= circleRadius){
                                //console.log(distend);  
                            } 
                            if ( distend <= 500){
                                // Show the night vision layer
                                NIGHT = true;
                                map.addLayer(nightVisionLayer);
                            } 
                            if ( distend <= 10){  
                                WIN = true;
                            } 
                            if ( distendveggie <= 60){
                                CLOSE = false; 
                                closenemi()
                                gameover()
                            } 
                            if ( distendveggie <= 300 && GAME == true){
                                CLOSE = true;
                                closenemi()
                                hidegamestopinfo()
                            } else { CLOSE = false; closenemi() }
                
                            if(GAME == true && STOP == true && CLOSE == false ){
                                showgamestopinfo()
                            }
                
                            document.getElementById('distend').textContent = distend.toFixed(2);
                            //$('#distend').text(distend.toFixed(2));jquery
                            }, 1000);
                
                            youwin();
                        }; 
                
                        //red circle ///
                        var circle = L.circleMarker(map.getCenter(), {
                            radius: 50,
                            color: 'red',
                            fillOpacity: 0.2,
                        }).addTo(map);
                       
                        // Create the torch polygon
                        var torch = L.polygon([], {
                            color: 'yellow',
                            fillOpacity: 0.2
                        }).addTo(map);
                            
                        //Final distination///
                        var endcircle = L.circleMarker([lat2, lng2], {
                            className: 'circle-blink',
                            radius: 50,
                            color: 'green',
                            fillOpacity: 0.2,
                        }).addTo(map);
                
                        map.on('move',function(e){
                        circle.setLatLng(map.getCenter());
                        map._renderer._update();
                        });
                
                        //prevent window move when press key 32
                        $(document).on('keydown', 
                        function (e) {
                            if (e.keyCode == '32' && e.target.tagName != 'TEXTAREA') {
                                e.preventDefault();
                            }
                        });
                        //scroll to the top when refresh the page
                        $(document).ready(function(){
                            $(this).scrollTop(0);
                        });
                    
                    });
                
                
                </script>