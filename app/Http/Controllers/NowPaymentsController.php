<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client; // Add this import
use App\Models\Order; // Add this import
use App\Repositories\CoinsAddressRepositoryInterface;
use App\Repositories\NetWorkRepositoryInterface;

class NowPaymentsController extends Controller
{
    private $apiKey;
    private $baseUrl = 'https://api.nowpayments.io/v1';
    private $coinsAddressRepository;
    private $netWorkRepository;
    public function __construct(CoinsAddressRepositoryInterface $coinsAddressRepository, NetWorkRepositoryInterface $netWorkRepository)
    { 
        $this->netWorkRepository = $netWorkRepository;
        $this->coinsAddressRepository = $coinsAddressRepository;
        $this->apiKey = config('services.nowpayments.api_key');
    }

    public function networkList(Request $request)
    {
        if ($request->ajax()) {
            // Retrieve all addresses by default
            $data['networks'] = $this->netWorkRepository->getAll();
    
            // Apply filtering if a keyword is provided
            if ($request->keyword != null) {
                $data['networks'] = $this->netWorkRepository->getAll()->filter(function ($item) use ($request) {
                    return stripos($item->name, $request->keyword) !== false;
                });
            }
    
            // Return JSON response for AJAX
            return response()->json($data);
        } else {
            return view('frontend.payments.nowpayment');
        }
    }

    public function walletList(Request $request)
    {
        // Initialize response data
        $data = [
            'details' => null,
            'wallets' => []
        ];

        // Ensure 'id' is provided
        if (!$request->has('id')) {
            return response()->json(['error' => 'Invalid request. Missing ID.'], 400);
        }

        // Retrieve network details
        $network = $this->netWorkRepository->getById($request->id);

        if (!$network) {
            return response()->json(['error' => 'Network not found.'], 404);
        }

        // If there is a default address, return details
        if (!empty($network->default_address)) {
            $data['details'] = $network;
        } else {
            // Retrieve wallet list
            $wallets = $network->wallets;

            // Apply search filter if keyword is provided
            if ($request->filled('keyword')) {
                $keyword = strtolower($request->keyword);
                $wallets = $wallets->filter(function ($item) use ($keyword) {
                    return stripos(strtolower($item->symbol), $keyword) !== false;
                });
            }

            $data['wallets'] = $wallets->values(); // Reset array keys after filtering
        }

        return response()->json($data);

            
            
            // $client = new Client();
            // $headers = [
            //     'x-api-key' => $this->apiKey,
            // ];
            
            // try {
            //     // $apiRequest = new \GuzzleHttp\Psr7\Request('GET', 'https://api.nowpayments.io/v1/currencies?fixed_rate=true', $headers);
            //     $apiRequest = new \GuzzleHttp\Psr7\Request('GET', 'https://api.nowpayments.io/v1/full-currencies', $headers);
            //     $response = $client->sendAsync($apiRequest)->wait();
            //     $currencies = json_decode($response->getBody(), true); // Decode the JSON response
                
            //     return view('frontend.payments.nowpayment', compact('currencies'));
            // } catch (\Exception $e) {
            //     // Handle errors
            //     return back()->withErrors(['error' => 'Failed to fetch currencies: ' . $e->getMessage()]);
            // }
    }
    
     public function copyAddress(Request $request){
        if($request->ajax()){
            $data = $this->netWorkRepository->getById($request->id);
            return response($data);
        }else{
            return response('Failed to copy');
        }
        
    }

