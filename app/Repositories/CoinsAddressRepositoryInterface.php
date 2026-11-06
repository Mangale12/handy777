<?php

            namespace App\Repositories;
            use App\Http\Requests\CoinAddressRequest;
            interface CoinsAddressRepositoryInterface
            {
                public function getAll();
                public function getById($id);
                public function create(CoinAddressRequest $request);
                public function update($id, CoinAddressRequest $request);
                public function delete($id);
                public function getAllNetwork();
                
            }
            