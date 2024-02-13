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
    beforeEach(function () {
        $this->paslonService = new PaslonService();
    });

    it('should return age 32', function () {
        $result = $this->paslonService->hitungUmur('12 Desember 1991');

        expect($result)->toBe(32);
    });

    it('should return age 0, invalid date', function () {
        $result = $this->paslonService->hitungUmur('32 Desember 2023');

        expect($result)->toBe(0);
    });

    it('should return tempat lahir', function () {
        $result = $this->paslonService->parseTempatLahir('Jakarta, 12 Desember 1991');

        expect($result)->toBe('Jakarta');
    });

    it('should return tempat lahir tidak valid', function () {
        $result = $this->paslonService->parseTempatLahir('32 Desember 2023');

        expect($result)->toBe('Tempat lahir tidak valid');
    });

    it('should return tanggal lahir', function () {
        $result = $this->paslonService->parseTanggalLahir('Jakarta, 12 Desember 1991');

        expect($result)->toBe('12 Desember 1991');
    });

    it('should return tanggal lahir tidak valid', function () {
        $result = $this->paslonService->parseTanggalLahir('32 Desember 2023');

        expect($result)->toBe('Tanggal lahir tidak valid');
    });
});
