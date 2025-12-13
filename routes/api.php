<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Photo;

// Endpoint API Sederhana
Route::get('/photos', function () {
    $photos = Photo::all();
    
    return response()->json([
        'status' => 'success',
        'message' => 'List Data Foto Jonas',
        'data' => $photos
    ], 200);
});