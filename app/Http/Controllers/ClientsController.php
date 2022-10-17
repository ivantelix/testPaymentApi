<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Client;

class ClientsController extends Controller
{

    /**
   * @OA\Get(
   *     path="/api/clients/",
   *     summary="Get all clients",
   *     @OA\Response(
   *         statusCode=200,
   *         clients=array of clients
   *     ),
   * )
   */
    public function show()
    {
        try {

            $clients = Client::all();

        } catch (\Exception $e) {
            
            return response()->json([
              'data' => [
                'code'   => $e->getCode(),
                'errors' => $e->getMessage()
              ]
            ], 500);
        }

        return response()->json(['statusCode' => 200, "clients" => $clients], 200);

    }

  
    public function test()
    {       
        if ( !session()->has('valor') ) {
            $response = Http::get('https://mindicador.cl/api/dolar');
            $usdValue = $response->json('serie')[0];
            
            session()->put('valor', $usdValue);

            return session('valor');
        }
        else {
            return session('valor')['valor'];
        }


    }
}
