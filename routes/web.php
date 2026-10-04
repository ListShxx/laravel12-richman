<?php

use App\Http\Controllers\AboutMeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeightController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| 1. ระบบลา (Leave Management Portal)
|--------------------------------------------------------------------------
*/

// กำหนดให้หน้าแรกสุด (/) วิ่งเข้าหน้าระบบลาโดยตรง
Route::get('/', function () {
    return redirect()->route('leave.index');
});

// หน้าหลักระบบลา (เข้าถึงได้ทุกคน)
Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');

// การยื่นลา, อนุมัติ/ปฏิเสธ, และการลบรายการ (ต้องล็อกอินก่อน)
Route::middleware('auth')->group(function () {
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    Route::patch('/leave/{leaveRequest}', [LeaveController::class, 'updateStatus'])->name('leave.updateStatus');
    Route::delete('/leave/{leaveRequest}', [LeaveController::class, 'destroy'])->name('leave.destroy');
});

// Custom Logout เมื่อออกจากระบบให้พาเด้งกลับมาที่ /leave
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/leave');
})->name('logout');


/*
|--------------------------------------------------------------------------
| 2. ระบบยืนยันตัวตน และจัดการโปรไฟล์ (Auth & Profile)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| 3. โปรเจกต์ About Me และแบบฝึกหัดอื่นๆ (แยกกลุ่มป้องกัน Route ชนกัน)
|--------------------------------------------------------------------------
*/

// หน้า About Me
Route::get('/about-me', [AboutMeController::class, 'index'])->name('about-me');

// Active Bootstrap (เปลี่ยนชื่อเป็น active.index, active.about ป้องกันปุ่ม Login ดึงไปมั่ว)
Route::prefix('active')->name('active.')->group(function () {
    Route::get('/index', function () { return view('active/index'); })->name('index');
    Route::get('/about', function () { return view('active/about'); })->name('about');
    Route::get('/services', function () { return view('active/services'); })->name('services');
    Route::get('/portfolio', function () { return view('active/portfolio'); })->name('portfolio');
    Route::get('/team', function () { return view('active/team'); })->name('team');
    Route::get('/blog', function () { return view('active/blog'); })->name('blog');
    Route::get('/contact', function () { return view('active/contact'); })->name('contact');
});

// Gallery Pages
Route::get("/gallery", function () {
    $ant = "https://cdn3.movieweb.com/i/article/Oi0Q2edcVVhs4p1UivwyyseezFkHsq/1107:50/Ant-Man-3-Talks-Michael-Douglas-Update.jpg";
    $bird = "https://images.indianexpress.com/2021/03/falcon-anthony-mackie-1200.jpg";
    $cat = "https://media.newyorker.com/photos/5a875e3f33aebd0cab9bab12/master/w_2560%2Cc_limit/Brody-Passionate-Politics-Black-Panther.jpg";
    $god = "https://www.blackoutx.com/wp-content/uploads/2021/04/Thor.jpg";
    $spider = "https://icdn5.digitaltrends.com/image/spiderman-far-from-home-poster-2-720x720.jpg";

    return view("test/index", compact("ant", "bird", "cat", "god", "spider"));
});

Route::get("/gallery/ant", function () {
    $ant = "https://cdn3.movieweb.com/i/article/Oi0Q2edcVVhs4p1UivwyyseezFkHsq/1107:50/Ant-Man-3-Talks-Michael-Douglas-Update.jpg";
    return view("test/ant", compact("ant"));
});

Route::get("/gallery/bird", function () {
    $bird = "https://images.indianexpress.com/2021/03/falcon-anthony-mackie-1200.jpg";
    return view("test/bird", compact("bird"));
});

Route::get("/gallery/cat", function () {
    $cat = "https://media.newyorker.com/photos/5a875e3f33aebd0cab9bab12/master/w_2560%2Cc_limit/Brody-Passionate-Politics-Black-Panther.jpg";
    return view("test/cat", compact("cat"));
});

// General Pages
Route::get("/homepage", function () { return "<h1>This is home page</h1>"; });
Route::get("/blog/{id}", function ($id) { return "<h1>This is blog page : {$id} </h1>"; });
Route::get("/category/{a?}", function ($a = "mobile") { return "<h1>This is category page : {$a} </h1>"; });
Route::get("/hello", function () { return view("hello"); });
Route::get('/greeting', function () {
    $name = 'Tayanon';
    $last_name = 'Hakhun';
    return view('greeting', compact('name','last_name') );
});

Route::get("/teacher", function () { return view("teacher"); });
Route::get("/student", function () { return view("student"); });
Route::get("/theme", function () { return view("theme"); });
Route::get('/test', function () { return view('test'); })->name('test');

Route::get('/coronavirus', function () {
    $reports = [
        (object) ["country" => "Thailand", "date" => "2020-04-19", "total" => "2765", "active" => "790", "death" => "47", "recovered" => "1928"],
        (object) ["country" => "Thailand", "date" => "2020-04-18", "total" => "2733", "active" => "899", "death" => "47", "recovered" => "1787"],
        (object) ["country" => "Thailand", "date" => "2020-04-17", "total" => "2700", "active" => "964", "death" => "47", "recovered" => "1689"],
        (object) ["country" => "China", "date" => "2020-04-16", "total" => "2672", "active" => "1033", "death" => "46", "recovered" => "1593"],
        (object) ["country" => "China", "date" => "2020-04-15", "total" => "2643", "active" => "1103", "death" => "43", "recovered" => "1497"],
    ];
    return view("coronavirus", compact("reports"));
})->name('coronavirus');

// Query & Products
Route::get('query/sql', function () {
    $products = DB::select("SELECT * FROM products");
    return view('query-test', compact('products'));
});

Route::get('query/builder', function () {
    $products = DB::table('products')->get();
    return view('query-test', compact('products'));
});

Route::get('query/orm', function () {
    $products = Product::get();
    return view('query-test', compact('products'));
});

Route::get('barchart', function () { return view('barchart'); })->name('barchart');

Route::get('product-index', function () {
    $products = Product::get();
    return view('query-test', compact('products'));
})->name("product.index");

Route::get('product-form', function () { return view('product-form'); })->name("product.form");

Route::post('/product-submit', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'name.required' => 'กรุณากรอกชื่อสินค้า',
        'description.required' => 'กรุณากรอกรายละเอียดสินค้า',
        'price.required' => 'กรุณากรอกราคา',
        'price.numeric' => 'ราคาต้องเป็นตัวเลข',
        'image.image' => 'ไฟล์ต้องเป็นรูปภาพ',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
        $url = Storage::url($imagePath);
        $data["image"] = $url;
    }

    Product::create($data);

    return redirect()->route('product.index')->with('success', 'เพิ่มสินค้าแล้ว!');
})->name('product.submit');
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // เปลี่ยนเป็น back() เพื่อให้กลับไปยังหน้าที่กดกดล็อกเอาต์ (About Me หรือ Leave)
    return redirect()->back();
})->name('logout');
// Weights Resource
Route::resource('weights', WeightController::class);