<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\User;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements
    SkipsOnError,
    WithHeadingRow,
    ToCollection
{
    use Importable;

    private function getRow($row)
    {
        return [
            "email" => $this->email($row),
            "full_name" => $this->name($row),
        ];
    }

    private function email($row)
    {
        if (!isset($row['email'])) {
            throw new \Exception("Excel Header Is Not Compatiable (eg. full name, email)", 400);
            // $row = $row->values();
        }
        return $row['email'] ?? $row[1];
    }

    private function name($row)
    {
        if (!isset($row['full_name'])) {
            throw new \Exception("Excel Header Is Not Compatiable (should contain full name, email )", 400);
            // $row = $row->values();
        }

        return $row['full_name'] ?? $row[0];
    }

    public function collection(Collection $rows)
    {
        $inserted = User::all();
        $flag = true;

        if ($inserted->count() == 0) { // first time to insert to database 
            $inserted = collect([]);
            foreach ($rows as $row) {
                $similar_emails = $inserted->where('email', $this->email($row));
                if ($similar_emails->count() == 0) {
                    $inserted->push(collect($row)->all());
                } else {
                    $similar_emails->transform(function ($item) use ($row) {
                        return collect($row)->except('email')->all();
                    });
                }
            }

            $flag &= User::insert($inserted->all());
        } else { //inserted before
            foreach ($rows as $row) {
                if ($inserted->where('email', $this->email($row))->count() == 0) {
                    $result = User::insert($this->getRow($row));
                } else {
                    $result = User::where('email', $this->email($row))->update(
                        collect($row)->except('email')->all()
                    );
                }

                $flag &= $result;
            }
        }

        return $flag;
    }


    public function chunkSize() : int
    {
        return 500;
    }

    /**
     * @param \Throwable $e
     */
    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
        flash($e->getMessage())->error();
        return redirect()->route('home');
    }

}
