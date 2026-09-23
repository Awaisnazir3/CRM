<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CdrController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DidController;
use App\Http\Controllers\LnpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SipServerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\CrmAuth;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/quick-login', [AuthController::class, 'quickLogin'])->name('login.quick');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Protected CRM Routes
Route::middleware([CrmAuth::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // DID Inventory Management
    Route::prefix('dids')->name('dids.')->group(function () {
        Route::get('/', [DidController::class, 'index'])->name('index');
        Route::get('/allocate', [DidController::class, 'allocate'])->name('allocate');
        Route::post('/allocate', [DidController::class, 'storeAllocation'])->name('allocate.store');
        Route::get('/bulk-allocation', [DidController::class, 'bulkAllocation'])->name('bulk-allocation');
        Route::post('/bulk-allocation', [DidController::class, 'storeBulkAllocation'])->name('bulk-allocation.store');
        Route::get('/allocation-history', [DidController::class, 'allocationHistory'])->name('allocation-history');
        Route::get('/requested', [DidController::class, 'requestedDids'])->name('requested');
        Route::get('/approval-queue', [DidController::class, 'approvalQueue'])->name('approval-queue');
        Route::get('/ready-to-commit', [DidController::class, 'readyToCommit'])->name('ready-to-commit');
        Route::get('/monthly-reconciliation', [DidController::class, 'monthlyReconciliation'])->name('monthly-reconciliation');
        Route::get('/create', [DidController::class, 'create'])->name('create');
        Route::post('/', [DidController::class, 'store'])->name('store');
        Route::get('/{id}', [DidController::class, 'show'])->name('show');
        Route::put('/{id}', [DidController::class, 'update'])->name('update');
        Route::post('/{id}/change-route', [DidController::class, 'changeRoute'])->name('change-route');
        Route::post('/{id}/release', [DidController::class, 'releaseDid'])->name('release');
        Route::post('/{id}/toggle-suspend', [DidController::class, 'toggleSuspend'])->name('toggle-suspend');
    });

    // API JSON Lookups for Modals & Quick Search
    Route::get('/api/buyers/search', [DidController::class, 'searchBuyers'])->name('api.buyers.search');
    Route::get('/api/dids/search', [DidController::class, 'searchDids'])->name('api.dids.search');

    // Customer CRM
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
    });

    // Vendor Management
    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('index');
        Route::get('/{id}', [VendorController::class, 'show'])->name('show');
    });

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{oid}', [OrderController::class, 'show'])->name('show');
    });

    // Billing & Financial Ledgers
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');

    // VoIP Call Detail Records (CDRs)
    Route::prefix('cdrs')->name('cdrs.')->group(function () {
        Route::get('/', [CdrController::class, 'index'])->name('index');
        Route::get('/{id}', [CdrController::class, 'show'])->name('show');
    });

    // Support Desk & Complaints
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('/{id}', [TicketController::class, 'show'])->name('show');
        Route::post('/{id}/reply', [TicketController::class, 'reply'])->name('reply');
        Route::post('/{id}/toggle-status', [TicketController::class, 'toggleStatus'])->name('toggle-status');
    });

    // LNP Number Porting
    Route::prefix('lnp')->name('lnp.')->group(function () {
        Route::get('/', [LnpController::class, 'index'])->name('index');
        Route::put('/{id}', [LnpController::class, 'update'])->name('update');
    });

    // VoIP Servers & SIP Trunks
    Route::get('/servers', [SipServerController::class, 'index'])->name('servers.index');

    // Telecom Analytics & Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Tools & Utilities
    Route::prefix('tools')->name('tools.')->group(function () {
        Route::get('/node-stats', [ToolsController::class, 'nodeStats'])->name('node-stats');
        Route::get('/api-logs', [ToolsController::class, 'apiLogs'])->name('api-logs');
        Route::get('/buyer-history', [ToolsController::class, 'buyerHistory'])->name('buyer-history');
    });
    Route::get('/reports/node-stats', [ToolsController::class, 'nodeStats']);
});