        public function fetchCurrencies()
    {
        $client = new Client();
        $headers = [
            'x-api-key' => $this->apiKey,
        ];

        try {
            $apiRequest = new \GuzzleHttp\Psr7\Request('GET', 'https://api.nowpayments.io/v1/full-currencies', $headers);
            $response = $client->sendAsync($apiRequest)->wait();
            $currencies = json_decode($response->getBody(), true); // Parse JSON response

            return response()->json(['currencies' => $currencies]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch currencies: ' . $e->getMessage()], 500);
        }
    }
    
    public function getCryptoDetails(Request $request){
        $data = $this->coinsAddressRepository->getById($request->id);
        return response($data);
    }

    public function processPayment(Request $request)
    {
        $client = new Client();
        $headers = [
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ];

        // $body = json_encode([
        //     'price_amount' => $request->input('amount'),
        //     'price_currency' => $request->input('currency'),
        //     "pay_currency"   => "btc",
        //     'order_id' => uniqid('order_'), // Unique order ID
        //     'order_description' => $request->input('description'),
        //     "ipn_callback_url" => "https://nowpayments.io",
        //     'success_url' => url('/payment-success'),
        //     'cancel_url' => url('/payment-cancel'),
        // ]);
        $body = '{
            "price_amount": 3999.5,
            "price_currency": "usd",
            "pay_currency": "btc",
            "ipn_callback_url": "https://nowpayments.io",
            "order_id": "RGDBP-21314",
            "order_description": "Apple Macbook Pro 2019 x 1"
          }';

        try {
            $apiRequest = new \GuzzleHttp\Psr7\Request('POST', 'https://api.nowpayments.io/v1/payment', $headers, $body);
            $response = $client->sendAsync($apiRequest)->wait();
            $paymentResponse = json_decode($response->getBody(), true);
            return $paymentResponse;
            return response()->json([
                'success_url' => $paymentResponse['invoice_url'], // URL for payment
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create payment: ' . $e->getMessage()], 500);
        }
    }
    // public function createInvoice(Request $request)
    // {
    //     $request->validate([
    //         'price_amount' => 'required|numeric|min:0.0001041851',
    //         'price_currency' => 'required|string|size:3',
    //         'order_id' => 'required|string',
    //         'order_description' => 'nullable|string',
    //     ]);

    //     $body = [
    //         'price_amount' => $request->input('price_amount'),
    //         'price_currency' => $request->input('price_currency'),
    //         'order_id' => $request->input('order_id'),
    //         'order_description' => $request->input('order_description'),
    //         'ipn_callback_url' => route('nowpayments.ipn'),
    //         'success_url' => route('nowpayments.success'),
    //         'cancel_url' => route('nowpayments.cancel'),
    //     ];

    //     try {
    //         $response = Http::withHeaders([
    //             'x-api-key' => $this->apiKey,
    //             'Content-Type' => 'application/json',
    //         ])->post($this->baseUrl . '/invoice', $body);
    //         if ($response->successful()) {
    //             return response()->json($response->json(), 201);
    //         } else {
    //             Log::error('NowPayments Invoice Creation Error: ' . $response->body());
    //             return response()->json([
    //                 'message' => 'Failed to create invoice.',
    //                 'errors' => $response->json(),
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('NowPayments Exception: ' . $e->getMessage());
    //         return response()->json(['message' => 'An unexpected error occurred.'], 500);
    //     }
    // }

    public function createInvoice(Request $request)
    {
        $request->validate([
            'price_amount' => 'required|numeric|min:0.0001041851', // Your minimum amount validation
            'order_id' => 'required|string',
            'order_description' => 'nullable|string',
        ]);

        $body = [
            'price_amount' => $request->input('price_amount'),
            "price_currency" => "usd",
            'order_id' => $request->input('order_id'),
            'order_description' => $request->input('order_description'),
            'ipn_callback_url' => route('nowpayments.ipn'),
            'success_url' => route('nowpayments.success'),
            'cancel_url' => route('nowpayments.cancel'),
        ];

        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/invoice', $body);

            if ($response->successful()) {
                $responseData = $response->json();
                // Create a new Payment model and store the response data
                $payment = new Order();
                $payment->order_number = $request->input('order_id');
                $payment->total_amount = $request->input('price_amount');
                $payment->price_currency = $request->input('price_currency');
                $payment->pay_currency = $request->input('pay_currency');
                $payment->nowpayments_payment_id = $responseData['payment_id'] ?? null; // Store NowPayments payment ID, handle null
                $payment->nowpayments_invoice_id = $responseData['id']; // Store NowPayments invoice ID
                $payment->payment_status = 'pending'; // Set initial payment status
                $payment->invoice_url = $responseData['invoice_url']; // Store the invoice URL
                $payment->save(); // Save the payment details to the database
                // Extract invoice_id (or use invoice_url)
                $invoiceId = $responseData['id'];
                $invoiceUrl = $responseData['invoice_url'];
    
                return response()->json([
                    'invoice_id' => $invoiceId,
                    'invoice_url' => $invoiceUrl,
                    'message' => 'Invoice created successfully',
                    'full_details' => $responseData
                ], 201);
                Log::info("data : " .$responseData);
            } else {
                Log::error('NowPayments Invoice Creation Error: ' . $response->body());
                return response()->json([
                    'message' => 'Failed to create invoice.',
                    'errors' => $response->json(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('NowPayments Exception: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function ipn(Request $request)
    {
        Log::info('NowPayments IPN Received:', $request->all());

        $hmac = hash_hmac('sha512', file_get_contents('php://input'), $this->apiKey);

        if ($hmac !== $request->header('x-nowpayments-sig')) {
            Log::warning('Invalid NowPayments IPN signature.');
            return response('Invalid signature', 400);
        }

        $ipnData = $request->all();

        // Process IPN data (VERY IMPORTANT)
        $ipnData = $request->all();

        if (isset($ipnData['order_id']) && isset($ipnData['payment_status']) && isset($ipnData['pay_currency'])) { //Check if pay_currency is present
            $payment = Payment::where('order_id', $ipnData['order_id'])->first();
            if ($payment) {
                $payment->payment_status = $ipnData['payment_status'];
                $payment->pay_currency = $ipnData['pay_currency']; // Update pay_currency from IPN
                $payment->save();
    
                Log::info("Order {$ipnData['order_id']} status updated to {$ipnData['payment_status']} and pay currency to {$ipnData['pay_currency']}");
            } else {
                Log::warning("Order {$ipnData['order_id']} not found in database for IPN update.");
            }
        } else {
            Log::warning("Required data missing from IPN request", $ipnData);
        }
    
        return response('IPN processed', 200);
    }

    public function success(Request $request)
    {
        return redirect('/payment/success'); // Redirect after successful payment
    }

    public function cancel(Request $request)
    {
        return redirect('/payment/cancel'); // Redirect after cancelled payment
    }
}