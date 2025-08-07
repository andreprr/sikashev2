<?php

use Illuminate\Support\Facades\Route;
$controller_path = 'App\Http\Controllers';

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

/*
Route::get('/', function () {
    return redirect()->route('home');
});



*/

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/auth/signurl', $controller_path . '\authentications\AuthController@signurl')->name('auth-signurl');

Route::get('/auth/loginurl', $controller_path . '\authentications\AuthController@loginurl')->name('auth-loginurl');

Route::get('/custom/verify-email', $controller_path . '\Auth\EmailVerificationController@verifyEmail')->name('verification.custom.verify');

Route::get('/email/verify/{id}/{hash}', $controller_path . '\Auth\EmailVerificationController@verify')
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/resend', $controller_path . '\Auth\EmailVerificationController@resend')
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

Route::get('password/reset', $controller_path . '\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', $controller_path . '\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', $controller_path . '\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', $controller_path . '\Auth\ResetPasswordController@reset')->name('password.update');
    
Route::get('/', $controller_path . '\prestasi\AppController@index')->name('landing');
Route::get('/app/detailCourse/{slug}', $controller_path . '\mooc\AppController@detailCourse')->name('app-detail-course');
Route::middleware(['auth:sanctum', 'verified','profile'])->get('/app/enroll/{course_id}', $controller_path . '\mooc\AppController@enroll')->name('app-enroll');
Route::get('/app/progress/{coursemember_id}', $controller_path . '\mooc\AppController@progress')->name('app-progress');

//Auth
Route::get('/auth/login', $controller_path . '\authentications\AuthController@login')->name('auth');
Route::post('/auth/login', $controller_path . '\authentications\AuthController@dologin')->name('auth-dologin');

Route::get('/auth/signup', $controller_path . '\authentications\AuthController@signup')->name('sign-up');

Route::post('/auth/signup', $controller_path . '\authentications\AuthController@dosignup')->name('auth-sign-up');

Route::get('/certificate', $controller_path . '\mooc\CourseMemberController@certificate')->name('certificate');

Route::get('/certificatepdf', $controller_path . '\mooc\CourseMemberController@generatePDF')->name('generatePDF');
    
Route::middleware('auth:sanctum')->post('/auth/logout', $controller_path . '\authentications\AuthController@logout')->name('auth-logout');

