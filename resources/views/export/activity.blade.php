<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="p-2">

    @php
        App::setLocale(app()->getLocale());
        Number::useCurrency('IDR');
        Number::useLocale(app::getLocale());
    @endphp

    <table class="w-full">
        <tbody class="text-center">
            <tr>
                <td>E-Monev Dinas Tanaman Pangan Hortikultura dan Pertanian</td>
            </tr>
            <tr>
                <td>Provinsi Kalimantan Tengah</td>
            </tr>
            <tr>
                <td>Tahun 2025</td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr class="text-left">
                <td class="w-fit pe-5">Kode</td>
                <td>: {{ $activity->code }}</td>
            </tr>
            <tr class="text-left">
                <td class="w-fit pe-5">Nomenklatur</td>
                <td>: {{ $activity->label }}</td>
            </tr>
            <tr class="text-left">
                <td class="w-fit pe-5">Target</td>
                <td>: {{ $activity->volume }} {{ $activity->unit }}</td>
            </tr>
            <tr class="text-left">
                <td class="w-fit pe-5">Bidang / UPT</td>
                <td>: {{ $activity->role->name }}</td>
            </tr>
            <tr class="text-left">
                <td class="w-fit pe-5">Pelaksanaan</td>
                <td>: {{ $activity->reports()->max('reports.implementation_progress') }}%</td>
            </tr>
            <tr class="text-left">
                <td class="w-fit pe-5">Persentase Anggaran</td>
                <td>: {{ $activity->code }}</td>
            </tr>
            <tr class="text-left">
                <td class="w-fit pe-5">Alokasi</td>
                <td>: {{ Number::currency($activity->components()->sum('allocation_total'), precision: 0) }}</td>
            </tr>
            <tr class="text-left">
                <td class="w-fit pe-5">Realisasi</td>
                <td>
                    :
                    {{ $activity->reports()->sum(DB::raw('realization_capital + realization_good + realization_employee + realization_social')) }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="w-full border-collapse border border-gray-400 my-4">
        <thead class="text-center">
            <tr>
                <td class="border font-bold" colspan="10">Komponen</td>
            </tr>
            <tr>
                <td class="border font-bold" rowspan="2">Kode & Nomenklatur</td>
                <td class="border font-bold" colspan="2">Fisik</td>
                <td class="border font-bold" colspan="3">Anggaran</td>
                <td class="border font-bold" colspan="4">Alokasi Anggaran per Jenis Belanja</td>
            </tr>
            <tr>
                <td class="border">Target</td>
                <td class="border">Pelaksanaan</td>
                <td class="border">Alokasi</td>
                <td class="border">Realisasi</td>
                <td class="border">%</td>
                <td class="border">Belanja Modal</td>
                <td class="border">Belanja Barang</td>
                <td class="border">Belanja Pegawai</td>
                <td class="border">Bantuan Sosial</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($activity->components as $component)
                <tr>
                    <td class="border px-2">
                        <b> {{ $component->code }}</b>
                        <br>
                        {{ $component->label }}
                    </td>
                    <td class="border text-center">
                        {{ $component->volume }}
                        <br>
                        {{ $component->unit }}
                    </td>
                    <td class="border text-center">
                        {{ $component->reports()->max('reports.implementation_progress') }} %
                    </td>
                    <td class="border text-center">
                        {{ Number::currency($component->allocation_total, precision: 0) }}
                    </td>
                    <td class="border text-center">
                        {{ Number::currency(
                            $component->reports()->sum(DB::raw('realization_capital + realization_good + realization_employee + realization_social')),
                            precision: 0,
                        ) }}
                    </td>
                    <td class="border text-center">
                        {{ Number::percentage(
                            floor(
                                ($component->reports()->sum(DB::raw('realization_capital + realization_good + realization_employee + realization_social')) /
                                    $component->allocation_total) *
                                    100,
                            ),
                            precision: 0,
                        ) }}
                    </td>
                    <td class="border text-center">
                        {{ Number::currency($component->allocation_capital, precision: 0) }}
                    </td>
                    <td class="border text-center">
                        {{ Number::currency($component->allocation_good, precision: 0) }}
                    </td>
                    <td class="border text-center">
                        {{ Number::currency($component->allocation_employee, precision: 0) }}
                    </td>
                    <td class="border text-center">
                        {{ Number::currency($component->allocation_social, precision: 0) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @foreach ($activity->components as $component)
        <table class="w-full border-collapse border border-gray-400 my-4">
            <tbody class="text-center">
                <tr>
                    <td class="border" colspan="11">
                        <b>{{ $component->code }}</b>:
                        {{ $component->label }}
                    </td>
                </tr>
                <tr>
                    <td class="border font-bold" rowspan="2">Bulan</td>
                    <td class="border font-bold" colspan="3">Fisik</td>
                    <td class="border font-bold" colspan="4">Realisasi Anggaran</td>
                    <td class="border font-bold" rowspan="2">Parsial</td>
                    <td class="border font-bold" rowspan="2">Progress %</td>
                    <td class="border font-bold" rowspan="2">Status Masalah</td>
                </tr>
                <tr>
                    <td class="border">Realisasi Fisik</td>
                    <td class="border">Realisasi Riil</td>
                    <td class="border">Status</td>
                    <td class="border">Belanja Modal</td>
                    <td class="border">Belanja Barang</td>
                    <td class="border">Belanja Pegawai</td>
                    <td class="border">Bantuan Sosial</td>
                </tr>
            </tbody>
            <tbody>
                @foreach ($component->reports->sortBy('month') as $report)
                    <tr>
                        @php
                            $rowspan = 1;
                            $rowspan += $report->implementation_description ? 1 : 0;
                            $rowspan += $report->issue_description ? 1 : 0;
                        @endphp
                        <td class="border text-center" rowspan="{{ $rowspan }}">
                            {{ Carbon\Carbon::createFromFormat('m', $report->month)->translatedFormat('F') }}
                        </td>
                        <td class="border text-center">
                            @if ($report->physical_volume)
                                {{ $report->physical_volume }} <br> %
                            @endif
                        </td>
                        <td class="border text-center">
                            @if ($report->physical_real)
                                {{ $report->physical_real }} <br> %
                            @endif
                        </td>
                        <td class="border text-center">
                            {{ $report->physical_status ? __('Status Utilization:true') : __('Status Utilization:false') }}
                        </td>
                        <td class="border text-center">
                            {{ Number::currency($report->realization_capital, precision: 0) }}</td>
                        <td class="border text-center">{{ Number::currency($report->realization_good, precision: 0) }}
                        </td>
                        <td class="border text-center">
                            {{ Number::currency($report->realization_employee, precision: 0) }}</td>
                        <td class="border text-center">
                            {{ Number::currency($report->realization_social, precision: 0) }}</td>
                        <td class="border text-center">
                            {{ Number::percentage(floor(($report->budget_realization() / $component->allocation_total) * 100), precision: 0) }}
                        </td>
                        <td class="border text-center">
                            {{ Number::percentage($report->implementation_progress, precision: 0) }}
                        </td>
                        <td class="border text-center">
                            {{ $report->issue_is_solve ? __('Issue Solve:true') : __('Issue Solve:false') }}
                        </td>
                    </tr>
                    @if ($report->implementation_description)
                        <tr class="font-thin text-xs">
                            <td class="border">{{ __('Keterangan') }}</td>
                            <td class="border" colspan="9">
                                {{ $report->implementation_description }}
                            </td>
                        </tr>
                    @endif
                    @if ($report->issue_description)
                        <tr class="font-thin text-xs">
                            <td class="border">{{ __('Masalah') }}</td>
                            <td class="border" colspan="9">
                                {{ $report->issue_description }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="break-inside-avoid text-center">

        <table class="w-full my-4">
            <tr class="my-8">
                <td class="w-1/13"></td>
                <td class="w-3/13"></td>
                <td class="w-5/13"></td>
                <td class="w-3/13">Palangka Raya, 05 Mei 2025</td>
                <td class="w-1/13"></td>
            </tr>
        </table>

        <table class="w-full my-4">
            <tr>
                <td class="w-1/13"></td>
                <td class="w-3/13"></td>
                <td class="w-5/13"></td>
                <td class="w-3/13">Mengesahkan,</td>
                <td class="w-1/13"></td>
            </tr>
            <tr>
                <td class="w-1/13"></td>
                <td class="w-3/13">Kepala Dinas Tanaman Pangan Hortikultura Peternakan</td>
                <td class="w-5/13"></td>
                <td class="w-3/13 content-start">PPKD</td>
                <td class="w-1/13"></td>
            </tr>
        </table>
        <br><br><br><br><br><br>
        <table class="w-full my-4">
            <tr class="font-bold underline text-center">
                <td class="w-1/13"></td>
                <td class="w-3/13">Ir. Hj. SUNARTI, MM</td>
                <td class="w-5/13"></td>
                <td class="w-3/13">SYAHFIRI, SE</td>
                <td class="w-1/13"></td>
            </tr>
            <tr>
                <td class="w-1/13"></td>
                <td class="w-3/13">NIP: 19690907199403200</td>
                <td class="w-5/13"></td>
                <td class="w-3/13">NIP. 196810131999031006</td>
                <td class="w-1/13"></td>
            </tr>
        </table>
    </div>

</body>

</html>
