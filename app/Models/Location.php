<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Location
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Location extends Eloquent
{
	protected $fillable = [
		'name'
	];

	public function devices(){
		return $this->hasMany("App\Models\Device");
	}

	public function campaigns(){
		return $this->belongsToMany("App\Models\Campaign");
	}
}
