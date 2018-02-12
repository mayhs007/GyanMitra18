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

Route::get('users/{id}/get_college_mates', ['as' => 'users.college_mate', 'uses' => 'PagesController@getCollegeMates'])->middleware('auth');
Route::group(['middleware' => 'auth.redirect_admin'], function(){
    Route::get( '/', ['as' => 'user_pages.home', 'uses' => 'PagesController@home'])->middleware('guest');
    Route::get('about', ['as' => 'user_pages.about', 'uses' => 'PagesController@about']);
    Route::get('home', ['as' => 'user_pages.home', 'uses' => 'PagesController@home']);
    Route::get('event', ['as' => 'user_pages.event', 'uses' => 'PagesController@event']);
    Route::get('schedule', ['as' => 'user_pages.schedule', 'uses' => 'PagesController@schedule']);
    Route::get('contact', ['as' => 'user_pages.contact', 'uses' => 'PagesController@contact']);
    Route::get('guestLecture', ['as' => 'user_pages.guestLecture', 'uses' => 'PagesController@guestLecture']);
    Route::get('events/{department_id}', ['as' => 'user_pages.events', 'uses' => 'PagesController@events']);
    Route::get('workshop/{department_id}', ['as' => 'user_pages.workshop', 'uses' => 'PagesController@workshop']);
    Route::get('help', ['as' => 'user_pages.help', 'uses' => 'PagesController@help']);  
    Route::get('prizes', ['as' => 'user_pages.prizes', 'uses' => 'PagesController@prizes']);       
    Route::get('register/offline', ['as' => 'user_pages.registration.offline', 'uses' => 'PagesController@offlineRegistration']);   
    Route::group(['middleware' => 'auth'], function(){
        // Routes for team registration
        Route::group(['prefix' => 'events/{event_id}'], function(){
            // Registration routes for single participation events
            // Middleware registrations to check whether the user has or not registered events
            Route::get('register', ['as' => 'user_pages.register', 'uses' => 'PagesController@register'])->middleware('registrations:single,no');
            Route::get('unregister', ['as' => 'user_pages.unregister', 'uses' => 'PagesController@unregister'])->middleware('registrations:single,yes');
            // Routes for team participation
            // Middleware registrations to check whether the team has or not registered events            
           Route::group(['middleware' => 'registrations:team,no'], function(){
                Route::get('teams/register', ['as' => 'pages.registerteam', 'uses' => 'PagesController@createTeam']);
                Route::post('teams/register', 'PagesController@registerTeam');  
            });    
            Route::get('teams/{id}/unregister', ['as' => 'pages.unregisterteam', 'uses' => 'PagesController@unregisterTeam'])->middleware('registrations:team,yes');
        });


        Route::group(['prefix' => 'workshop/{event_id}'], function(){
            // Registration routes for single participation events
            // Middleware registrations to check whether the user has or not registered events
            Route::get('register', ['as' => 'user_pages.register', 'uses' => 'PagesController@register'])->middleware('registrations:single,no');
            Route::get('unregister', ['as' => 'user_pages.unregister', 'uses' => 'PagesController@unregister'])->middleware('registrations:single,yes');
                      
            
        });
        // Route for the user's dashboard
        Route::get('dashboard', ['as' => 'user_pages.dashboard', 'uses' => 'PagesController@dashboard']);
        // Route for requesting hospitality
        Route::get('hospitality', ['as' => 'user_pages.hospitality', 'uses' => 'PagesController@hospitality']);
        Route::get('hospitality/request', ['as' => 'user_pages.hospitality.request', 'uses' => 'PagesController@requestHospitality']);
        // Route for event confirmation
        Route::get('confirm', ['as' => 'user_pages.confirm', 'uses' => 'PagesController@confirm'])->middleware('registrations.confirm:no');
        // Route for ticket generation
        Route::group(['middleware' => 'registrations.confirm:yes'], function(){
            Route::get('download-ticket', ['as' => 'user_pages.ticket.download', 'uses' => 'PagesController@downloadTicket']);
            Route::post('upload-ticket', ['as' => 'user_pages.ticket.upload', 'uses' => 'PagesController@uploadDemandDraftImage']);
            Route::post('upload-tickets', ['as' => 'user_pages.ticket.uploadaccomodation', 'uses' => 'PagesController@uploadAccomodationDemandDraftImage']);
        });  
        Route::get('/payment/reciept', ['as' => 'user_pages.payment.reciept', 'uses' => 'PagesController@paymentReciept']);        
    });
});


Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function(){
    // Login routes
    Route::get('login', ['as' => 'auth.login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', 'LoginController@login');
    //Password Reset
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
    // Logout route
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'LoginController@logout']);
    // Registration routes
    Route::get('register', ['as' => 'auth.register', 'uses' => 'RegisterController@showRegistrationForm']);
    Route::post('register', 'RegisterController@register');
    Route::get('activate', ['as' => 'auth.activate', 'uses' => 'RegisterController@activate']);
    Route::get('change-password', ['as' => 'auth.changePassword', 'uses' => 'PasswordController@showChangePassword']);
    Route::post('change-password', ['uses' => 'PasswordController@changePassword']);
});

