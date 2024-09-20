<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogPostController;
use Illuminate\Support\Str;

Route::middleware('auth:api')->group(function () {
    Route::get('/posts', [BlogPostController::class, 'index']);
    Route::post('/posts', [BlogPostController::class, 'store']);
    Route::get('/posts/{id}', [BlogPostController::class, 'show']);
    Route::put('/posts/{id}', [BlogPostController::class, 'update']);
    Route::delete('/posts/{id}', [BlogPostController::class, 'destroy']);
});
Route::get('/redirect', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));

    $query = http_build_query([
        'client_id' => 'client-id',
        'redirect_uri' => 'http://third-party-app.com/callback',
        'response_type' => 'code',
        'scope' => '',
        'state' => $state
    ]);

    return redirect('http://passport-app.test/oauth/authorize?'.$query);
});
Route::get('/login', function () {
    return response()->json([
        'error' => 'Unauthorized',
        'message' => '401 Unauthorized action.',
    ], 401);
})->name('login');
