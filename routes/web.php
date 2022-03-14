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

// Auth::routes();
Auth::routes(['register' => false]);

/* Authorized Users */
Route::group(['middleware' => ['auth','web'],],
    function ()
{

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/export', 'ExportController@export')->name('export');
    Route::get('/export_agent_template/upload-agent_template', 'ExportController@uploadAgentTemplate')->name('export-upload-agent_template');
    Route::get('/export_tl_template/upload-tl_template', 'ExportController@uploadTLTemplate')->name('export-upload-tl_template');
    Route::post('/import', 'ImportController@import')->name('import');

    Route::get('/profile', 'HomeController@profile')->name('profile');

    /* Admin Links */
    Route::group(['middleware' => ['adminOnly'],'prefix'=>'admin' ],
        function(){
            Route::resource('users','Admin\AdminController');

            Route::POST('positions', 'Admin\AdminController@storePosition')->name('users.position.store');
            Route::PUT('position/{positionId}', 'Admin\AdminController@updatePosition')->name('users.position.update');
            Route::DELETE('position/{positionId}', 'Admin\AdminController@deletePosition')->name('users.position.destroy');

            Route::GET('/api/users/details', 'Admin\AdminController@getHrPortalEmployeesAPI')->name('users.details.api');

            //Setup
            Route::resource('admin-roles','Admin\RoleController');
            Route::resource('admin-positions','Admin\PositionController');
            Route::resource('departments','Admin\DepartmentController');

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
            Route::GET('agent','ScoreController@agentScore');
            Route::POST('agent','ScoreController@addAgentScore')->name('agent-score.store');
            Route::GET('agent/{score_id}','ScoreController@editAgentScore')->name('agent-score.edit');
            Route::PUT('agent/{score_id}','ScoreController@updateAgentScore')->name('agent-score.update');
            Route::DELETE('agent/{score_id}','ScoreController@deleteAgentScore')->name('agent-score.destroy');
            Route::GET('agent/show/{score_id}','ScoreController@showAgentScore')->name('agent-score.show');
            Route::GET('agent/print/{score_id}','ScoreController@printAgentScore')->name('agent-score.print');
            Route::POST('agent/feedback/{score_id}','ScoreController@agentFeedback')->name('agent-feedback.store');
            Route::POST('agent/action_plan/{score_id}','ScoreController@agentActionPlan')->name('agent-action-plan.store');
            Route::POST('agent/acknowledge/{score_id}','ScoreController@acknowledgeScore')->name('agent-acknowledge.store');

            //Supervisor & TL
            Route::GET('tl','ScoreController@tlScore');
            Route::POST('tl','ScoreController@addTLScore')->name('tl-score.store');
            Route::GET('tl/{score_id}','ScoreController@editTLScore')->name('tl-score.edit');
            Route::PUT('tl/{score_id}','ScoreController@updateTLScore')->name('tl-score.update');
            Route::DELETE('tl/{score_id}','ScoreController@deleteTLScore')->name('tl-score.destroy');
            Route::GET('tl/show/{score_id}','ScoreController@showTLScore')->name('tl-score.show');
            Route::GET('tl/print/{score_id}','ScoreController@printTLScore')->name('tl-score.print');
            Route::POST('tl/feedback/{score_id}','ScoreController@tlFeedback')->name('tl-feedback.store');
            Route::POST('tl/action_plan/{score_id}','ScoreController@tlActionPlan')->name('tl-action-plan.store');
            Route::POST('tl/acknowledge/{score_id}','ScoreController@acknowledgeScoreTL')->name('tl-acknowledge.store');
        });// Scores


         /* Users */
            Route::get('user/password', 'HomeController@viewPassword');
            Route::post('/user/password', 'HomeController@storePassword')->name('user.store');



}); //Middleware auth
