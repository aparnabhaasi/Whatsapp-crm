<?php

    namespace App\Http\Controllers;

    use App\Models\Contacts;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;

    class ContactsController extends Controller
    {
        // Index method for manual contact management
        public function index()
        {
            $contacts = Contacts::all();
            return view('front-end.contacts', compact('contacts'));
        }

        // Store manual contacts
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

        // Update method for manual contact updates
        public function update(Request $request, $id)
        {
            // Validate Data
            $validateData = $request->validate([
                'name' => 'string|required',
                'mobile' => 'string|required',
                'email' => 'string|required',
                'tags' => 'string|required',
            ]);

            // Find contact by id
            $contact = Contacts::findOrFail($id);

            // Update contact details
            $contact->name = $validateData['name'];
            $contact->mobile = $validateData['mobile'];
            $contact->email = $validateData['email'];
            $contact->tags = $validateData['tags'];

            $contact->save();

            return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
        }

        // Destroy method for deleting contacts
        public function destroy($id)
        {
            $contact = Contacts::findOrFail($id);

            $contact->delete();

            return redirect()->route('contacts.index')->with('success', 'Contact Deleted Successfully');
        }


    }

