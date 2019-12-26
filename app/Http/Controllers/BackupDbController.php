<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\DbDumper\Databases\MySql;

class BackupDbController extends Controller
{
    //
    public function db_dumper(Request $request)
    {
        $databaseName = DB::getDatabaseName();
        $userName = env("DB_USERNAME", "pms");
        $password = env("DB_PASSWORD", "It@Force201(");
        $name = "db_backups/".$databaseName."_".date('YmdHis').".sql";

        MySql::create()
            ->setDumpBinaryPath('/usr/bin')
            ->setDbName($databaseName)
            ->setUserName($userName)
            ->setPassword($password)
            ->dumpToFile(public_path($name));

        $zip_file = public_path("db_backups/".$databaseName."_".date('YmdHis').".zip");
        $zip = new \ZipArchive();
        $res = $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($res === TRUE) {
            $invoice_file = $name;

            $zip->addFile(public_path($invoice_file), $invoice_file);
            $zip->close();
//            $mydb = new BackupDb();
//            $mydb->title = $databaseName."_".date('YmdHis').".zip";
//            $mydb->file_size =  $this->formatSizeUnits(File::size(public_path($name)));
//            $mydb->save();
            return redirect()
                ->route("dashboard")
                ->with([
                    'message'    => "DB Backup Successfully",
                    'alert-type' => 'success',
                ]);
        }else{
            return redirect()
                ->route("dashboard")
                ->with([
                    'message'    => "DB Backup Failed",
                    'alert-type' => 'success',
                ]);
        }
    }
}