//manage
Route::middleware(['auth:sanctum', 'verified','profile'])->group(function () use ($controller_path) {
    //dashboard
    Route::get('/dashboard', $controller_path . '\manage\DashboardController@index')->name('home');

    //profile
    //Profile
    Route::get('/myprofile', $controller_path . '\user\ProfileController@index')->name('profile-index');
    Route::post('/myprofile/update', $controller_path . '\user\ProfileController@update')->name('profile-update');

    //Users
    Route::get('/user', $controller_path . '\user\UserController@index')->name('user-index');
    Route::get('/user/create', $controller_path . '\user\UserController@create')->name('user-create');
    Route::get('/user/edit/{id}', $controller_path . '\user\UserController@edit')->name('user-edit');
    Route::get('/user/role', $controller_path . '\user\RoleController@index')->name('role-index');
    Route::get('/user/role/create', $controller_path . '\user\RoleController@create')->name('role-create');
    Route::get('/user/role/edit/{id}', $controller_path . '\user\RoleController@edit')->name('role-edit');

    Route::put('/user/verifymanual/{id}', $controller_path . '\user\UserController@verifymanual')->name('user-verifymanual');
    Route::post('/user/store', $controller_path . '\user\UserController@store')->name('user-store');
    Route::put('/user/update/{id}', $controller_path . '\user\UserController@update')->name('user-update');
    Route::put('/user/changestatus/{id}', $controller_path . '\user\UserController@changestatus')->name('user-changestatus');
    Route::delete('/user/destroy/{id}', $controller_path . '\user\UserController@destroy')->name('user-destroy');
    Route::post('/user/role/store', $controller_path . '\user\RoleController@store')->name('role-store');
    Route::put('/user/role/update/{id}', $controller_path . '\user\RoleController@update')->name('role-update');
    Route::post('/user/resetlogin', $controller_path . '\user\UserController@resetlogin')->name('user-resetlogin');

    //Course
    Route::get('/course', $controller_path . '\mooc\CourseController@index')->name('course-index');
    Route::get('/course/create', $controller_path . '\mooc\CourseController@create')->name('course-create');
    Route::get('/course/edit/{id}', $controller_path . '\mooc\CourseController@edit')->name('course-edit');

    Route::post('/course/store', $controller_path . '\mooc\CourseController@store')->name('course-store');
    Route::put('/course/update/{id}', $controller_path . '\mooc\CourseController@update')->name('course-update');
    Route::put('/course/changestatus/{id}', $controller_path . '\mooc\CourseController@changestatus')->name('course-changestatus');
    //changeStatusSection
    Route::put('/course/changestatussection/{id}', $controller_path . '\mooc\CourseController@changeStatusSection')->name('section-changestatus');
    Route::delete('/course/destroysection/{id}', $controller_path . '\mooc\CourseController@destroySection')->name('section-destroy');
    

    Route::delete('/course/destroy/{id}', $controller_path . '\mooc\CourseController@destroy')->name('course-destroy');

    Route::post('/course/section/store', $controller_path . '\mooc\CourseController@storeSection')->name('course-section-store');
    Route::get('/course/section/edit/{id}', $controller_path . '\mooc\CourseController@editSection')->name('course-section-edit');
    
    //membercourse
    Route::get('/coursemember', $controller_path . '\mooc\CourseMemberController@index')->name('coursemember-index');
    Route::get('/coursemember/create', $controller_path . '\mooc\CourseMemberController@create')->name('coursemember-create');
    Route::get('/coursemember/edit/{id}', $controller_path . '\mooc\CourseMemberController@edit')->name('coursemember-edit');

    //riwayat course member
    Route::get('/coursemember/history', $controller_path . '\mooc\CourseMemberController@history')->name('coursemember-history');
    Route::get('/coursemember/progress', $controller_path . '\mooc\CourseMemberController@progress')->name('coursemember-progress');
    Route::get('/coursemember/certhistory', $controller_path . '\mooc\CourseMemberController@certhistory')->name('coursemember-certhistory');
    

    Route::post('/coursemember/store', $controller_path . '\mooc\CourseMemberController@store')->name('coursemember-store');
    Route::put('/coursemember/update/{id}', $controller_path . '\mooc\CourseMemberController@update')->name('coursemember-update');
    Route::put('/coursemember/changestatus/{id}', $controller_path . '\mooc\CourseMemberController@changestatus')->name('coursemember-changestatus');
    Route::delete('/coursemember/destroy/{id}', $controller_path . '\mooc\CourseMemberController@destroy')->name('coursemember-destroy');

    Route::get('/coursemonitoring', $controller_path . '\mooc\MonitoringCourseController@index')->name('coursemonitoring-index');
    Route::get('/coursemonitoring/export', $controller_path . '\mooc\MonitoringCourseController@export')->name('coursemonitoring-export');
    
    

    //ExamForm
    Route::get('/form', $controller_path . '\mooc\ExamFormController@index')->name('form-index');
    Route::get('/form/create', $controller_path . '\mooc\ExamFormController@create')->name('form-create');
    Route::get('/form/edit/{id}', $controller_path . '\mooc\ExamFormController@edit')->name('form-edit');
    Route::get('/form/show/{slug}', $controller_path . '\mooc\ExamFormController@show')->name('form-show');
    Route::get('/form/prev', $controller_path . '\mooc\ExamFormController@prev')->name('form-prev');

    Route::get('/form/getjson', $controller_path . '\mooc\ExamFormController@getjson');
    Route::put('/form/storejson/{oid}', $controller_path . '\mooc\ExamFormController@storejson');



    Route::post('/form/store', $controller_path . '\mooc\ExamFormController@store')->name('form-store');
    Route::put('/form/update/{id}', $controller_path . '\mooc\ExamFormController@update')->name('form-update');
    Route::put('/form/changestatus/{id}', $controller_path . '\mooc\ExamFormController@changestatus')->name('form-changestatus');
    Route::delete('/form/destroy/{id}', $controller_path . '\mooc\ExamFormController@destroy')->name('form-destroy');
    Route::get('/form/duplicate/{id}', $controller_path . '\mooc\ExamFormController@duplicate')->name('form-duplicate');


    //tags
    Route::get('/tag', $controller_path . '\mooc\TagController@index')->name('tag-index');
    Route::get('/tag/create', $controller_path . '\mooc\TagController@create')->name('tag-create');
    Route::get('/tag/edit/{id}', $controller_path . '\mooc\TagController@edit')->name('tag-edit');
    Route::post('/tag/store', $controller_path . '\mooc\TagController@store')->name('tag-store');
    Route::put('/tag/update/{id}', $controller_path . '\mooc\TagController@update')->name('tag-update');
    Route::delete('/tag/destroy/{id}', $controller_path . '\mooc\TagController@destroy')->name('tag-destroy');

    //tags
    Route::get('/businesscategory', $controller_path . '\mooc\BusinessCategoryController@index')->name('businesscategory-index');
    Route::get('/businesscategory/create', $controller_path . '\mooc\BusinessCategoryController@create')->name('businesscategory-create');
    Route::get('/businesscategory/edit/{id}', $controller_path . '\mooc\BusinessCategoryController@edit')->name('businesscategory-edit');
    Route::post('/businesscategory/store', $controller_path . '\mooc\BusinessCategoryController@store')->name('businesscategory-store');
    Route::put('/businesscategory/update/{id}', $controller_path . '\mooc\BusinessCategoryController@update')->name('businesscategory-update');
    Route::delete('/businesscategory/destroy/{id}', $controller_path . '\mooc\BusinessCategoryController@destroy')->name('businesscategory-destroy');

    //tags
    Route::get('/businessfield', $controller_path . '\mooc\BusinessFieldController@index')->name('businessfield-index');
    Route::get('/businessfield/create', $controller_path . '\mooc\BusinessFieldController@create')->name('businessfield-create');
    Route::get('/businessfield/edit/{id}', $controller_path . '\mooc\BusinessFieldController@edit')->name('businessfield-edit');
    Route::post('/businessfield/store', $controller_path . '\mooc\BusinessFieldController@store')->name('businessfield-store');
    Route::put('/businessfield/update/{id}', $controller_path . '\mooc\BusinessFieldController@update')->name('businessfield-update');
    Route::delete('/businessfield/destroy/{id}', $controller_path . '\mooc\BusinessFieldController@destroy')->name('businessfield-destroy');

    //Form Input
    Route::get('/forminput', $controller_path . '\form\FormInputController@index')->name('forminput-index');
    Route::get('/forminput/create', $controller_path . '\form\FormInputController@create')->name('forminput-create');
    Route::get('/forminput/submit/{uniqid}/{step_id}', $controller_path . '\form\FormInputController@submit')->name('forminput-submit');
    Route::get('/forminput/resume/{uniqid}', $controller_path . '\form\FormInputController@resume')->name('forminput-resume');
    Route::get('/forminput/reset/{uniqid}', $controller_path . '\form\FormInputController@reset')->name('forminput-reset');
    Route::post('/forminput/store/files//{uniqid}', $controller_path . '\form\FormInputController@storeFiles')->name('forminput-store-files');
    Route::put('/forminput/store/verif//{uniqid}', $controller_path . '\form\FormInputController@storeVerif')->name('forminput-store-verif');
    Route::post('/forminput/store', $controller_path . '\form\FormInputController@store')->name('forminput-store');
    Route::put('/forminput/update/{id}', $controller_path . '\form\FormInputController@update')->name('forminput-update');
    Route::post('/forminput/process-step/{uniqid}', $controller_path . '\form\FormInputController@processNextStep')->name('forminput-process-step');
    Route::post('/forminput/finish-step/{uniqid}', $controller_path . '\form\FormInputController@processFinishStep')->name('forminput-finish-step');
    Route::get('/forminput/export/{uniqid}', $controller_path . '\form\FormInputController@export')->name('forminput-export');
    
    //Exam
    Route::get('/app/exam', $controller_path . '\mooc\ExamController@index')->name('exam-index');
    Route::post('/app/do-exam', $controller_path . '\mooc\ExamController@store')->name('exam-doexam');

    //filemanager
    Route::get('/filemanager', $controller_path . '\file\FileManagerController@getfmdata')->name('getfmdata');
    Route::post('/filemanager/upload', $controller_path . '\file\FileManagerController@upload')->name('uploadfmdata');
    Route::get('/filemanager/{file}', $controller_path . '\file\FileManagerController@getfilefm')->name('getfilefm');
    Route::get('/getsectionfile/{file}', $controller_path . '\file\FileManagerController@getsectionfile')->name('getsectionfile');
    Route::get('/getfilemp3/{file}', $controller_path . '\file\FileManagerController@getfilemp3')->name('getfilemp3');

    Route::get('/getfile/{file}', $controller_path . '\file\FileManagerController@getfile')->name('getfile');


    Route::get('/event', $controller_path . '\form\EventController@index')->name('event-index');
    Route::get('/event/create', $controller_path . '\form\EventController@create')->name('event-create');
    Route::get('/event/edit/{id}', $controller_path . '\form\EventController@edit')->name('event-edit');
    Route::post('/event/store', $controller_path . '\form\EventController@store')->name('event-store');
    Route::put('/event/update/{id}', $controller_path . '\form\EventController@update')->name('event-update');
    Route::delete('/event/destroy/{id}', $controller_path . '\form\EventController@destroy')->name('event-destroy');

    Route::get('/event_step', $controller_path . '\form\EventStepController@index')->name('event_step-index');
    Route::get('/event_step/create', $controller_path . '\form\EventStepController@create')->name('event_step-create');
    Route::get('/event_step/edit/{id}', $controller_path . '\form\EventStepController@edit')->name('event_step-edit');
    Route::post('/event_step/store', $controller_path . '\form\EventStepController@store')->name('event_step-store');
    Route::put('/event_step/update/{id}', $controller_path . '\form\EventStepController@update')->name('event_step-update');
    Route::delete('/event_step/destroy/{id}', $controller_path . '\form\EventStepController@destroy')->name('event_step-destroy');

    Route::get('/step_field', $controller_path . '\form\StepFieldController@index')->name('step_field-index');
    Route::get('/step_field/create', $controller_path . '\form\StepFieldController@create')->name('step_field-create');
    Route::get('/step_field/edit/{id}', $controller_path . '\form\StepFieldController@edit')->name('step_field-edit');
    Route::post('/step_field/store', $controller_path . '\form\StepFieldController@store')->name('step_field-store');
    Route::put('/step_field/update/{id}', $controller_path . '\form\StepFieldController@update')->name('step_field-update');
    Route::delete('/step_field/destroy/{id}', $controller_path . '\form\StepFieldController@destroy')->name('step_field-destroy');

    //Pekerjaan
    Route::get('/applicantsjob', $controller_path . '\prestasi\ApplicantsJobController@index')->name('applicantsjob-index');
    Route::get('/applicantsjob/create', $controller_path . '\prestasi\ApplicantsJobController@create')->name('applicantsjob-create');
    Route::get('/applicantsjob/edit/{id}', $controller_path . '\prestasi\ApplicantsJobController@edit')->name('applicantsjob-edit');

    Route::post('/applicantsjob/store', $controller_path . '\prestasi\ApplicantsJobController@store')->name('applicantsjob-store');
    Route::put('/applicantsjob/update/{id}', $controller_path . '\prestasi\ApplicantsJobController@update')->name('applicantsjob-update');
    Route::put('/applicantsjob/destroy/{id}', $controller_path . '\prestasi\ApplicantsJobController@destroy')->name('applicantsjob-destroy');

    //Bidang Penelitian
    Route::get('/researchfield', $controller_path . '\prestasi\ResearchFieldController@index')->name('researchfield-index');
    Route::get('/researchfield/create', $controller_path . '\prestasi\ResearchFieldController@create')->name('researchfield-create');
    Route::get('/researchfield/edit/{id}', $controller_path . '\prestasi\ResearchFieldController@edit')->name('researchfield-edit');

    Route::post('/researchfield/store', $controller_path . '\prestasi\ResearchFieldController@store')->name('researchfield-store');
    Route::put('/researchfield/update/{id}', $controller_path . '\prestasi\ResearchFieldController@update')->name('researchfield-update');
    Route::put('/researchfield/destroy/{id}', $controller_path . '\prestasi\ResearchFieldController@destroy')->name('researchfield-destroy');

    //Bentuk Institusi
    Route::get('/institutioncategory', $controller_path . '\prestasi\InstitutionCategoryController@index')->name('institutioncategory-index');
    Route::get('/institutioncategory/create', $controller_path . '\prestasi\InstitutionCategoryController@create')->name('institutioncategory-create');
    Route::get('/institutioncategory/edit/{id}', $controller_path . '\prestasi\InstitutionCategoryController@edit')->name('institutioncategory-edit');

    Route::post('/institutioncategory/store', $controller_path . '\prestasi\InstitutionCategoryController@store')->name('institutioncategory-store');
    Route::put('/institutioncategory/update/{id}', $controller_path . '\prestasi\InstitutionCategoryController@update')->name('institutioncategory-update');
    Route::put('/institutioncategory/destroy/{id}', $controller_path . '\prestasi\InstitutionCategoryController@destroy')->name('institutioncategory-destroy');

    Route::get('/job', $controller_path . '\form\JobController@index')->name('job-index');
    Route::get('/job/create', $controller_path . '\form\JobController@create')->name('job-create');
    Route::get('/job/edit/{id}', $controller_path . '\form\JobController@edit')->name('job-edit');
    Route::post('/job/store', $controller_path . '\form\JobController@store')->name('job-store');
    Route::put('/job/update/{id}', $controller_path . '\form\JobController@update')->name('job-update');
    Route::delete('/job/destroy/{id}', $controller_path . '\form\JobController@destroy')->name('job-destroy');
    Route::put('/job/changestatus/{id}', $controller_path . '\form\JobController@changestatus')->name('job-changestatus');
});

Route::get('/images/{file}', $controller_path . '\file\ImageController@getimage')->name('getimage');