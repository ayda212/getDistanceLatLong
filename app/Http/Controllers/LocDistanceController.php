<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LocDistance;
use LocDistanceBetween;

class LocDistanceController extends Controller
{
    public function create(request $request){
        $locDistance = new LocDistance;
        $locDistance->name = $request->name;
        $locDistance->category = $request->category;
        $locDistance->tools = $request->tools;
        $locDistance->damage = $request->damage;
        $locDistance->longitude = $request->longitude;
        $locDistance->latitude = $request->latitude;
        $locDistance->save();

        $response = [
            'status' => '200',
            'msg' => 'data berhasil disimpan'
        ];

        return response()->json($response);

    }
    //index (menampilkan semua data)
    public function getCustomer(request $request){

        $longitude = $request->longitude;
        $latitude = $request->latitude;

        $listCostumer = LocDistance::all();
        $tes = 0;
        $data = [];
        foreach ($listCostumer as $key => $Customer)
        {
            $distance = LocDistanceBetween::distance($Customer->latitude, $Customer->longitude, $latitude, $longitude, "K");
            if($distance < 10){
                $Customer['distance'] = $distance . ' KM';
                $Customer['price'] = $distance * 4000 + 50000;
                $data[$key] = $Customer;
            }
        }

        if (count($data) != 0) {
            $response = [
                'status' => '200',
                'msg' => 'data berhasil disimpan',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => '200',
                'msg' => 'data kosong'
            ];
        }
        return response()->json($response);
    }
}
