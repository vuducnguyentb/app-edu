<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostTag
 * 
 * @property int $tag_id
 * @property int $post_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Post $post
 * @property Tag $tag
 *
 * @package App\Models
 */
class PostTag extends Model
{
	use SoftDeletes;
	protected $table = 'post_tag';
	public $incrementing = false;

	protected $casts = [
		'tag_id' => 'int',
		'post_id' => 'int'
	];

	protected $fillable = [
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
