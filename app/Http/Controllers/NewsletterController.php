<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;


class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::latest()->get();
        return view('admin.newsletters.index', compact('newsletters'));
    }

  //VIEW NEWSLETTER FUNCTION

    public function show(Newsletter $newsletter)
    {
        return view('admin.newsletters.show', compact('newsletter'));
    }

    // EDIT NEWSLETTER FUNCTION
    public function edit(Newsletter $newsletter)
    {
        return view('admin.newsletters.edit', compact('newsletter'));
    }

    //UPDATE NEWSLETTER FUNCTION
    public function update(Request $request, Newsletter $newsletter)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        $newsletter->update($request->all());
        return redirect()->route('newsletters.index')->with('success', 'Newsletter updated successfully!');
    }

    //DELETE NEWSLETTER FUNCTION
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return redirect()->route('newsletters.index')->with('danger', 'Newsletter deleted successfully!');
    }
}


