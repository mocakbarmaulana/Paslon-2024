<?php

namespace App\Dto;

use Spatie\LaravelData\Data;

class KarirDto extends Data
{
    public function __construct(
        public string $jabatan,
        public int $tahun_mulai,
        public ?int $tahun_selesai,
    ) {
    }
}
