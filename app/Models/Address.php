<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'notes',
    ];



    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }



    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;

        if ($this->address_line_2)
        {
            $address .= ' '.$this->address_line_2;
        }

        $address .= ', ';
        $address .= $this->postal_code.' ';
        $address .= $this->city.', ';
        $address .= $this->state.' ';
        $address .= $this->country;

        return $address;
    }
}
