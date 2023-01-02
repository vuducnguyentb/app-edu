<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * 
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $content
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $status
 * @property int $type
 * @property int|null $user_id
 * @property int|null $file_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property File|null $file
 * @property User|null $user
 * @property Collection|Comment[] $comments
 * @property Collection|Category[] $categories
 * @property Collection|Tag[] $tags
 *
 * @package App\Models
 */
class Post extends Model
{
	use SoftDeletes;
	protected $table = 'posts';

	protected $casts = [
		'status' => 'int',
		'type' => 'int',
		'user_id' => 'int',
		'file_id' => 'int'
	];

	protected $fillable = [
		'title',
		'slug',
		'excerpt',
		'content',
		'meta_description',
		'meta_keywords',
		'status',
		'type',
		'user_id',
		'file_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function file()
	{
		return $this->belongsTo(File::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'post_category')
					->withPivot('created_by', 'updated_by', 'deleted_by', 'deleted_at')
					->withTimestamps();
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class)
					->withPivot('created_by', 'updated_by', 'deleted_by', 'deleted_at')
					->withTimestamps();
	}
}
