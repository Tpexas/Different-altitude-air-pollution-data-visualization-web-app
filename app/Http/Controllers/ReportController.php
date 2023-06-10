<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\SensorData;
use App\Exports\DataExport;
use Illuminate\Http\Request;

use App\Imports\DroneDataImport;
use App\Imports\SensorDataImport;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ReportController extends Controller
{
    public function index(){
        
        return view('reports.index', [
            'reports' => Report::latest()->filter(request(['search']))->paginate(10)
        ]);
    }

    public function show3D(Report $report){
        $droneAndSensorData = SensorData::select('sensor_data.*', 'drone_data.*')->join('drone_data', 'sensor_data.time', '=', 'drone_data.time')
            ->where([['sensor_data.report_id', '=', $report->id], ['drone_data.report_id', '=', $report->id]])->groupBy('sensor_data.id')->get();
            foreach($droneAndSensorData as $data){
                $data['altitude'] = $data->altitude*0.304;
            }

            return view('reports.show_3D', [
                'droneAndSensorData' => $droneAndSensorData,
                'report' => $report
            ]);

    }

    public function show(Report $report){
        $droneData = $report->drone_data()->get();
        foreach($droneData as $data){
            $data['altitude'] = $data->altitude*0.304;
            $data['time'] = date('H:i:s', strtotime($data->time. ' + 7 hours'));
        }
        $droneAndSensorData = SensorData::select('sensor_data.*', 'drone_data.*')->join('drone_data', 'sensor_data.time', '=', 'drone_data.time')
            ->where([['sensor_data.report_id', '=', $report->id], ['drone_data.report_id', '=', $report->id]])->groupBy('sensor_data.id')->get();
            if($droneAndSensorData->isNotEmpty()){
        foreach($droneAndSensorData as $data){
            $data['altitude'] = $data->altitude*0.304;
            $data['time'] = date('H:i:s', strtotime($data->time. ' + 7 hours'));
        }


            $coordinateCenter  = floor(count($droneAndSensorData)/2);

        $droneChartData = $droneData->pluck('altitude', 'time');
                    
        $maxPollution = $droneAndSensorData->sortByDesc('sensor1')->take(5);

        $highestPollution = $droneAndSensorData->max('sensor1');
        $avgPollution = round($droneAndSensorData->avg('sensor1'), 1);
        $minPollution = $droneAndSensorData->min('sensor1');
        $avgTemp = round($droneAndSensorData->avg('temperature'), 1);
        $avgHumidity = round($droneAndSensorData->avg('humidity'), 1);
        $minLat = $droneAndSensorData->min('latitude');
        $maxLat = $droneAndSensorData->max('latitude');
        $minLng = $droneAndSensorData->min('longitude');
        $maxLng = $droneAndSensorData->max('longitude');
        
        $api = '';
        $start = strtotime($droneAndSensorData[0]->date . $droneAndSensorData[0]->time);
        $end = $start+3600;
        $lat = $droneAndSensorData[$coordinateCenter]->latitude;
        $lng = $droneAndSensorData[$coordinateCenter]->longitude;
        $pastPollution = Http::get("http://api.openweathermap.org/data/2.5/air_pollution/history?lat={$lat}&lon={$lng}&start={$start}&end={$end}&appid={$api}");
        $pastWeather = Http::get("https://history.openweathermap.org/data/2.5/history/city?lat={$lat}&lon={$lng}&type=hour&start={$start}&end={$end}&appid={$api}"); 
        $location = Http::get("http://api.openweathermap.org/geo/1.0/reverse?lat={$lat}&lon={$lng}&limit=1&appid={$api}");
        $windApi = "http://maps.openweathermap.org/maps/2.0/weather/WND/{z}/{x}/{y}?date={$start}&appid={$api}";

        foreach($pastWeather['list'] as $list){
            $direction = $list['wind']['deg'] / 22.5 + .5;
        $cardinal_array = [ "Šiaurės","Šiaurės-šiaurės rytų","Šiaurės rytų","Rytų-šiaurės rytų","Rytų","Rytų-pietryčių", "Pietryčių", "Pietų-pietryčių","Pietų","Pietų-pietvakarių","Pietvakarių","Vakarų-pietvakarių","Vakarų","Vakarų-šiaurės vakarų","Šiaurės vakarų","Šiaurės-šiaurės vakarų" ];
        $cardinal = $cardinal_array[ ( $direction % 16 ) ];
        }

        $flightTime = (strtotime($droneData->pluck('time')->last())-strtotime($droneData->pluck('time')->first()));

        $labels = $droneAndSensorData->pluck('time')->toArray();
$sensor1 = $droneAndSensorData->pluck('sensor1')->toArray();
$altitude = $droneAndSensorData->pluck('altitude')->toArray();
$pm10 = $droneAndSensorData->pluck('pm10')->toArray();
$pm2_5 = $droneAndSensorData->pluck('pm2_5')->toArray();
$no2 = $droneAndSensorData->pluck('no2')->toArray();
$so2 = $droneAndSensorData->pluck('so2')->toArray();
$o3 = $droneAndSensorData->pluck('o3')->toArray();
$co = $droneAndSensorData->pluck('co')->toArray();

        return view('reports.show', [
            'report' => $report,
            'droneData' => $droneData,
            'droneChartData' => $droneChartData,
            'droneAndSensorData' => $droneAndSensorData,
            'maxPollution' => $maxPollution,
            'avgPollution' => $avgPollution,
            'minPollution' => $minPollution,
            'highestPollution' => $highestPollution,
            'coordinateCenter' => $coordinateCenter,
            'pastPollution' => $pastPollution,
            'pastWeather' => $pastWeather->json(),
            'location' => $location->json(),
            'flightTime' => $flightTime,
            'windApi' => $windApi,
            'avgTemp' => $avgTemp,
            'avgHumidity' => $avgHumidity,
            'minLat' => $minLat,
            'maxLat' => $maxLat,
            'minLng' => $minLng,
            'maxLng' => $maxLng,
            'labels' => $labels,
            'sensor1' => $sensor1,
            'altitude' => $altitude,
            'pm10' => $pm10,
            'pm2_5' => $pm2_5,
            'no2' => $no2,
            'so2' => $so2,
            'o3' => $o3,
            'co' => $co,
            'cardinal' => $cardinal,
            'error' => $error = false,
            ]);
        }
        else{
            $error = true;
            return view('reports.show', [
                'report' => $report,
                'error' => $error,

                ]); 
        }
    }
    
    public function create(){
        return view('reports.create');
    }

    public function store(Request $request){

        $formFields = $request->validate([
            'pavadinimas' => 'required|max:64',
            'aprasymas' => 'nullable',

        ]);

        $formFields['user_id'] = auth()->id();

        $validateFiles = $request->validate([
            'sensor_data' => 'required|mimes:csv,txt',
            'drone_data' => 'required|mimes:csv,txt'
        ]);

        if($request->hasFile('sensor_data') && $request->hasFile('drone_data')){
            $formFields['has_sensor_data'] = true;
            $formFields['has_drone_data'] = true;
        }
        else if($request->hasFile('sensor_data') && !$request->hasFile('drone_data')){
            $formFields['has_sensor_data'] = true;
        }
        else if($request->hasFile('drone_data') && !$request->hasFile('sensor_data')){
            $formFields['has_drone_data'] = true;
        }

            $sensor_columns= (new HeadingRowImport)->toArray($request->file('sensor_data'));
            $drone_columns= (new HeadingRowImport)->toArray($request->file('drone_data'));

                foreach($sensor_columns[0] as $col){
                if (in_array("time", $col) && in_array("temperature", $col) && in_array("humidity", $col) && in_array("sensor1", $col)
                && in_array("so2", $col) && in_array("pm10", $col) && in_array("pm2_5", $col) && in_array("no2", $col)
                && in_array("o3", $col) && in_array("co", $col)) {
                 $sensor_data_valid = true;
            }else{
                $sensor_data_valid = false;
            }
        }

        foreach($drone_columns[0] as $col){
        if (in_array("customdate_local", $col) && in_array("customupdatetime_local", $col) && in_array("osdlatitude", $col) && in_array("osdlongitude", $col)
        && in_array("osdheight_ft", $col)) {
         $drone_data_valid = true;
    }else{
        $drone_data_valid = false;
    }
}

if($sensor_data_valid && $drone_data_valid){
    $report = Report::create($formFields);


            if($request->hasFile('sensor_data')){
                $report_id = $report->id;
            Excel::import(new SensorDataImport($report_id), $request->file('sensor_data'));
            }
            if($request->hasFile('drone_data')){
                $report_id = $report->id;
            Excel::import(new DroneDataImport($report_id), $request->file('drone_data'));
            }
            return redirect()->route('ataskaitos', [$report_id]);            
}
else{
    return back()->with('message', 'Jūsų duomenyse trūksta duomenų stulpelių');
}


        
    }
      
    public function export(Report $report) 
    {
        $droneAndSensorData = SensorData::select( 'drone_data.date', 'sensor_data.time', 'sensor_data.sensor1', 'sensor_data.so2', 'sensor_data.no2', 'sensor_data.pm10',
        'sensor_data.pm2_5', 'sensor_data.o3', 'sensor_data.co', 'sensor_data.temperature', 'sensor_data.humidity',  'drone_data.latitude',  'drone_data.longitude', 
        'drone_data.altitude')->join('drone_data', 'sensor_data.time', '=', 'drone_data.time')
            ->where([['sensor_data.report_id', '=', $report->id], ['drone_data.report_id', '=', $report->id]])->groupBy('sensor_data.id')->get();
            foreach($droneAndSensorData as $data){
                $data['altitude'] = $data->altitude*0.304;
                $data['time'] = date('H:i:s', strtotime($data->time. ' + 7 hours'));
            }

        return Excel::download(new DataExport($droneAndSensorData), 'Ataskaita_'.$report->pavadinimas .'.xlsx');
    }

    public function manage(){
        return view('reports.manage', ['reports' => auth()->user()->reports()->get(),]);
    }


}
