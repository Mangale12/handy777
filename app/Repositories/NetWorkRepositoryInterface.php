<?php

            namespace App\Repositories;
            use App\Http\Requests\NetworkRequest;
            interface NetWorkRepositoryInterface
            {
                public function getAll();
                public function getById($id);
                public function create(NetworkRequest $request);
                public function update($id, NetworkRequest $request);
                public function delete($id);
                public function getWalletsById($id);
            }
            