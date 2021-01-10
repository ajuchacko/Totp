<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2021 Aju chacko
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Ajuchacko\Totp;

use Carbon\Carbon;
use OTPHP\TOTP as OTP;
use Illuminate\Support\Str;

class Totp {

    function __construct($duration, $size)
    {
        $this->digits = $size;

        $this->ttl = $this->parseDuration($duration);

        $this->otp = $this->generate($this->ttl, $size);
    }

    public static function make($duration = null, $size = null)
    {
        $duration = $duration ?? config('totp.ttl');
        $size = $size ?? config('totp.size');

        if ($size < 2) {
            throw new \InvalidArgumentException('Otp Size Can Not be smaller than 2');
        }

        return new self($duration, $size);
    }

    public function validUntil()
    {
        $expiryTimeStamp = $this->otp->getEpoch() + $this->ttl;

        return Carbon::createFromFormat('d-m-Y H:i:s', date('d-m-Y H:i:s', $expiryTimeStamp))->micro(0);
    }

    public function code()
    {
        return $this->at($this->otp->getEpoch());
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
        return $this->otp = $this->generate($this->ttl, $this->digits);
    }

    private function generate($duration, $size)
    {
        $totp = OTP::create(null, $duration, $digest = 'sha1', $size, $epoch = time());

        empty(config('app.name')) ?: $totp->setIssuer(config('app.name'));

        $totp->setLabel(Str::random(15));

        return $totp;
    }

    private function parseDuration($duration)
    {
        if (is_string($duration) && $timestamp = strtotime($duration)) {
            $expiry_time = Carbon::parse($timestamp);
            return Carbon::now()->diffInSeconds($expiry_time) + 1;
        }

        return $duration;
    }

    public function __toString()
    {
        return $this->otp->getProvisioningUri();
    }
}