Route::group(['middleware' => 'payment.check'], function(){
    Route::post('/payment/success', ['as' => 'user_pages.payment.success', 'uses' => 'PagesController@paymentSuccess']);
    Route::post('/payment/failure', ['as' => 'user_pages.payment.failure', 'uses' => 'PagesController@paymentFailure']);
});

//Routes for administrators
Route::group(['prefix' => 'admin', 'as' => 'admin::', 'middleware' => ['auth','auth.admin:']], function(){
    Route::group(['middleware' => 'auth.admin:root'], function(){
        // Open, Close registration
        Route::get('registrations/open', ['as' => 'registrations.open', 'uses' => 'AdminPagesController@openRegistrations']);
        Route::get('registrations/close', ['as' => 'registrations.close', 'uses' => 'AdminPagesController@closeRegistrations']);
        Route::get('Accomodation/open', ['as' => 'Accomodation.open', 'uses' => 'AdminPagesController@openAccomodations']);
        Route::get('Accomodation/close', ['as' => 'Accomodation.close', 'uses' => 'AdminPagesController@closeAccomodations']);
        // Enable or disable offline registration forms
        Route::get('registrations/offline/enable', ['as' => 'registrations.offline.enable', 'uses' => 'AdminPagesController@enableOfflineRegistration']);
        Route::get('registrations/offline/disable', ['as' => 'registrations.offline.disable', 'uses' => 'AdminPagesController@disableOfflineRegistration']);
       // Route to get the list of admins emails in json
       Route::get('get_admins', ['as' =>'admins', 'uses' => 'AdminPagesController@getAdmins']);

       Route::get('requests/all', ['as' => 'requests.all', 'uses' => 'AdminPagesController@allRequests']);
       Route::get('requests', ['as' => 'requests', 'uses' => 'AdminPagesController@requests']);
       
       Route::post('requests', 'AdminPagesController@replyRequest');    

       Route::resource('users', 'UsersController', ['except' => 'show']);

                    
    });
    Route::group(['middleware' => 'auth.admin:root.registration'], function(){
        // Making user present
        Route::get('registrations/{user_id}/present', ['as' => 'registrations.present', 'uses' => 'AdminPagesController@userPresent']);
        // Making user absent
        Route::get('registrations/{user_id}/absent', ['as' => 'registrations.absent', 'uses' => 'AdminPagesController@userAbsent']);    
        // Adding new registrations onspot
        Route::get('registrations', ['as' => 'registrations', 'uses' => 'AdminPagesController@registrations']);
        Route::get('paymentsonline', ['as' => 'paymentsonline', 'uses' => 'AdminPagesController@paymentsonline']);
       Route::get('paymentsdd', ['as' => 'paymentsdd', 'uses' => 'AdminPagesController@paymentsdd']);
       Route::get('accpaymentsonline', ['as' => 'accpaymentsonline', 'uses' => 'AdminPagesController@accpaymentsonline']);
       Route::get('accpaymentsdd', ['as' => 'accpaymentsdd', 'uses' => 'AdminPagesController@accpaymentsdd']);
        Route::get('confirmedregistrations', ['as' => 'confirmedregistrations', 'uses' => 'AdminPagesController@confirmedregistrations']);
        Route::get('registrations/create', ['as' => 'registrations.create', 'uses' => 'AdminPagesController@new_registration' ]);
        Route::post('registrations/create', 'AdminPagesController@create_registration');
        // Edit student details and registered events on the spot
        Route::get('registrations/{user_id}', ['as' => 'registrations.edit', 'uses' => 'AdminPagesController@editRegistration']);
        Route::put('registrations/{user_id}', 'AdminPagesController@updateRegistration');
        // Edit solo events
        Route::get('registrations/{user_id}/events/register', ['as' => 'registrations.events.register', 'uses' => 'AdminPagesController@register']);
        Route::get('registrations/{user_id}/events/{event_id}/uregister', ['as' => 'registrations.events.unregister', 'uses' => 'AdminPagesController@unregister']);
        // Edit team events
        Route::post('registrations/{user_id}/teams/register', ['as' => 'registrations.teams.register', 'uses' => 'AdminPagesController@registerTeam']);
        Route::get('registrations/{user_id}/teams/{event_id}/uregister', ['as' => 'registrations.teams.unregister', 'uses' => 'AdminPagesController@unregisterTeam']);
        // Add accomodations on the spot
        Route::get('registrations/{user_id}/accomodations/register', ['as' => 'registrations.accomodations.register', 'uses' => 'AdminPagesController@registerAccomodation']);
        //  Edit student teams to add or remove team members
        Route::get('registrations/teams/{id}/edit', ['as' => 'registrations.teams.edit', 'uses' => 'AdminPagesController@editTeam']);
        Route::put('registrations/teams/{id}/edit', 'AdminPagesController@updateTeam'); 
        // Open, Close registration
        Route::get('registrations/open', ['as' => 'registrations.open', 'uses' => 'AdminPagesController@openRegistrations']);
        Route::get('registrations/close', ['as' => 'registrations.close', 'uses' => 'AdminPagesController@closeRegistrations']);
        // Enable or disable offline registration forms
        Route::get('registrations/offline/enable', ['as' => 'registrations.offline.enable', 'uses' => 'AdminPagesController@enableOfflineRegistration']);
        Route::get('registrations/offline/disable', ['as' => 'registrations.offline.disable', 'uses' => 'AdminPagesController@disableOfflineRegistration']);
        // Manual event confirmation and unconfirmation by admin        
        Route::get('registrations/{user_id}/confirm', ['as' => 'registrations.confirm', 'uses' => 'AdminPagesController@confirmRegistration']); 
        Route::get('registrations/{user_id}/unconfirm', ['as' => 'registrations.unconfirm', 'uses' => 'AdminPagesController@unconfirmRegistration']); 
        // Manual payment on the spot by the admin
        Route::get('registrations/{user_id}/payments/confirm', ['as' => 'registrations.payments.confirm', 'uses' => 'AdminPagesController@confirmPayment']); 
        Route::get('registrations/{user_id}/payments/unconfirm', ['as' => 'registrations.payments.unconfirm', 'uses' => 'AdminPagesController@unconfirmPayment']); 

    });
    Route::group(['middleware' => 'auth.admin:root'], function(){
        // List of visible prizes
        Route::get('prizes/list', ['as' => 'prizes.list', 'uses' => 'AdminPagesController@editPrizeList']);
        Route::post('prizes/list', 'AdminPagesController@updatePrizeList');
        Route::get('prizes', ['as' => 'prizes.index', 'uses' => 'PagesController@prizes']);
        // Route to get the list of admins emails in json
        Route::get('get_admins', ['as' =>'admins', 'uses' => 'AdminPagesController@getAdmins']);

        Route::get('requests/all', ['as' => 'requests.all', 'uses' => 'AdminPagesController@allRequests']);
        Route::get('requests', ['as' => 'requests', 'uses' => 'AdminPagesController@requests']);
        
        Route::post('requests', 'AdminPagesController@replyRequest');    
        // Resource route for users
        Route::resource('users', 'UsersController', ['except' => ['show']]);

        Route::resource('events', 'EventsController', ['except' => ['show']]);
              
        // Nested resource for adding prizes
        Route::resource('events.prizes', 'PrizesController', ['except' => ['show', 'index', 'edit', 'update', 'destroy']]);
        Route::get('events/{event}/prizes/edit', ['as' => 'events.prizes.edit', 'uses' => 'PrizesController@edit']);
        Route::put('events/{event}/prizes', ['as' => 'events.prizes.update', 'uses' => 'PrizesController@update']);
        Route::get('events/{event_id}/prizes', ['as' => 'events.prizes.show', 'uses' => 'PrizesController@show']);
    });
    // For viewing the organizer specific details
    Route::group(['middleware' => 'organizing'], function(){
        Route::get('events/{event_id}/registrations', ['as' => 'event.registrations', 'uses' => 'AdminPagesController@eventRegistrations']);
        Route::get('events/{event_id}/requests', ['as' => 'event.requests', 'uses' => 'AdminPagesController@eventRequests']);
    });
    Route::group(['middleware' => 'auth.admin:root.organizer'], function(){
        // Report generation for events and accomodations
        Route::get('reports', ['as' => 'reports', 'uses' => 'AdminPagesController@reports']);      
        Route::get('reports/registrations', ['as' => 'reports.registrations', 'uses' => 'AdminPagesController@reportRegistrations']);
        Route::get('reports/allregistrations', ['as' => 'reports.allregistrations', 'uses' => 'AdminPagesController@reportallRegistrations']);
        Route::get('reports/workshopregistrations', ['as' => 'reports.workshopregistrations', 'uses' => 'AdminPagesController@reportWorkshopRegistrations']);   
        Route::get('reports/domainregistrations', ['as' => 'reports.domainregistrations', 'uses' => 'AdminPagesController@reportDomainRegistrations']);   
        Route::get('reports/accomodations', ['as' => 'reports.accomodations', 'uses' => 'AdminPagesController@reportAccomodations']);    
    });
    Route::resource('colleges', 'CollegesController', ['except' => 'show']);   
    // Integrated terminal for developers
    Route::group(['middleware' => 'auth.admin:developer'], function(){
        Route::get('terminal', ['as' => 'terminal', 'uses' => 'AdminPagesController@terminal']);
        Route::post('terminal', ['uses' => 'AdminPagesController@executeCommand']);  
    });
    // Requests for hospitality
    Route::group(['middleware' => 'auth.admin:hospitality'], function(){
        Route::get('accomodations', ['as' => 'accomodations', 'uses' => 'AdminPagesController@accomodationRequests']);
        Route::get('accomodations/all', ['as' => 'accomodations.all', 'uses' => 'AdminPagesController@allAccomodationRequests']);
        Route::post('accomodations', 'AdminPagesController@replyAccomodationRequest');        
    });
    Route::get('/', ['as' => 'root', 'uses' => 'AdminPagesController@root']);
});

  