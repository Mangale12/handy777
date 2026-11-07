<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\FormNumberConroller;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admin\CashAppController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FrontendSettingController;

use App\Http\Controllers\Admin\ActivityStatusController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchTableController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\MissingUserController;
use App\Http\Controllers\NowPaymentsController;
use Illuminate\Support\Facades\Artisan;



use App\Models\GeneralSetting;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    // Artisan::call('config:cache');
    // Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
   return '<h1>Cache Cleared</h1>';

})->name('clear.go');

Route::get('/run-mail-alert', function () {

    // 🔐 simple security (secret key)
    if (request('key') !== 'my-secret-key-123') {
        abort(403, 'Unauthorized');
    }

    Artisan::call('mail:send-alert');

    return "Mail command executed!";
});

Route::get('player/fetch-history', [FormController::class, 'getHistoryByDate'])->name('player.fetch-history');
Route::get('chat', [FormController::class, 'chat'])->name('chat');
Route::post('chat', [FormController::class, 'chatPost'])->name('chat.submit');
Route::post('chat/logout', [FormController::class, 'chatLogout'])->name('chat.logout');
Route::redirect('chat/start', 'chat');
Route::get('/video',function()
{
    return view('video_test');
});
Route::get('/video/iframe',function()
{
    return view('video_iframe');
});
Route::get("smstest",[FormController::class,"testSms"]);

//front route
Route::get('/', function () {
    $theme = GeneralSetting::first('theme');
    // dd($theme);
    switch($theme) {
        case('anna'):
            return view('frontend.'.$theme->theme.'.welcome');
            break;
        case('anna 2'):
            return view('frontend.'.$theme->theme.'.welcome');
            break;
        case('cloud'):
            return view('frontend.'.$theme->theme.'.welcome');
            break;

        default:
            return view('frontend.'.$theme->theme.'.welcome');
    }
    // return view('welcome');
})->name('homePage');

Route::get('party', [App\Http\Controllers\HalloinController::class, 'index'])->name('halloin.index');

Route::post('party/store', [App\Http\Controllers\HalloinController::class, 'store'])->name('halloin.store');
Route::get('party/success', [App\Http\Controllers\HalloinController::class, 'success'])->name('halloin.success');

Route::get('party/spinner', [App\Http\Controllers\HalloinController::class, 'spinner'])->name('halloin.spinner');


Route::get('/game/{x}', [FormNumberConroller::class, 'go'])->name('fire.go');
//formtest route
Route::get('/ohana',function()
{
    return view('test');
});
Route::get('/test1',function()
{
    return view('test2');
});
Route::get('admin/add-players',function(){
   return view('newLayout.components.player');
})->name('admin.add_players')->middleware('auth');
Route::get('mass-mail',[FormController::class, 'massMail'])->name("massMail");
Route::get('test/mass-mail',[FormController::class, 'testmassMail'])->name("testmassMail");
Route::get('noor/mass-mail',[FormController::class, 'noorMassMail'])->name("noorMassMail");
Route::get('noor/active-mass-mail',[FormController::class, 'noorActiveMassMail'])->name("noorActiveMassMail");
Route::get('woods/mass-mail',[FormController::class, 'woodsMassMail'])->name("woodsMassMail");
Route::get('noor/jan-active-user',[FormController::class, 'noorJanActiveUsers'])->name("noorJanActiveUsers");

Route::get("see", function(){
    return view('mails.ecxel_mail');
});
Route::get('/games/all', [FormNumberConroller::class, 'gogames'])->name('go.games');
Route::post('/save-device-info', function (Request $request) {
    $deviceModel = $request->device;
    $osName = $request->os;

    // Save the device information to the database or handle it as needed
    // For example:
    // Device::create([
    //     'model' => $deviceModel,
    //     'os' => $osName
    // ]);

    return response()->json(['message' => 'Device information saved successfully.']);
});

//User upload sheet start
Route::get('user-details',[UserDetailsController::class,'index'])->name("user_details.index");
Route::post('user-details',[UserDetailsController::class,'store'])->name('user_details.store');

//User Details End




