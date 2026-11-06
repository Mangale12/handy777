@extends('newLayout.layouts.newLayout')
@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h4>Fill user details</h4>
    </div>
<div class="card-body p-5">
               
   @if ($errors->any())
   <div class="alert alert-danger mt-3">
      <ul>
         @foreach ($errors->all() as $error)
         <h3>
            <li>{{ $error }}</li>
         </h3>
         @endforeach
      </ul>
   </div>
   </br>
   @endif
   <form id="regForm" action="{{ route('forms.stores') }}" method="POST" >
      @csrf
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input class="form-control" type="text" value="{{old('full_name')}}" autocomplete="off" placeholder="Eve Adam" name="full_name" maxlength="20" required>
      </div>
      <input type="hidden" value="{{auth()->id()}}" name="user_id">
      <div class="form-group">
        <label for="exampleInputEmail1">Phone *</label>
        <input class="form-control" type="tel" value="{{old('number')}}" autocomplete="off" placeholder="XXX XXX XXXX" name="number" maxlength="10" required>
      </div>
      
      <div class="form-group">
        <label for="exampleInputEmail1">State *</label>
        <select class="form-control" name="mail" required>
                     <option value="" disabled selected="selected">Select Game</option>
                     <option value="" selected="selected">Select a State</option>
                     <option value="AL">Alabama</option>
                     <option value="AK">Alaska</option>
                     <option value="AZ">Arizona</option>
                     <option value="AR">Arkansas</option>
                     <option value="CA">California</option>
                     <option value="CO">Colorado</option>
                     <option value="CT">Connecticut</option>
                     <option value="DE">Delaware</option>
                     <option value="DC">District Of Columbia</option>
                     <option value="FL">Florida</option>
                     <option value="GA">Georgia</option>
                     <option value="HI">Hawaii</option>
                     <option value="ID">Idaho</option>
                     <option value="IL">Illinois</option>
                     <option value="IN">Indiana</option>
                     <option value="IA">Iowa</option>
                     <option value="KS">Kansas</option>
                     <option value="KY">Kentucky</option>
                     <option value="LA">Louisiana</option>
                     <option value="ME">Maine</option>
                     <option value="MD">Maryland</option>
                     <option value="MA">Massachusetts</option>
                     <option value="MI">Michigan</option>
                     <option value="MN">Minnesota</option>
                     <option value="MS">Mississippi</option>
                     <option value="MO">Missouri</option>
                     <option value="MT">Montana</option>
                     <option value="NE">Nebraska</option>
                     <option value="NV">Nevada</option>
                     <option value="NH">New Hampshire</option>
                     <option value="NJ">New Jersey</option>
                     <option value="NM">New Mexico</option>
                     <option value="NY">New York</option>
                     <option value="NC">North Carolina</option>
                     <option value="ND">North Dakota</option>
                     <option value="OH">Ohio</option>
                     <option value="OK">Oklahoma</option>
                     <option value="OR">Oregon</option>
                     <option value="PA">Pennsylvania</option>
                     <option value="RI">Rhode Island</option>
                     <option value="SC">South Carolina</option>
                     <option value="SD">South Dakota</option>
                     <option value="TN">Tennessee</option>
                     <option value="TX">Texas</option>
                     <option value="UT">Utah</option>
                     <option value="VT">Vermont</option>
                     <option value="VA">Virginia</option>
                     <option value="WA">Washington</option>
                     <option value="WV">West Virginia</option>
                     <option value="WI">Wisconsin</option>
                     <option value="WY">Wyoming</option>
                  </select>
      </div>
      
       <div class="form-group">
        <label for="exampleInputEmail1">Referred By (If Applies)</label>
        <input class="form-control" type="text" value="{{old('r_id')}}" autocomplete="off" placeholder="S_XXxXX" name="r_id" maxlength="15" >
      </div>
       <div class="form-group">
        <label for="exampleInputEmail1">Email *</label>
        <input required class="form-control" type="email" value="{{old('email')}}" autocomplete="off" placeholder="name@xyz.com" name="email">
      </div>
      
      <div class="form-group">
        <label for="exampleInputEmail1">Facebook Name *</label>
         <input class="form-control" type="text" value="{{old('facebook_name')}}" autocomplete="off" placeholder="Your Facebook Name" name="facebook_name" maxlength="20" required>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Game *</label>
      <select class="form-control account-select" name="account" required>
         <option value="" disabled selected="selected">Select Game</option>
         @foreach(\App\Models\Account::get() as $a => $b)
         <option value="{{$b->id}}" data-title="{{$b->title}}">{{$b->name}}</option>
         @endforeach
      </select>
      </div>
     
     <div class="form-group">
        <label for="exampleInputEmail1">Game ID *</label>
         <input class="form-control game-id-text" type="text" value="{{old('game_id')}}" autocomplete="off" placeholder="SXXXX" name="game_id" maxlength="15" minlength="8" required>
      </div>
       <button type="submit" class="btn btn-primary">Submit</button>
   </form>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script>
   $(document).ready(function () {
   $('.account-select').on('change', function () {
       var gameId = $(this).find(':selected').data('title');
       $('.game-id-text').val(gameId + '_');
    });
   });
       
</script>

<!--ouer game end-->
<!--restrict user start -->

@endsection