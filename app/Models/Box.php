<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Box
 * 
 * @property int $id
 * @property string $name
 * @property int $car_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Box extends Eloquent
{
	protected $casts = [
		'car_id' => 'int'
	];

	protected $fillable = [
		'name',
		'car_id',
        'creator_id'
	];

	public function car(){
		return $this->belongsTo('App\Models\Car');
	}
}
