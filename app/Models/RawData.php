<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:03 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RawData
 * 
 * @property int $id
 * @property string $data
 * @property string $imei
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class RawData extends Eloquent
{
	protected $fillable = [
		'data',
		'imei'
	];
}
