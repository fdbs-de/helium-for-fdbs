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



    // START: Duplicate
    public function duplicate()
    {
        $model = $this->replicate();
        $model->push();

        $model->addresses()->saveMany($this->addresses()->get()->map(function ($item) { return $item->replicate(); }));
        $model->legal_details()->saveMany($this->legal_details()->get()->map(function ($item) { return $item->replicate(); }));
        $model->bank_details()->saveMany($this->bank_details()->get()->map(function ($item) { return $item->replicate(); }));
        $model->emails()->saveMany($this->emails()->get()->map(function ($item) { return $item->replicate(); }));
        $model->phone_numbers()->saveMany($this->phone_numbers()->get()->map(function ($item) { return $item->replicate(); }));
        $model->significant_dates()->saveMany($this->significant_dates()->get()->map(function ($item) { return $item->replicate(); }));
        $model->website_links()->saveMany($this->website_links()->get()->map(function ($item) { return $item->replicate(); }));

        return $model;
    }
    // END: Duplicate
}
