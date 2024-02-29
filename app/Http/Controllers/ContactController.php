<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    // public function store(ContactRequest $request): view
    // {
    //     Mail::to('administrateur@chezmoi.com')
    //         ->send(new Contact($request->except('_token')));
    //     return view('confirm');
    // }
}
