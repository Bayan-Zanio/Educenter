<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CoursesController;

use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\CoursesController as ApiCoursesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursesController as ControllersCoursesController;
use App\Http\Controllers\CourseSingleController;
use App\Models\Category;
use App\Http\Middleware\CheckUserType;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', [HomeController::class,'index']);
Route::get('/contact', [ContactController::class,'index']);
Route::get('/events', [ContactController::class,'events']);
Route::get('/courses', [HomeController::class,'show']);
Route::get('/about', [HomeController::class,'about']);
Route::get('coursesingle/{slug}' , [ControllersCoursesController::class, 'show'])->name('coursesingle');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::namespace('Admin')
->prefix('admin')
->as('admin.')
->middleware('auth','user.type:admin')
->group(function()
{
    Route::group([
        'prefix'=>'categories',
        'as'=>'categories.',
    ],function()
    {
        Route::get('/',[CategoriesController::class,'index'])->name('index');
        Route::get('/create','CategoriesController@create')->name('create');
        Route::get('/(id)','CategoriesController@show')->name('show');
    
        
        Route::post('/',[CategoriesController::class,'store'])->name('store');
        Route::get('/{id}/edit',[CategoriesController::class,'edit'])->name('edit');
        Route::put('/{id}',[CategoriesController::class,'update'])->name('update');
        Route::delete('/{id}',[CategoriesController::class,'destroy'])->name('destroy');
    }
    );

    Route::get('categories/trash' , [CategoriesController::class , 'trash'])->name('categories.trash');
    Route::put('categories/trash/{id}' , [CategoriesController::class , 'restore'])->name('categories.restore');
    Route::delete('categories/trash/{id}' , [CategoriesController::class , 'forceDelete'])->name('categories.force-delete');
    Route::get('courses/trash' , [CoursesController::class , 'trash'])->name('courses.trash');
    Route::put('courses/trash/{id}' , [CoursesController::class , 'restore'])->name('courses.restore');
    Route::delete('courses/trash/{id}' , [CoursesController::class , 'forceDelete'])->name('courses.force-delete');
    Route::resources([
        'categories' => 'CategoriesController',
        'courses' => 'CoursesController',
        'roles' => 'RolesController'
    ]);

    /*Route::resource('categories','CategoriesController');


    Route::resource('products','ProductsController')->names([
        'index'=>'products.index'
    ]);

    Route::resource('roles','RolesController');*/

});
