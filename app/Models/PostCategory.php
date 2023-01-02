<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostCategory
 * 
 * @property int $category_id
 * @property int $post_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category $category
 * @property Post $post
 *
 * @package App\Models
 */
class PostCategory extends Model
{
	use SoftDeletes;
	protected $table = 'post_category';
	public $incrementing = false;

	protected $casts = [
		'category_id' => 'int',
		'post_id' => 'int'
	];

	protected $fillable = [
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function post()
	{
		return $this->belongsTo(Post::class);
	}
}
