<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_secure_encode_64()
    {
        // Tu peux mocker l'env('APP_KEY') si nécessaire
        putenv('APP_KEY=test_key');
        $result = secureEncode64('hello');
        $this->assertEquals(base64_encode('hello' . 'test_key'), $result);
    }

    public function test_format_currency()
    {
        $result = format_currency(1234.56, 'EUR', 'fr_FR');
        $this->assertIsString($result);
        $this->assertStringContainsString('€', $result);
    }

    public function test_format_number()
    {
        $result = format_number(1234.56);
        $this->assertIsString($result);
        $this->assertStringContainsString(',', $result); // locale fr_FR
    }

    public function test_format_date()
    {
        $result = format_date('2024-04-17', 'DD/MM/YYYY');
        $this->assertIsString($result);
    }

    public function test_format_hour()
    {
        $this->assertEquals('12:34', format_hour('12:34:56'));
        $this->assertEquals('12:34', format_hour('12:34'));
        $this->assertNull(format_hour(null));
    }

    public function test_format_telephone()
    {
        $this->assertEquals('06 12 34 56 78', format_telephone('0612345678'));
        $this->assertNull(format_telephone(null));
    }

    public function test_format_siret()
    {
        $this->assertEquals('123 456 789 12345', format_siret('12345678912345'));
        $this->assertNull(format_siret(null));
    }

    public function test_format_date_FrToEng()
    {
        $this->assertEquals('2024-04-17', format_date_FrToEng('17/04/2024'));
        $this->assertNull(format_date_FrToEng(null));
    }

    public function test_nb_days_between()
    {
        $this->assertEquals(1, nbDaysBetween('2024-04-16', '2024-04-17'));
        $this->assertEquals(2, nbDaysBetween('2024-04-16', '2024-04-17', true));
    }

    public function test_nb_days_off_between()
    {
        $this->assertEquals(2, nbDaysOffBetween('2024-04-13', '2024-04-15')); // Samedi + Dimanche
    }

    public function test_size_file_readable()
    {
        $this->assertEquals('0 B', sizeFileReadable(0));
        $this->assertEquals('1 kB', sizeFileReadable(1024));
    }

    public function test_sanitize_float()
    {
        $this->assertEquals(1234.56, sanitizeFloat('1.234,56'));
        $this->assertEquals(0.0, sanitizeFloat(null));
    }

    public function test_supprimer_decoration()
    {
        $this->assertEquals(1234.56, supprimer_decoration('1.234,56'));
        $this->assertEquals(0, supprimer_decoration(null));
    }

    public function test_bool_val()
    {
        $this->assertTrue(bool_val('true'));
        $this->assertTrue(bool_val('1'));
        $this->assertTrue(bool_val('yes'));
        $this->assertFalse(bool_val('no'));
        $this->assertFalse(bool_val('0'));
        $this->assertFalse(bool_val('random'));
    }
}
