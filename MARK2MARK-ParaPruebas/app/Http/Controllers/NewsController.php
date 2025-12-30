<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\DTOs\News\NewsDTO;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

class NewsController extends Controller
{
    public function getAll()
    {
        $news = News::orderBy('fecha', 'desc')->get();
        $dtos = [];

        foreach ($news as $item) {
            $dtos[] = new NewsDTO($item);
        }

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Novedades obtenidas correctamente',
            $dtos
        );
    }

    public function getById($id)
    {
        $news = News::find($id);

        if (!$news) {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Novedad no encontrada',
                null
            );
        }

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Novedad obtenida correctamente',
            new NewsDTO($news)
        );
    }

    public function create(CreateNewsRequest $request)
    {
        $data = $request->validated();

        // Si no viene fecha, ponemos ahora
        if (!isset($data['fecha'])) {
            $data['fecha'] = now();
        }

        $news = News::create($data);

        return $this->sendResponse(
            'SUCCESS',
            201,
            'Novedad creada correctamente',
            new NewsDTO($news)
        );
    }

    public function update(UpdateNewsRequest $request, $id)
    {
        $news = News::find($id);

        if (!$news) {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Novedad no encontrada',
                null
            );
        }

        $news->update($request->validated());

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Novedad actualizada correctamente',
            new NewsDTO($news)
        );
    }

    public function delete($id)
    {
        $news = News::find($id);

        if (!$news) {
            return $this->sendResponse(
                'NO SUCCESS',
                404,
                'Novedad no encontrada',
                null
            );
        }

        $news->delete();

        return $this->sendResponse(
            'SUCCESS',
            200,
            'Novedad eliminada correctamente',
            new NewsDTO($news)
        );
    }

    protected function sendResponse($status, $cod, $mensaje, $data)
    {
        return response()->json([
            'status' => $status,
            'codigo' => $cod,
            'mensaje' => $mensaje,
            'data' => $data
        ], $cod);
    }
}
