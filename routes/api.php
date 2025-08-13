<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// routes/web.php ATAU routes/api.php (disarankan di api.php)
use App\Http\Controllers\MidtransWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route ini TIDAK perlu middleware 'auth' karena diakses oleh Midtrans langsung
Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
