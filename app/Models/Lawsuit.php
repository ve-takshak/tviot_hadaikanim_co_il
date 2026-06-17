<?php

namespace App\Models;

use Carbon\Carbon;
use Dotenv\Repository\Adapter\GuardedWriter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Lawsuit extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    public function client()
    {
        return $this->belongsTo(user::class, 'client_id');
    }
    public function agent()
    {
        return $this->belongsTo(user::class, 'agent_id');
    }

    public function appraiser_data()
    {
        return $this->belongsTo(Appraiser::class, 'appraiser');
    }

    public function inc_company()
    {
        return $this->belongsTo(InsuranceCompany::class, 'inc_company_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'lawsuit_id')->orderBy('created_at', 'desc');
    }
    public function documents()
    {
        return $this->hasMany(document::class, 'lawsuit_id')->orderBy('created_at', 'desc');
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            1 => 'Open',
            0 => 'Archive',
            2 => 'Repeated claims for settlement/policy',
            3 => 'Under attorney management/handling',
            4 => 'Settlement / policy claims',
            5 => 'Pre-Archive'
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }
    public function getColorAttribute()
    {
        $paymentDate = Carbon::parse($this->payment_date);
        $currentDate = Carbon::now();

        if ($paymentDate->isPast()) {
            return 'text-danger';
        }

        $diffInDays = $paymentDate->diffInDays($currentDate);

        if ($diffInDays <= 3) {
            return 'text-primary'; 
        }

        return 'text-dark';
    }
    protected function paymentDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }
    protected function lawsuitBeginDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }
     protected function daysActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status == 0 ? null : Carbon::parse($this->created_at)->diffInDays(Carbon::now())
        );
    }

}
