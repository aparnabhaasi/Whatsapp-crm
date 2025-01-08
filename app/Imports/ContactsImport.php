<?php

namespace App\Imports;

use App\Models\Contacts; 
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements ToModel, WithHeadingRow
{
    public $importedContacts = [];

    public function model(array $row)
{
    // Create a new Contact instance
    $contact = Contacts::create([
        'name'   => $row['name'],
        'mobile' => $row['mobile'],
        'email'  => $row['email'],
        'tags'   => json_encode(explode(',', $row['tags'])),
        'app_id' => $row['app_id'],
    ]);

    // Add the saved contact (with ID) to the importedContacts array
    $this->importedContacts[] = $contact;

    return $contact;
}


    public function getImportedContacts()
    {
        return collect($this->importedContacts);
    }
}

