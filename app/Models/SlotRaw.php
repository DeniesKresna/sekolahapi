<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Mar 2020 11:06:37 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SlotRaw
 * 
 * @property int $id
 * @property string $imei
 * @property string $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class SlotRaw extends Eloquent
{
	protected $fillable = [
		'imei',
		'data'
	];
}
