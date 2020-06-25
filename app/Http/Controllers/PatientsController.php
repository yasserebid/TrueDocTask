<?php

namespace App\Http\Controllers;

use App\Imports\ImportPatients;
use App\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class PatientsController extends Controller
{
    public function importPatients()
    {
        return view('patients');
    }

    public function upload(Request $request)
    {

        $request->validate([
            "file" => 'required|mimes:xlsx'
        ]);
        $path = $request->file('file')->store('patients');
        $file_name = str_replace('patients/', '', $path);

        Cache::put($file_name.'_success', 0);
        Cache::put($file_name.'_fail', 0);

        Excel::import(new ImportPatients($file_name), storage_path('app/' . $path));
        return redirect()->back()->with("message", "Thank you , the file has been stored for importing");
    }
}
