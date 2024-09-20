<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'author', 'status'];

    public mixed $title;
    public mixed $content;
    public mixed $author;
    public mixed $status;
}
