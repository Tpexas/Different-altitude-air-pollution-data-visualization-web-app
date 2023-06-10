@section('googleMaps')
<script>
  let map, heatmap, flightPath;
     function initMap() {
      var mapProp = {
        zoom: 20,
      center: { lat: {{$droneData[$coordinateCenter]->latitude}}, lng: {{$droneData[$coordinateCenter]->longitude}}},
      mapTypeId: "satellite",
    };
    var map = new google.maps.Map(document.getElementById("map"), mapProp);
    // flightPath = new google.maps.Polyline({
    //   path: [
    //     @php
    //   foreach($droneData as $row){
    //     echo "new google.maps.LatLng($row->latitude, $row->longitude),";
    //   }
    // @endphp
    //  ],
    //   geodesic: true,
    //   strokeColor: "#FF0000",
    //   strokeOpacity: 1.0,
    //   strokeWeight: 2,
    // });
    // flightPath.setMap(map);
  
  
    map1 = new google.maps.Map(document.getElementById("map"), {
      zoom: 15,
      // center: { lat: 32.382131068919, lng: -99.753819229789},
      center: { lat: {{$droneData[$coordinateCenter]->latitude}}, lng: {{$droneData[$coordinateCenter]->longitude}}},
      mapTypeId: "satellite",
    });
    {{$i=0}}
    @foreach($maxPollution as $row)
    {{$i++}}
    const infowindow{{$i}} = new google.maps.InfoWindow({
      content: '<div>Koordinatės: {{$row->latitude}}; {{$row->longitude}}</div>' +
      '<div>Aukštis: {{$row->altitude}}</div>' +
      '<div>Tarša: {{$row->sensor1}} PPM</div>',
      ariaLabel: "Uluru",
    });
    marker{{$i}} = new google.maps.Marker({
      position:  { lat: {{$row->latitude}}, lng: {{$row->longitude}}},
      map: map1,
      title: "Uluru (Ayers Rock)",
    });
    marker{{$i}}.addListener("click", () => {
      infowindow{{$i}}.open({
        anchor: marker{{$i}},
        map: map1,
      });
    });
    @endforeach
  
  
  
    // marker = new google.maps.Marker({
    //   position:  { lat: 55.702023175898, lng: 21.139894149702},
    //   map: map1,
    //   title: "Uluru (Ayers Rock)",
    // });
    // marker1 = new google.maps.Marker({
    //   position:  { lat: 55.699786109703, lng: 21.144399063407},
    //   map: map1,
    //   title: "Uluru (Ayers Rock)",
    // });
    // infowindow = new google.maps.InfoWindow({
    //   content: '<div id="content">' +
    //   '<div id="siteNotice">' +
    //   "</div>" +
    //   '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
    //   '<div id="bodyContent">',
    //   ariaLabel: "Uluru",
    // });
    // marker.addListener("click", () => {
    //   infowindow.open({
    //     anchor: marker,
    //     map,
    //   });
    // });
    
  
  
    heatmap = new google.maps.visualization.HeatmapLayer({
      data: getPoints(),
      map: map1,
      maxIntensity:10000,
    });
    flightPath = new google.maps.Polyline({
      path: getFlightPoints(),
      geodesic: true,
      strokeColor: "#FF0000",
      strokeOpacity: 1.0,
      strokeWeight: 2,
      map: map1,
    });
    document
      .getElementById("toggle-heatmap")
      .addEventListener("click", toggleHeatmap);
      document
      .getElementById("toggle-path")
      .addEventListener("click", toggleFlightPath);
    document
      .getElementById("change-gradient")
      .addEventListener("click", changeGradient);
    document
      .getElementById("change-opacity")
      .addEventListener("click", changeOpacity);
    document
      .getElementById("change-radius")
      .addEventListener("click", changeRadius);
  }
  
  function toggleHeatmap() {
    heatmap.setMap(heatmap.getMap() ? null : map1);
  }
  function toggleFlightPath() {
    flightPath.setMap(flightPath.getMap() ? null : map1);
  }
  function changeGradient() {
    const gradient = [
      // "rgba(0, 255, 255, 0)",
      // "rgba(0, 255, 255, 1)",
      // "rgba(0, 191, 255, 1)",
      // "rgba(0, 127, 255, 1)",
      // "rgba(0, 63, 255, 1)",
      // "rgba(0, 0, 255, 1)",
      // "rgba(0, 0, 223, 1)",
      // "rgba(0, 0, 191, 1)",
      // "rgba(0, 0, 159, 1)",
      // "rgba(0, 0, 127, 1)",
      // "rgba(63, 0, 91, 1)",
      // "rgba(127, 0, 63, 1)",
      // "rgba(191, 0, 31, 1)",
      "rgba(0, 255, 255, 0)",
      "RGB(0, 228, 0)",
      "RGB(255, 255, 0)",
      "RGB(255, 126, 0)",
      "RGB(255, 0, 0)",
      "RGB(143, 63, 151)",
    ];
  
    heatmap.set("gradient", heatmap.get("gradient") ? null : gradient);
  }
  
  function changeRadius() {
    heatmap.set("radius", heatmap.get("radius") ? null : 20);
  }
  
  function changeOpacity() {
    heatmap.set("opacity", heatmap.get("opacity") ? null : 0.2);
  }
  
  // Heatmap data: 500 Points
  function getPoints() {
    return [
      // new google.maps.LatLng(37.782551, -122.445368),
  
    @php
      foreach($droneAndSensorData as $row){
        echo "{location: new google.maps.LatLng($row->latitude, $row->longitude), weight: $row->sensor1},";
      }
    @endphp
    // {location: new google.maps.LatLng(32.38206996, -99.7538718), weight: 2000},
    // {location: new google.maps.LatLng(32.3820700, -99.753972), weight: 1},
    ];
  }
  
  function getFlightPoints() {
    return [
      // new google.maps.LatLng(37.782551, -122.445368),
  
    @php
      foreach($droneAndSensorData as $row){
        echo "new google.maps.LatLng($row->latitude, $row->longitude),";
      }
    @endphp
  
    ];
  }
  window.initMap = initMap;
