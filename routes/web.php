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


Route::get('template', function () {
    return view('template');
});

Route::get('unauthorized', function () {
    return view('notifications.401');
})->name('unauthorized');

// Auth::routes();
Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');


/* Authorized Users */
Route::group(['middleware' => ['auth','web'],],
    function () 
{
    /* Admin Links */
    Route::group(['middleware' => ['adminOnly'],'prefix'=>'admin' ],
        function(){
            Route::resource('users','Admin\AdminController');

  
            //Setup
            Route::resource('admin-roles','Admin\RoleController');
            Route::resource('admin-positions','Admin\PositionController');
            Route::resource('departments','Admin\DepartmentController');

    });
  
    //Score
    Route::group(['prefix'=>'scores' ],
        function(){ 

            //Agent
            Route::GET('agent','ScoreController@agentScore');
            Route::POST('agent','ScoreController@addAgentScore')->name('agent-score.store');
            Route::GET('agent/{score_id}','ScoreController@editAgentScore')->name('agent-score.edit');
            Route::GET('agent/{score_id}?from_show','ScoreController@editAgentScore')->name('agent-score.edit'); //fordelete
            Route::PUT('agent/{score_id}','ScoreController@updateAgentScore')->name('agent-score.update');
            Route::DELETE('agent/{score_id}','ScoreController@deleteAgentScore')->name('agent-score.destroy');
            Route::GET('agent/show/{score_id}','ScoreController@showAgentScore')->name('agent-score.show');
            Route::GET('agent/print/{score_id}','ScoreController@printAgentScore')->name('agent-score.print');
            Route::POST('agent/feedback/{score_id}','ScoreController@agentFeedback')->name('agent-feedback.store');
            Route::POST('agent/action_plan/{score_id}','ScoreController@agentActionPlan')->name('agent-action-plan.store');
            Route::POST('agent/acknowledge/{score_id}','ScoreController@acknowledgeScore')->name('agent-acknowledge.store');

            //Supervisor & TL
            Route::GET('tl','ScoreController@tlScore');
        });

    

}); //Middleware auth