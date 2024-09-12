<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(){
        $contacts = Contacts::all();
        return view('front-end.contacts', compact('contacts'));
    }

    public function store(Request $request)
    {
        // Validate Data
        $validateData = $request->validate([
            'name' => 'string|required',
            'mobile' => 'string|required',
            'email' => 'string|required',
            'tags' => 'string|required', 
        ]);

        // Create new instance for contact
        $contact = new Contacts();
        $contact->name = $validateData['name'];
        $contact->mobile = $validateData['mobile'];
        $contact->email = $validateData['email'];
        $contact->tags = $validateData['tags']; // encode the array as JSON

        $contact->save();

        return redirect()->route('contacts.index')->with('Contact added successfully');
    }


    public function update(Request $request, $id){

        // validateData
        $validateData = $request->validate([
            'name' => 'string|required',
            'mobile' => 'string|required',
            'email' => 'string|required',
            'tags' => 'string|required',
        ]);

        // find contact by id 
        $contact = Contacts::findOrFail($id);

        // update contact details
        $contact -> name = $validateData['name'];
        $contact -> mobile = $validateData['mobile'];
        $contact -> email = $validateData['email'];
        $contact -> tags = $validateData['tags'];

        $contact -> save();

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
    }


    public function destroy($id){
        $contact = Contacts::findOrFail($id);

        $contact-> delete();

        return redirect()->route('contacts.index')->with('success', 'Contact Deleted Successfully');
    }

}
