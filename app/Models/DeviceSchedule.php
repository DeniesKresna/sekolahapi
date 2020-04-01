<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 19 Mar 2020 12:20:10 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DeviceSchedule
 * 
 * @property int $id
 * @property string $imei
 * @property string $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class DeviceSchedule extends Eloquent
{
	protected $fillable = [
		'imei',
		'data'
	];
}
