<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TestExportFromView implements FromView
{
    public function view(): View
    {
        return view('excel_exports.test_excel', [
            'users' => User::all(),
        ]);
    }
}
