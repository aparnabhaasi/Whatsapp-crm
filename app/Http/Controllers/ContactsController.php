<?php

    namespace App\Http\Controllers;

    use App\Imports\ContactsImport;
    use App\Models\Chats;
    use App\Models\Contacts;
    use App\Models\Broadcasts;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Maatwebsite\Excel\Facades\Excel;

    class ContactsController extends Controller
    {
        // Index method for manual contact management
        public function index()
{
    // Get the authenticated user's app_id
    $authAppId = auth()->user()->app_id;

    // Fetch contacts where the app_id matches the authenticated user's app_id
    $contacts = Contacts::where('app_id', $authAppId)->get();

    // Return the view with filtered contacts
    return view('front-end.contacts', compact('contacts'));
}


        // Store manual contacts
        public function store(Request $request)
{
    try {
        // Validate Data
        $validateData = $request->validate([
            'name' => 'string|required',
            'mobile' => 'string|required',
            'email' => 'string|nullable|email',
            'tags' => 'string|nullable',
        ]);

        $user = Auth::user();
        $app_id = $user->app_id;

        // Create new instance for contact
        $contact = new Contacts();
        $contact->name = $validateData['name'];
        $contact->mobile = $validateData['mobile'];
        $contact->email = $validateData['email'];
        $contact->tags = $validateData['tags']; // encode the array as JSON
        $contact->app_id = $app_id;

        $contact->save();

        return redirect()->route('contacts.index')->with('success', 'Contact added successfully');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Log validation errors
        \Log::error('Validation Error:', [
            'errors' => $e->errors()
        ]);
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        // Log general errors
        \Log::error('Error while storing contact:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'An error occurred while adding the contact.')->withInput();
    }
}


        // Update method for manual contact updates
        public function update(Request $request, $id)
{
    try {
        // Validate Data
        $validateData = $request->validate([
            'name' => 'string|required',
            'mobile' => 'string|required',
            'email' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        // Find contact by id
        $contact = Contacts::findOrFail($id);

        // Update contact details
        $contact->name = $validateData['name'];
        $contact->mobile = $validateData['mobile'];
        $contact->email = $validateData['email'] ?? null; 
        $contact->tags = $validateData['tags'] ?? null; 

        $contact->save();

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
    } catch (\Exception $e) {
        // Log the error message
        \Log::error('Error updating contact: ' . $e->getMessage());

        // Optionally redirect with error message
        return redirect()->route('contacts.index')->with('error', 'Failed to update contact');
    }
}


        // Destroy method for deleting contacts 
        public function destroy($id)
        {
            $contact = Contacts::findOrFail($id);

            // Delete related chats before deleting the contact
            $contact->chats()->delete();

            $contact->delete();

            return redirect()->route('contacts.index')->with('success', 'Contact Deleted Successfully');
        }


        public function uploadContacts(Request $request)
{
    // Validate file upload
    $request->validate([
        'file' => 'required|file|mimes:xlsx,csv',
    ]);

    try {
        // Import contacts from the uploaded file
        $import = new ContactsImport();
        Excel::import($import, $request->file('file'));

        // Get all imported contacts
        $importedContacts = $import->getImportedContacts();

        if ($importedContacts->isEmpty()) {
            return back()->with('error', 'No contacts were imported. Please check your file.');
        }

        // Extract IDs of the imported contacts as strings
        $contactIds = $importedContacts->pluck('id')->map(fn($id) => (string)$id)->toArray();

        // Create a new broadcast group
        $broadcast = new Broadcasts();
        $broadcast->contact_id = $contactIds; // Directly assign array
        $broadcast->broadcast_name = 'Broadcast on ' . now()->format('Y-m-d H:i:s');
        $broadcast->save();

        // Success response
        return back()->with('success', 'Contacts imported and broadcast group created successfully.');
    } catch (\Exception $e) {
        Log::error('An error occurred during contact upload', ['error' => $e->getMessage()]);
        return back()->with('error', 'An error occurred while importing contacts. Contact support.');
    }
}


    }

