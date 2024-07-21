<?php
//class Admin
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\User\AccountUserController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
//class user
use App\Http\Controllers\User\HomeUserController;
use App\Http\Controllers\User\ProductUserController;
use App\Http\Controllers\User\ServiceUserController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\checkOutController;
use App\Http\Controllers\User\BookingUserController;
use App\Http\Controllers\User\OrderUserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('test1', function () {
//     return view('Admin.Home');
// });
Route::get('test', [TestController::class, 'index'])->name('User.test');
Route::post('test', [TestController::class, 'store'])->name('test.store');
//user view
Route::group(['namespace' => 'User', 'prefix' => ''], function () {
    //phải đăng nhập mới được truy cập
    Route::middleware('checkLoginUser')->group(function () {
        //infor user
        Route::get('infor', [AccountUserController::class, 'inforUser'])->name('user.infor');
        Route::PUT('infor/{id}', [AccountUserController::class, 'updateInfor'])->name('user.updateInfor');
        //Change pass
        Route::get('changePass', [AccountUserController::class, 'changePassForm'])->name('user.changePassForm');
        Route::put('changePass', [AccountUserController::class, 'ChangePass'])->name('user.changePass');
        //log out
        Route::get('logout', [AccountUserController::class, 'logOut'])->name('user.logout');
        //booking
        Route::post('book', [BookingController::class, 'store'])->name('user.bookCreate');
        //cart checkout
        Route::get('cart/checkout', [CartController::class, 'checkout'])->name('user.checkout');
        Route::post('cart/checkout', [checkOutController::class, 'confirmCheckOut'])->name('user.confirmCheckOut');
        //follow orrder
        Route::get('order', [OrderUserController::class, 'index'])->name('user.orderView');
        Route::put('order/updateBook/{id}', [BookingController::class, 'update'])->name('user.updateBooking');
        Route::get('order/destroyBook/{id}', [BookingController::class, 'destroy'])->name('user.destroyBook');
    });

    Route::get('loginUser', [AccountUserController::class, 'index'])->name('user.login');
    // Route::post('login', [AccountUserController::class, 'login'])->name('user.checkAccount');
    Route::post('loginUser', [AccountUserController::class, 'loginCheck'])->name('user.checkLogin');

    Route::get('registerUser', [AccountUserController::class, 'registerForm'])->name('user.register');
    Route::post('registerUser', [AccountUserController::class, 'register'])->name('user.registAccount');

    Route::get('/', [HomeUserController::class, 'index'])->name('user.home');
    Route::get('about', function () {
        return view('User.about');
    })->name('user.about');
    Route::get('service', [ServiceUserController::class, 'index'])->name('user.service');
    //product
    Route::get('product/{id}', [ProductUserController::class, 'index'])->name('user.product');
    // Route::get('product/{id}', [ProductUserController::class, 'getProduct'])->name('user.getPro');
    Route::get('product/detail/{id}', [ProductUserController::class, 'getDetail'])->name('user.productDetail');
    Route::get('sort', [ProductUserController::class, 'Product'])->name('user.sortproduct');
    // Route::get('product/nam', [ProductUserController::class, 'SortProduct'])->name('user.sort');

    //comment
    Route::post('product/detail/{id}', [CommentController::class, 'store'])->name('user.comment');
    //booking
    Route::get('book', [BookingUserController::class, 'index'])->name('user.book');
    //contact
    Route::get('contact', function () {
        return view('User.contact');
    })->name('user.contact');
    //Cart
    Route::get('cart', [CartController::class, 'index'])->name('user.cart');
    Route::get('cart/addPro/{id}', [CartController::class, 'add'])->name('user.add');
    Route::get('cart/destroy', [CartController::class, 'destroyCart'])->name('user.destroyCart');
    Route::post('cart/update', [CartController::class, 'update'])->name('user.cartupdate');
    Route::get('cart/delete/{id}', [CartController::class, 'delete'])->name('user.delete');
});

//admin view
Route::get('admin/login', function () {
    return view('Admin.pages-login');
})->name('admin.login');
//post đăng nhập
Route::post('login', [UserController::class, 'checkLogin'])->name('admin.checkLogin');
//post đăng ký tài khoản
Route::prefix('admin')->middleware('checkLogin::class')->group(function () {
    //register
    Route::get('register', function () {
        return view('Admin.register');
    });
    //changepass
    Route::post('changePass', [UserController::class, 'changePass'])->name('admin.changePass');
    //updateProfile
    Route::post('updateProfile', [UserController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::post('register', [UserController::class, 'store'])->name('admin.register');
    //profile
    Route::get('profile', [UserController::class, 'profile'])->name('admin.profile');
    //Home
    Route::get('', [HomeController::class, 'index'])->name('admin.home');
    //Quan ly account
    Route::get('account', [UserController::class, 'index'])->name('admin.manageAccount');
    Route::get('account/{id}', [UserController::class, 'destroy'])->name('admin.destroy');
    //log out
    Route::get('logout', [UserController::class, 'logOut'])->name('admin.logout');
    //product
    Route::get('product', [ProductController::class, 'index'])->name('admin.product');
    Route::post('product/add', [ProductController::class, 'store'])->name('admin.createProduct');
    //load view form thêm mới sản phẩm
    Route::get('product/add', [ProductController::class, 'create'])->name('admin.addForm');
    Route::get('product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.deleteProduct');
    Route::get('product/change/{id}', [ProductController::class, 'edit'])->name('admin.changeProductView');
    Route::put('product/change/{id}', [ProductController::class, 'update'])->name('admin.updateProduct');
    //customer
    Route::get('customer', [CustomerController::class, 'index'])->name('admin.customer');
    //staff
    Route::get('staff', [StaffController::class, 'index'])->name('admin.staff');
    Route::get('staff/create', [StaffController::class, 'create'])->name('admin.staffCreate');
    Route::post('staff/store', [StaffController::class, 'store'])->name('admin.staffStore');
    Route::get('satff/destroy/{id}', [StaffController::class, 'destroy'])->name('admin.staffDestroy');
    Route::get('staff/edit/{id}', [StaffController::class, 'edit'])->name('admin.staffEdit');
    Route::put('staff/edit/{id}', [StaffController::class, 'update'])->name('admin.staffUpdate');
    //category
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('category/add', [CategoryController::class, 'create'])->name('admin.categoryForm');
    Route::post('category/add', [CategoryController::class, 'store'])->name('admin.createCat');
    Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.deleteCat');
    Route::PUT('category/update/{id}', [CategoryController::class, 'update'])->name('admin.updateCat');
    //service
    Route::get('service', [ServiceController::class, 'index'])->name('admin.service');
    Route::get('service/add', [ServiceController::class, 'create'])->name('admin.serviceAddView');
    Route::post('service/add', [ServiceController::class, 'store'])->name('admin.AddService');
    Route::get('service/change/{id}', [ServiceController::class, 'edit'])->name('admin.change');
    Route::get('service/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.deleteService');
    Route::post('service/change/{id}', [ServiceController::class, 'update'])->name('admin.updateService');
    //order
    Route::get('order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('order/detail/{id}', [OrderController::class, 'detail'])->name('admin.detail');
    Route::get('order/delivery/{id}', [OrderController::class, 'delivery'])->name('admin.delivery');
    Route::get('order/delete/{id}', [OrderController::class, 'destroy'])->name('admin.deleteOrder');
    //book
    Route::get('book', [BookingController::class, 'index'])->name('admin.book');
    Route::get('book/detail/{id}', [BookingController::class, 'detail'])->name('admin.bookDetail');
    Route::get('book/update/{id}', [BookingController::class, 'confirmBook'])->name('admin.bookConfirm');
    Route::get('book/cancel/{id}', [BookingController::class, 'UnConfirmBook'])->name('admin.bookUnConfirm');

    //banner
    Route::get('banner', [BannerController::class, 'index'])->name('admin.banner');
    Route::get('banner/create', [BannerController::class, 'create'])->name('admin.bannerCreate');
    Route::post('banner/create', [BannerController::class, 'store'])->name('admin.bannerStore');
});
/*Route::get('/', function () {
    return view('welcome');
});*/
