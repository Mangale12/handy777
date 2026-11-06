<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\FormGame;
use App\Models\Account;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
class TableImport implements ToCollection,WithHeadingRow
{
	private $groupSize=6,$skip = 2;
	private $rows = [];
	private $accounts=[];
	private $date,$fileName;
	public function __construct($date,$fileName){
		$this->date = $date .' 00:00:00';
		$this->fileName = $fileName;
	}
	protected function filterAmount($amount){
		$stringWithoutNonNumeric = preg_replace("/[^0-9]/", "", $amount);
		return (int)$stringWithoutNonNumeric;
	}

	protected function formatRowData($data){
		$filteredArray = array_filter($data, function ($subData) {
			return !empty(array_filter($subData, function ($value) {
				return $value !== null;
			}));
		});
		$rows = [];
		$counter=0;
		foreach($filteredArray as $row){
			for ($i = 0; $i < count($row); $i += ($this->groupSize + $this->skip)) {
				$groups = array_slice($row, $i, $this->groupSize);
				$checkEmpty = array_filter($groups,function($item){
					return $item!==null;
				});
				if(count($checkEmpty) > 0){
					$rows[$i][] = $groups;
				}

			}
		}
		$this->rows = $rows;
	}

// 	protected function formatAccounts($data){
// 		$rows=[];
// 		for ($i = 0; $i < count($data); $i += ($this->groupSize + $this->skip)) {
// 			$groups = array_slice($data, $i, $this->groupSize);
// 			$checkAllItemNull = array_filter($groups, function ($value) {
// 				return $value !== null;
// 			});
// 			if(count($checkAllItemNull) > 0){
// 				$rows[] = $checkAllItemNull[2];
// 			}
// 		}
// 		$this->accounts = $rows;
// 		dd($rows);
// 	}

protected function formatAccounts($data)
{
   
    $rows = [];

    for ($i = 0; $i < count($data); $i += ($this->groupSize + $this->skip)) {
        $groups = array_slice($data, $i, $this->groupSize);
         
        $checkAllItemNull = array_filter($groups, function ($value) {
            return $value !== null;
        });

        // Check if index 2 exists before accessing it
        if (isset($checkAllItemNull[2])) {
            $rows[] = $checkAllItemNull[2];
        }
    }
    $this->accounts = $rows;
}



	protected function updateBalance($data, $calType)
	{
		foreach ($data as $key => $amount) {
			$account = Account::find((int)$key);
			if ($account) {
				$currentBalance = (int)$account->balance;
				if ($calType === 'plus') {
					$newBalance = $currentBalance + (int)$amount;
				} else {
					$newBalance = $currentBalance - (int)$amount;
				}
				$account->update(['balance' => $newBalance]);
			}
		}
	}

