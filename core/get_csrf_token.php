<?php
// Script to get CSRF token from Laravel application
require_once 'core/bootstrap/app.php';

use Illuminate\Support\Facades\Route;

// Create a simple route to return CSRF token
Route::get('/get-csrf-token', function() {
    return csrf_token();
})->name('get.csrf.token');

// For now, let's just output the token directly
echo csrf_token();
?>