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
Route::get('/auth/social/{provider}', 'SocialAuthController@providerRedirect');
Route::get('/auth/{provider}/callback', 'SocialAuthController@providerRedirectCallback');
Route::get('form/request-for-agent', 'FormController@requestForAgent');
Route::post('form/process-request-for-agent', 'FormController@createRequestForAgent');
Route::get('form/bank-account-change', 'FormController@requestForBankAccountchange');
Route::post('form/process-bank-account-change', 'FormController@createBankAccountChange');
Route::get('form/payment-pending-issue', 'FormController@paymentPendingissue');
Route::post('form/process-payment-pending-issue', 'FormController@createPaymentPendingIssue');
Route::get('form/merchant-revisit', 'FormController@merchantRevisit');
Route::post('form/process-merchant-revisit', 'FormController@createMerchantRevisit');
Route::get('form/thanks', 'FormController@thanks');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('getimg', 'FormController@getImageFromS');
    Route::get('getfosimages', 'FosController@getFosImages');
});
    Route::get('storage/{filename}', function ($filename)
    {
        $path = storage_path('app/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });
    Route::get('support/{filename}', function ($filename)
    {
        $path = storage_path('app/support/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });
Route::get('merchant-photos/{filename}', function ($filename)
{
    $path = storage_path('app/merchant-photos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
    Route::get('files/{filename}', function ($filename)
    {
        $path = storage_path($filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });


Route::get('/{vue?}', function () {
    return view('home');
})->where('vue', '[\/\w\.-]*')->name('home');
