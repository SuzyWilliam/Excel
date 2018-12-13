<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Imports\UsersImport;
use App\Imports\UsersImport_v2;
use App\Http\Requests\UploadFile;

class UsersController extends Controller
{

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function import(UploadFile $request)
    {
        //check extensions
        $extension = \File::extension($request->file->getClientOriginalName());
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

            //import to database
            $this->excel->import(new UsersImport, $request->file('file'));
            flash('Uploaded Successfully')->success();
        } else {
            flash('File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!')->error();
        }

        return redirect()->route('home');
    }

    public function export()
    {
        //

    }

}
