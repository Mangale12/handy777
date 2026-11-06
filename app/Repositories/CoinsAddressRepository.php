<?php

            namespace App\Repositories;
            use App\Http\Requests\CoinAddressRequest;
            use App\Models\CoinsAddress;

            class CoinsAddressRepository extends BaseRepository implements CoinsAddressRepositoryInterface
            {
                
                private $model;
                private $networkRepository;

                public function __construct(CoinsAddress $model, NetWorkRepositoryInterface $networkRepository)
                {
                   
                    $this->model = $model;
                    $this->networkRepository = $networkRepository;
                }
                public function getAll()
                {
                    return $this->model::all();
                }

                public function getById($id)
                {
                    return $this->model::findOrFail($id);
                }

                public function create(CoinAddressRequest $request)
                {
                    try {
                        // Check if the file exists in the request
                        $iconPath = null;
                        $qrPath = null;
                        if ($request->hasFile('icon')) {
                            $iconPath = parent::uploadImage($request->file('icon'), public_path('uploads/coin_addresses/icon/'),'/public/uploads/coin_addresses/icon/');
                        }
                        if($request->hasFile('qr')){
                             $qrPath = parent::uploadImage($request->file('qr'), public_path('uploads/coin_addresses/qr/'),'/public/uploads/coin_addresses/qr/');
                        }
                        $this->model::create([
                                'net_work_id' => $request->network_id,
                                'wallet' => $request->wallet,
                                'address' => $request->address,
                                'logo' => $iconPath, // Path to the uploaded logo
                                'qr' => $qrPath,
                                'badge' => $request->badge,
                                'description' => $request->description,
                                'status' => $request->has('status') ? 1 : 0,
                            ]);
                
                            return true;
                    } catch (\Exception $e) {
                        // Handle any exceptions
                        dd($e);
                        return false;
                    }
                }

                public function update($id, CoinAddressRequest $request)
                {
                    
                    try {
                        $model = $this->getById($id);
                       
                        $qrPath = $model->qr;
                        $iconPath = $model->icon;
                        // if ($request->hasFile('logo')) {
                        //     $logoPath = parent::uploadImage($request->file('logo'), public_path('uploads/coin_addresses/'),'/uploads/coin_addresses/');
                        // }
                        if($request->hasFile('qr')){
                            parent::deleteFile($model->qr);
                             $qrPath = parent::uploadImage($request->file('qr'), public_path('uploads/coin_addresses/qr/'),'/public/uploads/coin_addresses/qr/');
                        }
                        if($request->hasFile('icon')){
                            parent::deleteFile($model->icon);
                            $iconPath = parent::uploadImage($request->file('icon'), public_path('uploads/coin_addresses/icon/'),'/public/uploads/coin_addresses/icon/');
                        }
                        $model->update([
                                'network' => $request->network,
                                'address' => $request->address,
                                'logo' => $request->logo, // Path to the uploaded logo
                                'qr' => $qrPath,
                                'icon' => $iconPath,
                                'badge' => $request->badge,
                                'description' => $request->description,
                                'status' => $request->has('status') ? 1 : 0,
                            ]);
                
                            return true;
                    } catch (\Exception $e) {
                        // Handle any exceptions
                        return false;
                    }
                }

                public function delete($id)
                {
                    $model = $this->getById($id);
                    return $model->delete();
                }
                
                public function getAllNetwork(){
                    return $this->networkRepository->getAll();
                }
            }
            