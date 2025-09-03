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
use App\Http\Controllers\AboutSlideController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\FounderController;
use App\Http\Controllers\ExecutiveController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ImpactController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\MemberBenefitsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\BlogController;
use App\Models\User;
use App\Http\Controllers\MpesaWebhookController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;


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
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Safaricom will POST here (no auth, no CSRF)
Route::post('/mpesa/register/callback', [MpesaWebhookController::class, 'registrationCallback'])
  ->name('mpesa.register.callback');

// registration renewal via stk push

    // Show renewal page if expired
    Route::get('/renew', function () {
        return view('memberships.renew');
    })->name('membership.renew.form');

    // Trigger STK push
    Route::post('/renew', [PaymentController::class, 'renewMembership'])
        ->name('membership.renew');

    // Dashboard – protected by membership check
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('check.membership')->name('dashboard');


// M-Pesa callback (should NOT require auth)
Route::post('/mpesa/stk/callback', [PaymentController::class, 'stkCallback'])
    ->name('mpesa.stk.callback');


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
    Route::get('slides/{slide}/edit', [SlideController::class, 'edit'])->name('slides.edit');
    Route::put('slides/{slide}', [SlideController::class, 'update'])->name('slides.update');
    Route::get('/slides/{id}', [SlideController::class, 'show'])->name('slides.show');
    Route::delete('slides/{slide}', [SlideController::class, 'destroy'])->name('slides.destroy');
});


//COLLABORATORS ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/collaborator', [CollaboratorsController::class, 'index'])->name('collaborators.index'); // List all collaborators
    Route::get('/collaborator/create', [CollaboratorsController::class, 'create'])->name('collaborators.create'); // Show form to create a new collaborator
    Route::post('/collaborator', [CollaboratorsController::class, 'store'])->name('collaborators.store'); // Store new collaborator in DB
    Route::get('/collaborator/{id}', [CollaboratorsController::class, 'show'])->name('collaborators.show'); // Show a single collaborator
    Route::get('/collaborator/{id}/edit', [CollaboratorsController::class, 'edit'])->name('collaborators.edit'); // Show edit form
    Route::put('/collaborator/{id}', [CollaboratorsController::class, 'update'])->name('collaborators.update'); // Update a collaborator
    Route::delete('/collaborator/{id}', [CollaboratorsController::class, 'destroy'])->name('collaborators.destroy'); // Delete a collaborator
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
    Route::get('/about/display', [AboutController::class, 'display'])->name('about.display');
    Route::get('/about/vision', [AboutController::class, 'vision'])->name('about.vision');
    Route::get('/about/mission', [AboutController::class, 'mission'])->name('about.mission');
    Route::get('/about/objectives', [AboutController::class, 'objectives'])->name('about.objectives');
    Route::get('/about/motto', [AboutController::class, 'motto'])->name('about.motto');
    Route::get('/about/about', [AboutController::class, 'about'])->name('about.about');
    Route::get('/about/belief', [AboutController::class, 'belief'])->name('about.belief');
    
    //ABOUT US SLIDES
    Route::middleware(['role:admin'])->group(function () {
        Route::middleware('auth')->group(function () {
    Route::get('/about-slides', [AboutSlideController::class, 'index'])->name('about-slides.index');
    Route::get('/about-slides/create', [AboutSlideController::class, 'create'])->name('about-slides.create');
    Route::post('/about-slides', [AboutSlideController::class, 'store'])->name('about-slides.store');
    Route::get('/about-slides/{aboutSlide}', [AboutSlideController::class, 'show'])->name('about-slides.show');
    Route::get('/about-slides/{aboutSlide}/edit', [AboutSlideController::class, 'edit'])->name('about-slides.edit');
    Route::put('/about-slides/{aboutSlide}', [AboutSlideController::class, 'update'])->name('about-slides.update');
    Route::delete('/about-slides/{aboutSlide}', [AboutSlideController::class, 'destroy'])->name('about-slides.destroy');
    });
    });
