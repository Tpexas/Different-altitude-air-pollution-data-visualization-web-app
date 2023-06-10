@extends('layout')
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://cdn.plot.ly/plotly-2.18.2.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'></script>
@endsection

@section('content')
@include('partials._search')


<div class="px-4">




    <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">

        <div class="col-span-1">
            <div class="flex flex-col py-4 text-center">
                <p class="font-bold text-xl">{{$firstReport->pavadinimas}}</p>
                <p>{{date("Y-m-d", strtotime($droneData[0]->date))}}
                    {{$droneData[0]->time}}
                </p>
                <p>Autorius - {{$firstReport->user()->first()->name}}</p>
            </div>
            <x-border-line class="">Oro kokybės lentelės</x-border-line>


            <div class=" flex space-x-6">
                @foreach($location as $list)
                <div>
                    <p>Vietovė: {{$list['name']}}, orų duomenys gauti
                        @endforeach
                        @foreach($pastWeather['list'] as $list)
                    </p>
                </div>
                <div>
                    <p>Vėjas: {{$list['wind']['speed']}} m/s, {{$list['wind']['deg']}} </p>
                </div>
                <div>
                    <p>Debesuotumas: {{$list['clouds']['all']}}%</p>
                </div>
                <div>
                    <p>Slėgis:
                        @php if(isset($list['main']['grnd_level'])){
                        echo $list['main']['grnd_level']." hPa";
                        }
                        else echo $list['main']['pressure']." hPa";
                        @endphp
                    </p>
                </div>
                @if(isset($list['rain']['1h']))
                <div>
                    <p>Lietaus kiekis pastarają valandą: {{$list['rain']['1h']}} mm</p>
                </div>
                @endif
                @if(isset($list['snow']['1h']))
                <div>
                    <p>Sniego kiekis pastarają valandą: {{$list['snow']['1h']}} mm</p>
                </div>
                @endif
                @endforeach
            </div>

            <div class=" font-medium lg:flex gap-6">
                <div class="lg:w-3/5 ">
                    <div class="rounded-lg overflow-hidden shadow-lg shadow-indigo-500/50">
                        <p class="px-1">Didžiausios CO2 taršos taškai</p>
                        <table class="tarsos_taskai w-full text-sm text-left">
                            <thead class="uppercase border-b border-gray-700">
                                <tr>
                                    <th scope=" col" class="py-4">
                                        Ilguma
                                    </th>
                                    <th scope="col" class="py-4">
                                        Platuma
                                    </th>
                                    <th scope="col" class="py-4">
                                        Aukštis
                                    </th>
                                    <th scope="col" class="py-4">
                                        CO2 (PPM)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maxPollution as $row)
                                <tr
                                    class="border-b border-gray-700 @include('components.case', ['data' => $row->sensor1, 'limits' => [0,700,1100,1600,2100]])">
                                    <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                        {{$row->latitude}}
                                    </th>
                                    <td class="py-4">
                                        {{$row->longitude}}
                                    </td>
                                    <td class="py-4">
                                        {{$row->altitude}}
                                    </td>
                                    <td class="py-4">
                                        {{$row->sensor1}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="w-2/5 pt-6">
                    <table class="w-full text-sm text-left ">
                        <tbody>
                            <thead class=" uppercase border-b border-gray-700">
                                <tr>
                                    <th scope=" col" class="py-4">
                                        Bendra informacija
                                    </th>
                                </tr>
                            </thead>
                            <tr
                                class="border-b border-gray-700 @include('components.case', ['data' => $highestPollution, 'limits' => [0,700,1100,1600,2100]])">
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    Aukščiausia tarša:
                                </th>
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    {{$highestPollution}} PPM
                                </th>

                            <tr
                                class="border-b border-gray-700 @include('components.case', ['data' => $minPollution, 'limits' => [0,700,1100,1600,2100]])">
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    Mažiausia tarša:
                                </th>
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    {{$minPollution}} PPM
                                </th>

                            <tr class="border-b border-gray-700
                @include('components.case', ['data' => $avgPollution, 'limits' => [0,700,1100,1600,2100]])">
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    Vidutinė tarša:
                                </th>
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    {{$avgPollution}} PPM
                                </th>
                            <tr class="bg-white border-b border-gray-700">
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    Skrydžio laikas:
                                </th>
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    {{gmdate("H:i:s", $flightTime)}}
                                </th>
                            <tr class="bg-white border-b border-gray-700">
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">
                                    Vidutinė temperatūra ir drėgmė:
                                </th>
                                <th scope="row" class="py-4 font-medium  whitespace-nowrap">

                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="">

                <div class="flex flex-wrap justify-center gap-6">
                    @foreach($pastPollution['list'] as $list)
                    <div
                        class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['main']['aqi'], 'limits' => [1,2,3,4,5]])">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight ">OKI</h5>
                        <p class="font-normal">Oro kokybės indeksas</p>
                        <p class="font-bold ">{{$list['main']['aqi']}}</p>
                    </div>
                    <div
                        class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['co'], 'limits' => [0,4400,9400,12400,15400]])">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight ">CO</h5>
                        <p class="font-normal">Anglies monoksidas</p>
                        <p class="font-bold ">{{$list['components']['co']}} µg/m3</p>
                    </div>
                    <div
                        class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['o3'], 'limits' => [0,40,70,150,200]])">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight ">O3</h5>
                        <p class="font-normal">Ozonas</p>
                        <p class="font-bold ">{{$list['components']['o3']}} µg/m3</p>
                    </div>
                    <div
                        class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['pm2_5'], 'limits' => [0,10,25,50,75]])">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight ">PM2.5</h5>
                        <p class="font-normal">Kietosios dalelės</p>
                        <p class="font-bold ">{{$list['components']['pm2_5']}} µg/m3</p>
                    </div>
                    <div
                        class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['pm10'], 'limits' => [0,20,50,100,200]])">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight ">PM10</h5>
                        <p class="font-normal">Kietosios dalelės</p>
                        <p class="font-bold ">{{$list['components']['pm10']}} µg/m3</p>
                    </div>
                    <div
                        class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['no2'], 'limits' => [0,40,70,150,200]])">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight">NO2</h5>
                        <p class="font-normal">Azoto dioksidas</p>
                        <p class="font-bold ">{{$list['components']['no2']}} µg/m3</p>
                    </div>
                    <div
                        class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center @include('components.case', ['data' => $list['components']['so2'], 'limits' => [0,20,80,250,350]])">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight">SO2</h5>
                        <p class="font-normal">Sieros dioksidas</p>
                        <p class="font-bold ">{{$list['components']['so2']}} µg/m3</p>
                    </div>
                    <div class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center bg-white">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight">NH3</h5>
                        <p class="font-normal">Amoniakas</p>
                        <p class="font-bold ">{{$list['components']['nh3']}} µg/m3</p>
                    </div>
                    <div class="p-6 shrink max-w-max rounded-lg shadow-md shadow-indigo-500/50 text-center bg-white">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight">NO</h5>
                        <p class="font-normal">Azoto monoksidas</p>
                        <p class="font-bold ">{{$list['components']['no']}} µg/m3</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <x-border-line class="">Diagramos</x-border-line>

            @if ($firstReport->has_drone_data == true)
            <div class="">
                <p>Drono aukštis per laiką</p>
                <div class="h-auto max-w-auto ">
                    {!! $altitudeChart->container() !!}
                </div>
            </div>

            {!! $altitudeChart->script() !!}
            @endif

            @if ($firstReport->has_sensor_data == true)
            <div class="">
                <p>Taršos matavimai per laiką</p>
                <div class="h-auto max-w-auto">
                    {!! $sensorChart->container() !!}
                </div>
            </div>

            {!! $sensorChart->script() !!}
            @endif

            <x-border-line class="">Skrydžio ir taršos duomenys žemelapyje</x-border-line>

            <div class="">
                <div id="floating-panel pb-1">
                    <button type="button"
                        class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        id="toggle-heatmap">Rodyti spalvas</button>
                    <button
                        class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        id="toggle-path">Rodyti skrydžio kelią</button>
                    <button
                        class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        id="change-gradient">Pakeisti spalvą</button>
                    <button
                        class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        id="change-radius">Pakeisti plotą</button>
                    <button
                        class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        id="change-opacity">Pakeisti ryškumą</button>
                </div>
                <div id="map" class="h-[500px] w-full" style="height: 500px; width: 100%;"></div>
                <div>
                    <p class="">Spalvų reikšmės pagal CO2 PPM</p>
                    <div class="flex w-64 justify-between">
                        <div class="w-32 h-6 bg-gradient-to-r from-aqi_green via-aqi_yellow  to-aqi_orange "></div>
                        <div class="w-32 h-6 bg-gradient-to-r from-aqi_orange via-aqi_red  to-aqi_purple "></div>
                    </div>
                    <div class="flex w-64 justify-between">
                        <p>400</p>
                        <p>700</p>
                        <p>1100</p>
                        <p>1700</p>
                        <p>2100</p>
                    </div>
                </div>
            </div>
            <x-border-line class="">Skyrdžio ir taršos duomenys 3D aplinkoje</x-border-line>
            <div class="">
                <div id='myDiv' class="w-full">
                    <!-- Plotly chart will be drawn inside this DIV -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let map, heatmap, flightPath;
   function initMap() {
    var mapProp = {
      zoom: 20,
    center: { lat: {{$droneData[$coordinateCenter]->latitude}}, lng: {{$droneData[$coordinateCenter]->longitude}}},
    mapTypeId: "satellite",
  };
  var map = new google.maps.Map(document.getElementById("map"), mapProp);


  map1 = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
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
  
  heatmap = new google.maps.visualization.HeatmapLayer({
    data: getPoints(),
    map: map1,
    maxIntensity:2000,
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

function getPoints() {
  return [

  @php
    foreach($droneAndSensorData as $row){
      echo "{location: new google.maps.LatLng($row->latitude, $row->longitude), weight: $row->sensor1},";
    }
  @endphp
  ];
}

function getFlightPoints() {
  return [

  @php
    foreach($droneAndSensorData as $row){
      echo "new google.maps.LatLng($row->latitude, $row->longitude),";
    }
  @endphp

  ];
}
window.initMap = initMap;
</script>

@php
foreach($droneData as $row){
$x[] = $row->latitude;


}
@endphp

<script>
    d3.csv('https://raw.githubusercontent.com/Tpexas/dataset/main/csv.csv', function(err, rows){
Plotly.newPlot('myDiv', [{
  type: 'scatter3d',
  mode: 'lines',
  showlegend: true,

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
  }
}], {
  
  height: 920
}, config = {responsive: true});
});

</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=visualization&callback=initMap"
    defer>
</script>

@endsection