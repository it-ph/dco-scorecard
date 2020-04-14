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
    Route::get('/profile', 'HomeController@profile')->name('profile');

    /* Admin Links */
    Route::group(['middleware' => ['adminOnly'],'prefix'=>'admin' ],
        function(){
            Route::resource('users','Admin\AdminController');

  
            //Setup
            Route::POST('admin-roles/isfillable/{roleId}','Admin\RoleController@columnFillable')->name('role.fillable');
             Route::resource('admin-roles','Admin\RoleController');
            Route::resource('admin-positions','Admin\PositionController');
            Route::resource('departments','Admin\DepartmentController');

            //Settings
            Route::GET('settings','Admin\SettingController@index');
            Route::post('/towerhead', 'Admin\SettingController@updateTowerHead')->name('towerhead.store');

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
            Route::GET('user/password', 'HomeController@viewPassword');
            Route::POST('/user/password', 'HomeController@storePassword')->name('user.store');

    


    /**
     * 
     *  VERSION 2.0
     */

     /* Admin Links */
    Route::group(['middleware' => ['adminOnly'],'prefix'=>'v2/admin' ],
    function(){


        //Setup
        Route::resource('admin-roles','Admin\RoleController');
        Route::resource('admin-positions','Admin\PositionController');
        Route::resource('departments','Admin\DepartmentController');

        //Settings
        Route::GET('settings','Admin\SettingController@index');
        Route::POST('/towerhead', 'Admin\SettingController@updateTowerHead')->name('towerhead.store');

        //Advanced Settings
        Route::GET('metrics','v2\SettingController@metrics');

        
        //Templates
        Route::GET('template/create','v2\TemplateController@create')->name('template.create');
        Route::POST('template','v2\TemplateController@store')->name('template.store');
        Route::POST('template/destroy/{templateId}','v2\TemplateController@destroy')->name('template.destroy');
        Route::POST('template/{templateId}/update','v2\TemplateController@update')->name('template.update');
        Route::GET('template/preview/{templateId}/{from}','v2\TemplateController@preview')->name('template.preview');
        ////Column
        Route::GET('template/column/create/{templateId}','v2\TemplateController@createColumn')->name('template.column.create');
        Route::POST('template/column/create/{templateId}','v2\TemplateController@storeColumn')->name('template.column.store');
        Route::POST('template/column/update/{columnId}','v2\TemplateController@updateColumn')->name('template.column.update');
        Route::POST('template/column/destroy/{templateId}/{columnPosition}/{columnId}','v2\TemplateController@destroyColumn')->name('template.column.destroy');
        Route::POST('template/column/isfillable/{columnId}','v2\TemplateController@columnFillable')->name('template.column.fillable');
        Route::POST('template/column/isfinalscore/{columnId}','v2\TemplateController@columnFinalScore')->name('template.column.isfinalscore');
       
       
        ////Content
        Route::GET('template/content/create/{templateId}','v2\TemplateController@createContent')->name('template.content.create');
        Route::POST('template/content/create/{templateId}','v2\TemplateController@storecreateContent')->name('template.content.store');
        Route::POST('template/content/update/{templateId}/{rowPosition}/{columnPosition}','v2\TemplateController@updateContent')->name('template.content.update');
        Route::POST('template/content/destroy/{templateContentId}','v2\TemplateController@destroyContent')->name('template.content.destroy');
        Route::POST('template/content/destroy/row/{templateId}/{rowPosition}','v2\TemplateController@destroyContentRow')->name('template.content.destroy.row');
        
        ////User Remarks
        Route::GET('template/remarks/create/{templateId}','v2\TemplateController@createRemarks')->name('template.remarks.create');
        Route::POST('template/remarks/create/{templateId}','v2\TemplateController@storeRemarks')->name('template.remarks.store');
        Route::POST('template/remarks/update/{remarksId}','v2\TemplateController@updateRemarks')->name('template.remarks.update');
        Route::POST('template/remarks/destroy/{remarksId}','v2\TemplateController@destroyRemarks')->name('template.remarks.destroy');
       

         
        
}); // adminOnly

        //Scores
        Route::group(['prefix'=>'v2/scores'],
        function(){ 
            //update fillable Content in Scorecard
            Route::GET('/update-scorecard-fillable','v2\ScoreController@updateScorecardFillable');

            //per Role
            Route::GET('/{roleId}','v2\ScoreController@scores')->name('v2.score');
            Route::POST('/{roleId}','v2\ScoreController@scoreStore')->name('v2.score.store');
            Route::GET('/show/{scoreCardId}/{roleId}','v2\ScoreController@showScoreCard')->name('v2.score.show');
            Route::GET('/print/{scoreCardId}/{roleId}','v2\ScoreController@printScoreCard')->name('v2.score.print');
            Route::DELETE('delete/{scoreCardId}','v2\ScoreController@deleteScorecard')->name('v2.score.destroy');
            Route::POST('acknowledge/{scoreCardId}','v2\ScoreController@acknowledgeScorecard')->name('v2.score.acknowledge');
            Route::POST('/feedback/{scoreCardId}/{remarksId}','v2\ScoreController@feedbackScorecard')->name('v2.score.feedback');
            // Route::POST('/action-plan/{scoreCardId}','v2\ScoreController@actionplanScorecard')->name('v2.score.actionplan');
            
            //  Route::POST('agent','ScoreController@scores')->name('agent-score.store');
            //  Route::GET('agent/{score_id}','ScoreController@editAgentScore')->name('agent-score.edit');
            //  Route::PUT('agent/{score_id}','ScoreController@updateAgentScore')->name('agent-score.update');
            //  Route::DELETE('agent/{score_id}','ScoreController@deleteAgentScore')->name('agent-score.destroy');
            //  Route::GET('agent/show/{score_id}','ScoreController@showAgentScore')->name('agent-score.show');
            //  Route::GET('agent/print/{score_id}','ScoreController@printAgentScore')->name('agent-score.print');
            //  Route::POST('agent/feedback/{score_id}','ScoreController@agentFeedback')->name('agent-feedback.store');
            //  Route::POST('agent/action_plan/{score_id}','ScoreController@agentActionPlan')->name('agent-action-plan.store');
            //  Route::POST('agent/acknowledge/{score_id}','ScoreController@acknowledgeScore')->name('agent-acknowledge.store');
 
             //Supervisor & TL
            //  Route::GET('tl','ScoreController@tlScore');
            //  Route::POST('tl','ScoreController@addTLScore')->name('tl-score.store');
            //  Route::GET('tl/{score_id}','ScoreController@editTLScore')->name('tl-score.edit');
            //  Route::PUT('tl/{score_id}','ScoreController@updateTLScore')->name('tl-score.update');
            //  Route::DELETE('tl/{score_id}','ScoreController@deleteTLScore')->name('tl-score.destroy');
            //  Route::GET('tl/show/{score_id}','ScoreController@showTLScore')->name('tl-score.show');
            //  Route::GET('tl/print/{score_id}','ScoreController@printTLScore')->name('tl-score.print');
            //  Route::POST('tl/feedback/{score_id}','ScoreController@tlFeedback')->name('tl-feedback.store');
            //  Route::POST('tl/action_plan/{score_id}','ScoreController@tlActionPlan')->name('tl-action-plan.store');
            //  Route::POST('tl/acknowledge/{score_id}','ScoreController@acknowledgeScoreTL')->name('tl-acknowledge.store');
       
             
        });//Scores

}); //Middleware auth



