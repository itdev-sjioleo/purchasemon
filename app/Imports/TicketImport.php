<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TicketImport implements ToCollection, WithChunkReading, ShouldQueue
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($rows as $row) 
        {
            dd($row);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
