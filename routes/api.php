<?php

use App\Http\Controllers\API\AssignedLeadController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\RefreshAccessToken;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\DashBoardController;
use App\Http\Controllers\API\FaceBook\MessengerController;
use App\Http\Controllers\API\IndustryController;
use App\Http\Controllers\API\InvoiceTemplateController;
use App\Http\Controllers\API\LeadController;
use App\Http\Controllers\API\LeadStageController;
use App\Http\Controllers\API\LeadTypeController;
use App\Http\Controllers\API\MarketingController;
use App\Http\Controllers\API\NeedTemplateController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OpportUnityController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\PromotionController;
use App\Http\Controllers\API\ProposalTemplateController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\RunningPromotionController;
use App\Http\Controllers\API\SaleController;
use App\Http\Controllers\API\SaleFunnelController;
use App\Http\Controllers\API\SocialInsightController;
use App\Http\Controllers\API\StageController;
use App\Http\Controllers\API\SwitchController;
use App\Http\Controllers\API\TodoController;
use App\Http\Controllers\API\ToolController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
], function () {
    // open routes
    Route::post('token', AuthController::class);

    // protected routes
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('user', [UserController::class, 'user']); // respond back with the authenticated user
        Route::get('refresh-token', RefreshAccessToken::class); // refresh the access token here

        // loads all the api resources
        Route::apiResources([
            'roles' => RoleController::class,
            'users' => UserController::class,
            'notifications' => NotificationController::class,
            'companies' => CompanyController::class,
            'leads' => LeadController::class,
            'customers' => CustomerController::class,
            'contacts' => ContactController::class,
            'lead-types' => LeadTypeController::class,
            'lead-stages' => LeadStageController::class,
            'stages' => StageController::class,
            'opportunities' => OpportUnityController::class,
            'products' => ProductController::class,
            'promotions' => PromotionController::class,
            'running-promotions' => RunningPromotionController::class,
            'sales' => SaleController::class,
            'tolls' => ToolController::class,
            'sale-funnels' => SaleFunnelController::class,
            'social-insights' => SocialInsightController::class,
            'tools' => ToolController::class,
            'todos' => TodoController::class,
            'marketings' => MarketingController::class,
            'campaigns' => CampaignController::class,
            'assign-campaigns' => AssignedLeadController::class,
            'industries' => IndustryController::class,
            'proposal-templates' => ProposalTemplateController::class,
            'invoice-templates' => InvoiceTemplateController::class,
            'need-templates' => NeedTemplateController::class,
        ]);

        // dashboards
        Route::group([
            'prefix' => 'dashboard'
        ], function () {
            Route::get('leads', [DashBoardController::class, 'leads']);
            Route::get('closed', [DashBoardController::class, 'closed']);
            Route::get('open', [DashBoardController::class, 'open']);
        });

        // switch options
        Route::group([
            'prefix' => 'switch'
        ], function () {
            Route::get('fetch', [SwitchController::class, 'fetchActiveCompany']);
            Route::get('{id}', [SwitchController::class, 'switchCompany']);
        });
    });
});


Route::group([
    'prefix' => 'facebook',
], function () {
    Route::group([
        'prefix' => 'messager',
    ], function () {
        Route::get('basic-text', [MessengerController::class, 'basicText']);
    });
});

/**
 * -----------------------
 * System Logs
 * -----------------------
 */
Route::get('sys/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
