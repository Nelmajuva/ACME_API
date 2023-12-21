<?php

namespace App\Http\Controllers\Api;

use App\Utilities\HTTPHelpers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

use Symfony\Component\CssSelector\Exception\InternalErrorException;

class DebtorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    /**
     * Obtiene la información de las deudas del
     * usuario.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByIdentification(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'identification' => 'required'
            ]);

            $identification = $request->input('identification');
            $reportenciaUrl = env('APP_REPOTENCIA_URL');

            /**
             * Verifica que exista la url para realizar
             * la petición.
             */
            if (!isset($reportenciaUrl)) throw new InternalErrorException("URL of reporencia not found.");

            /**
             * Consume el servicio de la plataforma de repotencia.
             * Method [GET]
             */
            $response = Http::withOptions(['verify' => false])->withHeaders([
                'Origin' => 'https://www.burodeconexiones.com:3005',
            ])->get($reportenciaUrl . '/getDataWhatsApp', [
                'cedula' => $identification,
            ]);

            /**
             * Creará un nuevo log en la db.
             */
            $this->insertLog($request, $response);

            $response = json_decode($response->body());
            return HTTPHelpers::responseJson($response->datos);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage(), 500);
        }
    }
}
