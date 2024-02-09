<?php

namespace App\Traits;

use App\Models\MfaMethod;
use OTPHP\TOTP;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

trait HasMultiFactorAuthentication
{
    public function mfaMethods()
    {
        return $this->morphMany(MfaMethod::class, 'authenticatable');
    }

    public function getHasMfaEnabledAttribute()
    {
        return $this->mfaMethods()->whereNotNull('enabled_at')->exists();
    }

    public function TOTPMethod()
    {
        return $this->mfaMethods()->where('type', 'totp')->firstOrFail();
    }



    public function setupTOTP()
    {
        // If TOTP is already enabled, do nothing
        if($this->mfaMethods()->where('type', 'totp')->whereNotNull('enabled_at')->exists()) return false;

        // If TOTP is not enabled, create a new TOTP method or update the existing one
        $this->mfaMethods()->updateOrCreate([
            'type' => 'totp',
        ],[
            'secret' => TOTP::generate()->getSecret(),
            'recipient' => 'Authenticator App',
            'enabled_at' => null,
        ]);
    }



    public function TOTPProvisioningUri(string $label = '')
    {
        // Get the TOTP method
        $method = $this->TOTPMethod();

        // Check if Method is enabled
        if ($method->enabled_at) return false;

        $otp = TOTP::createFromSecret($method->secret);
        $otp->setLabel($label);
        
        return $otp->getProvisioningUri();
    }



    public function TOTPProvisioningQRCode(string $label = '')
    {
        return Builder::create()
        ->writer(new PngWriter())
        ->data($this->TOTPProvisioningUri($label))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(200)
        ->margin(0)
        ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
        ->validateResult(false)
        ->build()
        ->getDataUri();
    }



    public function enableTOTP($otp): Bool
    {
        // Get the TOTP method
        $method = $this->TOTPMethod();

        // Check if Method is already enabled
        if ($method->enabled_at) return false;

        // Check if OTP is valid
        if (!TOTP::createFromSecret($method->secret)->verify((string) $otp)) return false;
        
        // Enable the method
        $method->update([
            'enabled_at' => now(),
        ]);

        return true;
    }



    public function verifyTOTP($otp)
    {
        // Get the TOTP method
        $method = $this->TOTPMethod();

        // Check if Method is enabled
        if (!$method->enabled_at) return false;

        // Check if OTP is valid
        return TOTP::createFromSecret($method->secret)->verify($otp);
    }



    public function resetTOTP()
    {
        // Get the TOTP method
        $this->TOTPMethod()->delete();
    }
}