<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pad extends Model
{
    use HasFactory;

    public const STATUS_UNUSED      = 'Unused';
    public const STATUS_INPROGRESS  = 'In progress';
    public const STATUS_ENDED       = 'Ended';

    // Not using auto increment id
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'language_id', 'status', 'content', 'output', 'note'
    ];

    /**
     * Interviewees join the pad
     *
     */
    public function interviewees()
    {
        return $this->belongsToMany(Interviewee::class, 'interviewee_pad')->withTimestamps();
    }

}