Route::post('add/form', [FormController::class, 'store'])->name('forms.stores');
Route::get('add/form', function(){

    return redirect()->route('homePage');
});
// Route::post('add/form', [FormController::class, 'store'])->name('forms.stores');
Route::post('saveForm', [FormNumberConroller::class, 'store'])->name('forms.saveForm');
Route::post('saveNote', [FormNumberConroller::class, 'saveNote'])->name('forms.saveNote');
Route::post('/checkCaptcha', [FormController::class, 'checkCaptcha'])->name('checkCaptcha');
Route::get('success', function () {

    $theme = GeneralSetting::first('theme');
    // dd($theme);
    switch($theme) {
        case('anna'):
            return view('frontend.'.$theme->theme.'.success');
            break;

        default:
            return view('frontend.'.$theme->theme.'.success');
    }
    // return view('success');
})->name('success');
Route::get('formsuccess', function () {
    return view('formsuccess');
});


//admin route
// Auth::routes();

Auth::routes([

    'register' => false, // Register Routes...

    'reset' => false, // Reset Password Routes...

    'verify' => false, // Email Verification Routes...

    'login'  => false, // login route
]);

use App\Http\Controllers\PlinkoController;
Route::get('/plinko', [PlinkoController::class, 'index'])->name('plinko');
Route::post('/plinko/toggle/{id}', [PlinkoController::class, 'togglePlinkoActivate'])->name('togglePlinkoActivate');
Route::get('/plinko/game/{token_id}', [PlinkoController::class, 'gamestart'])->name('plinko.game');
Route::post('/savegamedata', [PlinkoController::class, 'saveGameData']);

// Route::get('admin/form/create', [FormController::class, 'create'])->name('forms.create');
Route::post('admin/update/form/{id}', [FormController::class, 'update'])->name('update.form');
Route::post('admin/destroy/form/{id}', [FormController::class, 'destroy'])->name('form.destroy');
Route::get('/missing-user',[MissingUserController::class,'index'])->name('missingUser')->middleware('auth');

Route::resource('forms', FormController::class);
Route::get('forms/edit/{id}', [FormController::class, 'edit'])->name('forms.edit');
Route::post('saveNoteForm', [FormController::class, 'saveNote'])->name('forms.saveNoteForm');
Route::get('forms/destroy/{id}', [FormController::class, 'destroy'])->name('forms.destroy');


// Route::get('/new-home', [App\Http\Controllers\HomeController::class, 'new-index'])->name('new-home');
Route::resource('/imageupload',ImageController::class);
Route::get('/show-image',[HomeController::class,'showImage'])->name('show.images');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/days', [App\Http\Controllers\HomeController::class, 'day'])->name('day');
Route::get('/home/yesterday', [App\Http\Controllers\HomeController::class, 'yesterday'])->name('yesterday');
Route::get('/home/tommorow', [App\Http\Controllers\HomeController::class, 'tommorow'])->name('tommorow');
Route::get('/home/image-upload',[App\Http\Controllers\HomeController::class,'imageUpload'])->name('image-upload');

Route::get('/home/colab', [App\Http\Controllers\HomeController::class, 'colab'])->name('colab');
Route::get('colab/destroy/{id}', [FormNumberConroller::class, 'destroy'])->name('colab.destroy');
Route::post('colab/update/', [FormNumberConroller::class, 'update'])->name('colab.update');

Route::get('/deleted-players',[App\Http\Controllers\HomeController::class, 'deletedPlayers'])->name('deleted.players');
Route::get('players/restore/{id}', [FormController::class, 'restorePlayers'])->name('forms.restore');
Route::get('players/fdestroy/{id}', [FormController::class, 'forceDeletePlayers'])->name('forms.fdestroy');

