<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LayoutSequence
 * 
 * @property int $id
 * @property int $content_id
 * @property int $creator_id
 * @property int $layout_box_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class LayoutSequence extends Eloquent
{
	protected $casts = [
		'layout_box_id' => 'int',
		'content_id' => 'int',
		'creator_id' => 'int',
	];

	protected $fillable = [
		'layout_box_id',
		'content_id',
		'creator_id',
	];

	public function layout(){
		return $this->belongsTo("App\Models\Layout");
	}

	public function contents(){
		return $this->belongsTo("App\Models\Content");
	}
}
