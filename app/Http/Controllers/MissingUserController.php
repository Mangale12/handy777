<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissingUser;
use App\Models\Form;
use App\Models\Account;
use Datatables;

class MissingUserController extends Controller
{
	private $missingUser;
	public function __construct(){
		$this->missingUser = new MissingUser();
	}
	public function index(){
		try {
			$users = $this->missingUser
			->query()
			->with(['account']);
			if(request()->ajax()){
				return Datatables::of($users)
				->addIndexColumn()
				->addColumn('action', function($row){
					return '';
				})
				->rawColumns(['action'])
				->make(true);
			}
			$forms= Form::get()->toArray();
			return view('newLayout.missingUser.index',compact('forms'));
		} catch (Exception $e) {
			$message =$e->getMessage();
			Log::channel('spinnerBulk')->info($message);
			return redirect()
			->back()
			->with('error','Somthing were wrong');
		}
	}


	public function addToUser(Request $request,$id){
		try {
			$formId=$request->form_id;
			$data = MissingUser::find($id);
			$account = Account::find($data->account_id);
			$formData = [
				'form_id' => $formId,
				'account_id' => $data->account_id,
				'created_by' => auth()->user()->id,
				'created_at' => now()
			];
			$histories= [
				'form_id' => $formId,
				'account_id' => $data->account_id,
				'created_by' => auth()->user()->id,
				'created_at' => now()
			];
			\DB::table('form_games')->insert(array_merge($formData,['game_id' => $data->game_id]));
			if($data->balance > 0){
				$formData['amount'] = $data->balance;
				$histories['amount_loaded'] =  $data->balance;
				$histories['type'] ='load';
				\DB::table('form_balances')->insert($formData);
				\DB::table('histories')->insert($histories);
				$account->update(['balance' => $account->balance - $data->balance]);
			}
			if($data->tips > 0){
				$formData['amount'] = $data->tips;
				$histories['amount_loaded'] =  $data->tips;
				$histories['type'] ='tip';
				\DB::table('form_tips')->insert($formData);
				\DB::table('histories')->insert($histories);
				$account->update(['balance' => $account->balance + $data->balance]);


			}
			if($data->refer > 0){
				$formData['amount'] = $data->refer;
				$histories['amount_loaded'] =  $data->tips;
				$histories['type'] ='refer';
				\DB::table('form_refers')->insert($formData);
				\DB::table('histories')->insert($histories);
				$account->update(['balance' => $account->balance - $data->balance]);

			

			}
			if($data->redeem > 0){
				$formData['amount'] = $data->redeem;
				$histories['amount_loaded'] =  $data->tips;
				$histories['type'] ='redeem';
				\DB::table('form_redeems')->insert($formData);
				\DB::table('histories')->insert($histories);
				$account->update(['balance' => $account->balance + $data->balance]);


			}
			$data->delete();
			return redirect()
			->back()
			->with('success','Added successfully');

		} catch (Exception $e) {
			$message =$e->getMessage();
			return redirect()
			->back()
			->with('error','Somthing were wrong');
		}
	}
}