<?php

namespace App\DTOs\News;

use App\Models\News;
use JsonSerializable;
use Carbon\Carbon;

class NewsDTO implements JsonSerializable
{
    public int $id;
    public string $fecha;
    public string $contenido;
    public string $tipo;

    public function __construct(News $news)
    {
        $this->id = $news->id;
        $this->contenido = $news->contenido;
        $this->tipo = $news->tipo;

        $this->fecha = Carbon::parse($news->fecha)->format('d-m-Y H:i:s');
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
