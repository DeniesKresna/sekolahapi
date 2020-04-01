<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Line
 * 
 * @property int $id
 * @property int $device_id
 * @property int $box_id
 * @property int $car_id
 * @property int $driver_id
 * @property int $merchant_id
 * @property string $device_type_id
 * @property int $layout_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class DeviceLine extends Eloquent
{
	protected $casts = [
		'device_id' => 'int',
		'box_id' => 'int',
		'car_id' => 'int',
		'driver_id' => 'int',
		'merchant_id' => 'int',
		'layout_id' => 'int'
	];

	protected $fillable = [
		'device_id',
		'box_id',
		'car_id',
		'driver_id',
		'merchant_id',
		'device_type_id',
		'layout_id'
	];

	public function device(){
		return $this->belongsTo('App\Models\Device');
	}

	public function box(){
		return $this->belongsTo('App\Models\Box');
	}

	public function car(){
		return $this->belongsTo("App\Models\Car");
	}

	public function driver(){
		return $this->belongsTo("App\Models\Driver");
	}

	public function layout(){
		return $this->belongsTo("App\Models\Layout");
	}

	public function device_type(){
		return $this->belongsTo("App\Models\DeviceType");
	}
/*
	public function merchant(){
		return $this->belongsTo("App\Models\Merchant");
	}
	public function device_type(){
		return $this->belongsTo("App\Models\DeviceType");
	}
	*/
}
