@extends('newLayout.layouts.newLayout')

@section('title', 'Players Load Details')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Players Load Details</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('players-load-details') }}" method="get" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" 
                                   value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" 
                                   value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="player_id">Player</label>
                            <select name="player_id" id="player_id" class="form-control">
                                <option value="">All Players</option>
                                @foreach($allPlayers as $player)
                                    <option value="{{ $player->id }}" {{ request('player_id') == $player->id ? 'selected' : '' }}>
                                        {{ $player->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-group w-100">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        @if(request()->has('player_id') || request()->has('start_date') || request()->has('end_date'))
                            <div class="form-group ml-2">
                                <a href="{{ route('players-load-details') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>SN</th>
                            <th>Player</th>
                            <th>Email</th>
                            <th class="text-right">Total Load</th>
                            <th class="text-right">Total Tip</th>
                            <th class="text-right">Total Redeem</th>
                            <th class="text-right">Total Refer</th>
                            <th>Per Game Load</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($totals as $key => $total)
                            @php
                                $player = $total['player'];
                                $gameLoads = [];
                                
                                // Group histories by game and calculate load per game
                                foreach($player->histories->groupBy('game_id') as $gameId => $gameHistories) {
                                    $firstHistory = $gameHistories->first();
                                    $gameName = $firstHistory && $firstHistory->game ? $firstHistory->game->name : 'Unknown';
                                    $gameLoad = $gameHistories->where('type', 'load')->sum('amount_loaded');
                                    if ($gameLoad > 0) {
                                        $gameLoads[] = "{$gameName} (" . number_format($gameLoad, 2) . ")";
                                    }
                                }
                                $gameLoadStr = !empty($gameLoads) ? implode(', ', $gameLoads) : 'N/A';
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $player->full_name }}</td>
                                <td>{{ $player->email ?? 'N/A' }}</td>
                                <td class="text-right">{{ number_format($total['total_load'], 2) }}</td>
                                <td class="text-right">{{ number_format($total['total_tip'], 2) }}</td>
                                <td class="text-right">{{ number_format($total['total_redeem'], 2) }}</td>
                                <td class="text-right">{{ number_format($total['total_refer'], 2) }}</td>
                                <td>{{ $gameLoadStr }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No players found matching the criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
