<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Forecast
 * 
 * @property int $id
 * @property string $lat
 * @property string $lon
 * @property string $name
 * @property string $region
 * @property string $temp_c
 * @property string $condition_text
 * @property string $condition_icon
 * @property string $wind_kph
 * @property string $wind_dir
 * @property string $humidity
 * @property string $maxtemp_c_1
 * @property string $mintemp_c_1
 * @property string $condition_text_1
 * @property string $condition_icon_1
 * @property string $maxtemp_c_2
 * @property string $mintemp_c_2
 * @property string $condition_text_2
 * @property string $condition_icon_2
 * @property string $maxtemp_c_3
 * @property string $mintemp_c_3
 * @property string $condition_text_3
 * @property string $condition_icon_3
 * @property string $maxtemp_c_4
 * @property string $mintemp_c_4
 * @property string $condition_text_4
 * @property string $condition_icon_4
 * @property string $maxtemp_c_5
 * @property string $mintemp_c_5
 * @property string $condition_text_5
 * @property string $condition_icon_5
 * @property \Carbon\Carbon $initial_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Forecast extends Eloquent
{
	protected $dates = [
		'initial_time'
	];

	protected $fillable = [
		'lat',
		'lon',
		'name',
		'region',
		'temp_c',
		'condition_text',
		'condition_icon',
		'wind_kph',
		'wind_dir',
		'humidity',
		'maxtemp_c_1',
		'mintemp_c_1',
		'condition_text_1',
		'condition_icon_1',
		'maxtemp_c_2',
		'mintemp_c_2',
		'condition_text_2',
		'condition_icon_2',
		'maxtemp_c_3',
		'mintemp_c_3',
		'condition_text_3',
		'condition_icon_3',
		'maxtemp_c_4',
		'mintemp_c_4',
		'condition_text_4',
		'condition_icon_4',
		'maxtemp_c_5',
		'mintemp_c_5',
		'condition_text_5',
		'condition_icon_5',
		'initial_time'
	];
}
