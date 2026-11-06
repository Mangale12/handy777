<?php

namespace App\Imports;

use App\Models\UserDetails;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Excel;
use Illuminate\Support\Facades\DB;
class UserDetailsImport implements ToCollection, WithHeadingRow
{
    protected $rows = [];
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            
            $this->rows[] = [
                'email'=>$row['email'],
                'full_name' => $row['full_name'],
                //'last_name' => $row['last_name'],
                // 'email'=>$row['email'],
                'phone'=>$row['phone'],
                // Add more columns as needed
            ];
            DB::table('woods_jan_active_user')->insert([
                'full_name'=>$row['full_name'],
                'email'=>$row['email'],
                'phone'=>$row['phone'],
                ]);
            
        }
    }
    public function save(){
        dd($this->rows);
    }
    
    // public function model(array $row)
    // {
    //     dd($row);
    //     // Use your Eloquent model to create a new instance for each row
    //     return new YourModel([
    //         'full_name' => $row['full_name'],
    //         'facebook_name' => $row['facebook_name'],
    //         'email'=>$row['email'],
    //         'phone'=>$row['phone'],
    //         // Add more columns as needed
    //     ]);
    // }
}
