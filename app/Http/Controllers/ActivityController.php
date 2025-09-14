<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use function Spatie\LaravelPdf\Support\pdf;

class ActivityController extends Controller
{
    public function index(Request $request, $record)
    {
        return pdf()->view('export.activity', [
            "activity" => Activity::find($record)
        ])
            ->landscape()
            ->margins(
                top: 10,
                right: 10,
                bottom: 10,
                left: 10,
                unit: 'mm'
            )
            ->paperSize(210, 297, 'mm')
            ->download('activities.pdf');
    }
    public function view(Request $request, $record)
    {
        return view('export.activity', [
            "activity" => Activity::find($record)
        ]);
    }
    // public function view(Request $request, $record)
    // {
    //     return pdf()->view('export.activity', [
    //         "activity" => Activity::find($record)
    //     ])
    //         ->landscape()
    //         ->margins(
    //             top: 10,
    //             right: 10,
    //             bottom: 10,
    //             left: 10,
    //             unit: 'mm'
    //         )
    //         ->paperSize(210, 297, 'mm');
    // }
}
