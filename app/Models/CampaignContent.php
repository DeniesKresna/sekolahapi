<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CampaignContent
 * 
 * @property int $id
 * @property int $campaign_id
 * @property int $content_id
 * @property int $order_no
 *
 * @package App\Models
 */
class CampaignContent extends Eloquent
{
	protected $table = 'campaign_content';
	public $timestamps = false;

	protected $casts = [
		'campaign_id' => 'int',
		'content_id' => 'int',
		'order_no' => 'int'
	];

	protected $fillable = [
		'campaign_id',
		'content_id',
		'order_no'
	];
}
