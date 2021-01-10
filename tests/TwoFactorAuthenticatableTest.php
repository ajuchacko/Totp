<?php

namespace Ajuchacko\Totp\Tests;

use Ajuchacko\Totp\Tests\Models\User;
use Ajuchacko\Totp\Totp;
use Carbon\Carbon;

class TwoFactorAuthenticatableTest extends TestCase {

    function testUserCanGenerateOtpOnFirstCall()
    {
        $user = User::first();
        $this->assertNull($user->uri);

        $user->otp();

        $this->assertNotNull($user->uri);
    }

    function testUserCanGetOldOtp()
    {
        $user = User::first();

        $totp = $user->otp();

        $this->assertSame($totp->getEpoch(), $user->otp()->getEpoch());
    }

    function testUserCanGenerateNewOtpWithCustomTtl()
    {
        $totp = User::first()->otp('15 minutes', 7);

        $this->assertEquals(7, strlen($totp->code()));
        $this->assertEquals(Carbon::now()->addMinutes(15)->micro(0), $totp->validUntil());
    }

    function testUserCanRefreshOtpWithCurrentTtlandSize()
    {
        $user = User::first();

        $totp = $user->otp(1, 7);
        sleep(1);

        $newTotp = $user->refreshOtp();

        $this->assertNotEquals($totp->code(), $newTotp->code());
    }
}
