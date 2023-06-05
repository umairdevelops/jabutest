<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Group\GroupTable;
use App\Http\Livewire\Group\TaskGroup;
use App\Http\Livewire\Task\CreateTask;
use App\Http\Livewire\Task\TaskList;
use App\Http\Livewire\Login\Login;
use App\Http\Livewire\Register\Register;
use Illuminate\Support\Facades\Route;
use Laragear\WebAuthn\WebAuthn;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', TaskGroup::class)->name('/');
    Route::get('/groups', GroupTable::class)->name('groups');
    Route::get('/create/task', CreateTask::class)->name('createTask');
    Route::get('/tasks', TaskList::class)->name('tasks');
});


WebAuthn::routes();