<?php

namespace App\Models;

use Takshak\Adash\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Takshak\Imager\Facades\Placeholder;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function profileImg()
    {
        if (!empty($this->profile_img)) {
            if (Str::is('https://*', $this->profile_img)) {
                return $this->profile_img;
            }
            if (Storage::disk('public')->exists($this->profile_img)) {
                return storage($this->profile_img);
            }
        }

        $fileName = 'users/' . time() . '.jpg';
        $filePath = Storage::disk('public')->path($fileName);
        return Placeholder::dimensions(150, 150)
            ->background(rand(100, 999))
            ->text(substr($this->name, 0, 2), ['color' => '#fff', 'size' => 60])
            ->save($filePath)->saveModel($this, 'profile_img', $fileName)
            ->url();
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function dashboardRoute()
    {
        return route('dashboard');
    }
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function isRole($role)
    {
        return $this->roles->pluck('name')->contains($role);
    }

    public function isClient()
    {
        return $this->isRole('client');
    }
    public function isAgent()
    {
        return $this->isRole('agent');
    }
    public function isAdmin()
    {
        return $this->isRole('admin');
    }
    public function lawsuits()
{
    return $this->hasMany(Lawsuit::class, 'client_id');
}
public function hasDeletePermission($roleId)
{
    $permissionMap = [
        1 => 'admin_delete',
        2 => 'employee_delete',
        3 => 'agent_delete',
        5 => 'client_delete',
        6 => 'lawyer_delete',
       
    ];

    return isset($permissionMap[$roleId]) && $this->can($permissionMap[$roleId]);
}
public function hasEditPermission($roleId)
{
    $permissionMap = [
        1 => 'admin_update',
        2 => 'employee_update',
        3 => 'agent_update',
        5 => 'client_update',
        6 => 'lawyer_update',
       
    ];

    return isset($permissionMap[$roleId]) && $this->can($permissionMap[$roleId]);
}
public function hasShowPermission($roleId)
{
    $permissionMap = [
        1 => 'admin_show',
        2 => 'employee_show',
        3 => 'agent_show',
        5 => 'client_show',
        6 => 'lawyer_show',
       
    ];

    return isset($permissionMap[$roleId]) && $this->can($permissionMap[$roleId]);
}
public function getCreatePermissionByRoleId($roleId)
{
    $permissionMap = [
        1 => 'admin_create',
        2 => 'employee_create',
        3 => 'agent_create',
        5 => 'client_create',
        6 => 'lawyer_create',
    ];
    return $permissionMap[$roleId] ?? false;
}

}
