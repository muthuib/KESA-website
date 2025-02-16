<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\RegisterPartnerController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CollaboratorsController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\PartnerLoginController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LiveEventController;


Route::get('/', [HomeController::class, 'index'])->name('home');

//RBAC ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

//EMAIL VERIFICATION AFTER SIGN UP

Route::middleware(['auth', 'verified', EnsureEmailIsVerified::class])->group(function () {
    Route::get('/partner-dashboard', [PartnerController::class, 'index'])->name('partner.dashboard');
    Route::get('/member-dashboard', [MemberController::class, 'index'])->name('member.dashboard');
});




//USER management routes
Route::middleware(['role:admin'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::get('/users/{id}', [UserManagementController::class, 'show'])->name('users.show');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');


//Assign roles to user routes
Route::get('/users/{id}/assign-roles', [UserController::class, 'assignRolesForm'])->name('users.assignRolesForm');
Route::post('/users/{id}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assignRoles');
});
// Registration routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//Partners registration routes
Route::get('registration', [RegisterPartnerController::class, 'showRegistrationForm'])->name('registration');
Route::post('/registration',[RegisterPartnerController::class, 'registration']);

// Partner Login routes
Route::get('partnerlogin', [PartnerLoginController::class, 'showLoginForm'])->name('partnerlogin');
Route::post('partnerlogin', [PartnerLoginController::class, 'partnerlogin']);
Route::post('/logout', [PartnerLoginController::class, 'logout'])->name('logout');

// Login routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::middleware('auth')->group(function () {
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/app', function () {
        return view('layouts.app');
    })->name('app');
});

// routes for resources
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {
    // Only accessible to authenticated users/  logged in users
    Route::get('resources', [ResourceController::class, 'index'])->name('resources.index'); // Show all resources
    Route::get('resources/create', [ResourceController::class, 'create'])->name('resources.create'); // Show create form
    Route::post('resources', [ResourceController::class, 'store'])->name('resources.store'); // Store new resource
    Route::get('resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit'); //show edit form
    Route::put('resources/{resource}', [ResourceController::class, 'update'])->name('resources.update'); //update edited resource
    Route::delete('resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy'); //deletes resource
    // Add any other routes that should be protected by authentication here
});
});
Route::get('resources/{resource}', [ResourceController::class, 'view'])->name('resources.view'); //views resource
Route::get('/show', [ResourceController::class, 'showResources'])->name('resources.show');//display resources to end user

//PARTNER AND MEMBER DASHBOARDS
Route::middleware(['auth', 'verified'])->group(function () {
    // Partner dashboard route
    Route::get('/partner-dashboard', [PartnerController::class, 'index'])->name('partner.dashboard');
    
    // Member dashboard route
    Route::get('/member-dashboard', [MemberController::class, 'index'])->name('member.dashboard');
});

//Admin routes to add sliswshows
// Admin Routes: CRUD for slides (requires authentication)
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('slides', [SlideController::class, 'index'])->name('slides.index');
    Route::get('slides/create', [SlideController::class, 'create'])->name('slides.create');
    Route::post('slides', [SlideController::class, 'store'])->name('slides.store');
    Route::get('/slides/{id}', [SlideController::class, 'show'])->name('slides.show');
    Route::delete('slides/{slide}', [SlideController::class, 'destroy'])->name('slides.destroy');
});


//COLLABORATORS ROUTES
Route::middleware('auth')->group(function () {
    Route::post('/collaborators', [CollaboratorsController::class, 'store'])->name('collaborators.store');
    Route::resource('collaborators', CollaboratorsController::class);
    // Route to show collaborations
    Route::get('/collaborators', [CollaboratorsController::class, 'index'])->name('collaborators.index');
    });
    
Route::get('/fetch-collaborations', [CollaboratorsController::class, 'fetchCollaborations'])->name('collaborations.fetch');


//Routes for guest slideshow before login. it gets slideshows from admin routes.
// Guest/Home Route: Displays slides to everyone
Route::get('/', [GuestController::class, 'home'])->name('home');

//ROUTES FOR NEWS LETTER
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');


// For logged-in users (email passed as a parameter in the URL)T
Route::get('/unsubscribe/{email}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');


// Thank you page route
Route::get('/thankyou', function() {
    return view('thankyou');
})->name('thankyou');

// Route for displaying the unsubscribe response page
Route::get('/unsubscribe-response', function() {
    return view('unsubscribe-response');
})->name('unsubscribe-response');

