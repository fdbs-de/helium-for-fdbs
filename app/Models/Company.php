<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'legal_form',
        'description',
        'notes',
    ];



    // START: Relationships
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function legal_details(): MorphMany
    {
        return $this->morphMany(LegalDetail::class, 'governable');
    }

    public function bank_details(): MorphMany
    {
        return $this->morphMany(BankDetails::class, 'bankable');
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    public function phone_numbers(): MorphMany
    {
        return $this->morphMany(PhoneNumber::class, 'phoneable');
    }

    public function significant_dates(): MorphMany
    {
        return $this->morphMany(SignificantDate::class, 'dateable');
    }

    public function website_links(): MorphMany
    {
        return $this->morphMany(WebsiteLink::class, 'linkable');
    }
    // END: Relationships



    // START: Specific Addresses
    public function get_legal_address_attribute()
    {
        return $this->addresses()->where('type', 'legal')->first();
    }

    public function get_billing_address_attribute()
    {
        return $this->addresses()->where('type', 'billing')->first();
    }
    // END: Specific Addresses
}