</script>

@endsection

<script>
  const pollutionData = [
    { lat: 40.7000, lng: -74.0000, pollution: 45 },
    { lat: 40.7010, lng: -74.0010, pollution: 35 },
    { lat: 40.7020, lng: -74.0020, pollution: 25 },
    { lat: 40.7020, lng: -74.0030, pollution: 65 },
    { lat: 40.7050, lng: -74.0130, pollution: 80 },
    { lat: 40.7050, lng: -74.0140, pollution: 10 },
    { lat: 40.7150, lng: -74.0140, pollution: 21 },
    { lat: 40.7150, lng: -74.0180, pollution: 32 },
    { lat: 40.8150, lng: -74.1180, pollution: 22 },
    { lat: 40.8150, lng: -74.1180, pollution: 66 },
    { lat: 40.8150, lng: -74.1180, pollution: 66 },
    { lat: 40.8150, lng: -74.1180, pollution: 22 },
    { lat: 40.8150, lng: -74.1180, pollution: 22 },
    // ...
  ];

  // Initialize the Leaflet map
  var map = L.map('map5').setView([40.7, -74.0], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  

  const gridSize = 0.001; // Change this value to set the grid size
const latMin = 40.69; // Minimum latitude
const latMax = 40.82; // Maximum latitude
const lngMin = -74.12; // Minimum longitude
const lngMax = -73.99; // Maximum longitude

// Define a function to map pollution values to colors
function getColor(pollution) {
  return pollution > 80 ? '#800026' :
         pollution > 60 ? '#BD0026' :
         pollution > 40 ? '#E31A1C' :
         pollution > 20 ? '#cee649' :
         pollution > 10 ? '#FD8D3C' :
         pollution > 5  ? '#FEB24C' :
         pollution > 0  ? '#00': '#00' ;
                          
}

// Iterate over the grid and create rectangles
for (let lat = latMin; lat <= latMax; lat += gridSize) {
  for (let lng = lngMin; lng <= lngMax; lng += gridSize) {
    // Get the average pollution for the current square (you need to implement this based on your data)
    const averagePollution = getAveragePollution(lat, lng, gridSize);

    // Create a rectangle for the current square
    const rectangle = L.rectangle([[lat, lng], [lat + gridSize, lng + gridSize]], {
      color: getColor(averagePollution),
      weight: 1,
      fillColor: getColor(averagePollution),
      fillOpacity: 0.7
    });

    // Add the rectangle to the map
    rectangle.addTo(map);
  }
}

function getAveragePollution(lat, lng, gridSize) {
  // Define the bounds of the grid square
  const bounds = {
    latMin: lat,
    latMax: lat + gridSize,
    lngMin: lng,
    lngMax: lng + gridSize
  };

  // Filter the pollution measurements that fall within the grid square
  const measurementsInSquare = pollutionData.filter(measurement => {
    return measurement.lat >= bounds.latMin &&
           measurement.lat <= bounds.latMax &&
           measurement.lng >= bounds.lngMin &&
           measurement.lng <= bounds.lngMax;
  });

  // Calculate the average pollution value based on the extracted measurements
  const totalPollution = measurementsInSquare.reduce((sum, measurement) => sum + measurement.pollution, 0);
  const averagePollution = totalPollution / measurementsInSquare.length;

  return averagePollution;
}
</script>

<script>
  function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 16,
    center: { lat: {{$droneData[$coordinateCenter]->latitude}}, lng: {{$droneData[$coordinateCenter]->longitude}}},
    mapTypeId: "satellite",
  });
  const flightPlanCoordinates = [
    @foreach($droneAndSensorData as $row)
    {lat: {{$row->latitude}}, lng: {{$row->longitude}}},
    @endforeach
  ];
  {{$i=0}}
  @foreach($droneAndSensorData as $row)
  const flightPath{{$i}} = new google.maps.Polyline({
    path: flightPlanCoordinates.slice({{$i}}, {{$i+2}}),
    geodesic: true,
    strokeColor: @switch($row->sensor1)
@case($row->sensor1<700) "#00e400" @break
@case($row->sensor1>=700 && $row->sensor1<1100) "#ffff00" @break
@case($row->sensor1>=1100 && $row->sensor1<1700) "#ff7e00" @break
@case($row->sensor1>=1700 && $row->sensor1<2100) "#ff0000" @break
@case($row->sensor1>=2100) "#8F3F97" @break
@endswitch,
    strokeOpacity: 0.4,
    strokeWeight: {{$row->sensor1/105}},
  });

  flightPath{{$i}}.setMap(map);
  {{$i++}}
  @endforeach

  {{$x=0}}
    @foreach($maxPollution as $row)
    const infowindow{{$x}} = new google.maps.InfoWindow({
      content: '<div>Koordinatės: {{$row->latitude}}; {{$row->longitude}}</div>' +
      '<div>Aukštis: {{$row->altitude}}</div>' +
      '<div>Tarša: {{$row->sensor1}} PPM</div>',
      ariaLabel: "Uluru",
    });
    marker{{$x}} = new google.maps.Marker({
      position:  { lat: {{$row->latitude}}, lng: {{$row->longitude}}},
      map: map,
      title: "Uluru (Ayers Rock)",
    });
    marker{{$x}}.addListener("click", () => {
      infowindow{{$x}}.open({
        anchor: marker{{$x}},
        map: map,
      });
    });
    infowindow{{$x}}.setMap(map);
  {{$x++}}
    @endforeach
}

