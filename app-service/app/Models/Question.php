<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'language_id', 'title', 'description', 'content'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
