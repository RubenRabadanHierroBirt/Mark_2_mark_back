<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Club;
use App\Models\Competition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function download(string $tipo)
    {
        $tipo = strtolower($tipo);
        $titulo = 'Informe';
        $lineas = [];

        switch ($tipo) {
            case 'atletas':
                $titulo = 'Informe de Atletas';
                $lineas[] = 'ID | Nombre | Email | Estado | Usuario';
                $items = Athlete::with('user')
                    ->where('id_usuario', '!=', 1)
                    ->orderBy('id')
                    ->get();
                foreach ($items as $item) {
                    $lineas[] = implode(' | ', [
                        $item->id,
                        $item->nombre,
                        $item->email ?? '',
                        $item->status ?? '',
                        $item->user ? $item->user->username : ''
                    ]);
                }
                break;
            case 'clubes':
                $titulo = 'Informe de Clubes';
                $lineas[] = 'ID | Nombre | Email | Estado | Localidad';
                $items = Club::orderBy('id')->get();
                foreach ($items as $item) {
                    $lineas[] = implode(' | ', [
                        $item->id,
                        $item->name,
                        $item->email ?? '',
                        $item->estado ?? '',
                        $item->localidad ?? ''
                    ]);
                }
                break;
            case 'competiciones':
                $titulo = 'Informe de Competiciones';
                $lineas[] = 'ID | Nombre | Fecha | Estado | Revisado';
                $items = Competition::orderBy('fecha', 'desc')->get();
                foreach ($items as $item) {
                    $fecha = $item->fecha ? Carbon::parse($item->fecha)->format('Y-m-d') : '';
                    $lineas[] = implode(' | ', [
                        $item->id,
                        $item->name,
                        $fecha,
                        $item->status ?? '',
                        $item->revisado_federacion ? 'Si' : 'No'
                    ]);
                }
                break;
            case 'noticias':
                $titulo = 'Informe de Noticias';
                $lineas[] = 'Fecha | Fuente | Titulo';
                $apiKey = env('NEWS_API_KEY', '');
                $baseUrl = env('NEWS_API_BASE_URL', 'https://newsapi.org/v2/everything');
                $query = env('NEWS_API_QUERY', 'atletismo OR \"track and field\"');
                $language = env('NEWS_API_LANGUAGE', 'es');
                $pageSize = (int) env('NEWS_API_PAGE_SIZE', 10);

                if (!$apiKey) {
                    $lineas[] = 'Sin API key configurada (NEWS_API_KEY).';
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
                    $lineas[] = 'Error NewsAPI: ' . $response->status();
                    break;
                }

                $articles = $response->json('articles', []);
                foreach ($articles as $item) {
                    $fecha = isset($item['publishedAt']) ? Carbon::parse($item['publishedAt'])->format('Y-m-d') : '';
                    $fuente = $item['source']['name'] ?? '';
                    $tituloNoticia = $item['title'] ?? '';
                    $tituloNoticia = mb_strlen($tituloNoticia) > 80 ? mb_substr($tituloNoticia, 0, 77) . '...' : $tituloNoticia;
                    $lineas[] = implode(' | ', [
                        $fecha,
                        $fuente,
                        $tituloNoticia
                    ]);
                }
                break;
            default:
                return response()->json(['message' => 'Tipo de informe no valido'], 404);
        }

        $pdf = $this->buildPdf($lineas, $titulo);
        $filename = 'reporte-' . $tipo . '.pdf';

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function buildPdf(array $lineas, string $titulo): string
    {
        $titulo = $this->sanitizeText($titulo);
        $fecha = Carbon::now()->format('Y-m-d H:i');
        $contenido = [];
        $contenido[] = 'BT';
        $contenido[] = '/F1 12 Tf';
        $contenido[] = '72 760 Td';
        $contenido[] = '(' . $this->escapePdfText($titulo) . ') Tj';
        $contenido[] = '0 -16 Td';
        $contenido[] = '(' . $this->escapePdfText('Generado: ' . $fecha) . ') Tj';
        $contenido[] = '0 -20 Td';

        foreach ($lineas as $linea) {
            $texto = $this->escapePdfText($linea);
            $contenido[] = '(' . $texto . ') Tj';
            $contenido[] = '0 -14 Td';
        }

        $contenido[] = 'ET';
        $stream = implode("\n", $contenido);
        $length = strlen($stream);

        $objects = [];
        $objects[] = '1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj';
        $objects[] = '2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj';
        $objects[] = '3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj';
        $objects[] = '4 0 obj << /Length ' . $length . ' >> stream' . "\n" . $stream . "\n" . 'endstream endobj';
        $objects[] = '5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj';

        $xref = [];
        $pdf = "%PDF-1.4\n";
        $xref[] = sprintf('%010d 65535 f ', 0);
        $offset = strlen($pdf);

        foreach ($objects as $index => $obj) {
            $xref[] = sprintf('%010d 00000 n ', $offset);
            $pdf .= $obj . "\n";
            $offset = strlen($pdf);
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . count($xref) . "\n" . implode("\n", $xref) . "\n";
        $pdf .= "trailer << /Size " . count($xref) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xrefOffset . "\n%%EOF";

        return $pdf;
    }

    private function escapePdfText(string $text): string
    {
        $text = $this->sanitizeText($text);
        $text = str_replace('\\', '\\\\', $text);
        $text = str_replace('(', '\\(', $text);
        $text = str_replace(')', '\\)', $text);
        return $text;
    }

    private function sanitizeText(string $text): string
    {
        $text = preg_replace("/[\\r\\n]+/", ' ', $text);
        if (function_exists('iconv')) {
            $converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
            if ($converted !== false) {
                $text = $converted;
            }
        }
        return preg_replace('/[^\\x20-\\x7E]/', '', $text);
    }
}
