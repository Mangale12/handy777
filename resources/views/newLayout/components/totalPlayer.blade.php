<a href ={{route('gamers')}}>
    <div class="row" style="padding-bottom:40px;">
    <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">{{$language_texts['total-players']}}</p>
                            <h5 class="font-weight-bolder">
                                {{count($activeGame['form_games'])}}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</a>
