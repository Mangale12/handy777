<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CoinsAddressRepositoryInterface;
use App\Http\Requests\CoinAddressRequest;

class CoinsAddressController extends Controller
{
    private $viewPath = 'admin.coin-address';
    private $baseRoute = 'admin.coin-address';
    private $repository;

    public function __construct(CoinsAddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display the list of coin addresses.
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        $data['address'] = $this->repository->getAll();
        return view("{$this->viewPath}.index", compact('data'));
    }

    /**
     * Show the form for creating a new coin address.
     *
     * @return \Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        $data['networks'] = $this->repository->getAllNetwork();
        return view("{$this->viewPath}.create", compact('data'));
    }

    /**
     * Store a newly created coin address in storage.
     *
     * @param  \App\Http\Requests\CoinAddressRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CoinAddressRequest $request): \Illuminate\Http\RedirectResponse
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
        $data['address'] = $this->repository->getById($id);
        $data['networks'] = $this->repository->getAllNetwork();
        return view($this->viewPath.'.edit', compact('data'));
    }
    
    public function update($id, CoinAddressRequest $request){
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

