<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ContentPlaylist
 * 
 * @property int $id
 * @property int $content_id
 * @property int $playlist_id
 * @property int $order_no
 *
 * @package App\Models
 */
class ContentPlaylist extends Eloquent
{
	protected $table = 'content_playlist';
	public $timestamps = false;

	protected $casts = [
		'content_id' => 'int',
		'playlist_id' => 'int',
		'order_no' => 'int'
	];

	protected $fillable = [
		'content_id',
		'playlist_id',
		'order_no'
	];
}
