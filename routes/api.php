<?
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ===== Authentication =====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//=================================
Route::middleware('auth:api')->group(function () {
    // Orders
    Route::get('/orders', [OrderController::class,'index']);
    Route::get('/orders/{id}', [OrderController::class,'show']);
    Route::post('/orders', [OrderController::class,'store']);
    Route::put('/orders/{id}', [OrderController::class,'update']);
    Route::delete('/orders/{id}', [OrderController::class,'destroy']);

    // Payments
    Route::get('/payments', [PaymentController::class,'index']);
    Route::get('/orders/{id}/payments', [PaymentController::class,'orderPayments']);
    Route::post('/payments', [PaymentController::class,'processPayment']);
});



?>

