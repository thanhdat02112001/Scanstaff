<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interviewee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Pads that interviewee joined
     *
     */
    public function pads()
    {
        return $this->belongsToMany(Pad::class, 'interviewee_pad')->withTimestamps();
    }
}
