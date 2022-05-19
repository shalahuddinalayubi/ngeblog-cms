<?php

namespace Ngeblog\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lara\Comment\Commentator;
use Lara\Comment\Contracts\IsCommentator;
use Laravel\Sanctum\HasApiTokens;
use Ngeblog\Database\Factories\UserFactory;

class User extends Authenticatable implements IsCommentator
{
    use HasApiTokens, HasFactory, Notifiable, Commentator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Ngeblog\Post\Database\Factories\PostFactory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(\Ngeblog\Post\Models\Post::class);
    }
}