//USER DASHBOARD
Route::middleware(['auth', 'check.membership'])->group(function () {
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
    Route::get('/admin/events', [EventController::class, 'index'])->name('events.index'); // Route for managing events (Index)
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/admin/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});
});
Route::get('/event', [EventController::class, 'showAllEvents'])->name('events.showAll'); // Route for displaying events to users (Show All)
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {

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

//TEAM MEMBERS ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
Route::get('/team-members', [TeamMemberController::class, 'index'])->name('team-members.index');
Route::get('/team-members/create', [TeamMemberController::class, 'create'])->name('team-members.create');
Route::post('/team-members', [TeamMemberController::class, 'store'])->name('team-members.store');
Route::get('/team-members/{teamMember}', [TeamMemberController::class, 'show'])->name('team-members.show');
Route::get('/team-members/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('team-members.edit');
Route::put('/team-members/{teamMember}', [TeamMemberController::class, 'update'])->name('team-members.update');
Route::delete('/team-members/{teamMember}', [TeamMemberController::class, 'destroy'])->name('team-members.destroy');
});
});
Route::get('/team-member', [TeamMemberController::class, 'display'])->name('team-members.display');

//SEARCH ROUTES
Route::get('/search', [SearchController::class, 'search'])->name('search');

//PUBLICATIONS ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
Route::get('/publication', [PublicationController::class, 'index'])->name('publications.index');
Route::get('/publications/create', [PublicationController::class, 'create'])->name('publications.create');
Route::post('/publication', [PublicationController::class, 'store'])->name('publications.store');
Route::get('/publications/{publication}', [PublicationController::class, 'show'])->name('publications.show');
Route::get('/publications/{publication}/edit', [PublicationController::class, 'edit'])->name('publications.edit');
Route::put('/publications/{publication}', [PublicationController::class, 'update'])->name('publications.update');
Route::delete('/publications/{publication}', [PublicationController::class, 'destroy'])->name('publications.destroy');
});
});
Route::get('/publications/download/{publication}', [PublicationController::class, 'download'])->name('publications.download');
Route::get('/publication/display', [PublicationController::class, 'display'])->name('publications.display');
Route::get('/publications/download/{id}', [App\Http\Controllers\PublicationController::class, 'download'])->name('publications.download');


//ACTIVITIES ROUTES
// List all activities (Index)
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
Route::get('/activity', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activity/create', [ActivityController::class, 'create'])->name('activities.create');
Route::post('/activity', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activity/{id}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('/activitity/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
Route::put('/activity/{id}', [ActivityController::class, 'update'])->name('activities.update');
Route::get('/activities/display', [ActivityController::class, 'display'])->name('activities.display');
Route::delete('/activity/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');
});
});
Route::get('/activities/display', [ActivityController::class, 'display'])->name('activities.display');

// FOUNDERS ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
Route::get('/founder', [FounderController::class, 'index'])->name('founders.index'); // List all founders
Route::get('/founders/create', [FounderController::class, 'create'])->name('founders.create'); // Show create form
Route::post('/founder', [FounderController::class, 'store'])->name('founders.store'); // Store new founder
Route::get('/founders/{founder}', [FounderController::class, 'show'])->name('founders.show'); // Show single founder
Route::get('/founders/{founder}/edit', [FounderController::class, 'edit'])->name('founders.edit'); // Show edit form
Route::put('/founders/{founder}', [FounderController::class, 'update'])->name('founders.update'); // Update founder
Route::delete('/founders/{founder}', [FounderController::class, 'destroy'])->name('founders.destroy'); // Delete founder
});
});
Route::get('/founderss', [FounderController::class, 'display'])->name('founders.display'); // Custom display method

// EXECUTIVES ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
Route::get('/executive', [ExecutiveController::class, 'index'])->name('executives.index');
Route::get('/executives/create', [ExecutiveController::class, 'create'])->name('executives.create');
Route::post('/executive', [ExecutiveController::class, 'store'])->name('executives.store');
Route::get('/executives/{executive}', [ExecutiveController::class, 'show'])->name('executives.show');
Route::get('/executives/{executive}/edit', [ExecutiveController::class, 'edit'])->name('executives.edit');
Route::put('/executives/{executive}', [ExecutiveController::class, 'update'])->name('executives.update');
Route::delete('/executives/{executive}', [ExecutiveController::class, 'destroy'])->name('executives.destroy');
});
});
Route::get('/executivess', [ExecutiveController::class, 'display'])->name('executives.display');

