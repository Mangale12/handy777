
@extends('newLayout.layouts.newLayout')

@section('title')
    Coin Address
@endsection
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Coin Address</h3>
                            <a href="{{route('admin.coin-address.index')}}" class="btn btn-success btn-sm float-right">View Coin Address</a>
                        </div>
                        {{-- <div class="col-md-12 p-0">
                            @include('admin.includes.message')
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('admin.coin-address.update', $data['address']->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Network -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="network">Network</label>
                                            <select class="form-control" name="network_id">
                                                @foreach($data['networks'] as $key=>$network)
                                                <option value="{{ $network->id }}" {{old('network_id', $data['address']->net_work_id) ? "selected" : ""}}>{{ $network->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="badge">Badge</label>
                                            <input type="text" id="badge" class="form-control @error('badge') is-invalid @enderror" 
                                                   name="badge" value="{{ old('badge', $data['address']->badge) }}">
                                            @error('badge')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="network">Wallet Name</label>
                                            <input type="text" id="wallet" class="form-control @error('wallet') is-invalid @enderror" 
                                                   name="wallet" value="{{ old('wallet', $data['address']->wallet) }}">
                                            @error('wallet')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Coin Address -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Coin Address</label>
                                            <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" 
                                                   name="address" value="{{ old('address', $data['address']->address) }}">
                                            @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Logo -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="icon">Icon</label>
                                            <input type="file" id="icon" class="form-control @error('icon') is-invalid @enderror" 
                                                   name="icon">
                                            <img src="{{ asset($data['address']->icon)}}" height="100", width="200">
                                            @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- QR -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="qr">QR</label>
                                            <input type="file" id="qr" class="form-control @error('qr') is-invalid @enderror" 
                                                   name="qr" value="{{ old('qr') }}">
                                            <img src="{{ asset($data['address']->qr)}}" height="100", width="200">

                                            @error('qr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="qr">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ $data['address']->description }}</textarea>
                                            
                                            @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Status -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <input type="checkbox" id="status" class="form-check-input @error('status') is-invalid @enderror" 
                                                   name="status" value="1" {{ old('status') ? 'checked' : '' }}>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm float-right">Save</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection



