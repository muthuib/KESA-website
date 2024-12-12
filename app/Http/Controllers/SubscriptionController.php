<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendNewsletterJob;
use App\Models\Newsletter;  // Import the Newsletter model
use Illuminate\Support\Facades\Log; // Add this for logging
use Symfony\Component\Mime\Part\TextPart;


class SubscriptionController extends Controller
{
    // Subscribe to the newsletter
    public function subscribe(Request $request)
{
    // Validate email input (email must be a valid email format)
    $request->validate([
        'email' => 'required|email',  // No need to validate uniqueness here yet
    ]);

    // Check if the email already exists in the database
    $existingSubscription = Subscription::where('EMAIL', $request->email)->first();

    if ($existingSubscription) {
        // If email already exists, flash a message to the session and return back
        return redirect()->back()->with('error', 'This email has already been subscribed.');
    }

    // Create a new subscription entry in the database
    Subscription::create(['EMAIL' => $request->email]);

    // Send a confirmation email
    Mail::to($request->email)->send(new \App\Mail\SubscriptionConfirmation($request->email));

    // Flash a success message to the session
    session()->flash('success', 'Thank you for subscribing! Check your email for confirmation.');

    // Redirect to the 'thankyou' page or another page
    return redirect()->route('thankyou');
}


    // Unsubscribe from the newsletter
    public function unsubscribe(Request $request)
{
    // Get the email from the route or the form submission
    $email = $request->route('email') ?? $request->input('email');

    // Ensure email is present
    if (!$email) {
        return redirect()->route('unsubscribe-response')->with('error', 'Email is required to unsubscribe.');
    }

    // Find the subscription by email
    $subscription = Subscription::where('EMAIL', $email)->first();

    if ($subscription) {
        // If the subscription exists, delete it
        $subscription->delete();

        // Flash a success message
        session()->flash('success', 'You have successfully unsubscribed from our newsletter.');

        // Redirect to unsubscribe-response page
        return redirect()->route('unsubscribe-response');
    }

    // If no subscription found
    session()->flash('error', 'This email is not subscribed to our newsletter.');
    return redirect()->route('unsubscribe-response');
    }
    //SHOW NEWSLETTER FORM 
    public function showNewsletterForm()
    {
        return view('send-newsletter'); // Replace 'send-newsletter' with your actual Blade file name.
    }

    // Send newsletter to all subscribed users
    public function sendNewsletter(Request $request)
{
    // Validate the request
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    // Save the newsletter to the database
    $newsletter = Newsletter::create([
        'SUBJECT' => $request->input('subject'),
        'MESSAGE' => $request->input('message'),
    ]);

    // Check if the newsletter was successfully saved
    if (!$newsletter) {
        return redirect()->back()->with('error', 'Failed to save the newsletter. Please try again.');
    }

    // Get all subscribed users' emails
    $subscribers = Subscription::pluck('EMAIL')->toArray();

    if (empty($subscribers)) {
        return redirect()->back()->with('error', 'No subscribers found.');
    }

    // Send the newsletter
    foreach ($subscribers as $email) {
        SendNewsletterJob::dispatch($email, $newsletter->SUBJECT, $newsletter->MESSAGE);
        
    }
    
    // Redirect with a success message
    return redirect()->back()->with('success', 'Newsletter sent successfully to all subscribers.');
}
    
    public function index()
        {
            // Fetch all newsletters (if listing newsletters)
            $newsletters = Newsletter::all();

            // Alternatively, fetch subscriptions if listing subscriptions
            // $subscriptions = Subscription::all();

            return view('admin.newsletters.index', compact('newsletters'));
        }

        
}
