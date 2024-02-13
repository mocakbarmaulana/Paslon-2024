<?php

namespace App\Dto;

use App\Enum\PosisiEnum;
use Spatie\LaravelData\Data;

class ProfileDto extends Data
{
    public function __construct(
        public string $nama_lengkap,
        public int $nomor_urut,
        public PosisiEnum $posisi,
        public string $tempat_lahir,
        public string $tanggal_lahir,
        public int $usia,
        public array $karir,
    ) {
    }
}
