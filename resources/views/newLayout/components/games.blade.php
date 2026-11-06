<div class="row">
    <div class="col-lg-12" style="padding-bottom:20px;">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Games</h6>
            </div>
            <div class="card-body p-3">
                <div class="row">
                    @if (isset($games) && !empty($games))
                        @foreach($games as $game)
                            @php
                                $query = $_GET;
                                $query['game'] = $game['title'];
                                $query_result = http_build_query($query);
                            @endphp
                            <input type="hidden" class="activeGameId" value="{{isset($activeGame) ? $activeGame['id'] : '1' }}">
                            <div class="col-xl-3 col-sm-3 mb-3 game-card-{{$game['id']}} {{(isset($activeGame) && $activeGame['id'] == $game['id'])?'active-game-btn':''}}">
                                <div class="card game-btn-card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center game-card123-{{$game['title']}}" style="justify-content: space-between;">
                                                    <a class="mb-1 game-btn {{(str_replace(' ','-',$game['title']))}}-{{($game['id'])}}" href="{{url('/table?').$query_result}}" data-title="{{($game['title'])}}" data-balance="{{($game['balance'])}}">
                                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                            {{-- <i class="ni ni-mobile-button text-white opacity-10"></i> --}}
                                                            @if($game['image'] == '')
                                                            <i class="ni ni-mobile-button text-white opacity-10"></i>
                                                            @else
                                                            <img style="max-width: 100%" src="{{asset('/public/uploads/'.$game['image'])}}">
                                                            @endif
                                                            {{-- <img src="" alt=""> --}}
                                                        </div>
                                                    </a>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">{{$game['title']}}</h6>
                                                        <span class="text-xs game-span-item span-{{(str_replace(' ','-',$game['title']))}}-{{($game['id'])}} {{(isset($activeGame) && $activeGame['id'] == $game['id'])?'active-game-btn':''}}">$ {{($game['balance'])}}</span>
                                                    </div>
                                                    {{-- {{dd()}} --}}
                                                    @if (Auth::user()->role == 'admin')
                                                        
                                                    <div class="d-flex flex-column">
                                                        <a href="#popup8" class="edit-game-table" data-id="{{$game['id']}}"><i class="fa fa-pencil"></i> </a>
                                                        {{-- <button  class="btn  btn-primary mb-0 undo-transaction" style="background-color:#1100ff;"  > <a href="#popup8" style="color:white;">Undo</a></button> --}}
                                                    </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div id="popup8" class="overlay">
                            <div class="popup">
                                <h2>Edit Balance</h2>
                                <a class="close" href="#">&times;</a>
                                <div class="content ">
                                    <div class="row" style="padding-top:20px;">
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <form action="{{route('gamerUpdateBalance')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="game_id" class="game_id" value="">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="game_balance" placeholder="Enter Amount">
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-success" type="submit">Load</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div >
                            </div >
                        </div >
                        
                    @else
                        No games available
                    @endif
                   
                </div>
                
            </div>
        </div>
    </div>
</div>
