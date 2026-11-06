<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PlinkoActivateMail;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Validator;
use App\Models\PlinkoData;

class PlinkoController extends Controller
{
    public function index()
    {
        // Retrieve necessary columns from forms table
        $forms = Form::select('id','full_name', 'number', 'email', 'facebook_name', 'plinko_balance', 'plinko_activate')->get();

        // Pass the data to the view
        return view('plinko.index', compact('forms'));
    }

    public function togglePlinkoActivate(Request $request, $id)
    {
        // Find the form by ID
        $form = Form::find($id);

        if ($form) {
            // Check if the incoming value matches the current value
            $isActivated = $request->plinko_activate;

            // If the current value is the same as the incoming value, do not perform the toggle
            if ($form->plinko_activate == $isActivated) {
                return response()->json(['success' => true, 'message' => 'Plinko Activate status is already ' . ($isActivated ? 'activated' : 'deactivated') . '.']);
            }

            // If deactivated, set plinko_token to null
            if ($isActivated == 0) {
                $form->plinko_token = null;
            } else {
                // If activated, generate a token and update plinko_token
                $token_id = Str::random(32);
                $form->plinko_token = $token_id;
            }

            // Update plinko_activate column
            $form->plinko_activate = $isActivated;
            $form->save();

            // Return activation response
            $activationResponse = $isActivated == 1 ? 'Activated successfully' : 'Deactivated successfully';

            // Send email if activated
            if ($isActivated == 1) {
                $settings = GeneralSetting::where('id', 1)->first();
                $data = [
                    'full_name' => $form->full_name,
                    'theme' => ($settings->theme),
                    'plinko_token' => $form->plinko_token
                ];
                
                // Attempt to send email and handle failure
                try {
                    Mail::to($form->email)->send(new PlinkoActivateMail($data)); // Send email to the user
                    return response()->json([
                        'success' => true, 
                        'activation_message' => $activationResponse,
                        'email_message' => 'Email sent successfully'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => true,
                        'activation_message' => $activationResponse,
                        'email_message' => 'Failed to send email',
                        'error_message' => $e->getMessage()
                    ]);
                }
            }

            return response()->json(['success' => true, 'activation_message' => $activationResponse]);
        }

        return response()->json(['success' => false, 'message' => 'Form not found.']);
    }

    public function gamestart($token_id)
    {
        // Check if the token exists in the database
        $form = Form::select('id','full_name','plinko_activate','plinko_balance')->where('plinko_token', $token_id)->first();

        if ($form && $form->plinko_activate == 1) {
            // Token is valid, pass the data to the view
            return view('plinko.game', compact('form','token_id'));
        }

        // If token is invalid, you can redirect or show an error
        return redirect()->route('homePage')->with('error', 'Invalid token.');
    }
    
    public function saveGameData(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'form_id' => 'required|exists:forms,id',
            'bet_amount' => 'required|numeric',
            'multiplier_value' => 'required|numeric',
            'risk_level' => 'required|string',
            'rows_selected' => 'required|integer',
            'game_type' => 'required|string',
            'win_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
            'new_balance' => 'required|numeric',
            'token_used' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // Save data to the plinko_data table
        $plinkoData = PlinkoData::create([
            'form_id' => $request->form_id,
            'bet_amount' => $request->bet_amount,
            'multiplier_value' => $request->multiplier_value,
            'risk_level' => $request->risk_level,
            'rows_selected' => $request->rows_selected,
            'game_type' => $request->game_type,
            'win_balance' => $request->win_balance,
            'current_balance' => $request->current_balance,
            'new_balance' => $request->new_balance,
            'token_used' => $request->token_used,
        ]);

        // Update the form with the new balance
        $form = Form::find($request->form_id);
        $form->plinko_balance = $request->new_balance;
        $form->save();

        return response()->json(['success' => true, 'message' => 'Game data saved successfully!']);
    }

}
