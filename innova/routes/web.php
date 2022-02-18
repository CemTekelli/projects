<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\InstaController;
use App\Http\Controllers\PartenerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestimonialController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;



//---------------------------- FRONT ----------------------------
Route::get('/', [AllController::class, 'home'])->name('home');
Route::get('/about', [AllController::class, 'about'])->name('about');
Route::get('/contact', [AllController::class, 'contact'])->name('contact');
Route::get('/product-indoor', [AllController::class, 'productIndoor'])->name('indoor');
Route::get('/product-indoor/{slug}', [AllController::class, 'productShow'])->name('product');
Route::get('/product-outdoor', [AllController::class, 'productOutdoor'])->name('outdoor');
    //range price
Route::post('/product-indoor/range', [AllController::class, 'range'])->name('ayhan');
Route::get('/faq', [AllController::class, "faq"])->name('faq');
Route::get('/moving', [AllController::class, "moving"])->name('moving');
    //Search
Route::get('/product/search', [AllController::class, 'search'])->name('search');
    // send mail
Route::post('admin/contact/store', [ContactController::class, 'store'])->name('contact.store');
    // add comments
Route::post('/admin/comment/store', [CommentController::class, 'store'])->name('comment.store');
    //change lang
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
    //catalogue
Route::get('/catalogue', [AllController::class, "catalogue"])->name('catalogue');

//---------------------------- BACK ADMIN ----------------------------
Route::get('/admin/dashboard', [AdminController::class, 'admin'])->middleware(['auth'])->name('admin');
Route::middleware(['auth', 'admin'])->group(function () {
        // Products
    Route::get('/admin/products-indoor', [ProductController::class, 'index'])->name('product.index'); 
    Route::get('/admin/products-outdoor', [ProductController::class, 'outdoor'])->name('product.outdoor'); 
    Route::get('/admin/product/{product}/show', [ProductController::class, 'show'])->name('product.show');
    Route::get('admin/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/admin/product/search', [ProductController::class, 'search'])->name('search.back');
    Route::post('admin/product/store-product', [ProductController::class, 'store'])->name('product.store');
        // products-image-crop (apart)
    Route::post('crop',[ProductController::class, 'store_image'])->name('crop.store');
    Route::get('img-all',[ProductController::class, 'getimage'])->name('img.get');
    Route::get('remove-img/{i}', [ProductController::class, "destroy_img"])->name('img.destroy');
    Route::get('admin/product/store-product/rollback/{name}', [ProductController::class, 'rollback'])->name('product.rollback');
    Route::get('admin/product/store-product/cancel', [ProductController::class, 'cancel'])->name('product.cancel');
        //Porduct crud 
    Route::put('admin/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('admin/product/{id}/img-update', [ProductController::class, 'image_update'])->name('image.update');
    Route::delete('/admin/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.delete');
        //Comments
    Route::get('/admin/comments-products', [CommentController::class, 'index'])->name('comment.index'); 
        //Users
    Route::get('/admin/users', [AdminController::class, "users"])->name('users.index');
        //OPIGNION
    Route::resource('/admin/testimonial', TestimonialController::class);
        //FAQ
    Route::resource('/admin/faq', FaqController::class);
        //INSTA
    // Route::resource('/admin/instagram', InstaController::class);
    Route::get('/admin/instagram', [InstaController::class, "index"])->name('instagram.index');
    Route::post('admin/instagram/store', [InstaController::class, 'store'])->name('instagram.store');
    Route::post('/admin/instagram/{id}', [InstaController::class, 'destroy'])->name('instagram.destroy');
        //Parteners
    Route::get('/admin/parteners', [PartenerController::class, "index"])->name('parteners.index');
    Route::get('/admin/parteners/{id}/delete', [PartenerController::class, "destroy"])->name('parteners.destroy');
    Route::post('/admin/parteners/create',[PartenerController::class, 'store'])->name('parteners.store');
        //About
    Route::resource('/admin/about', AboutController::class);
        //Contact
    Route::get('/admin/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/admin/contact/destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');

});
// Route::resource('/admin/contact', ContactController::class);








//---------------------------- AUTH ----------------------------
require __DIR__.'/auth.php';




// //EXEMPLE
// Route::get('/admin/skills', [SkillController::class, 'index'])->name('skill.index');
// Route::get('/admin/skills/{id}/show', [SkillController::class, 'show'])->name('skill.show');
// Route::delete('/admin/skills/{id}/delete', [SkillController::class, 'destroy'])->name('skill.delete');
// Route::get('admin/skills/create', [SkillController::class, 'create'])->name('skill.create');
// Route::post('admin/skills/store', [SkillController::class, 'store'])->name('skill.store');
// Route::get('admin/skills/{id}/edit', [SkillController::class, 'edit'])->name('skill.edit');
// Route::put('admin/skills/{id}/update', [SkillController::class, 'update'])->name('skill.update');