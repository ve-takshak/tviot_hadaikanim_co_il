<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function lawsuit_documents()
    {
        return storage($this->file_name);
    }

    public function lawsuit_doc()
    {
        return $this->belongsTo(Lawsuit::class);
    }
}
