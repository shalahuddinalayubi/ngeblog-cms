<?php

namespace Ngeblog\Post\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lara\Comment\Commentable;
use Lara\Comment\Contracts\IsCommentable;
use Lara\Tag\HasTags;
use Ngeblog\Database\Factories\PostFactory;

class Post extends Model implements IsCommentable
{
    use HasFactory, HasTags, Commentable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'tags',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Ngeblog\Post\Database\Factories\PostFactory
     */
    protected static function newFactory()
    {
        return PostFactory::new();
    }

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(\Ngeblog\User\Models\User::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
