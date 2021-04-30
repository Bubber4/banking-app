<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', function () {
    return view('welcome');
});

// Created using command:
// php artisan make:model Branch -mc
Route::get('/branch', [BranchController::class, 'index'])->name('branch.index');
Route::get('/branch/top', [BranchController::class, 'top'])->name('branch.top');
Route::get('/branch/create', [BranchController::class, 'create'])->name('branch.create');;
Route::post('/branch/create', [BranchController::class, 'store']);
Route::get('/branch/{branchId}/edit', [BranchController::class, 'edit'])->name('branch.edit');
Route::patch('/branch/{branchId}/update', [BranchController::class, 'update'])->name('branch.update');
Route::delete('/branch/{branchId}/delete', [BranchController::class, 'delete'])->name('branch.delete');

// Created using command:
// php artisan make:controller CustomerController --resource
Route::resource('customer', CustomerController::class);
Route::get('/customer/{customerId}/transfer', [CustomerController::class, 'transfer'])->name('customer.transfer');
Route::post('/customer/{customerId}/transfer', [CustomerController::class, 'transfer_to']);

/*
Here is a small 'map' about the available routes:

|        | GET|HEAD  | /                        |                  | Closure                                         | web        |
|        | GET|HEAD  | api/user                 |                  | Closure                                         | api        |
|        |           |                          |                  |                                                 | auth:api   |

|        | GET|HEAD  | branch                   | branch.index     | App\Http\Controllers\BranchController@index     | web        |
|        | GET|HEAD  | branch/create            |                  | App\Http\Controllers\BranchController@create    | web        |
|        | POST      | branch/create            |                  | App\Http\Controllers\BranchController@store     | web        |
|        | DELETE    | branch/{branchId}/delete | branch.delete    | App\Http\Controllers\BranchController@delete    | web        |
|        | GET|HEAD  | branch/{branchId}/edit   | branch.edit      | App\Http\Controllers\BranchController@edit      | web        |
|        | PATCH     | branch/{branchId}/update | branch.update    | App\Http\Controllers\BranchController@update    | web        |

|        | GET|HEAD  | customer                 | customer.index   | App\Http\Controllers\CustomerController@index   | web        |
|        | POST      | customer                 | customer.store   | App\Http\Controllers\CustomerController@store   | web        |
|        | GET|HEAD  | customer/create          | customer.create  | App\Http\Controllers\CustomerController@create  | web        |
|        | GET|HEAD  | customer/{customer}      | customer.show    | App\Http\Controllers\CustomerController@show    | web        |
|        | PUT|PATCH | customer/{customer}      | customer.update  | App\Http\Controllers\CustomerController@update  | web        |
|        | DELETE    | customer/{customer}      | customer.destroy | App\Http\Controllers\CustomerController@destroy | web        |
|        | GET|HEAD  | customer/{customer}/edit | customer.edit    | App\Http\Controllers\CustomerController@edit    | web        |

*/