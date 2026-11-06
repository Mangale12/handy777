
@extends('newLayout.layouts.newLayout')

@section('title') Crypto Network @endsection
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Network</h3>
                            <a href="{{route('roles.index')}}" class="btn btn-success btn-sm float-right">View Network List</a>
                        </div>
                        {{-- <div class="col-md-12 p-0">
                            @include('admin.includes.message')
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('admin.networks.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Network -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="network">Network</label>
                                            <input type="text" id="name" class="form-control @error('network') is-invalid @enderror" 
                                                   name="name" value="{{ old('name') }}">
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="badge">Badge</label>
                                            <input type="text" id="badge" class="form-control @error('badge') is-invalid @enderror" 
                                                   name="badge" value="{{ old('badge') }}">
                                            @error('badge')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Coin Address -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Symbol</label>
                                            <input type="text" id="symbol" class="form-control @error('address') is-invalid @enderror" 
                                                   name="symbol" value="{{ old('symbol') }}">
                                            @error('symbol')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <!-- Logo -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="logo">Icon </label>
                                            <input type="file" id="icon" class="form-control @error('icon') is-invalid @enderror" 
                                                   name="icon">
                                            @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <hr>
                                        <span>if Direct Network</span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="logo">Address </label>
                                            <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" 
                                                   name="address">
                                            @error('address')
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
                                            @error('qr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="qr">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"></textarea>
                                            
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
