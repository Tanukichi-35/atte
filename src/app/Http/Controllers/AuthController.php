<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AuthController extends Controller
{
    public function admin()
    {
        // $contacts = Contact::all();
        // return view('admin', compact('contacts'));
        $contacts = Contact::Paginate(7);
        $categories = Category::All();
        return view('admin', compact('contacts', 'categories'));
    }
}
