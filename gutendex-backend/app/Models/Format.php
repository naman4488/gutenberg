<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'books_format';

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}

