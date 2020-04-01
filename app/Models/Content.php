<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Content
 * 
 * @property int $id
 * @property int $customer_id
 * @property string $name
 * @property string $description
 * @property string $file_url
 * @property string $file_path
 * @property string $file_name
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Content extends Eloquent
{
	protected $casts = [
		'customer_id' => 'int'
	];

	protected $fillable = [
		'customer_id',
		'name',
		'description',
		'file_url',
		'file_path',
		'file_name',
		'type'
	];

	public function campaigns(){
        return $this->belongsToMany("App\Models\Campaign");
    }

    public function playlists(){
        return $this->belongsToMany("App\Models\Playlist")->withPivot('order_no');
    }

    public function customer(){
    	return $this->belongsTo('App\Models\User');
    }
}
