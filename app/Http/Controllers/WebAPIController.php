<?php

namespace App\Http\Controllers;

use App\Models\Geometri;
use App\Models\Sawah;
use App\Services\GeometriService;
use App\Services\Response;
use App\Services\SawahService;
use Illuminate\Http\Request;

class WebAPIController extends Controller
{
    public function __construct(
        public SawahService $sawahService,
        public GeometriService $geometriService
    ) {
    }

    public function index(Request $request)
    {
    }

    public function getAllSawah(Request $request)
    {
        $response = new Response();
        $all_sawah = $this->sawahService->getAll();
        $sawah_response = array(
            "type" => "FeatureCollection",
            "features" => array()
        );

        foreach ($all_sawah as $sawah) {
            $temp = array(
                "type" => "Feature",
                "properties" => array(
                    "color" => $sawah->color,
                    "popupContent" => array(
                        "ownerName" => $sawah->owner,
                        "crop" => $sawah->crop,
                        "hamlet" => $sawah->hamlet,
                        "plantingDate" => $sawah->planting_date
                    )
                ),
                "geometry" => array(
                    "type" => $sawah->geometri->geo_type,
                    "coordinates" => json_decode($sawah->geometri->coordinates)
                )
            );

            $sawah_response["features"][] = $temp;
        }

        $response->data = $sawah_response;

        return response()->json($response);
    }

    public function addSawah(Request $request)
    {
        $response = new Response();
        $sawah = new Sawah();
        $geometri = new Geometri();
        $sawah->fill($request->input());
        $geometri->fill($request->input());

        $this->sawahService->add($sawah);
        $geometri->geo_type = 'Polygon';
        $geometri->id_sawah = $sawah->id;
        $this->geometriService->add($geometri);

        $response->data = $sawah;

        return response()->json($response);
    }

    public function getSawahById(Request $request, string $id)
    {

        $sawah = $this->sawahService->getById($id);
        if (is_null($sawah)) {
            return response()->json([
                "code" => 404,
                "message" => "Field not found"
            ]);
        }

        $response = new Response();
        $response->data = $sawah;

        return response()->json($response);
    }

    public function updateSawah(Request $request)
    {
        $response = new Response();
        $response->data = $this->sawahService->update($request->input('id'), $request->input());

        return response()->json($response);
    }

    public function deleteSawah(Request $request, string $id)
    {
        $response = new Response();
        $response->data = $this->sawahService->delete($id);

        return response()->json($response);
    }
}
