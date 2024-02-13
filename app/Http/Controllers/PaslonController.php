<?php

namespace App\Http\Controllers;

use App\Enum\PosisiEnum;
use App\Services\PaslonService;
use Illuminate\Contracts\View\View;

class PaslonController extends Controller
{
    private PaslonService $paslonService;

    public function __construct(PaslonService $paslonService)
    {
        $this->paslonService = $paslonService;
    }

    public function __invoke(): View
    {
        $response = $this->paslonService->getPaslon();
        $data = collect([]);

        if (! array_key_exists('status', $response)) {
            $paslonPresiden = $this->paslonService->convertToDtoProfile(
                $response['calon_presiden'], PosisiEnum::PRESIDEN());
            $paslonWakilPresiden = $this->paslonService->convertToDtoProfile(
                $response['calon_wakil_presiden'],
                PosisiEnum::WAKIL_PRESIDEN());

            $result = array_merge($paslonPresiden, $paslonWakilPresiden);

            // group by nomor urut and sort by nomor urut ascending
            $data = collect($result)->groupBy('nomor_urut')->sortKeys();
        }

        return view('paslon', compact('data', 'response'));
    }
}
