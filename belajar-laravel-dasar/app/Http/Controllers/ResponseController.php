<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(): Response{
        return response("Hello Response");
    }

    public function header(): Response{

        $body = [
            "firstname" => "Farhan",
            "lastname" => "Yp",
        ];

        return  response(json_encode($body), 200)
                // Untuk menetapkan 1 header
                ->header('Content-Type', 'application/json')
                // Bisa menetapkan banyak header
                ->withHeaders([
                    'Author' => 'Farhan Yudha Pratama',
                    'App' => 'Belajar Laravel'
                ]);

        return response("Hello Response");
    }

    public function responseView(): Response{
        return  response()
                ->view('home', [
                    "name" => "Farhan Yudha Pratama"
                ]);
    }

    public function responseJson(): JsonResponse{

        $body = [
            "firstname" => "Farhan",
            "lastname" => "Yp",
        ];

        return  response()->json($body);
    }

    public function responseFile(): BinaryFileResponse{

        return  response()->file(storage_path('app/public/pictures/Ada Wong - Resident Evil 4 Remake.jpg'));
    }

    public function responseDownload(): BinaryFileResponse{

        return  response()->download(storage_path('app/public/pictures/Ada Wong - Resident Evil 4 Remake.jpg'));
    }

}
