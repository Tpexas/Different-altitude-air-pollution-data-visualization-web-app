@switch($data)
@case($data>=$limits[0] && $data<$limits[1]) bg-aqi_green @break
@case($data>=$limits[1] && $data<$limits[2]) bg-aqi_yellow @break
@case($data>=$limits[2] && $data<$limits[3]) bg-aqi_orange @break
@case($data>=$limits[3] && $data<$limits[4]) bg-aqi_red @break
@case($data>=$limits[4]) bg-aqi_purple @break

@endswitch