<?php

namespace Ajuchacko\Totp;

use Carbon\Carbon;
use OTPHP\TOTP as OTP;
use Illuminate\Support\Str;

class Totp {

    function __construct($duration = 600, $size = 4)
    {
        $this->duration = $duration;

        $this->size = $size;

        $this->otp = $this->generate($duration, $size);
    }

    private function generate($period, $digits)
    {
        $totp = OTP::create(null, $period, $digest = 'sha1', $digits, $epoch = time());
        $totp->setLabel(Str::random(10));

        $this->code = $totp->now();
        $this->uri = $totp->getProvisioningUri();

        return $totp;
    }

    public static function make($duration = 600, $size = 4)
    {
        return new self($duration, $size);
    }

    public function validUntil()
    {
        $expiryTimeStamp = $this->otp->getEpoch() + $this->duration;

        return Carbon::createFromFormat('d-m-Y H:i:s', date('d-m-Y H:i:s', $expiryTimeStamp))->micro(0);
    }

    public function code()
    {
        return $this->code;
    }

    public function verify($code)
    {
        return $this->otp->verify($code);
    }

    public function expired()
    {
        return !$this->validUntil()->isFuture();
    }

    public function at($timestamp)
    {
        return $this->otp->at($timestamp);
    }

    public function refresh()
    {
        return $this->otp = $this->generate($this->duration, $this->size);
    }
}
