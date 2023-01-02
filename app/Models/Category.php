<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property int $status
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'status' => 'int',
		'_lft' => 'int',
		'_rgt' => 'int',
		'parent_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'slug',
		'status',
		'_lft',
		'_rgt',
		'parent_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function posts()
	{
		return $this->belongsToMany(Post::class, 'post_category')
					->withPivot('created_by', 'updated_by', 'deleted_by', 'deleted_at')
					->withTimestamps();
	}
}
