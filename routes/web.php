<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\SendEmailController;

Route::get('send-email', [SendEmailController::class, 'index'])->name('send-email');

$controller_path = 'App\Http\Controllers';

// authentication
Route::get('/auth/login', $controller_path . '\authentications\LoginBasic@index')->name('login')->middleware('guest');
Route::post('/auth/signin', $controller_path . '\authentications\LoginBasic@authenticate')->name('signin')->middleware('guest');
Route::post('/auth/signup', $controller_path . '\authentications\RegisterBasic@signup')->name('signup')->middleware('guest');
Route::post('/auth/reset', $controller_path . '\authentications\ForgotPasswordBasic@reset')->name('reset')->middleware('guest');



Route::get('/auth/register', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register')->middleware('guest');
Route::get('/auth/forgot-password', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    $controller_path = 'App\Http\Controllers';
    // Main Page Route
    Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard'); 
    Route::get('/auth/logout', $controller_path . '\authentications\LoginBasic@logout')->name('logout'); 
    

    //profile
    Route::get('/user/profile', $controller_path . '\user\Profile@index')->name('account-profile');
    Route::get('/user/settings', $controller_path . '\user\Profile@settings')->name('account-settings');
    Route::post('/user/update', $controller_path . '\user\Profile@update')->name('profileupdate');
    Route::post('/user/delete', $controller_path . '\user\Profile@delete')->name('profiledelete');

    // register
    Route::get('/student/register', $controller_path . '\student\Register@register')->name('student-register');
    Route::get('/student/view-registration', $controller_path . '\student\Register@register')->name('registration');
    Route::post('/student/register/save', $controller_path . '\student\Register@registerSave');
    Route::post('/student/register/update', $controller_path . '\student\Register@registerUpdate');
    Route::post('/student/register/delete', $controller_path . '\student\Register@registerDelete');


    Route::get('/student/ethical-clearance', $controller_path . '\student\EthicalClearance@index')->name('student-ethical-clearance');
    Route::post('/student/ethical-clearance/save', $controller_path . '\student\EthicalClearance@save');
    Route::post('/student/ethical-clearance/update', $controller_path . '\student\EthicalClearance@update');
    Route::post('/student/ethical-clearance/delete', $controller_path . '\student\EthicalClearance@delete');

    Route::get('/student/research-proposal', $controller_path . '\student\ResearchProposal@index')->name('student-research-proposal');
    Route::post('/student/research-proposal/save', $controller_path . '\student\ResearchProposal@save');
    Route::post('/student/research-proposal/update', $controller_path . '\student\ResearchProposal@update');
    Route::post('/student/research-proposal/delete', $controller_path . '\student\ResearchProposal@delete');
    
    Route::get('/student/seminer-week', $controller_path . '\student\SeminerWeek@index')->name('student-seminer-week');
    Route::post('/student/seminer-week/save', $controller_path . '\student\SeminerWeek@save');
    Route::post('/student/seminer-week/update', $controller_path . '\student\SeminerWeek@update');
    Route::post('/student/seminer-week/delete', $controller_path . '\student\SeminerWeek@delete');


    Route::get('/student/dissertation', $controller_path . '\student\Dissertation@index')->name('student-dissertation');
    Route::post('/student/dissertation/save', $controller_path . '\student\Dissertation@save');
    Route::post('/student/dissertation/update', $controller_path . '\student\Dissertation@update');
    Route::post('/student/dissertation/delete', $controller_path . '\student\Dissertation@delete');


    Route::get('/student/journal', $controller_path . '\student\Journal@index')->name('student-journal');
    Route::post('/student/journal/save', $controller_path . '\student\Journal@save');
    Route::post('/student/journal/update', $controller_path . '\student\Journal@update');
    Route::post('/student/journal/delete', $controller_path . '\student\Journal@delete');


    Route::get('/student/completion-letter', $controller_path . '\student\CompletionLetter@index')->name('student-completion-letter');
    Route::post('/student/completion-letter/save', $controller_path . '\student\CompletionLetter@save');


    Route::get('/student/tutorials', $controller_path . '\student\Tutorials@index')->name('tutorials');
    
    // User Interface
    Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
    Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
    Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
    Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
    Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
    Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
    Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
    Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
    Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
    Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
    Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
    Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
    Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
    Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
    Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
    Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

    // extended ui
    Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');

    // icons
    Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');

    // form elements
    Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
    Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');

    // form layouts
    Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');

    // tables
    Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');

    // form layouts
    Route::get('/supervisor/programmes', $controller_path . '\user\Programmes@index')->name('programmes');
    Route::get('/supervisor/intakes', $controller_path . '\user\Intakes@index')->name('intakes');
    Route::get('/supervisor/users', $controller_path . '\user\Users@index')->name('users');
    Route::get('/supervisor/projects', $controller_path . '\user\Projects@index')->name('projects');
    Route::get('/supervisor/project/{id}', $controller_path . '\user\Projects@project')->name('project');

});
