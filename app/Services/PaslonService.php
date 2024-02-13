<?php

namespace App\Services;

use App\Dto\KarirDto;
use App\Dto\ProfileDto;
use App\Enum\PosisiEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PaslonService
{
    public function getPaslon(
        string $url = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7'
    ): array {
        $response = Http::get($url);

        $statusMap = [
            408 => 'Request timeout',
            404 => 'URL not found',
        ];

        if ($response->successful()) {
            return $response->json();
        }

        $statusCode = $response->status();

        return [
            'status' => 'error',
            'message' => $statusMap[$statusCode] ?? 'Something went wrong',
        ];
    }

    public function convertToDtoProfile(array $data, PosisiEnum $posisiEnum): array
    {
        $result = [];

        foreach ($data as $item) {
            $tempatLahir = $this->parseTempatLahir($item['tempat_tanggal_lahir']);
            $tanggalLahir = $this->parseTanggalLahir($item['tempat_tanggal_lahir']);
            $umur = $this->hitungUmur($tanggalLahir);
            $karir = $this->parseKarir($item['karir']);

            $result[] = new ProfileDto(
                $item['nama_lengkap'],
                $item['nomor_urut'],
                $posisiEnum,
                $tempatLahir,
                $tanggalLahir,
                $umur,
                $karir
            );
        }

        return $result;
    }

    public function parseKarir(array $karir): array
    {
        $result = [];

        foreach ($karir as $item) {
            $periodes = explode(' dan ', $item);

            foreach ($periodes as $periode) {
                preg_match('/^(.+?)\((\d{4})-(\d{4})\)$/', $periode, $matches);

                if (count($matches) === 4) {
                    $result[] = new KarirDto(
                        trim($matches[1]),
                        (int) $matches[2],
                        (int) $matches[3]
                    );
                }
            }
        }

        return $result;
    }

    public function parseTanggalLahir(string $tanggalLahir): string
    {
        $parts = explode(',', $tanggalLahir);

        if (count($parts) !== 2) {
            return 'Tanggal lahir tidak valid';
        }

        return trim($parts[1]) ?? 'Tanggal lahir tidak valid';
    }

    public function parseTempatLahir(string $tempatLahir): string
    {
        $parts = explode(',', $tempatLahir);

        if (count($parts) !== 2) {
            return 'Tempat lahir tidak valid';
        }

        return trim($parts[0]) ?? 'Tempat lahir tidak valid';
    }

    public function hitungUmur(string $tanggalLahir): int
    {
        $bulan = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];

        $tanggalLahir = str_replace(array_keys($bulan), array_values($bulan), $tanggalLahir);

        $date = Carbon::createFromFormat('d m Y', $tanggalLahir);

        // check is not valid date
        if (! $date) {
            return 0;
        } else {
            return $date->age;
        }
    }
}
