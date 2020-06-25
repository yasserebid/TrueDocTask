<?php

namespace App\Imports;

use App\Mail\SendImportResult;
use App\Patient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Events\AfterImport;

class ImportPatients implements ToModel, WithEvents, ShouldQueue, SkipsOnError, WithStartRow, WithChunkReading, WithBatchInserts, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public static $file_name;

    public function __construct($file_name)
    {
        self::$file_name = $file_name;
    }

    public function model(array $row)
    {
        Cache::increment(self::$file_name . '_success');
        return new Patient([
            "first_name" => $row[0],
            "second_name" => $row[1],
            "family_name" => $row[2],
            "uid" => $row[3],
        ]);
    }

    
    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required',
            '2' => 'required',
            '3' => 'required',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function onFailure(Failure ...$failures)
    {
        $rows = [];
        foreach ($failures as $faluire) {
            if (!in_array($faluire->row(), $rows))
                Cache::increment(self::$file_name . '_fail');

            $rows[] = $faluire->row();
        }
    }

    public function onError(\Throwable $e)
    {
        Cache::increment(self::$file_name . '_fail');
    }


    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterImport::class => [self::class, 'afterImport'],
        ];
    }

    public static function afterImport(AfterImport $event)
    {
        $file = self::$file_name;
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new SendImportResult($file));
    }
}
