<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LayoutBox
 * 
 * @property int $id
 * @property int $layout_id
 * @property string $lemma_publisher_id
 * @property string $lemma_ads_unit_id
 * @property int $box_number
 * @property int $timeout
 * @property string $data_type
 * @property int $width
 * @property int $height
 * @property string $align_parent_end
 * @property string $align_parent_top
 * @property string $align_parent_bottom
 * @property int $below
 * @property int $right_of
 * @property int $left_of
 * @property int $font_size
 * @property int $enable_slotting
 * @property int $creator_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class LayoutBox extends Eloquent
{
	protected $casts = [
		'layout_id' => 'int',
		'box_number' => 'int',
		'timeout' => 'int',
		'width' => 'int',
		'height' => 'int',
		'below' => 'int',
		'right_of' => 'int',
		'left_of' => 'int',
		'font_size' => 'int',
		'enable_slotting' => 'int',
		'creator_id' => 'int'
	];

	protected $fillable = [
		'layout_id',
		'lemma_publisher_id',
		'lemma_ads_unit_id',
		'box_number',
		'timeout',
		'data_type',
		'width',
		'height',
		'align_parent_end',
		'align_parent_top',
		'align_parent_bottom',
		'below',
		'right_of',
		'left_of',
		'font_size',
		'enable_slotting',
		'creator_id'
	];

	public function layout(){
		return $this->belongsTo("App\Models\Layout");
	}

	public function sequences(){
		return $this->belongsToMany('App\Models\Content','layout_sequences');
	}
}
