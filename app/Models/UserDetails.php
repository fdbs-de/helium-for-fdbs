<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'prefix',
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'nickname',
        'legalname',
        'company',
        'department',
        'title',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return $this->prefix . ' ' . $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname . ' ' . $this->suffix;
    }

    public function getFullnameOrNicknameAttribute()
    {
        return $this->fullname ? : $this->nickname;
    }
}
