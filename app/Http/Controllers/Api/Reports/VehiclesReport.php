<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Utilities\HTTPHelpers;
use App\Utilities\PDFHelpers;

class VehiclesReport extends Controller
{
    private PDFHelpers $PDFHelpers;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->PDFHelpers = new PDFHelpers();
    }

    public function generatePDF()
    {
        try {
            $mpdf = $this->PDFHelpers->initDocument();
            $listOfVehicles = Vehicle::select(['*'])->with('motorOfVehicle')->with('typeOfVehicle')->with('driver')->with('owner')->get();

            $tableContent = '';

            for ($i = 0; $i < count($listOfVehicles); $i++) {
                $vehicle = $listOfVehicles[$i];

                $tableContent = '
                    <tr class="tr">
                        <td class="td">' . $vehicle->plate . '</td>
                        <td class="td">' . $vehicle->typeOfVehicle->name . '</td>
                        <td class="td">' . $vehicle->brandOfVehicle->name . '</td>
                        <td class="td">' . $vehicle->driver->first_name . ' ' . $vehicle->driver->second_name . ' ' . $vehicle->driver->surnames . '</td>
                        <td class="td">' . $vehicle->owner->first_name . ' ' . $vehicle->owner->second_name . ' ' . $vehicle->owner->surnames . '</td>
                    </tr>
                ';
            }

            $body = '
                <div class="container">
                    <table width="100%">
                      <tr>
                        <td align="left"></td>
                        <td align="center">
                            <p>INFORME DE VEHÍCULOS</p>
                        </td>
                        <td align="right"></td>
                      </tr>
                    </table>
                    <p class="text">A continuación, se presentará un informe con todos los vehículos de la compañía junto con sus conductores y propietarios.</p>
                    <table class="table">
                        <tr class="tr">
                            <th class="th">Placa</th>
                            <th class="th">Tipo de vehículo</th>
                            <th class="th">Marca</th>
                            <th class="th">Conductor</th>
                            <th class="th">Propietario</th>
                        </tr>
                        ' . $tableContent . '
                    </table>
                </div>
            ';

            $mpdf->WriteHTML($this->PDFHelpers->stylesheet . $body);

            return $this->PDFHelpers->generateContentBlob($mpdf);
        } catch (\Throwable $th) {
            return HTTPHelpers::responseError($th->getMessage());
        }
    }
}
