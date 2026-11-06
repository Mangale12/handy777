<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NetWorkRepositoryInterface;
use App\Http\Requests\NetworkRequest;

class NetWorkController extends Controller
{
    private $repository;
    private $view_path = 'admin.networks';
    private $baseRoute = 'admin.networks';
    public function __construct(NetWorkRepositoryInterface $repository){
        $this->repository = $repository;
    }
    
    public function index(){
        $data['networks'] = $this->repository->getAll();
        return view($this->view_path.'.index', compact('data'));
    }
    
    public function create(){
        return view($this->view_path.'.create');
    }
    
    public function store(NetworkRequest $request): \Illuminate\Http\RedirectResponse
    {
        $success = $this->repository->create($request);

        if ($success) {
            return redirect()->route("{$this->baseRoute}.index")
                             ->with('success', 'Coin address created successfully.');
        } else {
            return redirect()->back()
                             ->with('error', 'Failed to create coin address.');
        }
    }
    
    public function edit($id){
        $data['item'] = $this->repository->getById($id);
        return view($this->view_path.'.edit', compact('data'));
    }
    
    public function update($id, NetworkRequest $request){
        $success = $this->repository->update($id,$request);

        if ($success) {
            return redirect()->route("{$this->baseRoute}.index")
                             ->with('success', 'Coin address created successfully.');
        } else {
            return redirect()->back()
                             ->with('error', 'Failed to create coin address.');
        }
    }
    
    
}
