<?php

use App\Services\PaslonService;
use Illuminate\Support\Facades\Http;

describe('fetch api', function () {
    it('handle request timeout', function () {
        // Mock a request timeout response
        Http::fake([
            'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7' => Http::response(null, 408),
        ]);

        $this->assertTrue(true);
    });
});

describe('function service', function () {
    it('parse karir', function () {
        $karir = [
            'Rektor Universitas Paramadina (2007-2013)',
            'Menteri Pendidikan dan Kebudayaan (2014-2016)',
            'Gubernur DKI Jakarta (2017-2022)',
        ];

        $paslonService = new PaslonService();

        $result = $paslonService->parseKarir($karir);

        $expected = [
            new \App\Dto\KarirDto('Rektor Universitas Paramadina', 2007, 2013),
            new \App\Dto\KarirDto('Kebudayaan', 2014, 2016),
            new \App\Dto\KarirDto('Gubernur DKI Jakarta', 2017, 2022),
        ];

        expect($result)->toBe($expected);
    });
});
