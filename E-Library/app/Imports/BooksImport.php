<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Book([
            'name' => $row['name'],
            'author' => $row['author'],
        ]);
    }
}
