<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\ApiController;
use App\Models\Forecast;
use App\Models\PrayHour;
//use App\Models\Geolocation;
use App\Models\User;
use Ixudra\Curl\Facades\Curl;
use Goutte\Client;
use Datetime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class WidgetController extends ApiController
{
    public function forecasts(Request $request){
        $latitude = $request->lat;
        $longitude = $request->lon;
        $current_time = date("Y-m-d H:i:s");
        $fcsapikey = env('WEATHER_API_KEY','ae9b93fd2a5c4d7d89280238201701');

        $queryResult = Forecast::where('initial_time',date("Y-m-d H", strtotime($current_time)).":00:00")->get();

        $nearestPoint = ['data'=>[], 'dst'=>1];
        foreach ($queryResult->toArray() as $row) {
            $dst = $this->distance($latitude,$longitude,$row['lat'],$row['lon'],"K");
            if($dst <= $nearestPoint['dst']){
                $nearestPoint['data'] = $row;
                $nearestPoint['dst'] = $dst;
            }
        }
        if(count($nearestPoint['data']) > 0){   
            $forecast = $nearestPoint['data'];
        }
        else{
            $data = json_decode((Curl::to('http://api.weatherapi.com/v1/forecast.json?key='.$fcsapikey.'&q='.$latitude.','.$longitude.'&days=5')->get()),TRUE);
            if(isset($data['location'])){
                $inputdata = array_merge($data['location'],$data['current']);

                $inputdata['condition_text'] = $inputdata['condition']['text'];
                $inputdata['condition_icon'] = $inputdata['condition']['icon'];
                $i=0;
                foreach($data['forecast']['forecastday'] as $forecastdata){
                    $i++;
                    $inputdata['maxtemp_c_'.$i] = $forecastdata['day']['maxtemp_c'];
                    $inputdata['mintemp_c_'.$i] = $forecastdata['day']['mintemp_c'];
                    $inputdata['condition_text_'.$i] = $forecastdata['day']['condition']['text'];
                    $inputdata['condition_icon_'.$i] = $forecastdata['day']['condition']['icon'];
                }
                $inputdata['initial_time'] = date("Y-m-d H").":00:00";
                $forecast = Forecast::create($inputdata);
            }
            else
                return view('nointernet');
        }
        if($request->mode=='half' || $request->mode=='halfapi' || $request->mode=='api'){
            if($forecast['condition_text'] == 'Freezing drizzle') $forecast['condition_text'] = 'Freezing';
            else if($forecast['condition_text'] == 'Heavy freezing drizzle') $forecast['condition_text'] = 'Heavy freez';
            else if($forecast['condition_text'] == 'Heavy rain at times') $forecast['condition_text'] = 'Heavy rain';
            else if($forecast['condition_text'] == 'Light drizzle') $forecast['condition_text'] = 'Light drizzle';
            else if($forecast['condition_text'] == 'Light freezing rain') $forecast['condition_text'] = 'Light freezing';
            else if($forecast['condition_text'] == 'Light rain shower') $forecast['condition_text'] = 'Light rain';
            else if($forecast['condition_text'] == 'Light showers of ice pellets') $forecast['condition_text'] = 'Light rain';
            else if($forecast['condition_text'] == 'Light sleet showers') $forecast['condition_text'] = 'Light sleet';
            else if($forecast['condition_text'] == 'Light snow showers') $forecast['condition_text'] = 'Light snow';
            else if($forecast['condition_text'] == 'Mist') $forecast['condition_text'] = 'Berkabut';
            else if($forecast['condition_text'] == 'Moderate or heavy freezing rain') $forecast['condition_text'] = 'Mod freez';
            else if($forecast['condition_text'] == 'Moderate or heavy rain in area with thunder') $forecast['condition_text'] = 'Mod rain';
            else if($forecast['condition_text'] == 'Moderate or heavy rain shower') $forecast['condition_text'] = 'Mod rain';
            else if($forecast['condition_text'] == 'Moderate or heavy showers of ice pellets') $forecast['condition_text'] = 'Mod ice';
            else if($forecast['condition_text'] == 'Moderate or heavy sleet') $forecast['condition_text'] = 'Mod sleet';
            else if($forecast['condition_text'] == 'Moderate or heavy sleet showers') $forecast['condition_text'] = 'Mod sleet';
            else if($forecast['condition_text'] == 'Moderate or heavy snow in area with thunder') $forecast['condition_text'] = 'Mod snow';
            else if($forecast['condition_text'] == 'Moderate or heavy snow showers') $forecast['condition_text'] = 'Mod snow';
            else if($forecast['condition_text'] == 'Moderate rain') $forecast['condition_text'] = 'Mod rain';
            else if($forecast['condition_text'] == 'Moderate rain at times') $forecast['condition_text'] = 'Mod rain';
            else if($forecast['condition_text'] == 'Moderate snow') $forecast['condition_text'] = 'Mod snow';
            else if($forecast['condition_text'] == 'Partly Cloudy') $forecast['condition_text'] = 'Berawan';
            else if($forecast['condition_text'] == 'Patchy freezing drizzle nearby') $forecast['condition_text'] = 'Patchy freez';
            else if($forecast['condition_text'] == 'Patchy heavy snow') $forecast['condition_text'] = 'Patchy snow';
            else if($forecast['condition_text'] == 'Patchy light drizzle') $forecast['condition_text'] = 'Patchy light';
            else if($forecast['condition_text'] == 'Patchy light rain') $forecast['condition_text'] = 'Patchy rain';
            else if($forecast['condition_text'] == 'Patchy light rain in area with thunder') $forecast['condition_text'] = 'Patchy rain';
            else if($forecast['condition_text'] == 'Patchy light snow') $forecast['condition_text'] = 'Patchy snow';
            else if($forecast['condition_text'] == 'Patchy light snow in area with thunder') $forecast['condition_text'] = 'Patchy snow';
            else if($forecast['condition_text'] == 'Patchy moderate snow') $forecast['condition_text'] = 'Patchy snow';
            else if($forecast['condition_text'] == 'Patchy rain possible') $forecast['condition_text'] = 'Patchy rain';
            else if($forecast['condition_text'] == 'Patchy rain nearby') $forecast['condition_text'] = 'Patchy rain';
            else if($forecast['condition_text'] == 'Patchy sleet nearby') $forecast['condition_text'] = 'Patchy sleet';
            else if($forecast['condition_text'] == 'Patchy snow nearby') $forecast['condition_text'] = 'Patchy snow';
            else if($forecast['condition_text'] == 'Thundery outbreaks in nearby') $forecast['condition_text'] = 'Thundery';
            else if($forecast['condition_text'] == 'Torrential rain shower') $forecast['condition_text'] = 'Torrential';
        }

        $forecast['street_name'] = $this->geo($latitude,$longitude);
        if($request->has('mode')){
            if($request->mode=='half')
                return view('widget.forecasthalf',$forecast);
            else if($request->mode=='api' || $request->mode=='halfapi')
                return response()->json(['data'=>$forecast]);
            else
                return view('widget.forecast',$forecast);
        }
        return view('widget.forecast',$forecast);
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit) {
      //based on https://www.geodatasource.com/developers/php
      if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
      }
      else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
          return ($miles * 1.609344);
        } else if ($unit == "N") {
          return ($miles * 0.8684);
        } else {
          return $miles;
        }
      }
    }
    //http://www.islamicfinder.us/index.php/api/prayer_times?latitude=-7.272917&longitude=112.742714&timezone=Asia/Jakarta&method=9
    //http://api.aladhan.com/v1/timings?latitude=-7.272917&longitude=112.742714&method=8
    //https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=-7.283844&longitude=112.740148&localityLanguage=en
    private function geo($latitude,$longitude){
        $url = 'https://nominatim.openstreetmap.org/reverse?email=denies@smart-it.co.id&format=json&lat='.$latitude.'&lon='.$longitude;
        $result = json_decode((Curl::to($url)->get()),TRUE);
        return $result['display_name'];
    }

    public function prayhours(Request $request){
        $latitude = $request->lat;
        $longitude = $request->lon;
        $current_date = date("d-m-Y");
        $dataSalat = json_decode((Curl::to('http://api.aladhan.com/v1/timings?latitude='.$latitude.'&longitude='.$longitude.'&method=8')->get()),TRUE);

        if($dataSalat['code']!=200){
            return view('nointernet');
        }

        if($request->has('mode')){
            if($request->mode=='half')
                return view('widget.prayhourhalf',$dataSalat['data']['timings']);
            else if($request->mode=='api' || $request->mode=='halfapi')
                return response()->json(['data'=>$dataSalat['data']['timings']]);
            else if($request->mode=='running')
                return view('widget.prayhourrunning',$dataSalat['data']['timings']);
            else
                return view('widget.prayhour',$dataSalat['data']['timings']);
        }
        return view('widget.prayhour',$dataSalat['data']['timings']);
    }
}