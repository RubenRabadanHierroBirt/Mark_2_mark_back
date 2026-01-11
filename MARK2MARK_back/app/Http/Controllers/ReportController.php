<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Club;
use App\Models\Competition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function downloadExcel(string $tipo)
    {
        $tipo = strtolower($tipo);
        $titulo = 'Informe';
        $header = [];
        $rows = [];

        switch ($tipo) {
            case 'atletas':
                $titulo = 'Informe de Atletas';
                $header = ['ID', 'Nombre', 'Email', 'Estado', 'Usuario'];
                $items = Athlete::with('user')
                    ->where('id_usuario', '!=', 1)
                    ->orderBy('id')
                    ->get();
                foreach ($items as $item) {
                    $rows[] = [
                        $item->id,
                        $item->nombre,
                        $item->email ?? '',
                        $item->status ?? '',
                        $item->user ? $item->user->username : ''
                    ];
                }
                break;
            case 'clubes':
                $titulo = 'Informe de Clubes';
                $header = ['ID', 'Nombre', 'Email', 'Estado', 'Localidad'];
                $items = Club::orderBy('id')->get();
                foreach ($items as $item) {
                    $rows[] = [
                        $item->id,
                        $item->name,
                        $item->email ?? '',
                        $item->estado ?? '',
                        $item->localidad ?? ''
                    ];
                }
                break;
            case 'competiciones':
                $titulo = 'Informe de Competiciones';
                $header = ['ID', 'Nombre', 'Fecha', 'Estado', 'Revisado'];
                $items = Competition::orderBy('fecha', 'desc')->get();
                foreach ($items as $item) {
                    $fecha = $item->fecha ? Carbon::parse($item->fecha)->format('Y-m-d') : '';
                    $rows[] = [
                        $item->id,
                        $item->name,
                        $fecha,
                        $item->status ?? '',
                        $item->revisado_federacion ? 'Si' : 'No'
                    ];
                }
                break;
            case 'noticias':
                $titulo = 'Informe de Noticias';
                $header = ['Fecha', 'Fuente', 'Titulo'];
                $apiKey = env('NEWS_API_KEY', '');
                $baseUrl = env('NEWS_API_BASE_URL', 'https://newsapi.org/v2/everything');
                $query = env('NEWS_API_QUERY', 'atletismo OR \"track and field\"');
                $language = env('NEWS_API_LANGUAGE', 'es');
                $pageSize = (int) env('NEWS_API_PAGE_SIZE', 10);

                if (!$apiKey) {
                    $rows[] = ['Sin API key configurada (NEWS_API_KEY).', '', ''];
                    break;
                }

                $response = Http::get($baseUrl, [
                    'q' => $query,
                    'language' => $language,
                    'sortBy' => 'publishedAt',
                    'pageSize' => $pageSize,
                    'apiKey' => $apiKey,
                ]);

                if (!$response->ok()) {
                    $rows[] = ['Error NewsAPI: ' . $response->status(), '', ''];
                    break;
                }

                $articles = $response->json('articles', []);
                foreach ($articles as $item) {
                    $fecha = isset($item['publishedAt']) ? Carbon::parse($item['publishedAt'])->format('Y-m-d') : '';
                    $fuente = $item['source']['name'] ?? '';
                    $tituloNoticia = $item['title'] ?? '';
                    $tituloNoticia = mb_strlen($tituloNoticia) > 80 ? mb_substr($tituloNoticia, 0, 77) . '...' : $tituloNoticia;
                    $rows[] = [
                        $fecha,
                        $fuente,
                        $tituloNoticia
                    ];
                }
                break;
            default:
                return response()->json(['message' => 'Tipo de informe no valido'], 404);
        }

        $csv = $this->buildCsv($header, $rows);
        $filename = 'reporte-' . $tipo . '.csv';

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function buildCsv(array $header, array $rows): string
    {
        $lines = [];
        $lines[] = $this->csvLine($header);
        foreach ($rows as $row) {
            $lines[] = $this->csvLine($row);
        }
        return implode("\n", $lines);
    }

    private function csvLine(array $values): string
    {
        $escaped = array_map(function ($value) {
            $value = $value === null ? '' : (string) $value;
            $value = str_replace('"', '""', $value);
            if (strpos($value, ',') !== false || strpos($value, '"') !== false || strpos($value, "\n") !== false || strpos($value, "\r") !== false) {
                $value = '"' . $value . '"';
            }
            return $value;
        }, $values);

        return implode(',', $escaped);
    }

}
