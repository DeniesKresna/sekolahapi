<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Driver
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $gender
 * @property string $plate_number
 * @property string $handphone
 * @property string $ktp_number
 * @property string $address
 * @property int $active
 * @property \Carbon\Carbon $last_login
 * @property string $one_signal_user_id
 * @property int $registered
 * @property string $group
 * @property int $driver_photo
 * @property string $tax
 * @property string $notes
 * @property float $last_lat
 * @property float $lats_lng
 * @property \Carbon\Carbon $last_gps_time
 * @property float $total_km
 * @property int $total_times
 * @property int $total_points
 * @property int $system_connected
 * @property int $driver_connected
 * @property string $ktp_photo
 * @property string $customer_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Driver extends Eloquent
{
	protected $casts = [
		'user_id' => 'int',
        'creator_id'=>'int',
		'active' => 'int',
		'registered' => 'int',
		'driver_photo' => 'int',
		'last_lat' => 'float',
		'lats_lng' => 'float',
		'total_km' => 'float',
		'total_times' => 'int',
		'total_points' => 'int',
		'system_connected' => 'int',
		'driver_connected' => 'int'
	];

	protected $dates = [
		'last_login',
		'last_gps_time'
	];

	protected $fillable = [
		'user_id',
        'creator_id',
		'name',
		'gender',
		'plate_number',
		'handphone',
		'ktp_number',
		'address',
		'active',
		'last_login',
		'one_signal_user_id',
		'registered',
		'group',
		'driver_photo',
		'tax',
		'notes',
		'last_lat',
		'lats_lng',
		'last_gps_time',
		'total_km',
		'total_times',
		'total_points',
		'system_connected',
		'driver_connected',
		'ktp_photo',
		'customer_code'
	];

	public function user(){
		return $this->belongsTo("App\Models\User");
	}
}
