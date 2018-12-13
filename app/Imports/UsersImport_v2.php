<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\User;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeImport;

class UsersImport_v2 implements ToCollection, WithChunkReading, ShouldQueue
{
    use Importable, RegistersEventListeners;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $inserted = collect(User::pluck('email'));

        foreach ($rows as $row) {
            if (!$inserted->contains('abigale.west@example.com')) {
                User::insert([
                    "email" => $row[1],
                    "name" => $row[0],
                ]);
                $inserted->push($row[1]);
            } else {
                User::where('email', $row[1])->update([
                    "name" => $row[0]
                ]);
            }
        }

    }

    public function chunkSize() : int
    {
        return 500;
    }

    public static function beforeImport(BeforeImport $event)
    {
        dd('here');
    }
}
