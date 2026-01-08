<?php

use App\Http\Controllers\admin\CkEditorImageController;

use App\Http\Controllers\admin\hostelAdminBackend\BlockController;
use App\Http\Controllers\admin\hostelAdminBackend\FeatureController;
use App\Http\Controllers\admin\hostelAdminBackend\InventoryController;
use App\Http\Controllers\admin\hostelAdminBackend\OccupancyController;
use App\Http\Controllers\admin\hostelAdminBackend\PayrollController;
use App\Http\Controllers\admin\hostelAdminBackend\ResidentController;
use App\Http\Controllers\admin\hostelAdminBackend\RoomController;
use App\Http\Controllers\admin\hostelAdminBackend\SettingController;
use App\Http\Controllers\admin\hostelAdminBackend\SliderController;
use App\Http\Controllers\admin\hostelAdminBackend\StaffController;
use App\Http\Controllers\admin\hostelAdminBackend\UserController;
use App\Http\Controllers\admin\hostelAdminBackend\BillController;
use App\Http\Controllers\admin\hostelAdminBackend\AboutController;
use App\Http\Controllers\admin\hostelAdminBackend\ReviewController;
use App\Http\Controllers\admin\hostelAdminBackend\RegistrationController;
use App\Http\Controllers\admin\hostelAdminBackend\TeamController;
use App\Http\Controllers\admin\hostelAdminBackend\NewsAndBlogController;
use App\Http\Controllers\admin\hostelAdminBackend\ContactController;
use App\Http\Controllers\admin\hostelAdminBackend\AlbumController;
use App\Http\Controllers\admin\hostelAdminBackend\TermsAndPoliciesController;

use App\Http\Controllers\admin\NotificationController;

use App\Http\Controllers\admin\superAdminBackend\BlogController;
use App\Http\Controllers\admin\superAdminBackend\DashboardController;
use App\Http\Controllers\admin\superAdminBackend\HostelController;
use App\Http\Controllers\admin\superAdminBackend\IconController;
use App\Http\Controllers\admin\superAdminBackend\PropertyListController;
use App\Http\Controllers\admin\superAdminBackend\SystemAboutController;
use App\Http\Controllers\admin\superAdminBackend\SystemFAQCategoryController;
use App\Http\Controllers\admin\superAdminBackend\SystemFAQController;
use App\Http\Controllers\admin\superAdminBackend\SystemTestimonialController;
use App\Http\Controllers\admin\superAdminBackend\AmenityController;


use App\Http\Middleware\activeHostel;
use App\Http\Middleware\EnsureHostelContext;
use App\Http\Middleware\EnsureWardenContext;

use App\Http\Middleware\SuperAdminOnly;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Auth\GoogleController;

Auth::routes(['register' => false]);

// Front
Route::get('/',[\App\Http\Controllers\frontend\mainPortal\HomeController::class,'home'])->name('home');
Route::get('testimonials/paginate',[\App\Http\Controllers\frontend\mainPortal\HomeController::class,'paginateTestimonials'])->name('testimonials.paginate');
Route::post('hostel-system/property-list',[\App\Http\Controllers\frontend\mainPortal\HomeController::class,'propertyListSubmit'])->name('propertyListSubmit');
Route::post('hostel-system/filter-hostels', [\App\Http\Controllers\frontend\mainPortal\HomeController::class, 'filterHostels'])->name('home.filterHostels');
Route::post('near-me', [\App\Http\Controllers\frontend\mainPortal\HomeController::class, 'nearMe'])->name('home.nearMe');
Route::get('hostel-system/about',[\App\Http\Controllers\frontend\mainPortal\AboutController::class,'about'])->name('about');
Route::get('hostel-system/blog',[\App\Http\Controllers\frontend\mainPortal\BlogController::class,'blog'])->name('blog');
Route::get('hostel-system/blog-detail/{slug}',[\App\Http\Controllers\frontend\mainPortal\BlogController::class,'blogDetail'])->name('blogDetail');
Route::get('hostel-system/faq',[\App\Http\Controllers\frontend\mainPortal\FaqController::class,'faq'])->name('faq');
Route::get('hostel-system/hostel',[\App\Http\Controllers\frontend\mainPortal\HostelController::class,'hostel'])->name('hostel');
Route::post('hostel-system/filter-hostel', [\App\Http\Controllers\frontend\mainPortal\HostelController::class, 'filter'])->name('hostel.filter');
Route::get('hostel-system/hostel-detail/{slug}',[\App\Http\Controllers\frontend\mainPortal\HostelController::class,'hostelDetail'])->name('hostelDetail');