Route::get('/dashboard', [App\Http\Controllers\NewHomeController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::post('/change-color', [App\Http\Controllers\NewHomeController::class, 'changeColor'])->name('change-color');
Route::get('/gamers-games/{id}', [App\Http\Controllers\NewHomeController::class, 'gamerGames'])->name('gamerGames');
Route::get('/gamers-games/{id}/?month=previous', [App\Http\Controllers\NewHomeController::class, 'gamerGames'])->name('gamersgames.previousmanth');
Route::get('/gamers', [App\Http\Controllers\NewHomeController::class, 'gamers'])->name('gamers');
Route::get('/gamers/edit/{id}', [App\Http\Controllers\NewHomeController::class, 'gamerEdit'])->name('gamerEdit');
Route::post('/gamers/update/{id}', [App\Http\Controllers\NewHomeController::class, 'gamerUpdate'])->name('gamerUpdate');
Route::get('/gamers/destroy/{id}', [App\Http\Controllers\NewHomeController::class, 'gamerDestroy'])->name('gamerDestroy');
Route::get('/inactive-players/{id}', [App\Http\Controllers\NewHomeController::class, 'inactivePlayers'])->name('inactive-players');

//updated by Ameer Bajracharya 2022-05-05
Route::get('/activity-status',          [ActivityStatusController::class, 'index'])->name('activity.status.index');
Route::post('/activity-status-store',   [ActivityStatusController::class, 'store'])->name('activity.status.store');
Route::get('/activity-status-delete/{id}', [ActivityStatusController::class, 'delete'])->name('activity.status.delete');
Route::post('/change-activity-status',  [ActivityStatusController::class, 'changeActivityStatus'])->name('activity.status.change');
Route::post('/table-search', [SearchTableController::class, 'tableSearch'])->name('tableSearch');
Route::post('/gamers/update-balance', [App\Http\Controllers\NewHomeController::class, 'gamerUpdateBalance'])->name('gamerUpdateBalance');

Route::get('/players-load-details', [App\Http\Controllers\NewHomeController::class, 'playersLoadDetails'])->name('players-load-details');


Route::get('/spinner', [App\Http\Controllers\NewHomeController::class, 'spinner'])->name('spinner');
Route::get('/spinner/form/{token}', [App\Http\Controllers\NewHomeController::class, 'userSpinner'])->name('spinnerForm');

//updated Route by Ameer Bajracharya
Route::get('/table', [SearchTableController::class, 'table'])->name('table')->middleware('auth');
Route::post('/table', [SearchTableController::class, 'table'])->name('table.search')->middleware('auth');


Route::get('/unsubmails', [App\Http\Controllers\NewHomeController::class, 'unsubMails'])->name('unsubMails');
Route::get('/spinner-winner', [App\Http\Controllers\NewHomeController::class, 'spinnerWinner'])->name('spinner-winner');
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs')->middleware('admin');

Route::get('/redeem-history', [App\Http\Controllers\NewHomeController::class, 'redeemHistory'])->name('redeemHistory')->middleware('auth');
Route::post('/table-loadBalance', [App\Http\Controllers\NewHomeController::class, 'tableUpdate'])->name('tableUpdate');
Route::post('/table-loadCashBalance', [App\Http\Controllers\NewHomeController::class, 'loadCashBalance'])->name('loadCashBalance');
Route::post('/table-referBalance', [App\Http\Controllers\NewHomeController::class, 'referBalance'])->name('referBalance');
Route::post('/table-redeemBalance', [App\Http\Controllers\NewHomeController::class, 'redeemBalance'])->name('redeemBalance');
Route::post('/table-tipBalance', [App\Http\Controllers\NewHomeController::class, 'tipBalance'])->name('tipBalance');
Route::post('/add-user', [App\Http\Controllers\NewHomeController::class, 'addUser'])->name('addUser');
Route::post('/user-history', [App\Http\Controllers\NewHomeController::class, 'userHistory'])->name('user-history');
Route::get('/all-history', [App\Http\Controllers\NewHomeController::class, 'allHistory1'])->name('all-history');
Route::get('/all-history1', [App\Http\Controllers\NewHomeController::class, 'allHistory'])->name('all-history1');
Route::get('/todays-history', [App\Http\Controllers\NewHomeController::class, 'todaysHistory'])->name('todays-history');
Route::post('/filter-user-history', [App\Http\Controllers\NewHomeController::class, 'filterUzserHistory'])->name('filter-user-history');
Route::post('/filter-all-history', [App\Http\Controllers\NewHomeController::class, 'filterAllHistory'])->name('filter-all-history');
Route::get('/gamers/restore/{id}', [App\Http\Controllers\NewHomeController::class, 'gamerRestore'])->name('gamerRestore');
Route::get('/undo-history', [App\Http\Controllers\NewHomeController::class, 'undoHistory'])->name('undo-history');
Route::get('/undo-item-history/{id}', [App\Http\Controllers\NewHomeController::class, 'undoItemHistory'])->name('undo-item-history');
Route::get('/undo-table/{id}', [App\Http\Controllers\NewHomeController::class, 'undoTable'])->name('undo-table');
Route::post('/export', [App\Http\Controllers\NewHomeController::class, 'export'])->name('export');
Route::post('/remove-form-game', [App\Http\Controllers\NewHomeController::class, 'removeFormGame'])->name('remove-form-game');
Route::post('/filter-undo-history', [App\Http\Controllers\NewHomeController::class, 'filterUndoHistory'])->name('filter-undo-history');

// Route::get('/all-history1', [App\Http\Controllers\NewHomeController::class, 'allHistory1'])->name('all-history1');

Route::get('/game-image/{id}', [App\Http\Controllers\NewHomeController::class, 'gameImage'])->name('gameImage');
Route::post('/game-image-store/', [App\Http\Controllers\NewHomeController::class, 'gameExtraImageStore'])->name('gameExtraImageStore');
Route::get('/game-image-destroy/{id}/{key}', [App\Http\Controllers\NewHomeController::class, 'gameImageDestroy'])->name('gameImage.destroy');
Route::get('/games', [App\Http\Controllers\NewHomeController::class, 'games'])->name('games');
Route::get('/games/edit/{id}', [App\Http\Controllers\NewHomeController::class, 'gameEdit'])->name('gameEdit');
Route::post('/games/update/{id}', [App\Http\Controllers\NewHomeController::class, 'gameUpdate'])->name('gameUpdate');
Route::get('/games/destroy/{id}', [App\Http\Controllers\NewHomeController::class, 'gameDestroy'])->name('gameDestroy');
Route::post('/games/store/', [App\Http\Controllers\NewHomeController::class, 'gameStore'])->name('gameStore');
Route::post('/games/images/store/', [App\Http\Controllers\NewHomeController::class, 'gameImageStore'])->name('gameImageStore');

//generate pdf file and save in public.pdf directory
Route::get('/employee/pdf', [App\Http\Controllers\NewHomeController::class, 'createPDF']);

Route::get('/gamers-games/{id}', [App\Http\Controllers\NewHomeController::class, 'gamerGames'])->name('gamerGames');
Route::post('/send-message', [App\Http\Controllers\NewHomeController::class, 'sendMessage'])->name('send-message');
Route::post('/send-sms', [App\Http\Controllers\NewHomeController::class, 'sendSMS'])->name('send-sms');
Route::post('/updateForm', [App\Http\Controllers\NewHomeController::class, 'updateForm'])->name('updateForm');
Route::get('/settings',[App\Http\Controllers\NewHomeController::class,'settings'])->name('settings')->middleware('admin');
Route::post('/settings-update',[App\Http\Controllers\NewHomeController::class,'settingStore'])->name('settingStore')->middleware('admin');
Route::post('/gameids',[App\Http\Controllers\NewHomeController::class,'gameids'])->name('gameids')->middleware('admin');
Route::get('/user-details/{id}',[App\Http\Controllers\NewHomeController::class,'userDetails'])->name('userDetails')->middleware('auth');
Route::post('/updateGameId',[App\Http\Controllers\NewHomeController::class,'updateGameId'])->name('updateGameId')->middleware('admin');


Route::get('/user-spinner', [App\Http\Controllers\NewHomeController::class, 'userSpinner'])->name('userSpinner');
Route::get('/report', [App\Http\Controllers\NewHomeController::class, 'report'])->name('report');

Route::get('/dashboard/colab', [App\Http\Controllers\NewHomeController::class, 'colab'])->name('dashboard.colab');
Route::get('/dashboard/colab/edit/{id}', [App\Http\Controllers\NewHomeController::class, 'editColab'])->name('dashboardColab.edit');
Route::get('/dashboard/colab/destroy/{id}', [App\Http\Controllers\NewHomeController::class, 'destroyColab'])->name('dashboardColab.destroy');
Route::post('/dashboard/colab/update/', [App\Http\Controllers\NewHomeController::class, 'updateColab'])->name('dashboardColab.update');
Route::get('/profile', [App\Http\Controllers\NewHomeController::class, 'profile'])->name('profile');
Route::post('/profile/update', [App\Http\Controllers\NewHomeController::class, 'profileStore'])->name('profile.update');

Route::get('/all-data1', [App\Http\Controllers\NewHomeController::class, 'allData1'])->name('allData');
Route::get('/monthly-history', [App\Http\Controllers\NewHomeController::class, 'allData'])->name('monthlyHistory');
Route::post('/this-day-history', [App\Http\Controllers\NewHomeController::class, 'thisDay'])->name('thisDay');
Route::post('/filter-user-history-allData', [App\Http\Controllers\NewHomeController::class, 'filterUserHistoryAllData'])->name('filterUserHistoryAllData');

Route::get('/login-logs', [App\Http\Controllers\NewHomeController::class, 'loginLogs'])->name('loginLogs');
Route::post('/this-month-logs', [App\Http\Controllers\NewHomeController::class, 'thisMonthLogs'])->name('thisMonthLogs');

Route::get('/game-data', [App\Http\Controllers\NewHomeController::class, 'gameData'])->name('gameData');
Route::post('/addHistory', [App\Http\Controllers\NewHomeController::class, 'addHistory'])->name('addHistory');
Route::post('/this-day-game-history', [App\Http\Controllers\NewHomeController::class, 'thisDayGame'])->name('thisDayGame');

Route::get('/generateSpinnerKey/', [App\Http\Controllers\NewHomeController::class, 'generateSpinnerKey'])->name('generateSpinnerKey');
Route::post('/settings-email-id-counter-update',[App\Http\Controllers\NewHomeController::class,'settingStore'])->name('email_id_counter')->middleware('admin');
Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('Prasundahal@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});
// Route::redirect('/fire/{x}', 'http://firekirin.xyz:8580/index.html');

Route::get('send-sms-notification', [NotificationController::class, 'sendSmsNotificaition']);
Route::get('send-sms', [NotificationController::class, 'sendSmsNotificaition'])->name('forms.sendsms');
Route::get('send-email-notification/{id}', [HomeController::class, 'sendemail'])->name('forms.sendmail');


Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.index')->middleware('admin');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/chat/admin', function () {
        return redirect()->route('admin.chat');
    })->name('chat.admin');
    Route::get('/admin/chat', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chat');
    Route::get('/admin/chat/start', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chat.start');
    Route::get('/admin/chat/sessions', [App\Http\Controllers\Admin\ChatController::class, 'sessions'])->name('admin.chat.sessions');
    Route::get('/admin/chat/{sessionId}/messages', [App\Http\Controllers\Admin\ChatController::class, 'messages'])->name('admin.chat.messages');
    Route::post('/admin/chat/{sessionId}/messages', [App\Http\Controllers\Admin\ChatController::class, 'storeMessage'])->name('admin.chat.messages.store');
    Route::post('/admin/chat/{sessionId}/read', [App\Http\Controllers\Admin\ChatController::class, 'markRead'])->name('admin.chat.read');
    Route::post('/admin/chat/{sessionId}/block', [App\Http\Controllers\Admin\ChatController::class, 'toggleBlock'])->name('admin.chat.block');
    Route::post('/admin/chat/{sessionId}/close', [App\Http\Controllers\Admin\ChatController::class, 'toggleClose'])->name('admin.chat.close');
    Route::delete('/admin/chat/{sessionId}', [App\Http\Controllers\Admin\ChatController::class, 'destroySession'])->name('admin.chat.destroy');
});
Route::get('cashier/dashboard',[CashierController::class,'index'])->name('cashier.index')->middleware('cashier');
Route::get('/logout',[AdminController::class,'logout'])->name('logout');
Route::get('/admin/login',[AdminController::class,'login'])->name('admin.login');
Route::post('/admin/login',[LoginController::class,'login'])->name('admin.login');
Route::get('/admin/login/change-password',[AdminController::class,'changePassword'])->name('admin.login.change_password');
Route::post('/admin/login/check-email',[AdminController::class,'changePassword'])->name('admin.login.check_email');
Route::get('/admin/login/new-password',[AdminController::class,'changePassword'])->name('admin.login.new_password');
Route::post('/admin/login/store-password',[AdminController::class,'changePassword'])->name('admin.login.new_password_store');
Route::get('/admin/login/email-verification',[AdminController::class,'changePassword'])->name('login.email_verification');
Route::get('/admin/login/confirm-otp',[AdminController::class,'changePassword'])->name('admin.login.confirm_otp');
Route::post('/admin/login/confirm-otp',[AdminController::class,'changePassword'])->name('admin.login.confirm_otp.check');

Route::post('/set-winner', [App\Http\Controllers\NewHomeController::class, 'setWinner'])->name('set-winner');

// Route::get('/admin/login/email-confirm-otp',function(){
//     dd('check');
// })->name("admin.login.confirm_otp");

Route::get('mailtest', function () {
    $mailData = [
        'name'  => "mangal",
        'subject'  => "tamang",
        'email' => "email",
        'text'=>"hello",
    ];
    $user['to']="mangaletamang65@gmail.com";
    $user['from']='mangal12@sharewarenepal.com';
    // dd('heheh');
    // Mail::send('mailtest',$mailData,function($message) use ($user) {
    //     $message->to($user['to']);
    //     $message->from($user['from']);
    //     $message->subject('Mail From Client');
    // });
});
Route::get('/cashier/login',[CashierController::class,'login'])->name('cashier.login');
Route::get('/admin/credential',[AdminController::class,'getCredential'])->name('admin.credential')->middleware('admin');
Route::get('/admin/frontend',[AdminController::class,'getFrontend'])->name('admin.frontend')->middleware('admin');
Route::post('/admin/frontsetting',[FrontendSettingController::class,'storeGeneralSetting'])->name('admin.store.frontsetting')->middleware('admin');
Route::get('admin/image',[FrontendSettingController::class,'image'])->name('image')->middleware('admin');
Route::resource('/imageupload',ImageController::class);
Route::post('/changestatus',[ImageController::class,'updateStatus'])->name('image.update_status')->middleware('admin');

Route::get('/admin/colab', [App\Http\Controllers\HomeController::class, 'colab'])->name('colab')->middleware('admin');
Route::get('colab/edit/{id}', [FormNumberConroller::class, 'edit'])->name('colab.edit')->middleware('admin');
Route::get('colab/destroy/{id}', [FormNumberConroller::class, 'destroy'])->name('colab.destroy')->middleware('admin');
Route::post('colab/update/', [FormNumberConroller::class, 'update'])->name('colab.update')->middleware('admin');

Route::get('/admin/all_players', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.allplayers')->middleware('admin');
Route::get('/admin/show-image',[ImageController::class,'showImages'])->name('show.images')->middleware('admin');
Route::post('/add-user', [App\Http\Controllers\NewHomeController::class, 'addUser'])->name('addUser');

Route::get('cashier/show_today',[CashierController::class,'showToday'])->name('cashier.showtoday');

Route::get('admin/games',[AdminController::class,'showGames'])->name('admin.games')->middleware('admin');
Route::get('admin/store-games',[AdminController::class,'storeAccount'])->name('store.games')->middleware('admin');
Route::post('admin/store-games',[AdminController::class,'storeGames'])->name('save.games')->middleware('admin');
Route::get('admin/edit-games/{id}',[AdminController::class,'editGames'])->name('edit.games')->middleware('admin');
Route::post('admin/update-games/{id}',[AdminController::class,'updateGames'])->name('update.games')->middleware('admin');
Route::post('/changegamestatus',[AdminController::class,'updateStatus'])->name('games.update_status')->middleware('admin');
Route::get('admin/del-games/{id}',[AdminController::class,'delGames'])->name('del.games')->middleware('admin');
Route::get('admin/trash-games',[AdminController::class,'trashGames'])->name('trash.games')->middleware('admin');
Route::get('admin/restore-games/{id}',[AdminController::class,'restoreGames'])->name('restore.games')->middleware('admin');
Route::get('admin/force-del-games/{id}',[AdminController::class,'forceDelGames'])->name('fdel.games')->middleware('admin');
Route::resource('admin/cashapp',CashAppController::class);
Route::get('admin/trash-cashapp',[CashAppController::class,'trashCashapp'])->name('trash.cashapp')->middleware('admin');
Route::get('admin/restore-cashapp/{id}',[CashAppController::class,'restoreCashapp'])->name('cashapp.restore')->middleware('admin');
Route::get('admin/force-del-cashapp/{id}',[CashAppController::class,'forceDelCashapp'])->name('cashapp.fdelete')->middleware('admin');
Route::get('admin/cashier-front',[AdminController::class,'showCashierFrontSetting'])->name('cashier.frontend');
Route::get('cashier/cashapp',[CashierController::class,'showCashApp'])->name('cashier.showcashapp');
Route::post('updateBalance',[CashierController::class,'updateCashAppBalance'])->name('cashier.updatebalance');
Route::post('admin/store-cashier-front',[AdminController::class,'storeCashierFront'])->name('cashier.store.frontsetting');
Route::post('/table-import',[SearchTableController::class,'importTable'])->name('importTable')->middleware('auth');
Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function(){
    // Route::group(['middleware'=>['role:admin|Super Admin']], function(){
        Route::resource('user', UserController::class);
        Route::post('user-status',[UserController::class,'status'])->name('admin.user_status');
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    // });

    Route::get('admin/coin-address',[App\Http\Controllers\CoinsAddressController::class,'index'])->name('admin.coin-address.index');
    Route::get('admin/coin-address/create',[App\Http\Controllers\CoinsAddressController::class,'create'])->name('admin.coin-address.create');
    Route::post('admin/coin-address/store',[App\Http\Controllers\CoinsAddressController::class,'store'])->name('admin.coin-address.store');
    Route::get('admin/coin-address/edit/{id}',[App\Http\Controllers\CoinsAddressController::class,'edit'])->name('admin.coin-address.edit');
    Route::put('admin/coin-address/update/{id}',[App\Http\Controllers\CoinsAddressController::class,'update'])->name('admin.coin-address.update');
    Route::post('admin/coin-address/delete/{id}',[App\Http\Controllers\CoinsAddressController::class,'destroy'])->name('admin.coin-address.destroy');

    //networks routes
    Route::get('admin/networks',[App\Http\Controllers\NetWorkController::class,'index'])->name('admin.networks.index');
    Route::get('admin/networks/create',[App\Http\Controllers\NetWorkController::class,'create'])->name('admin.networks.create');
    Route::post('admin/networks/store',[App\Http\Controllers\NetWorkController::class,'store'])->name('admin.networks.store');
    Route::get('admin/networks/edit/{id}',[App\Http\Controllers\NetWorkController::class,'edit'])->name('admin.networks.edit');
    Route::put('admin/networks/update/{id}',[App\Http\Controllers\NetWorkController::class,'update'])->name('admin.networks.update');
    Route::post('admin/networks/delete/{id}',[App\Http\Controllers\NetWorkController::class,'destroy'])->name('admin.networks.destroy');


    Route::get('participants', [App\Http\Controllers\ParticipantController::class, 'index'])->name('participants.index');
    Route::get('participants/create', [App\Http\Controllers\ParticipantController::class, 'create'])->name('participants.create');
    Route::post('participants', [App\Http\Controllers\ParticipantController::class,'store'])->name('participants.store');
    Route::get('participants/{participant}', [App\Http\Controllers\ParticipantController::class, 'show'])->name('participants.show');
    Route::get('participants/{participant}/edit', [App\Http\Controllers\ParticipantController::class, 'edit'])->name('participants.edit');
    Route::put('participants/{participant}', [App\Http\Controllers\ParticipantController::class,'update'])->name('participants.update');
    Route::delete('participants/{participant}', [App\Http\Controllers\ParticipantController::class,'destroy'])->name('participants.destroy');
    Route::get('participants/spinner', [App\Http\Controllers\ParticipantController::class,'spinner'])->name('participants.spinner');
    Route::post('participants;', [App\Http\Controllers\ParticipantController::class, 'participants'])->name('participants');
});

Route::get('/pay-now', [NowPaymentsController::class, 'networkList'])->name('payment.form');
Route::get('/get-crypto-details', [NowPaymentsController::class, 'getCryptoDetails'])->name('get-crypto-details');
Route::get('/payment/wallet-list', [NowPaymentsController::class,'walletList'])->name('payment.wallet-list');
Route::post('/payment/copy-address', [NowPaymentsController::class,'copyAddress'])->name('payment.copyAddress');

Route::post('messenger-id',[App\Http\Controllers\NewHomeController::class,'messengerId'])->name('messenger-id');




Route::get('gameData', [App\Http\Controllers\ParticipantController::class, 'gameData'])->name('gameData');
