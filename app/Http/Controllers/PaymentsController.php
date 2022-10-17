<?php

namespace App\Http\Controllers;

Use \Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Jobs\GetUsdValueApi;
use App\Models\Payment;

class PaymentsController extends Controller
{

    /**
   * @OA\Get(
   *     path="/api/payments/{client_id}",
   *     summary="Get payments from specifyc client",
   *     @OA\Parameter(
   *         client_id="Id of client",
   *     ),
   *     @OA\Response(
   *         statusCode=200,
   *         payments=array of payments,
   *         message="Payment successfully registered."
   *     ),
   * )
   */
    public function show($client_id)
    {
        try {

            $payments = Payment::with('client')->where('client_id', '=', $client_id)->get();

        } catch (\Exception $e) {
            
            return response()->json([
              'data' => [
                'code'   => $e->getCode(),
                'errors' => $e->getMessage()
              ]
            ], 500);
        }

        return response()->json(['statusCode' => 200, "payments" => $payments], 200);

    }
    
    /**
   * @OA\Get(
   *     path="/api/payments",
   *     summary="Create new payments",
   *     @OA\Parameter(
   *         client_id="Id of client",
   *     ),
   *     @OA\Response(
   *         statusCode=201,
   *         message="Payment successfully registered."
   *     ),
   * )
   */
    public function create(Request $request)
    {
        try {

            DB::beginTransaction();

            $paymentData = [
                'uuid' => Str::uuid(),
                'expires_at' => Carbon::now()->addYear(),
                'client_id' => $request->client_id
            ];

            $payment = Payment::create($paymentData);

            DB::commit();

            //Dispatch job for clp_usd value
            GetUsdValueApi::dispatch($payment);
            
        } catch (\Exception $e) {
            
            DB::rollBack();

            return response()->json([
              'data' => [
                'code'   => $e->getCode(),
                'errors' => $e->getMessage()
              ]
            ], 500);
        }

        return response()->json(["statusCode" => 201, "message" => "Payment successfully registered."], 201);
    }

}
