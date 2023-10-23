<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload (Request $request): string {

        // Untuk mengambil banyak gambar
        $picture = $request->allFiles();

        // Untuk mengambil 1 gambar
        $picture = $request->file("picture");
        $picture->storePubliclyAs("pictures", $picture->getClientOriginalName(), "public");

        return "OK: " . $picture->getClientOriginalName();
    }
}
