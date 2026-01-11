<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
    
     public function getExternalNews(Request $request)
    {
        $envKey = env('NEWS_API_KEY', '');
        $apiKey = $envKey !== '' ? $envKey : (string) $request->query('apiKey', '');
        $baseUrl = (string) $request->query('baseUrl', env('NEWS_API_BASE_URL', 'https://newsapi.org/v2/everything'));
        $query = (string) $request->query('query', env('NEWS_API_QUERY', 'atletismo OR "track and field"'));
        $language = (string) $request->query('language', env('NEWS_API_LANGUAGE', 'es'));
        $pageSize = (int) $request->query('pageSize', env('NEWS_API_PAGE_SIZE', 9));
        $pageSize = max(1, min(20, $pageSize));

        $response = Http::get($baseUrl, [
            'q' => $query,
            'language' => $language,
            'sortBy' => 'publishedAt',
            'pageSize' => $pageSize,
            'apiKey' => $apiKey,
        ]);

        return response()->json($response->json(), $response->status());
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
