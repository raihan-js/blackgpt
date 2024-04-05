<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chat\ChatController;

Route::view('/', 'landing');
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');


Route::get('chat', [ChatController::class, 'chatView'])->middleware(['auth'])->name('chat');
Route::post('/chat/completion', [ChatController::class, 'chatCompletion'])->name('chat.completion');
Route::post('/chat/start-new-session', [ChatController::class, 'startNewSession'])->name('chat.startNewSession');
Route::get('/chat/history', [ChatController::class, 'fetchConversationHistory'])->name('chat.history');
Route::get('/chat/session/{sessionId}', [ChatController::class, 'fetchSessionConversations'])->name('chat.sessionConversations');


require __DIR__.'/auth.php';