//Send newsletters to adll subscribed users
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {
Route::get('/send-newsletter', [SubscriptionController::class, 'showNewsletterForm'])->name('send.newsletter');
Route::post('/send-newsletter', [SubscriptionController::class, 'sendNewsletter'])->name('send.newsletter');
Route::get('/newsletters', [SubscriptionController::class, 'index'])->name('newsletters.index');
Route::get('unsubscribe/{EMAIL}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');


Route::get('admin/newsletters/{newsletter}/show', [NewsletterController::class, 'show'])->name('newsletters.show'); //view newsletter
Route::get('admin/newsletters/{newsletter}/edit', [NewsletterController::class, 'edit'])->name('newsletters.edit'); //show edit form
Route::put('admin.newsletters/{newsletter}', [NewsletterController::class, 'update'])->name('newsletters.update'); //update edited newsletter
Route::delete('admin.newsletters/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletters.destroy'); //deletes newsletter
});
});

//ABOUT US ROUTES
// Route::get('/about', [AboutUsController::class, 'index'])->name('about.index');
Route::middleware(['role:admin'])->group(function () {
//DASHBOARD ANALYTICS ROUTES
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

//ABOUT ROUTES
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('about/{id}/edit', [AboutController::class, 'edit'])->name('about.edit');
Route::put('about/{id}', [AboutController::class, 'update'])->name('about.update');
Route::get('about/create', [AboutController::class, 'create'])->name('about.create');
Route::post('about', [AboutController::class, 'store'])->name('about.store');
Route::delete('about/{id}', [AboutController::class, 'destroy'])->name('about.destroy');
});
Route::get('/about/vision', [AboutController::class, 'vision'])->name('about.vision');
Route::get('/about/mission', [AboutController::class, 'mission'])->name('about.mission');
Route::get('/about/objectives', [AboutController::class, 'objectives'])->name('about.objectives');

//USER DASHBOARD
Route::middleware('auth')->group(function () {
Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user-dashboard');
Route::get('/profile/edit/{id}', [UserDashboardController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update/{id}', [UserDashboardController::class, 'update'])->name('profile.update');


});

//TICKETS AND  MPESA INTERGRATION ROUTES
// Ticket Routes
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
});
});
Route::get('/tickets/buy', [TicketController::class, 'buy'])->name('tickets.buy');

// Mpesa Routes
Route::post('/mpesa/initiate', [MpesaController::class, 'initiatePayment'])->name('mpesa.initiate');
Route::post('/mpesa/callback', [MpesaController::class, 'handleCallback'])->name('mpesa.callback');
Route::get('/payment-success', [MpesaController::class, 'paymentSuccess'])->name('payment.success');
// Define a route for the payment error
Route::get('/payment-error', function () {
    return view('payment.error');
})->name('payment.error');

//EVENT AND EVENT REGISTRATION ROUTES
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {
Route::resource('events', EventController::class); //for crud
});
});
Route::get('/events', [EventController::class, 'showAllEvents'])->name('events.showAll'); // Route for displaying events to users (Show All)
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {
    Route::get('/admin/events', [EventController::class, 'index'])->name('events.index'); // Route for managing events (Index)
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');  // Use model binding here  
});
});
Route::get('/events/{event}/register', [RegistrationController::class, 'create'])->name('registrations.create');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('registrations.store');

//CONTACT ROUTES
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::get('/contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/{contact}/edit', [ContactController::class, 'edit'])->name('contact.edit');
Route::put('/contact/{contact}', [ContactController::class, 'update'])->name('contact.update');
Route::delete('/contact/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');
});
});
Route::get('/contacts', [ContactController::class, 'display'])->name('contact.display');

//FEEDBACK ROUTES
Route::get('/feedbacks', [FeedbackController::class, 'display'])->name('feedbacks.display');
Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create'); // Feedback form
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store'); // Store feedback
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () { 
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index'); // Display feedback
Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']);
});
});

//LIVE EVENTS ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
Route::get('/media', [LiveEventController::class, 'index'])->name('live-events.index');
Route::get('/media/add', [LiveEventController::class, 'create'])->name('live-events.create');
Route::post('/media/store', [LiveEventController::class, 'store'])->name('live-events.store');
Route::get('/live-events/edit/{id}', [LiveEventController::class, 'edit'])->name('live-events.edit');
Route::put('/live-events/update/{id}', [LiveEventController::class, 'update'])->name('live-events.update');
Route::delete('/live-events/destroy/{id}', [LiveEventController::class, 'destroy'])->name('live-events.destroy');
});
});
Route::get('/live-events/list', [LiveEventController::class, 'list'])->name('live-events.list');