// MEMBERSHIPS ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index'); // List all memberships
        Route::get('/memberships/create', [MembershipController::class, 'create'])->name('memberships.create'); // Show create form
        Route::post('/memberships', [MembershipController::class, 'store'])->name('memberships.store'); // Store new membership
        Route::get('/memberships/{membership}', [MembershipController::class, 'show'])->name('memberships.show'); // Show single membership
        Route::get('/memberships/{membership}/edit', [MembershipController::class, 'edit'])->name('memberships.edit'); // Show edit form
        Route::put('/memberships/{membership}', [MembershipController::class, 'update'])->name('memberships.update'); // Update membership
        Route::delete('/memberships/{membership}', [MembershipController::class, 'destroy'])->name('memberships.destroy'); // Delete membership
    });
});

// Custom display method (if needed)
Route::get('/membership', [MembershipController::class, 'display'])->name('memberships.display');
Route::get('/membership-types', [MemberBenefitsController::class, 'types'])->name('memberships.types');

// NEWS ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/new', [NewsController::class, 'index'])->name('news.index');
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/new', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    });
});
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/new/display', [NewsController::class, 'display'])->name('news.display');

// IMPACTS ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/impacts', [ImpactController::class, 'index'])->name('impacts.index');
        Route::get('/impacts/create', [ImpactController::class, 'create'])->name('impacts.create');
        Route::post('/impacts', [ImpactController::class, 'store'])->name('impacts.store');
        Route::get('/impacts/{impact}', [ImpactController::class, 'show'])->name('impacts.show');
        Route::get('/impacts/{impact}/edit', [ImpactController::class, 'edit'])->name('impacts.edit');
        Route::put('/impacts/{impact}', [ImpactController::class, 'update'])->name('impacts.update');
        Route::delete('/impacts/{impact}', [ImpactController::class, 'destroy'])->name('impacts.destroy');
   });
});

// TESTIMONIALS ROUTES
Route::middleware(['role:admin'])->group(function () {
Route::middleware('auth')->group(function () {
    Route::get('/testimonial', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/testimonials/{testimonial}', [TestimonialController::class, 'show'])->name('testimonials.show');
    Route::get('/testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
  });
});
Route::get('/testimonials/display', [App\Http\Controllers\TestimonialController::class, 'display'])->name('testimonials.display');

// MEMBER BENEFITS ROUTE
Route::get('/member-benefits', [App\Http\Controllers\MemberBenefitsController::class, 'showBenefits'])->name('benefits');


// CHANGE PASSWORD and FORGOT PASSWORD ROUTEs
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendTemporaryPassword'])->name('password.email');
Route::get('/change-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/change-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'changePassword'])->name('password.update');

// BLOG ROUTES
Route::middleware(['role:admin'])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/blo', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('/blo', [BlogController::class, 'store'])->name('blog.store');
        Route::get('/blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
    });
});

// Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blo/display', [BlogController::class, 'display'])->name('blog.display');
Route::get('/blogs/author/{author}', [App\Http\Controllers\BlogController::class, 'byAuthor'])->name('blog.byAuthor');


// QR CODE ROUTES
Route::get('/verify/{membership}', function ($membership) {
    $user = User::where('MEMBERSHIP_NUMBER', $membership)->first();

    if (!$user) {
        return view('verify_unverified', ['membershipNumber' => $membership]);
    }

    return view('verify', ['user' => $user]);
})->name('verify.member');

// TAG ROUTE
Route::get('/blogs/tags/{tag}', [BlogController::class, 'tag'])->name('blog.tag');






// CLEAR CACHE ROUTE RUN https://www.kesakenya.org/clearcache


// Route::get('/clearcache', function() {
//     Artisan::call('config:clear');
//     Artisan::call('cache:clear');
//     Artisan::call('config:cache'); // Optional to rebuild cache
//     return 'Config and cache cleared';
// });


