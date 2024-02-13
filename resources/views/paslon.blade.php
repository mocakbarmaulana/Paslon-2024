<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Paslon 2024</title>

    <style>
        h1, h3 {
            text-align: center;
        }

        p, ul {
            font-size: 16px;
        }

        .text-center {
            text-align: center;
        }

        .outer {
            width: 50%;
            padding: 16px;
            margin: 0 auto;
        }

        .outer-paslon {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 1px solid black;
            padding: 0 16px;
        }
    </style>
</head>
<body>
    <h1>Profil Calon Presiden dan Calon Wakil Presiden 2024</h1>
    <div>
        @if(is_array($data) && array_key_exists('status', $data))
            <h2>{{ $data['message'] }}</h2>
        @else
            <div class="outer">
            @foreach($data as $key => $item)
                <h3>{{ $key }}</h3>
                <div class="outer-paslon">
                @foreach($item as $paslon)
                        <div>
                            <h5 class="text-center">{{ $paslon->nama_lengkap }}</h5>
                            <p class="text-center">
                            <span>{{ $paslon->tempat_lahir }}</span>,
                            <span>{{ $paslon->tanggal_lahir }}</span>
                            </p>
                            <p class="text-center">{{ $paslon->usia }} Tahun</p>
                            <div>
                                <p>Karir</p>
                                <ul>
                                @foreach($paslon->karir as $karir)
                                        <li>
                                            <span>{{ $karir->jabatan }}</span>
                                            ({{ $karir->tahun_mulai }} - {{ $karir->tahun_selesai }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            </div>
        @endif
    </div>
</body>
</html>
