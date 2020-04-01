<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Car
 * 
 * @property int $id
 * @property int $driver_id
 * @property int $box_id
 * @property string $plate_number
 * @property string $stnk
 * @property string $car_type
 * @property string $car_color
 * @property \Carbon\Carbon $installation_date
 * @property string $stnk_photo
 * @property string $front_car_photo
 * @property string $side_car_photo
 * @property string $vehicle_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Car extends Eloquent
{
	protected $casts = [
		'driver_id' => 'int',
		'box_id' => 'int',
        'creator_id' => 'int'
	];

	protected $dates = [
		'installation_date'
	];

	protected $fillable = [
		'driver_id',
		'box_id',
        'creator_id',
		'plate_number',
		'stnk',
		'car_type',
		'car_color',
		'installation_date',
		'stnk_photo',
		'front_car_photo',
		'side_car_photo',
		'vehicle_type'
	];

	public function driver(){
		return $this->belongsTo('App\Models\Driver');
	}

	public function box(){
		return $this->belongsTo('App\Models\Box');
	}
}
