<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory, Taggable;

    protected $fillable=[
        'user_id',
        'image',
        'title',
        'description',
        'slug',
        'close_to_comment',
        'is_live',
        'upload_successful',
        'disk'
    ];

    // protected $fillable=[
    //     'user_id',
    //     'team_id',
    //     'image',
    //     'title',
    //     'description',
    //     'slug',
    //     'close_to_comment',
    //     'is_live',
    //     'upload_successful',
    //     'disk'
    // ];

    // protected $casts=[
    //     'is_live' => 'boolean',
    //     'upload_successful' => 'boolean',
    //     'close_to_comments' => 'boolean'
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function team()
    // {
    //     return $this->belongsTo(Team::class);
    // }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
                ->orderBy('created_at', 'asc');
    }

    public function getImagesAttribute()
    {
        return [
            'thumbnail' => $this->getImagePath('thumbnail'),
            'large' => $this->getImagePath('large'),
            'original' => $this->getImagePath('original'),
        ];
    }

    protected function getImagePath($size)
    {
        return Storage::disk($this->disk)
                        ->url("uploads/designs/{$size}/".$this->image);
    }
}