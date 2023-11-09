<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BankDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'bank_name',
        'branch',
        'account_name',
        'account_number',
        'swift_code',
        'iban',
    ];



    public function bankable(): MorphTo
    {
        return $this->morphTo();
    }
}
