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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => '', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

  // Password Reset Routes...
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['as' => 'password.update', 'uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

  // Registration Routes...
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm'])
->middleware('role:Administrator|Call Center Direktor|Broker Direktor|Agent Team Leader|Berater Team Leader|Call Center Admin|Berater Admin');
Route::post('register', ['as' => '', 'uses' => 'Auth\RegisterController@register']);

Route::post('/register/leaderSearch','Auth\RegisterController@searchLeaders')->name('select.leader');
Route::post('/register/beraterSearch','Auth\RegisterController@searchBeraters')->name('select.berater');
Route::post('/register/qualitySearch','Auth\RegisterController@searchQuality')->name('select.quality');

Route::get('password/email', function(){
  abort(404);
});

Route::middleware(['auth'])->group(function () {
    // Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'AppointmentsController@showAppointments')->name('index');

    Route::get('/changePassword','UsersController@showChangePasswordForm');
    Route::post('/changePassword','UsersController@changePassword')->name('changePassword');

    Route::get('/users', 'UsersController@showUsers')->name('showUsers')
    ->middleware('role:Administrator|Call Center Direktor|Broker Direktor|Agent Team Leader|Berater Team Leader|Call Center Admin|Berater Admin');
    Route::get('/getUsers', 'UsersController@getUsers')->name('get.users')
    ->middleware('role:Administrator|Call Center Direktor|Broker Direktor|Agent Team Leader|Berater Team Leader|Call Center Admin|Berater Admin');
    Route::get('users/{user}/confirm', 'UsersController@confirm')->name('confirm');
    Route::get('users/{user}/unconfirm', 'UsersController@unconfirm')->name('unconfirm');
    Route::get('/users/{user}/edit', 'UsersController@edit')->name('edit.user')
    ->middleware('role:Administrator|Call Center Direktor|Broker Direktor|Berater Team Leader|Call Center Admin|Berater Admin|Agent Team Leader');
    Route::post('/users/{user}', 'UsersController@update')->name('update.user')
    ->middleware('role:Administrator|Call Center Direktor|Broker Direktor|Agent Team Leader|Berater Team Leader|Call Center Admin|Berater Admin');
    Route::delete('/users/{user}/delete', 'UsersController@destroy')->name('delete.users')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::post('/users/{user}/company_logo_delete/{company_logo}', 'UsersController@deleteCompanyLogo')->name('delete.company_logo');
    Route::post('/users/{user}/upload','UsersController@uploadCompanyLogo')->name('upload.company_logo');

    Route::get('/createAppointment', 'AppointmentsController@createAppointment')->name('create.appointment');
    Route::post('/createAppointment', 'AppointmentsController@storeAppointment')->name('store.appointment');

    Route::get('/appointments', 'AppointmentsController@showAppointments')->name('show.appointment');
    Route::get('/getAppointments', 'AppointmentsController@getAppointments')->name('get.appointments');
    Route::get('/appointment/{appointment}/edit', 'AppointmentsController@edit')->name('edit.appointment');
    Route::post('/appointment/{appointment}', 'AppointmentsController@update')->name('update.appointment');
    Route::post('/appointments/agentSearch','AppointmentsController@searchAgents')->name('select.agent');
    Route::post('/appointments/assign','AppointmentsController@assignTo')->name('assign.to');
    Route::delete('/appointment/{appointment}/delete', 'AppointmentsController@destroy')->name('deleteAppointment')->middleware('role:Administrator');

    Route::post('/appointment/{appointment}/delete/{image}', 'AppointmentsController@deleteImage')->name('delete.image');
    Route::post('/appointment/{appointment}/upload','AppointmentsController@uploadImage')->name('upload.image');
    //Date Filter for Appointments
    Route::post('/getAppointment/time', 'AppointmentsController@AppointmentsTimeFilter')->name('get.AppointmentsTimeFilter');

    Route::post('/import-excel','AppointmentsController@import_excel')->name('import_excel')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::get('/singleExcel/{appointment}','AppointmentsController@single_excel')->name('single_excel')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::get('/exportall','AppointmentsController@export_all')->name('export_all')->middleware('role:Administrator|Call Center Admin|Berater Admin');

    //Appointments Feedback
    Route::post('/appointment-feedback/{appointment}','AppointmentsController@storeFeedback')->name('store.feedback');
    Route::get('/feedback/{appointment}/get', 'AppointmentsController@getDataFeedbacks');

    Route::get('/feedback/{appointment}/history', 'AppointmentsController@getDataFeedbackHistory');
    Route::get('/feedback/{appointment}/count', 'AppointmentsController@getDataFeedbackCount');
    Route::get('/feedback/{feedback}/files', 'AppointmentsController@getFeedbackFiles');
    Route::delete('/appointment/{id}/feedback/delete', 'AppointmentsController@destroyFeedback')->middleware('role:Administrator');

    Route::patch('/appointment/{id}/comment/edit', 'AppointmentsController@commentUpdate');
    Route::delete('/appointment/{id}/comment/delete', 'AppointmentsController@commentDelete');

    Route::get('/mail', 'MailSetupController@index')->name('mail')->middleware('role:Administrator');
    Route::post('/mailConfig', 'MailSetupController@store')->name('mailConfig')->middleware('role:Administrator');
    Route::post('/mailConfig/{mail}', 'MailSetupController@update')->name('updateMail')->middleware('role:Administrator');

    Route::get('/kundens', 'KundensController@index')->name('kunden.index');
    Route::get('/getKunden', 'KundensController@getKunden')->name('get.kunden');
    Route::get('/createKunden', 'KundensController@create')->name('create.kunden');
    Route::post('/createKunden', 'KundensController@store')->name('store.kunden');
    Route::post('/createKunden/companiesSearch','KundensController@searchCompanies')->name('select.company');
    Route::post('/createKunden/franchiseSearch','KundensController@searchfranchises')->name('select.franchise.details');
    Route::post('/createKunden/CompaniesSearch','KundensController@searchFromCompanies')->name('select.inputs.from.companies');
    Route::get('/kunden/{kunden}/edit', 'KundensController@edit')->name('edit.kunden');
    Route::post('/kunden/{kunden}', 'KundensController@update')->name('update.kunden');

    // Create Partners
    Route::get('partner', 'UsersController@dataTablePartners')->name('get.partners')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::get('/partners/create', 'UsersController@createPartners')->name('createPartners')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::get('/partners/index', 'UsersController@indexPartners')->name('indexPartners')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::post('/partners/store', 'UsersController@storePartners')->name('storePartners')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::delete('/partners/{DirectorPartner}/delete', 'UsersController@destroyPartners')->name('deletePartner')->middleware('role:Administrator');

    //Leads Routes
    Route::get('/leads', 'LeadsController@index')->name('leads.index');
    Route::get('/getleads', 'LeadsController@getLead')->name('get.lead');
    Route::get('/createLead', 'LeadsController@create')->name('create.lead');
    Route::post('/createLead', 'LeadsController@store')->name('store.lead');
    Route::get('/leads/{lead}/edit', 'LeadsController@edit')->name('edit.lead');
    Route::post('/leads/{lead}', 'LeadsController@update')->name('update.lead')->middleware('role:Administrator|Call Center Admin|Berater Admin|Call Center Direktor|Broker Direktor|Quality Controll');
    Route::post('/leadstime', 'LeadsController@LeadsTimeFilter')->name('get.LeadsTimeFilter');
    Route::get('/leads/{lead}/status/show', 'LeadsController@showStatusLeads');
    Route::post('/leads/{lead}/status/store', 'LeadsController@storeStatusLeads');
    Route::delete('/lead/{lead}/delete', 'LeadsController@destroy')->name('deleteLead')->middleware('role:Administrator');
    Route::get('/single-export/{lead}', 'LeadsController@single_export')->name('single_export')->middleware('role:Administrator|Call Center Admin|Berater Admin');
    Route::get('/exportall-lead','LeadsController@exportall_lead')->name('exportall_lead')->middleware('role:Administrator|Call Center Admin|Berater Admin');

    Route::patch('/lead/{id}/comment/edit', 'LeadsController@commentUpdate');
    Route::delete('/lead/{id}/comment/delete', 'LeadsController@commentDelete');

    Route::post('/lead/leadAgentSearch','LeadsController@searchLeadAgents')->name('select.leadAgent');
    Route::post('/lead/leadAssign','LeadsController@assignTo')->name('leadAssign.to');

});

