<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 * 
 * @property int $id
 * @property string|null $content
 * @property string|null $email
 * @property int|null $post_id
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Post|null $post
 *
 * @package App\Models
 */
class Comment extends Model
{
	use SoftDeletes;
	protected $table = 'comments';

	protected $casts = [
		'post_id' => 'int',
		'_lft' => 'int',
		'_rgt' => 'int',
		'parent_id' => 'int'
	];

	protected $fillable = [
		'content',
		'email',
		'post_id',
		'_lft',
		'_rgt',
		'parent_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}
}
