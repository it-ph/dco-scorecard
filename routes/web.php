<?php

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
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', function () {
    // return view('login');
    return redirect()->guest('/login');
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});


Route::get('template', function () {
    return view('template');
});

Route::get('unauthorized', function () {
    return view('notifications.401');
})->name('unauthorized');

//SSO
Route::group(['middleware' => ['web', 'guest']], function(){
    Route::get('login', 'Auth\AuthController@login')->name('login');
    Route::get('connect', 'Auth\AuthController@connect')->name('connect');
});

// Auth::routes();
Auth::routes(['register' => false]);

// 2FA
Route::POST('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::POST('verify/send', 'Auth\TwoFactorController@send')->name('verify.send');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

/* Authorized Users */
Route::group(['middleware' => ['auth','verify.access','web'],],
// Route::group(['middleware' => ['auth','twofactor','web'],],
    function ()
{

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/export', 'ExportController@export')->name('export');
    Route::get('/export_agent_template/upload-agent_template', 'ExportController@uploadAgentTemplate')->name('export-upload-agent_template');
    Route::get('/export_tl_template/upload-tl_template', 'ExportController@uploadTLTemplate')->name('export-upload-tl_template');
    Route::post('/import', 'ImportController@import')->name('import');
    Route::post('/import-tl-scorecard', 'ImportController@importTlScorecard')->name('import.tl');

    Route::get('/profile', 'HomeController@profile')->name('profile');

    // Signatures
    Route::GET('signatures','SignatureController@index');
    Route::GET('signature/create','SignatureController@create')->name('signature.create');
    Route::POST('signature','SignatureController@store')->name('signature.store');
    Route::GET('signature/upload','SignatureController@uploadSignature')->name('signature.upload');
    Route::POST('signature/upload/store','SignatureController@uploadStoreSignature')->name('signature.upload.store');
    Route::DELETE('signature/{signatureId}','SignatureController@destroy')->name('signature.destroy');
    Route::PUT('signature/{signatureId}','SignatureController@setDefaultSignature')->name('signature.default');

    // UPLOAD IMAGE
    Route::POST('scorecard/image/upload', 'ScoreController@imageUpload')->name('scorecard.image.upload');

    /* Admin Links */
    Route::group(['middleware' => ['adminOnly'],'prefix'=>'admin' ],
        function(){
            Route::resource('users','Admin\AdminController')->parameters(['users' => 'id']);
            Route::GET('/api/users/details', 'Admin\AdminController@getHrPortalEmployeesAPI')->name('users.details.api');

            //Setup
            Route::resource('admin-roles','Admin\RoleController')->parameters(['admin-roles' => 'id']);
            Route::resource('admin-positions','Admin\PositionController')->parameters(['admin-positions' => 'id']);
            Route::resource('departments','Admin\DepartmentController')->parameters(['departments' => 'id']);

            //Settings
            Route::GET('settings','Admin\SettingController@index');
            Route::post('towerhead', 'Admin\SettingController@updateTowerHead')->name('towerhead.store');
            Route::post('target', 'Admin\SettingController@updateTarget')->name('target.store');
            Route::post('weightage', 'Admin\SettingController@updateWeightage')->name('weightage.store');

    });

    //Score
    Route::group(['prefix'=>'scores' ],
        function(){

            //Agent
            // php laravel version upgrade: change score_id to id
            Route::GET('agent','ScoreController@agentScore');
            Route::POST('agent','ScoreController@addAgentScore')->name('agent-score.store');
            Route::GET('agent/{id}','ScoreController@editAgentScore')->name('agent-score.edit');
            Route::PUT('agent/{id}','ScoreController@updateAgentScore')->name('agent-score.update');
            Route::DELETE('agent/{id}','ScoreController@deleteAgentScore')->name('agent-score.destroy');
            Route::GET('agent/show/{id}','ScoreController@showAgentScore')->name('agent-score.show');
            Route::GET('agent/print/{id}','ScoreController@printAgentScore')->name('agent-score.print');
            Route::POST('agent/feedback/{id}','ScoreController@agentFeedback')->name('agent-feedback.store');
            Route::POST('agent/action_plan/{id}','ScoreController@agentActionPlan')->name('agent-action-plan.store');
            Route::POST('agent/strengths_opportunities/{id}','ScoreController@agentStrengthsOpportunities')->name('agent-opportunities-strengths.store');
            Route::POST('agent/screenshots/{id}','ScoreController@agentScreenshots')->name('agent-screenshots.store');
            Route::POST('agent/acknowledge/{id}','ScoreController@acknowledgeScore')->name('agent-acknowledge.store');

            //Supervisor & TL
            Route::GET('tl','ScoreController@tlScore');
            Route::POST('tl','ScoreController@addTLScore')->name('tl-score.store');
            Route::GET('tl/{id}','ScoreController@editTLScore')->name('tl-score.edit');
            Route::PUT('tl/{id}','ScoreController@updateTLScore')->name('tl-score.update');
            Route::DELETE('tl/{id}','ScoreController@deleteTLScore')->name('tl-score.destroy');
            Route::GET('tl/show/{id}','ScoreController@showTLScore')->name('tl-score.show');
            Route::GET('tl/print/{id}','ScoreController@printTLScore')->name('tl-score.print');
            Route::POST('tl/feedback/{id}','ScoreController@tlFeedback')->name('tl-feedback.store');
            Route::POST('tl/action_plan/{id}','ScoreController@tlActionPlan')->name('tl-action-plan.store');
            Route::POST('tl/screenshots/{id}','ScoreController@tlScreenshots')->name('tl-screenshots.store');
            Route::POST('tl/acknowledge/{id}','ScoreController@acknowledgeScoreTL')->name('tl-acknowledge.store');
        });// Scores


         /* Users */
            Route::get('user/password', 'HomeController@viewPassword');
            Route::post('/user/password', 'HomeController@storePassword')->name('user.store');



}); //Middleware auth

