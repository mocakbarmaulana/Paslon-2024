<?php

namespace App\Console\Commands;

use App\Enum\PosisiEnum;
use App\Services\PaslonService;
use Illuminate\Console\Command;

class PaslonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:paslon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): array
    {
        $paslonService = new PaslonService();
        $response = $paslonService->getPaslon();

        if (array_key_exists('status', $response)) {
            $this->error($response['message']);

            return [];
        }

        $paslonPresiden = $paslonService->convertToDtoProfile($response['calon_presiden'], PosisiEnum::PRESIDEN());
        $paslonWakilPresiden = $paslonService->convertToDtoProfile(
            $response['calon_wakil_presiden'],
            PosisiEnum::WAKIL_PRESIDEN());

        $result = array_merge($paslonPresiden, $paslonWakilPresiden);

        // group by nomor urut and sort by nomor urut ascending
        $data = collect($result)->sort(function ($a, $b) {
            return $a->nomor_urut <=> $b->nomor_urut;
        })->toArray();

        return $this->convertToTableFormat($data);
    }

    private function convertToTableFormat(array $data): array
    {
        $tableData = [];

        foreach ($data as $item) {
            $karir = array_map(function ($karirDto) {
                return $karirDto->jabatan.' ('.$karirDto->tahun_mulai.'-'.$karirDto->tahun_selesai.')';
            }, $item['karir']);

            $tableData[] = [
                'Nomor Urut' => $item['nomor_urut'],
                'Posisi' => $item['posisi']->value,
                'Tempat Lahir' => $item['tempat_lahir'],
                'Tanggal Lahir' => $item['tanggal_lahir'],
                'Usia' => $item['usia'],
                'Karir' => implode(', ', $karir),
            ];
        }

        return $tableData;
    }
}
