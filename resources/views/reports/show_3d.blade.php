@extends('layout')
@section('scripts')
<script src="https://cesium.com/downloads/cesiumjs/releases/1.95/Build/Cesium/Cesium.js"></script>
<link href="https://cesium.com/downloads/cesiumjs/releases/1.95/Build/Cesium/Widgets/widgets.css" rel="stylesheet">
@endsection

@section('content')


<div class="col-span-1 relative">
    <a class="border-y border-black/25 rounded-none hover:bg-gray-200 md:absolute md:m-0 m-2 top-2 xl:left-48 left-16"
        href="/ataskaitos/{{$report->id}}">Grįžti</a>
    <x-border-line class="col-span-1 text-center">Vizualizacija 3D aplinkoje</x-border-line>

    <div id="cesiumContainer" style="width:80%; height:80%;" class="mx-auto"></div>
    <div id="tooltip"
        style="display: none; position: absolute; pointer-events: none; background-color: rgba(42, 42, 42, 0.8); border-radius: 4px; padding: 6px 12px; color: white;">
    </div>
    <div class="flex justify-center">
        <div class="w-72 text-center">
            <p class="">Spalvų reikšmės pagal CO2 PPM</p>
            <div class="flex justify-between mx-auto">
                <div class="w-14 h-6 bg-aqi_green"></div>
                <div class="w-14 h-6 bg-aqi_yellow"></div>
                <div class="w-14 h-6 bg-aqi_orange"></div>
                <div class="w-14 h-6 bg-aqi_red"></div>
                <div class="w-14 h-6 bg-aqi_purple"></div>
            </div>
            <div class="flex w-64 justify-between">
                <p>400</p>
                <p>1000</p>
                <p>2000</p>
                <p>5000</p>
                <p>
                    40000</p>
            </div>
        </div>
    </div>
</div>

<script>
    Cesium.Ion.defaultAccessToken = '';
    const viewer = new Cesium.Viewer('cesiumContainer', {
  terrainProvider: Cesium.createWorldTerrain()
});
const osmBuildings = viewer.scene.primitives.add(Cesium.createOsmBuildings());

const hexColor = "#FF0000";
const cesiumColor = Cesium.Color.fromCssColorString(hexColor);

      const pathCoordinates = [
        @foreach($droneAndSensorData as $row)
    {longitude: {{$row->longitude}}, latitude: {{$row->latitude}}, sensor1: {{$row->sensor1}}, altitude: {{$row->altitude}}, color:  @switch($row->sensor1)
@case($row->sensor1<1000) "#00e400" @break
@case($row->sensor1>=1000 && $row->sensor1<2000) "#ffff00" @break
@case($row->sensor1>=2000 && $row->sensor1<5000) "#ff7e00" @break
@case($row->sensor1>=5000 && $row->sensor1<40000) "#ff0000" @break
@case($row->sensor1>=40000) "#8F3F97" @break
@endswitch,},
    @endforeach
];

const positions = [];

pathCoordinates.forEach((coordinate, index) => {
    if (index < pathCoordinates.length - 1) {
        const nextCoordinate = pathCoordinates[index + 1];
        const start = Cesium.Cartesian3.fromDegrees(
            coordinate.longitude,
            coordinate.latitude,
            coordinate.altitude
        );
        const end = Cesium.Cartesian3.fromDegrees(
            nextCoordinate.longitude,
            nextCoordinate.latitude,
            nextCoordinate.altitude
        );
        const cesiumColor = Cesium.Color.fromCssColorString(coordinate.color);

      const polylineEntity =  viewer.entities.add({
            polyline: {
                positions: [start, end],
                width: 6,
                material: cesiumColor
            }, 
            description: nextCoordinate.altitude,
            name: 'Taško duomenys',
   show: this.show,
   wall: {
      positions: [start, end],
      outline: true,
      outlineWidth: 1,
      outlineColor: cesiumColor.withAlpha(0.2),
      material: cesiumColor.withAlpha(0.2),
   }
        });
        polylineEntity.segmentData = "Aukštis: " + nextCoordinate.altitude + "m" + "<br>" + "Matavimai: " + nextCoordinate.sensor1 + "PPM<br>" + "Koordinatės: " + nextCoordinate.latitude.toString().slice(0, -9) + ", " +nextCoordinate.longitude.toString().slice(0, -9);
    }
});

const mouseHandler = new Cesium.ScreenSpaceEventHandler(viewer.canvas);

const tooltipElement = document.getElementById('tooltip');


let highlightedPolyline;

mouseHandler.setInputAction((event) => {
    const pickedObject = viewer.scene.pick(event.endPosition);
    if (Cesium.defined(pickedObject) && Cesium.defined(pickedObject.id) && pickedObject.id.polyline) {
        tooltipElement.style.display = 'block';
        tooltipElement.innerHTML = `Taško duomenys <br> ${pickedObject.id.segmentData}`;
        tooltipElement.style.top = `${event.endPosition.y + 125}px`;
        tooltipElement.style.left = `${event.endPosition.x + 200}px`;
        if (highlightedPolyline && highlightedPolyline !== pickedObject.id) {        
            // Grąžinama prieš tai buvusi linijos spalva
            highlightedPolyline.polyline.material = highlightedPolyline.originalMaterial;
            highlightedPolyline.wall.material = highlightedPolyline.wall.originalMaterial;
        }
        // Nustatoma linija, kurią reikia paryškinti
        highlightedPolyline = pickedObject.id;
        // Išsaugoma pradinė linijos spalva
        if (!highlightedPolyline.originalMaterial) {
            highlightedPolyline.originalMaterial = highlightedPolyline.polyline.material;
            highlightedPolyline.wall.originalMaterial =  highlightedPolyline.wall.material;
        }
        // Pakeičiama paryškintos linijos spalva
        highlightedPolyline.polyline.material = new Cesium.ColorMaterialProperty(Cesium.Color.BLUE);
        highlightedPolyline.wall.material = new Cesium.ColorMaterialProperty(Cesium.Color.BLUE.withAlpha(0.2));
    } else {
        if (highlightedPolyline) {
            // Grąžinama linjos spalva kai pelės žymeklis nėra užvestas
            highlightedPolyline.polyline.material = highlightedPolyline.originalMaterial;
            highlightedPolyline.wall.material = highlightedPolyline.wall.originalMaterial;
            highlightedPolyline = undefined;
            highlightedPolyline.wall= undefined;
        }
        tooltipElement.style.display = 'none';
    }
}, Cesium.ScreenSpaceEventType.MOUSE_MOVE);

// const handler = new Cesium.ScreenSpaceEventHandler(viewer.canvas);
function zoomToPolyline() {
    const positions = pathCoordinates.map(coordinate =>
        Cesium.Cartesian3.fromDegrees(
            coordinate.longitude,
            coordinate.latitude,
            coordinate.altitude
        )
    );

    const boundingSphere = Cesium.BoundingSphere.fromPoints(positions);

    viewer.camera.flyToBoundingSphere(boundingSphere, {
        offset: new Cesium.HeadingPitchRange(0, Cesium.Math.toRadians(-40), boundingSphere.radius * 2)
    });
}

zoomToPolyline();
</script>

@endsection