window.initMap = initMap;
</script>

<script>
  d3.csv('https://raw.githubusercontent.com/Tpexas/dataset/main/csv.csv', function(err, rows){

Plotly.newPlot('myDiv', [{
  type: 'scatter3d',
  mode: 'lines',
  name: 'oro taršos priklausomybė nuo bepiločio pozicijos',


  x:[
  @php
    foreach($droneData as $row){
      echo "\"$row->latitude\",";
    }
  
  @endphp
  ],
  y:[
  @php
    foreach($droneData as $row){
      echo "\"$row->longitude\",";
    }
  
  @endphp
  ],
  z:[
  @php
    foreach($droneData as $row){
      echo "\"$row->altitude\",";
    }
  
  @endphp
  ],
  opacity: 1,
  
  line: {
    colorscale: [
    ['0.0', 'RGB(0, 228, 0)'],
    ['0.35', 'RGB(255, 255, 0)'],
    ['0.55', 'RGB(255, 126, 0)'],
    ['0.85', 'RGB(255, 0, 0)'],
    ['1.0', 'RGB(143, 63, 151)']
  ],
    width:12,
    color : [
      @php
    foreach($droneAndSensorData as $row){
      echo "$row->sensor1,";
    }
  @endphp
    ],
    cmin: 0,
    cmax:2100,
    showscale: true,
    

  },
}], {
  
  height: 920,
  title:{
    text: 'Oro taršos priklausomybė nuo bepiločio pozicijos',
  }
}, config = {responsive: true});
});

</script>