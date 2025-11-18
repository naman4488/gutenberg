<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'download_count' => $this->download_count,

            'authors' => $this->authors->pluck('name'),
            'subjects' => $this->subjects->pluck('name'),
            'bookshelves' => $this->bookshelves->pluck('name'),
            'languages' => $this->languages->pluck('code'),

            'formats' => $this->formats->map(fn($f) => [
                'mime' => $f->mime_type,
                'url' => $f->url
            ])
        ];
    }
}