// Hostel Reviews Routes
Route::post('/hostel-reviews', [\App\Http\Controllers\frontend\mainPortal\HostelReviewController::class, 'store'])->name('hostelReviews.store');
Route::get('/hostel-reviews/{hostelId}', [\App\Http\Controllers\frontend\mainPortal\HostelReviewController::class, 'index'])->name('hostelReviews.index');

Route::group([
    'middleware' => [activeHostel::class],
    'prefix' => '{hostel}',
    'as' => 'hostel.'
], function () {
    Route::get('/', [\App\Http\Controllers\frontend\hostelPortal\HomeController::class, 'index'])->name('index');
    Route::get('/search-rooms', [\App\Http\Controllers\frontend\hostelPortal\HomeController::class, 'searchRooms'])->name('search-rooms');
    Route::post('/booking-store', [\App\Http\Controllers\frontend\hostelPortal\HomeController::class, 'storeBooking'])->name('bookingStore');
    Route::get('/about-us', [\App\Http\Controllers\frontend\hostelPortal\AboutController::class, 'about'])->name('aboutUs');
    Route::post('/inquiry-store', [\App\Http\Controllers\frontend\hostelPortal\AboutController::class, 'inquiryStore'])->name('inquiryStore');
    Route::get('/blog', [\App\Http\Controllers\frontend\hostelPortal\BlogController::class, 'blog'])->name('blog');
    Route::get('/blog-detail/{blogSlug}', [\App\Http\Controllers\frontend\hostelPortal\BlogController::class, 'blogDetail'])->name('blogDetail');
    Route::get('/checkout/{room}', [\App\Http\Controllers\frontend\hostelPortal\BookingController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [\App\Http\Controllers\frontend\hostelPortal\BookingController::class, 'store'])->name('checkout.store');
    Route::get('/contact', [\App\Http\Controllers\frontend\hostelPortal\ContactController::class, 'contact'])->name('contact');
    Route::post('/contact-store', [\App\Http\Controllers\frontend\hostelPortal\ContactController::class, 'contactStore'])->name('contactStore');
    Route::get('/gallery', [\App\Http\Controllers\frontend\hostelPortal\GalleryController::class, 'gallery'])->name('gallery');
    Route::get('/register', [\App\Http\Controllers\frontend\hostelPortal\RegisterController::class, 'register'])->name('register');
    Route::get('/rooms', [\App\Http\Controllers\frontend\hostelPortal\RoomController::class, 'room'])->name('room');
    Route::post('/rooms/filter', [\App\Http\Controllers\frontend\hostelPortal\RoomController::class, 'filterRooms'])->name('room.filter');
    Route::get('/room-detail/{room}', [\App\Http\Controllers\frontend\hostelPortal\RoomController::class, 'roomDetail'])->name('roomDetail');
    Route::get('/signin', [\App\Http\Controllers\frontend\hostelPortal\SigninController::class, 'signin'])->name('signin');
    Route::post('/signin/login', [\App\Http\Controllers\frontend\hostelPortal\SigninController::class, 'login'])->name('signin.login');
    Route::get('/terms-and-policies/{termSlug}', [\App\Http\Controllers\frontend\hostelPortal\TermsAndPolicyController::class, 'termsAndPolicy'])->name('termsAndPolicy');
});

// Resident Portal Routes
Route::post('/resident/login', [\App\Http\Controllers\admin\hostelUserBackend\ResidentAuthController::class, 'login'])->name('resident.login');

Route::group([
    'middleware' => ['auth', 'resident'],
    'prefix' => 'resident',
    'as' => 'resident.'
], function () {
    Route::get('/dashboard', [\App\Http\Controllers\admin\hostelUserBackend\ResidentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/hostels', [\App\Http\Controllers\admin\hostelUserBackend\ResidentDashboardController::class, 'hostels'])->name('hostels');
    Route::get('/hostels/{hostel}', [\App\Http\Controllers\admin\hostelUserBackend\ResidentDashboardController::class, 'hostelDetail'])->name('hostels.show');
    Route::get('/profile', [\App\Http\Controllers\admin\hostelUserBackend\ResidentDashboardController::class, 'profile'])->name('profile');
    Route::post('/logout', [\App\Http\Controllers\admin\hostelUserBackend\ResidentAuthController::class, 'logout'])->name('logout');
});

// Google OAuth routes
// Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
// Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// --- ckeditor image ---
Route::post('ckeditor/upload', [CkEditorImageController::class, 'uploadImage'])->name('ckeditor.upload');

// Notification routes (accessible by all authenticated users)
Route::group(['middleware' => 'auth'], function () {
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('view/notification', [NotificationController::class, 'index'])->name('notification.index');
});

// ---------- CMS Routes ----------
Route::group([
    'middleware' => ['auth', SuperAdminOnly::class],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    // --- dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // --- dashboard ---
    Route::get('/hostel/dashboard/{token}', [HostelController::class, 'show'])->name('hostel.dashboard');
    Route::get('/hostel/download-template', [HostelController::class, 'downloadTemplate'])->name('hostel.download-template');
    Route::post('/hostel/import', [HostelController::class, 'import'])->name('hostel.import');
    Route::get('/hostel/download-error-log/{filename}', [HostelController::class, 'downloadErrorLog'])->name('hostel.download-error-log');
    Route::resource('/hostel', HostelController::class);
    // property lists
    Route::get('/property-list/show/{slug}', [PropertyListController::class, 'show'])->name('propertyList.show');
    Route::post('/property-list/{slug}/approve', [PropertyListController::class, 'approve'])->name('propertyList.approve');
    Route::post('/property-list/{slug}/reject', [PropertyListController::class, 'reject'])->name('propertyList.reject');
    Route::resource('/property-list', PropertyListController::class);
    // --- icon ---
    Route::put('/icon/publish/{icon}', [IconController::class, 'publish'])->name('publish.icon');
    Route::resource('/icon', IconController::class);
    // about system
    Route::resource('/system-about', SystemAboutController::class);
    // faq category
    Route::put('/system-faq-category/publish/{category}', [SystemFAQCategoryController::class, 'publish'])->name('publish.faqCategory');
    Route::resource('/system-faq-category', SystemFAQCategoryController::class);
    // faq
    Route::put('/system-faq/publish/{faq}', [SystemFAQController::class, 'publish'])->name('publish.faq');
    Route::resource('/system-faq', SystemFAQController::class);
    // testimonial
    Route::put('/system-testimonial/publish/{testimonial}', [SystemTestimonialController::class, 'publish'])->name('publish.testimonial');
    Route::resource('/system-testimonial', SystemTestimonialController::class);
    // --- amenity ---
    Route::put('/amenity/publish/{amenity}', [AmenityController::class, 'publish'])->name('publish.amenity');
    Route::resource('/amenity', AmenityController::class);
    // --- blog ---
    Route::put('/news-blog/publish/{blog}', [BlogController::class, 'publish'])->name('publish.blog');
    Route::resource('/news-blog', BlogController::class);
    // --- config ---
    Route::get('/config', [\App\Http\Controllers\admin\superAdminBackend\ConfigController::class, 'index'])->name('config.index');
    Route::post('/config/update', [\App\Http\Controllers\admin\superAdminBackend\ConfigController::class, 'update'])->name('config.update');
});

Route::post('/hostel/exit', function () {
    session()->forget('current_hostel_id');
    return redirect()->route('admin.dashboard');
})->name('hostel.exit');

Route::group([
    'middleware' => ['auth', EnsureHostelContext::class],
    'prefix' => 'hostel',
    'as' => 'hostelAdmin.'
], function () {
    // --- dashboard ---
    Route::get('/dashboard/{token}', [\App\Http\Controllers\admin\hostelAdminBackend\DashboardController::class, 'index'])->name('dashboard');
    // --- user ---
    Route::resource('/user',UserController::class);
    // --- block ---
    Route::resource('/block',BlockController::class);
    // --- room ---
    Route::get('/room/{block}/floors', [RoomController::class, 'getFloors']);
    Route::get('/room/{block}/occupancies', [RoomController::class, 'getOccupancies']);
    Route::resource('/room',RoomController::class);
    // --- occupancy ---
    Route::resource('/occupancy',OccupancyController::class);
    // --- resident ---
    Route::get('/hostel/{hostel}/blocks', [ResidentController::class, 'getHostelBlocks']);
    Route::get('/resident/{block}/occupancy', [ResidentController::class, 'getOccupancies']);
    Route::get('block/{block}/floors', [ResidentController::class, 'getFloors']);
    Route::get('floor/{floor}/rooms', [ResidentController::class, 'getRooms']);
    Route::get('room/{room}/beds', [ResidentController::class, 'getBeds']);
    Route::get('resident/get-room-details/{room}', [ResidentController::class, 'getRoomDetails']);
    Route::post('/bed-transfer', [ResidentController::class, 'bedTransfer'])->name('resident.bedTransfer');
    Route::resource('/resident',ResidentController::class);
    // --- bill ---
    Route::get('/search-residents', [BillController::class, 'search'])->name('resident.search');
    Route::get('/bill/{resident}/create', [BillController::class, 'create'])->name('resident.bill.create');
    Route::post('/bill/snapshot', [BillController::class, 'storeSnapshot'])->name('bill.storeSnapshot');
    Route::resource('/bill', BillController::class);
    // --- staff ---
    Route::resource('/staff', StaffController::class);
    // --- payroll ---
    Route::get('/search-staffs', [PayrollController::class, 'search'])->name('staff.search');
    Route::get('/payroll/{staff}/create', [PayrollController::class, 'create'])->name('staff.payroll.create');
    Route::resource('/payroll', PayrollController::class);
    // --- inventory ---
    Route::resource('/inventory', InventoryController::class);
    // --- setting ---
    Route::get('/setting/{user}', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/update-email', [SettingController::class, 'updateEmail'])->name('setting.updateEmail');
    Route::post('/settings/verify-password', [SettingController::class, 'verifyPassword'])->name('setting.verifyPassword');
    Route::post('/setting/update-password', [SettingController::class, 'updatePassword'])->name('setting.updatePassword');
    // --- about ---
    Route::resource('/about', AboutController::class);
    // --- review ---
    Route::put('/review/publish/{review}', [ReviewController::class, 'publish'])->name('publish.review');
    Route::resource('/review', ReviewController::class);
    // --- registration ---
    Route::put('/registration/publish/{registration}', [RegistrationController::class, 'publish'])->name('publish.registration');
    Route::resource('/registration', RegistrationController::class);
    // --- team ---
    Route::put('/team/publish/{team}', [TeamController::class, 'publish'])->name('publish.team');
    Route::resource('/team', TeamController::class);
    // --- news and blog ---
    Route::put('/news-and-blog/publish/{newsAndBlog}', [NewsAndBlogController::class, 'publish'])->name('publish.newsAndBlog');
    Route::resource('/news-and-blog', NewsAndBlogController::class);
    // --- terms and policies ---
    Route::put('/terms-and-policies/publish/{termsAndPolicy}', [TermsAndPoliciesController::class, 'publish'])->name('publish.termsAndPolicy');
    Route::resource('/terms-and-policies', TermsAndPoliciesController::class);
    // --- short term bookings ---
    Route::post('/short-term-bookings/{slug}/update-status', [\App\Http\Controllers\admin\hostelAdminBackend\ShortTermBookingController::class, 'updateStatus'])->name('short-term-bookings.updateStatus');
    Route::resource('/short-term-bookings', \App\Http\Controllers\admin\hostelAdminBackend\ShortTermBookingController::class);
    // --- contact ---
    Route::resource('/contact-us', ContactController::class);
    // --- album ---
    Route::put('/album/publish/{album}', [AlbumController::class, 'publish'])->name('publish.album');
    Route::resource('/album', AlbumController::class);
    // // --- amenity ---
    // Route::put('/hostel-amenity/publish/{hostelAmenity}', [AmenityController::class, 'publish'])->name('publish.amenity');
    // Route::resource('/hostel-amenity', AmenityController::class);
    // --- feature ---
    Route::put('/hostel-feature/publish/{hostelFeature}', [FeatureController::class, 'publish'])->name('publish.feature');
    Route::resource('/hostel-feature', FeatureController::class);
    // --- slider ---
    Route::put('/slider/publish/{slider}', [SliderController::class, 'publish'])->name('publish.slider');
    Route::resource('/slider', SliderController::class);
    // --- config ---
    Route::get('/config', [\App\Http\Controllers\admin\hostelAdminBackend\ConfigController::class, 'index'])->name('config.index');
    Route::post('/config/update', [\App\Http\Controllers\admin\hostelAdminBackend\ConfigController::class, 'update'])->name('config.update');
    // booking
    Route::resource('/booking', \App\Http\Controllers\admin\hostelAdminBackend\BookingController::class);
});

Route::group([
    'middleware' => ['auth', EnsureWardenContext::class],
    'prefix' => 'block',
    'as' => 'hostelWarden.'
], function () {
    // --- dashboard ---
    Route::get('/dashboard/{token}', [\App\Http\Controllers\admin\hostelWardenBackend\DashboardController::class, 'index'])->name('dashboard');
    // --- inventory ---
    Route::resource('/inventory', \App\Http\Controllers\admin\hostelWardenBackend\InventoryController::class);
});