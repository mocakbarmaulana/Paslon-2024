<?php

use App\Console\Commands\PaslonCommand;
use App\Services\PaslonService;

beforeEach(function () {
    $this->refreshApplication();
});

it('should display paslon command', function () {
    // Mocking the PaslonService
    $result = (new PaslonCommand())->handle();

    $this->assertArrayHasKey('Nomor Urut', $result[0]);
});
