@extends('newLayout.layouts.newLayout')

@section('title')
     Unsub Mails Log 
@endsection
@section('content')
<style>
  .dataTables_wrapper{
    padding: 25px;
  }
  .dataTables_wrapper .row{
    padding: 10px;
  }
  tbody tr td{
    border-bottom: none;
  }
  .active-game-btn{
   background: #feb343;
  }
</style>
<style>
    
table {
  margin: 1em 0;
  border-collapse: collapse;
  border: 0.1em solid #d6d6d6;
}

caption {
  text-align: left;
  font-style: italic;
  padding: 0.25em 0.5em 0.5em 0.5em;
}

th,
td {
  padding: 0.25em 0.5em 0.25em 1em;
  vertical-align: text-top;
  text-align: left;
  text-indent: -0.5em;
}

th {
  vertical-align: bottom;
  background-color: #666;
  color: #fff;
}

tr:nth-child(even) th[scope=row] {
  background-color: #f2f2f2;
}

tr:nth-child(odd) th[scope=row] {
  background-color: #fff;
}

tr:nth-child(even) {
  background-color: rgba(0, 0, 0, 0.05);
}

tr:nth-child(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}



.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
  z-index: 9999;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}


.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 50% ;
  position: relative;
  transition: all 5s ease-in-out;
 
  

}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;

}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;

}
.popup .close:hover {
  color: #FF9800;
}
.popup .content {
  max-height: calc(100vh - 210px);
    overflow-y: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}


#timedate {
  font: small-caps lighter auto/150% "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
  text-align:left;
 
  margin: 40px auto;
  color:#fff;
  padding: 20px ;
}




.dropdown {
  position: relative;
  display: inline-block;
}



.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
 
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
  left: 0px;
  top: 0px;
  position: absolute;
  margin: 0rem 0rem -4rem  -4rem;
  
}


   .hidden{
   display: none;
   }
   .game-head-btn-div a:hover{
       background: #fdb244;
   }
   .active-game-btn .card{
       background: #fdb244;
   }

   .breadcrumb-div{
      background: #5e5050cc;
    padding: 5px;
   }

   .game-popup.game-categories-wrapper {
      border: 2px solid #e0e0e0;
      padding: 5px;
      margin: 5px;
   }
   .active-game-btn {
       background: #feb343 !important;
   }
</style>
<div class="row" id="werqwerq" style="padding-top:20px;">
  <div class="col-12">
     <div class="card mb-4">
        <div class="card-body px-0 pt-0 pb-2">
           <div class="table-responsive p-0">
              <table class="table align-items-center mb-0 datatable">
                 <thead class="sticky" >
                    <tr  >
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Type</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Sent On</th>
                    </tr>
                 </thead>
                 <tbody>                          
                  @php
                    $count = 1;
                  @endphp
                  @foreach ($forms as $key => $item)   
                    <tr >
                       <td class="align-middle text-center" style="text-align: center">
                           {{-- {{$current_month.' ,'.$key}} --}}
                           {{$item['full_name']}}
                       </td>
                       <td class="align-middle text-center">
                        {{$item['email']}}
                       </td>
                       <td class="align-middle text-center">
                        {{$item['days'].' days inactive'}}
                       </td>
                       <td class="align-middle text-center">
                        {{($item['status'] == 1)?'Active':'Unsubscribed'}}
                       </td>
                       <td class="align-middle text-center">
                        {{date('Y-m-d',strtotime($item['created_at']))}}
                       </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
</div>
@endsection

@section('script')
<script>
   
   $('.this-day-redeem').on('click', function(e) {
        console.log('asdf');
        var month_symbols = ['','January', 'February', 'March', 'April', 'May', 'June', 'July','August', 'September', 'October', 'November', 'December'];
        var year = $(this).attr("data-year");
        var month = $(this).attr("data-month");
        var day = $(this).attr("data-day");
        var form = $(this).attr("data-form");
        var category = $(this).attr("data-category");
        $('.history-type-change-btn-allDate1').attr('data-day',day);
        $('.history-type-change-btn-allDate1.game-category').removeClass('active-game-btn');
        $('.history-type-change-btn-allDate1.game-type').removeClass('active-game-btn');
        $('.history-type-change-btn-allDate1.game-category').attr('data-type','all');
        $('.history-type-change-btn-allDate1.game-category[data-category="'+category+'"]').addClass('active-game-btn');
        $('.history-type-change-btn-allDate1.game-type').attr('data-category',category);
        $('.history-type-change-btn-allDate1.game-type[data-type="all"]').addClass('active-game-btn');
        $('.game-category-info.reset-to-blank').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(form);
        var actionType = "POST";
        var ajaxurl = '/this-day-redeem';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "year": year,
                "month": month,
                "day": day,
                "category": category,
                'form' : form
            },
            dataType: 'json',
            beforeSend: function() {
                $(".user-history-body").html('Loading..');

            },
            success: function(data) {
               console.log(data);
                var accounts = data.accounts;
                var default_accounts = data.default_accounts;
                $.each($('.history-type-change-btn-allDate1.game-category'), function() {
                    var that = $(this);
                    $.each(accounts, function(index,value){
                        if(value.game_name == that.attr('data-category')) {
                            that.siblings('.game-category-info.reset-to-blank').html('\
                            Game Title: '+value.game_title+'\
                            <br>Game Balance: '+value.game_balance+'\
                            <br>Redeem: '+value.totals.redeem+'\
                            ');
                        } else if(that.siblings('.game-category-info.reset-to-blank').html() == '') {
                            $.each(default_accounts, function(index,value){
                                if(value.name == that.attr('data-category')) {
                                    that.siblings('.game-category-info.reset-to-blank').html('\
                                    Game Title: '+value.title+'\
                                    <br>Game Balance: '+value.balance+'\
                                    <br>Redeem: 0\
                                    ');
                                }
                            });
                        }
                    });
                });
                if (data.grouped != '') {
                    var optionLoop = '',
                    options = data.grouped;
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index,value) {
                     if(value == 0){
                        $('h2.popup-title').html('History of '+index.form.full_name);
                     }
                        var date_format = new Date(index.created_at),
                            redeem = parseInt(index.amount);
                        // var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        var a =  date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                            '<tr><td class="text-center">' + a + '</td>\
                            <td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount + '$</span></td>\
                            <td class="text-center">' + index.form.facebook_name + '</td>\
                            <td class="text-center">' + index.account.name + '</td>\
                            <td class="text-center">' + index.form_game.game_id + '</td>\
                            <td class="text-center">' + index.created_by.name + '</td></tr>';
                    });

                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });
</script>
@endsection

