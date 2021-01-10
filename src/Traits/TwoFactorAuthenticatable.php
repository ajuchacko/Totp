<?php

namespace Ajuchacko\Totp\Traits;

use Ajuchacko\Totp\Totp;
use OTPHP\Factory;

trait TwoFactorAuthenticatable {

    public function otp($duration = null, $size = null)
    {
        return $this->loadFromUri() ?? $this->newOtp($duration, $size);
    }

    public function refreshOtp()
    {
        $totp = $this->otp()->refresh();

        $this->updateUri($totp);

        return $totp;
    }

    private function loadFromUri()
    {
        if (is_null($this->uri)) {
            return null;
        }

        $otp = Factory::loadFromProvisioningUri($this->uri);

        return Totp::make($otp->getEpoch(), $otp->getDigits());
    }

    private function newOtp($duration = null, $size = null)
    {
        $totp = Totp::make($duration, $size);

        $this->updateUri($totp);

        return $totp;
    }

    private function updateUri($totp)
    {
        $this->update(['uri' => (string) $totp]);
    }
}
