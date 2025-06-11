<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use voku\helper\HtmlDomParser;

class ScraperController extends Controller
{
    public function scrape(Request $request)
    {
        $url = $request->get('url');

        $client = new Client();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() == 200) {
            $html = $response->getBody()->getContents();

            // Parsear HTML
            $dom = HtmlDomParser::str_get_html($html);

            // Buscar el div con los datos del estudiante
            $student_item = $dom->findOne('div[itemprop=mainContentOfPage]');

            if ($student_item) {
                // Extraer los párrafos y convertirlos a claves y valores
                $data = [];

                foreach ($student_item->find('p') as $p) {
                    $parts = explode(':', $p->text(), 2);
                    if (count($parts) == 2) {
                        $key = trim(strip_tags($parts[0]));
                        $value = trim($parts[1]);
                        $data[$key] = $value;
                    }
                }

                return response()->json($data);
            } else {
                return response()->json([
                    'error' => 'No se encontró el contenido del estudiante.',
                ], 404);
            }
        }

        return response()->json([
            'error' => 'Error al obtener la página.',
        ], $response->getStatusCode());
    }
}