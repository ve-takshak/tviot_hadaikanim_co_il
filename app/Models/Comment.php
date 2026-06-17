<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'lawsuit_id', 'user_id', 'message', 'added_date'];
    public function lawsuit()
    {
        return $this->belongsTo(Lawsuit::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
