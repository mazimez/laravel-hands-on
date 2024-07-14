<?php

namespace App\Http\Controllers;

use App\Traits\Base64ToFile;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use Base64ToFile;

    public function test(Request $request) {
        $base64 = $request->input('base64');

        $pdf = $this->base64ToFile($base64, 'files', 'png');

        return $pdf;
    }
}
