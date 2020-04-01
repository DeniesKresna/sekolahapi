<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DeviceGroup
 * 
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string $description
 * @property int $creator_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class DeviceGroup extends Eloquent
{
	protected $casts = [
		'creator_id' => 'int'
	];

	protected $fillable = [
		'key',
		'name',
		'description',
		'creator_id'
	];

	public function creator(){
		return $this->belongsTo("App\Models\User", "creator_id");
	}
}
