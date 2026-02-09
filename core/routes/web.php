<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('/ref/{ref}', function (Request $request, $ref) {
    // Store the value of the "ref" parameter in the session
    $request->session()->put('ref', $ref);

    // Redirect the user to the register page instead of home
    return redirect('/user/register');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});


Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

// Serve website index.html as root
Route::get('/', function () {
    return file_get_contents('website/index.html');
})->name('home');

// Serve website CSS files
Route::get('/css/{file}', function ($file) {
    $filePath = 'website/css/' . $file;
    if (file_exists($filePath)) {
        $mimeType = 'text/css';
        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'js') {
            $mimeType = 'application/javascript';
        } elseif (in_array(pathinfo($filePath, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'svg'])) {
            $mimeType = 'image/' . pathinfo($filePath, PATHINFO_EXTENSION);
        }
        return response()->file($filePath, ['Content-Type' => $mimeType]);
    }
    return abort(404);
});

// Serve website JS files
Route::get('/js/{file}', function ($file) {
    $filePath = 'website/js/' . $file;
    if (file_exists($filePath)) {
        return response()->file($filePath, ['Content-Type' => 'application/javascript']);
    }
    return abort(404);
});

// Serve website images
Route::get('/images/{file}', function ($file) {
    $filePath = 'website/images/' . $file;
    if (file_exists($filePath)) {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = 'image/' . $extension;
        return response()->file($filePath, ['Content-Type' => $mimeType]);
    }
    return abort(404);
})->where('file', '.*');

// Serve website fonts
Route::get('/fonts/{file}', function ($file) {
    $filePath = 'website/fonts/' . $file;
    if (file_exists($filePath)) {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = 'font/' . $extension;
        if ($extension === 'woff') {
            $mimeType = 'font/woff';
        } elseif ($extension === 'woff2') {
            $mimeType = 'font/woff2';
        }
        return response()->file($filePath, ['Content-Type' => $mimeType]);
    }
    return abort(404);
})->where('file', '.*');

// Serve other website pages
Route::get('/{any}', function ($any) {
    $filePath = 'website/' . $any;
    $fileWithHtml = $filePath . '.html';
    
    // Check if the file exists with .html extension
    if (file_exists($fileWithHtml)) {
        return file_get_contents($fileWithHtml);
    }
    
    // Check if the file exists without extension
    if (file_exists($filePath)) {
        return file_get_contents($filePath);
    }
    
    // For other routes, fall back to Laravel
    return abort(404);
})->where('any', '.*')->name('website.pages');

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit')->name('contact.submit');
    
    // API-style contact endpoint for AJAX requests
    Route::post('/api/contact-submit', 'contactSubmit')->name('api.contact.submit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    Route::get('company-policy/{id}/{slug}', 'SiteController@policy')->name('links');

    Route::get('plans', 'SiteController@plans')->name('plans');

    Route::get('blog', 'SiteController@blog')->name('blog');
    Route::get('blog-details/{id}', 'SiteController@blogDetail')->name('blogDetail');

    Route::get('/{slug}', 'pages')->name('pages');
});

// Test route for referral commission debugging
Route::get('/test-referral', 'TestController@testReferralCommission')->name('test.referral');

// Test route to force referral credit
Route::get('/test-referral-credit', function () {
    // Force a referral credit to prove the system works
    $user = \App\Models\User::where('ref_by', '!=', null)->first();
    
    if (!$user) {
        return 'No users with referrers found';
    }
    
    $referrer = \App\Models\User::find($user->ref_by);
    
    // Create a forced transaction
    $transaction = new \App\Models\Transaction();
    $transaction->user_id = $referrer->id;
    $transaction->wallet = 'referral_bonus';
    $transaction->amount = 100;
    $transaction->charge = 0;
    $transaction->trx_type = '+';
    $transaction->details = 'FORCED TEST CREDIT';
    $transaction->trx = 'test_' . time();
    $transaction->post_balance = 100;
    $transaction->save();
    
    return '✅ Forced referral credit of 100 NGN to user ' . $referrer->username . ' (ID: ' . $referrer->id . ')';
});

// Route to check current referral bonus state
Route::get('/check-referral-state', function () {
    $referralTransactions = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
    
    $output = "=== Referral Bonus State ===\n";
    $output .= "Referral bonus transactions: " . $referralTransactions . "\n";
    
    if ($referralTransactions > 0) {
        $transactions = \App\Models\Transaction::where('wallet', 'referral_bonus')->get();
        foreach ($transactions as $transaction) {
            $output .= "- User " . $transaction->user_id . ": " . $transaction->amount . " NGN (" . $transaction->details . ")\n";
        }
    }
    
    // Check admin settings
    $general = \App\Models\GeneralSetting::first();
    if ($general) {
        $output .= "\nAdmin settings:\n";
        $output .= "- Deposit commission: " . ($general->deposit_commission ? 'YES' : 'NO') . "\n";
        $output .= "- Plan subscribe commission: " . ($general->plan_subscribe_commission ? 'YES' : 'NO') . "\n";
        $output .= "- PTC view commission: " . ($general->ptc_view_commission ? 'YES' : 'NO') . "\n";
        $output .= "- Signup commission: " . ($general->signup_commission ? 'YES' : 'NO') . "\n";
    }
    
    // Check referral settings
    $referralSettings = \App\Models\Referral::all();
    $output .= "\nReferral settings: " . $referralSettings->count() . "\n";
    foreach ($referralSettings as $setting) {
        $output .= "- Type: " . $setting->commission_type . ", Level: " . $setting->level . ", Percent: " . $setting->percent . "%\n";
    }
    
    return '<pre>' . $output . '</pre>';
});

// Test referral commission routes
Route::controller('TestReferralController')->group(function () {
    Route::get('/test-commission', 'testCommission')->name('test.commission');
    Route::get('/check-state', 'checkState')->name('check.state');
});

// Fallback route must be LAST
Route::fallback(function () {
    return redirect('/');
});


