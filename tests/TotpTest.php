<?php

namespace Ajuchacko\Totp\Tests;

use Ajuchacko\Totp\Totp;
use Carbon\Carbon;

class TotpTest extends TestCase {

    function testOtpCanBeCreated()
    {
        $otp = Totp::make();

        $this->assertInstanceOf(Totp::class, $otp);
    }

    function testOtpHasDefaultVadlidityAndSize()
    {
        $now = Carbon::now()->micro(0);

        $otp = Totp::make();

        $this->assertEquals($now->addMinutes(10), $otp->validUntil());
        $this->assertEquals(4, strlen($otp->code()));
    }

    function testOtpLengthCanBeAdjusted()
    {
        $otp = Totp::make($duration = 10, $digits = 6);

        $this->assertEquals(6, strlen($otp->code()));
    }

    function testOtpCanBeVerifiedForthePeriod()
    {
        $now = time();

        $otp = Totp::make($duration_in_seconds = 1, 6);
        $code = $otp->code();

        $this->assertTrue($otp->verify($code));
        $this->assertNotEquals($code, $otp->at($next_second = ++$now));
    }

    function testCanCheckIfOptExpired()
    {
        $otp = Totp::make($duration_in_seconds = 1, 6);

        $this->assertFalse($otp->expired());
    }

    function testOtpCanBeRefreshedForNextPeriod()
    {
        $otp = Totp::make($duration_in_seconds = 1, 6);
        $this->assertTrue($otp->verify($code = $otp->code()));

        sleep(1);
        $otp->refresh();

        $this->assertFalse($otp->verify($code));
        $this->assertNotEquals($code, $otp->code());
        $this->assertTrue($otp->verify($otp->code()));
    }
}
