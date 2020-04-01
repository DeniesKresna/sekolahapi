<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:03 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Playlist
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $customer_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Playlist extends Eloquent
{
	protected $casts = [
		'customer_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'customer_id'
	];

	public function customer(){
		return $this->belongsTo("App\Models\User");
	}

	public function contents(){
		return $this->belongsToMany("App\Models\Content")->withPivot('order_no');
	}
}
