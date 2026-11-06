<?php

namespace App\Repositories;

use App\Http\Requests\NetworkRequest;
use App\Models\NetWork;
use Illuminate\Support\Facades\Log;
use Exception;

class NetWorkRepository extends BaseRepository implements NetWorkRepositoryInterface
{
    private $model;

    public function __construct(NetWork $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function getById($id)
    {
        return $this->model::findOrFail($id);
    }

    public function create(NetworkRequest $request)
    {
        try {
            $iconPath = null;
            $qr = null;
            if (isset($request->icon)) {
                $iconPath = parent::uploadImage($request->icon, public_path('uploads/networks/icon/'), '/public/uploads/networks/icon/');
            }
            if (isset($request->qr)) {
                $iconPath = parent::uploadImage($request->qr, public_path('uploads/networks/qr/'), '/public/uploads/networks/qr/');
            }

            $this->model::create([
                'name' => $request->name,
                'symbol' => $request->symbol,
                'icon' => $iconPath,
                'wallet_address' => $request->address,
                'qr' => $qr,
                'badge' => $request->badge,
                'description' => $request->description,
                'status' => $request->has('status') ? 1 : 0,
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Error creating model: ' . $e->getMessage());
            return false;
        }
    }

    public function update($id, NetworkRequest $request)
    {
        try {
            $model = $this->getById($id);
            $iconPath = $model->icon;
            $qrPath = $model->qr;
            if (isset($request->icon)) {
                parent::deleteFile($model->icon);
                $iconPath = parent::uploadImage($request->icon, public_path('uploads/networks/qr/'), '/public/uploads/networks/qr/');
            }
            if (isset($request->qr)) {
                parent::deleteFile($model->qr);
                $qrPath = parent::uploadImage($request->qr, public_path('uploads/networks/qr/'), '/public/uploads/networks/qr/');
            }

            $model->update([
                'name' => $request->name,
                'symbol' => $request->symbol,
                'icon' => $iconPath,
                'qr' => $qrPath,
                'default_address' => $request->address,
                'badge' => $request->badge,
                'description' => $request->description,
                'status' => $request->has('status') ? 1 : 0,
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Error updating model: ' . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $model = $this->getById($id);
            parent::deleteFile($model->icon);
            return $model->delete();
        } catch (Exception $e) {
            Log::error('Error deleting model: ' . $e->getMessage());
            return false;
        }
    }

    public function getWalletsById($id){
        return $this->getById($id)->wallets;
    }
    
    
}
