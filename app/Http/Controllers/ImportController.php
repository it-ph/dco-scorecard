<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ScoresImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'import_file'   => 'required'
        ],$messages = array('import_file.required' => 'File to upload is required'));

        $path = $request->file('import_file')->getRealPath();

        $import = new ScoresImport;
        Excel::import($import, $path);

        $errors = $import->getErrors();
        if(count(array_unique($errors)) > 1)
        {
            return redirect()->back()->withErrors(array_unique($errors));
        }
        else
        {
            return redirect()->back()->with('with_success', 'Scores Uploaded Succesfully!');
        }
    }
}
