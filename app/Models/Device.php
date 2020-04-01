<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Device
 * 
 * @property int $id
 * @property string $name
 * @property string $imei
 * @property string $sim_card_no
 * @property string $sim_card_serial
 * @property int $active
 * @property string $monitor
 * @property \Carbon\Carbon $last_gps_time
 * @property \Carbon\Carbon $last_screen_time
 * @property \Carbon\Carbon $last_screen_off_time
 * @property float $total_distance
 * @property int $total_screen_time
 * @property float $total_park_time
 * @property string $screen_status
 * @property float $last_lat
 * @property float $last_lng
 * @property int $driver_id
 * @property int $troubled
 * @property int $box_id
 * @property int $location_id
 * @property string $comment
 * @property int $device_type_id
 * @property int $device_group_id
 * @property string $app_version
 * @property int $download_status
 * @property int $creator_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Device extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'active' => 'int',
		'total_distance' => 'float',
		'total_screen_time' => 'int',
		'total_park_time' => 'float',
		'last_lat' => 'float',
		'last_lng' => 'float',
		'driver_id' => 'int',
		'troubled' => 'int',
		'box_id' => 'int',
		'location_id' => 'int',
		'device_type_id' => 'int',
		'device_group_id' => 'int',
		'download_status' => 'int',
		'creator_id' => 'int'
	];

	protected $dates = [
		'last_gps_time',
		'last_screen_time',
		'last_screen_off_time'
	];

	protected $fillable = [
		'name',
		'imei',
		'sim_card_no',
		'sim_card_serial',
		'active',
		'monitor',
		'last_gps_time',
		'last_screen_time',
		'last_screen_off_time',
		'total_distance',
		'total_screen_time',
		'total_park_time',
		'screen_status',
		'last_lat',
		'last_lng',
		'driver_id',
		'troubled',
		'box_id',
		'location_id',
		'comment',
		'device_type_id',
		'device_group_id',
		'download_status',
		'app_version',
		'creator_id'
	];

	public function creator(){
		return $this->belongsTo('App\Models\User', 'creator_id');
	}

	public function box() {
		return $this->belongsTo('App\Models\Box', 'box_id');
	}

	public function driver() {
		return $this->belongsTo('App\Models\Driver', 'driver_id');
	}

	public function location(){
		return $this->belongsTo('App\Models\Location');
	}

	public function device_line(){
		return $this->hasOne('App\Models\DeviceLine');
	}

	public function device_group(){
		return $this->belongsTo('App\Models\DeviceGroup');
	}

	public function device_type(){
		return $this->belongsTo('App\Models\DeviceType');
	}
}