	protected function storeData(){
		try {
			\DB::beginTransaction();
				$formTips = [];
				$formRefers=[];
				$formBalance = [];
				$formRedeems = [];
				$formMissingUsers= [];
				$totalTips = [] ;
				$totalRefers = [];
				$totalBalances= [];
				$totalRedeems = [];
				$histories = [];
				$accounts=$this->accounts;
				$findAccounts = \DB::table('accounts')
								->select('*')
								->where(function ($query) use ($accounts) {
									foreach ($accounts as $account) {
										$termLower = str_replace(' ', '', strtolower($account));
										$query->orWhere(\DB::raw("REPLACE(LOWER(name), ' ', '')"), 'LIKE', "%$termLower%");
									}
								})
								->get();
								
				$sheetId = \DB::table('sheet_logs')->insertGetId([
						'file' => $this->fileName,
						'date' => $this->date,
						'created_by' => auth()->user()->id,
						'created_at' => now()
				]);
				foreach($accounts as $key =>$account){
					$index = $key * ($this->groupSize + $this->skip);
				// 	if($index > 0){
					    
    					$findAccount = [];
    					foreach($findAccounts as $key =>$item){
    						$itemNameWithoutSpaces = str_replace(' ', '', strtolower($item->name));
    						$accountNameWithoutSpaces =  str_replace(' ', '', strtolower($account));
    						if($itemNameWithoutSpaces === $accountNameWithoutSpaces){
    							$findAccount = $item;
    							break;
    						}
    					}
    			
    			        try{
    			            $data = $this->rows[$index];
    			        }catch(\Exception $e){
    			            continue ; 
    			        }
    					
    					$users= array_map(function($item) use($findAccount){
    						return $item[0];
    					},$data);
    					$existUsers = \DB::table('form_games')
    								    ->whereIn(\DB::raw('LOWER(game_id)'), array_map('strtolower', $users))
    								    ->get()
    								    ->toArray();
    
    					foreach ($data as $key => $user) {
    						$filterExitsUser = array_map(function($existUser){
    							return strtolower($existUser->game_id);
    						},$existUsers);	
    						if( count($user) > 0 && !empty($user[0] && !empty($findAccount))){
    							$gameUser = strtolower($user[0]);
    							$index = array_search($gameUser, $filterExitsUser);
    							if($index!==false){
    								if(!empty($user[2])){
    									$totalRedeems[$existUsers[$index]->account_id] = ($totalTips[$existUsers[$index]->account_id] ?? 0 ) + $this->filterAmount($user[2]);
    									$formRedeems[] = [
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount' => $this->filterAmount($user[2]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' =>$this->date,
    
    									];
    									$histories[] = [
    										'type' =>'redeem',
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount_loaded' => $this->filterAmount($user[2]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    									];
    
    								}
    								if(!empty($user[3])){
    									$totalBalances[$existUsers[$index]->account_id] = ($totalTips[$existUsers[$index]->account_id] ?? 0 ) + $this->filterAmount($user[3]);
    									$formBalance[] = [
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount' => $this->filterAmount($user[3]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    									];
    									$histories[] = [
    										'type' =>'load',
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount_loaded' => $this->filterAmount($user[3]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    									];
    								}
    								if(!empty($user[4])){
    									$totalRefers[$existUsers[$index]->account_id] = ($totalTips[$existUsers[$index]->account_id] ?? 0 ) + $this->filterAmount($user[4]);
    									$formRefers[] = [
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount' => $this->filterAmount($user[4]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    									];
    									$histories[] = [
    										'type' =>'refer',
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount_loaded' => $this->filterAmount($user[4]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    									];
    								}
    								if(!empty($user[5])){
    									$totalTips[$existUsers[$index]->account_id] = ($totalTips[$existUsers[$index]->account_id] ?? 0 ) + $this->filterAmount($user[5]);
    									$formTips[] = [
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount' => $this->filterAmount($user[5]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    									];
    									$histories[] = [
    										'type' =>'tip',
    										'form_id' => $existUsers[$index]->form_id,
    										'account_id' => $existUsers[$index]->account_id,
    										'amount_loaded' => $this->filterAmount($user[5]),
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    									];
    								}
    							}else{
    								$filterExitsMissingUsers = array_map(function($existUser) {
    								    return strtolower($existUser['game_id']);
    								}, $formMissingUsers);
    								$missingUser =strtolower($user[0]);
    								$missingIndex = array_search($missingUser, $filterExitsMissingUsers);
    								$missingUserData = [
    									'game_id' =>$user[0],
    									'account_id' => $findAccount->id,
    									'balance' => $this->filterAmount($user[3]) ?? 0,
    									'refer' => $this->filterAmount($user[4]) ?? 0,
    									'tips' => $this->filterAmount($user[5]) ?? 0,
    									'redeem' => $this->filterAmount($user[2]) ?? 0,
    									'sheet_id' =>$sheetId,
    									'created_by' => auth()->user()->id,
    									'created_at' => $this->date
    								];
    								if ($missingIndex !== false) {
    									$formMissingUsers[$missingIndex] = [
    										'game_id' => $missingUser,
    										'account_id' => $findAccount->id,
    										'balance' => $this->filterAmount($user[3]) + $formMissingUsers[$missingIndex]['balance'],
    										'refer' => $this->filterAmount($user[4]) + $formMissingUsers[$missingIndex]['refer'],
    										'tips' => $this->filterAmount($user[5]) + $formMissingUsers[$missingIndex]['tips'],
    										'redeem' => $this->filterAmount($user[2]) + $formMissingUsers[$missingIndex]['redeem'],
    										'sheet_id' =>$sheetId,
    										'created_by' => auth()->user()->id,
    										'created_at' => $this->date
    
    									];
    								} else {
    									$formMissingUsers[] = $missingUserData;
    								}
    
    							}
    						}
    					}
				// 	}
				}
				if(count($formTips) > 0) {
					\DB::table('form_tips')->insert($formTips);
				}
				if(count($formRefers) > 0){
					\DB::table('form_refers')->insert($formRefers);
				}
				if(count($formRedeems) > 0){
					\DB::table('form_redeems')->insert($formRedeems);
				}
				if(count($formBalance) > 0){
					\DB::table('form_balances')->insert($formBalance);
				}
				if(count($formMissingUsers) > 0){
					\DB::table('missing_users')->insert($formMissingUsers);
				}
				if(count($totalBalances) > 0){
					$this->updateBalance($totalBalances,null);
				}
				if(count($totalRefers) > 0){
					$this->updateBalance($totalRefers,null);
				}
				if(count($totalTips) > 0){
					$this->updateBalance($totalTips,'plus');
				}
				if(count($totalRedeems) > 0){
					$this->updateBalance($totalRedeems,'plus');
				}
				if(count($histories) > 0){
					\DB::table('histories')->insert($histories);
				}
			
				\DB::commit();

		} catch (Exception $e) {		
			\DB::rollback();
			throw new Exception($e->getMessage());
		}
	}
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collections)
    {
    	$collectionsArr = $collections->toArray();
    	$startRowKey = null;
    	$endRowKey = null;
    	$startCount = 0;
    	foreach ($collectionsArr as $key => $collection) {
    	    
    	    
    		if (in_array('Account Name', $collection) && $startCount === 0) {
    			$startRowKey = $key + 1;
    		}
    		if (in_array('Total', $collection)) {
    			$endRowKey = $key - 1;
    			break;
    		}
    	}
    	if(!empty($startRowKey) && !empty($endRowKey)){
    		$length = $endRowKey - $startRowKey + 1;
    		$rowDatas = array_slice($collectionsArr,$startRowKey,$length);
    		$this->formatAccounts($collectionsArr[$startRowKey - 8]);
    		$this->formatRowData($rowDatas);
    		$this->storeData();
    	}	
        // if (!empty($startRowKey) && !empty($endRowKey) && $startRowKey >= 8) {
        //     $length = $endRowKey - $startRowKey + 1;
        //     $rowDatas = array_slice($collectionsArr, $startRowKey, $length);
        //     $this->formatAccounts($collectionsArr[$startRowKey - 8]);
        //     $this->formatRowData($rowDatas);
        //     $this->storeData();
        // } else {
        //     Log::error("offset error");
        // }


    }
}