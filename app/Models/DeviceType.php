<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Mar 2020 15:16:21 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DeviceType
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class DeviceType extends Eloquent
{
	protected $fillable = [
		'name'
	];
}
