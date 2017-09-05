<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\External\cardDav\carddav;
use Sabre\VObject;
use stdClass;
use Image;
use File;
use DateTime;
use Auth;

date_default_timezone_set('Europe/London');


class CardDavController extends Controller
{
    public function getContactsTest() {
    	$carddav = new carddav('https://mail.elementofinito.com:2080/rpc/addressbooks/adm@elementofinito.com');

    	$carddav->enable_debug();
 		$carddav->set_auth('adm@elementofinito.com', 'Yzw9h8ez1');
 		$carddav->get();	
 		$str = explode('HTTP/1.1 200 OK', $carddav->get_debug()[0]['response']);
 		
 		$conn = 'https://mail.elementofinito.com:2080' . strip_tags($str[1]);
 		$carddav = new carddav(trim($conn));
 		$carddav->set_auth('adm@elementofinito.com', 'Yzw9h8ez1');
 		$cards = $carddav->get();
 		$cardsList = explode("END:VCARD&#13" . chr(hexdec('0x3b')), $cards);
 		$contacts = array();
 		foreach($cardsList as $card) {
 			if((string)trim(strip_tags($card)) != "") {
 				$card_Id = substr($card, 0, strpos($card, 'B'));
	 			$card = $carddav->get_vcard(str_replace(chr(hexdec('0x0a')), ' ', trim(strip_tags($card_Id))));
	 			$vcard = VObject\Reader::read($card);
	 			$contact = new stdClass();
	 			$contact->EMAIL = (string)$vcard->EMAIL;
	 			$contact->FN = (string)$vcard->FN;
	 			$contacts[] = $contact;
 			}
 		}
 		return view('showContacts', array('contacts' => $contacts));
    }

    public function updateContacts() {
        $contacts = \App\Contact::all();
        $ids = [];
    
        foreach($contacts as $contact) {
            $id = 'contact-elementoFinito-' . $contact->id;
            array_push($ids, $id);
        }
    	$carddav = new carddav('https://cpanel19.dnscpanel.com:2080/rpc/addressbooks/adm@elementofinito.com/contacts~0a7ceb0d-bd6a-cd04-9f5b-c37700bf2cec/');
 		$carddav->set_auth('adm@elementofinito.com', 'ElementoFinitoEmail0');

        $cards = $carddav->get();
        $cardsList = explode("END:VCARD&#13" . chr(hexdec('0x3b')), $cards);
        $contacts = array();
        $i = 0;
        foreach($cardsList as $card) {
            if((string)trim(strip_tags($card)) != "") {
                $carddav = new carddav('https://cpanel19.dnscpanel.com:2080/rpc/addressbooks/adm@elementofinito.com/contacts~0a7ceb0d-bd6a-cd04-9f5b-c37700bf2cec/');
                $carddav->set_auth('adm@elementofinito.com', 'ElementoFinitoEmail0');
                $separate = explode('BEGIN', $card);
                $cardArray = explode(' ', $separate[0]);
                if($i > 0) {
                    $card_id = $cardArray[4];
                    $card = $carddav->get_vcard(trim(strip_tags($cardArray[4])));
                }
                else {
                    $card_id = $cardArray[5];
                    $card = $carddav->get_vcard(trim(strip_tags($cardArray[5])));
                }
                $vcard = VObject\Reader::read($card);
                $i += 1;

                $idToFind = substr($vcard->uid->serialize(), 27);
                $contact = \App\Contact::find($idToFind);
                $pos = array_search($vcard->uid, $ids);
                if($pos !== false) {
                    $vcard = new VObject\Component\VCard([
                        'N' => [$contact->lastName, $contact->firstName, $contact->middleName, '', ''],
                        'UID' => $ids[$pos],
                        'BDAY' => $contact->birthDate,
                        'EMAIL' => $contact->email,
                        'TEL' => $contact->phoneNumber,
                    ]);
                    $vcard->add('ADR', [$contact->doorNumber, '', $contact->address, $contact->city, $contact->region, $contact->zip_code, $contact->country], ['type' => 'HOME']);
                    unset($ids[$pos]);
                    $ids = array_values($ids);
                    $carddav->update($vcard->serialize(), trim(strip_tags($card_id)));
                }
            }
        }

        for($i = 0; $i < count($ids); $i++) {
            $dbId = substr($ids[$i], 23);
            $contact = \App\Contact::find($dbId);
            $vcard = new VObject\Component\VCard([
                'N' => [$contact->lastName, $contact->firstName, $contact->middleName, '', ''],
                'UID' => $ids[$i],
                'BDAY' => $contact->birthDate,
                'EMAIL' => $contact->email,
                'TEL' => $contact->phoneNumber,
            ]);
            $vcard->add('ADR', [$contact->doorNumber, '', $contact->address, $contact->city, $contact->region, $contact->zip_code, $contact->country], ['type' => 'HOME']);

            $carddav->add($vcard->serialize());
        }
    }

    public function getContacts() {
    	$contacts = \App\Contact::orderBy('firstName')->get();
        $companyContacts = \App\Company_Contact::orderBy('name')->get();
        $contactTypes = \App\Contact_Type::all();
        $contactSources = \App\Contact_Source::all();
        return view('showContacts', array('contacts' => $contacts, 'activeL' => 'pessoais', 'companyContacts' => $companyContacts, 'contactTypes' => $contactTypes, 'contactSources' => $contactSources));
    }

    public function getCompanyContacts() {
        $contacts = \App\Company_Contact::leftJoin('users', 'users.id', '=', 'company_contacts.responsiblePerson')
                                        ->select('users.name as responsible_name', 'company_contacts.name as name', 'company_contacts.photo as photo', 'company_contacts.id as id', 'url')
                                        ->orderBy('name')
                                        ->get();

        foreach($contacts as $contact) {
            $emails = \App\Company_Contact_Email::where('company_contact_id', $contact->id)->get();
            $contact->emails = $emails;
        }

        foreach($contacts as $contact) {
            $phones = \App\Company_Contact_Phone::where('company_contact_id', $contact->id)->get();
            $contact->phones = $phones;
        }

        $contactTypes = \App\Company_Contact_Type::all();
        $contactFields = \App\Company_Contact_Field::all();
        $contactDimensions = \App\Company_Contact_Dimension::all();

        return view('showCompanyContacts', array('contacts' => $contacts, 'activeL' => 'empresa', 'contactTypes' => $contactTypes, 'contactFields' => $contactFields, 'contactDimensions' => $contactDimensions));
    }

    public function createContact(Request $r) {
        $contact = new \App\Contact();
        if($r->hasfile('photo')) {
            $photo = $r->file('photo');
            $path = '/uploads/contacts/';

            if($contact->photo != 'default.jpg') {
                File::Delete(public_path($path . $contact->photo));
            }

            $filename = $r['name'] . time() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path . $filename));

            $contact->photo = $filename;
        }
        if($r['company'] != 0)
            $contact->company = $r['company'];
        $contact->firstName = $r['firstName'];
        $contact->lastName = $r['lastName'];
        if($r['middleName'] != "")
            $contact->middleName = $r['middleName'];
        if($r['birthDate'] != "")
            $contact->birthDate = $r['birthDate'];
        if($r['email'] != "")
            $contact->email = $r['email'];
        if($r['phoneNumber'] != "")
            $contact->phoneNumber = $r['phoneNumber'];
        if($r['address'] != "")
            $contact->address = $r['address'];
        if($r['doorNumber'] != "")
            $contact->doorNumber = $r['doorNumber'];
        if($r['city'] != "")
            $contact->city = $r['city'];
        if($r['region'] != "")
            $contact->region = $r['region'];
        if($r['zip_code'] != "")
            $contact->zip_code = $r['zip_code'];
        if($r['country'] != "")
            $contact->country = $r['country'];

        $contact->save();

        return redirect()->back();
    }

    public function createCompanyContact(Request $r) {
        $contact = new \App\Company_Contact();
        $contact->name = $r['name'];
        if($r['responsible_user'] != 0)
            $contact->responsiblePerson = $r['responsible_user'];
        if($r->hasfile('photo')) {
            $photo = $r->file('photo');
            $path = '/uploads/company_contacts/';

            if($contact->photo != 'default.jpg') {
                File::Delete(public_path($path . $contact->photo));
            }

            $filename = $r['name'] . time() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path . $filename));

            $contact->photo = $filename;
        }

        if($r['url'] != "")
            $contact->url = $r['url'];

        $contact->save();

        for($i = 0; $i < count($r['email']); $i++) {
            if($r['email'][$i] != "") {
                $contactEmail = new \App\Company_Contact_Email();
                $contactEmail->company_contact_id = $contact->id;
                $contactEmail->email = $r['email'][$i];
                $contactEmail->save();
            }
        }

        for($i = 0; $i < count($r['phone']); $i++) {
            if($r['phone'][$i] != "") {
                $contactPhone = new \App\Company_Contact_Phone();
                $contactPhone->company_contact_id = $contact->id;
                $contactPhone->phone = $r['phone'][$i];
                $contactPhone->save();
            }
        }

        return redirect()->back();

    }

    public function getContactDetails(Request $r) {
        $contact = \App\Contact::find($r['id']);

        if($contact->company != null)
            $contact->companyName = \App\Company_Contact::find($contact->company)->name;
        if($contact->type_id != null)
            $contact->typeName = \App\Contact_Type::find($contact->type_id)->name;
        if($contact->source_id != null)
            $contact->sourceName = \App\Contact_Source::find($contact->source_id)->name;
        if($contact->responsible_id != null)
            $contact->responsibleName = \App\User::find($contact->responsible_id)->name;

        $projectsWorked = \App\Project_Outside_Team::where('coordinator_id', $r['id'])
                                                      ->join('project', 'project_id', '=', 'project.id')
                                                      ->select('project.name', 'project.number')
                                                      ->get();

        if(!count($projectsWorked))
            $contact->projectsWorked = null;
        else {
            $contact->projectsWorked = "";
            $i = 0;
            $len = count($projectsWorked);
            foreach($projectsWorked as $project) {
                if($i == $len - 1) {
                    $contact->projectsWorked .= str_pad($project->number, 5, '0', STR_PAD_LEFT) . ' - ' . $project->name;
                } else {
                    $contact->projectsWorked .= str_pad($project->number, 5, '0', STR_PAD_LEFT) . ' - ' . $project->name . " | ";
                }
                $i++;
            }
        }

        if($contact->birthDate != null) {
            $date1 = new DateTime($contact->birthDate);
            $contact->birthDate = $date1->format('d-m-y');
            $contact->inputBirthDate = $date1->format('Y-m-d');
        }

        return $contact;
    }

    public function getCompanyContactDetails(Request $r) {
        $contact = \App\Company_Contact::leftJoin('users', 'users.id', '=', 'company_contacts.responsiblePerson')
                                ->where('company_contacts.id', $r['id'])
                                ->select('users.name as responsible_name', 'company_contacts.name as name', 'company_contacts.photo as photo', 'company_contacts.id as id', 'url')
                                ->first();

        return $contact;
    }

    public function editContact(Request $r) {
        $contact = \App\Contact::find($r['id']);
        if($r->hasfile('photo')) {
            $photo = $r->file('photo');
            $path = '/uploads/contacts/';

            if($contact->photo != 'default.jpg') {
                File::Delete(public_path($path . $contact->photo));
            }

            $filename = Auth::user()->name . time() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path . $filename));

            $contact->photo = $filename;
        }
        $contact->firstName = $r['firstName'] != "" ? $r['firstName'] : null;
        $contact->middleName = $r['middleName'] != "" ? $r['middleName'] : null;
        $contact->lastName = $r['lastName'] != "" ? $r['lastName'] : null;
        $contact->birthDate = $r['birthDate'] != "" ? $r['birthDate'] : null;
        $contact->email = $r['email'] != "" ? $r['email'] : null;
        $contact->phoneNumber = $r['phoneNumber'] != "" ? $r['phoneNumber'] : null;
        $contact->address = $r['address'] != "" ? $r['address'] : null;
        $contact->doorNumber = $r['doorNumber'] != "" ? $r['doorNumber'] : null;
        $contact->city = $r['city'] != "" ? $r['city'] : null;
        $contact->region = $r['region'] != "" ? $r['region'] : null;
        $contact->zip_code = $r['zip_code'] != "" ? $r['zip_code'] : null;
        $contact->country = $r['country'] != "" ? $r['country'] : null;
        $contact->company = $r['company'] != 0 ? $r['company'] : null;
        $contact->skype = $r['skype'] != "" ? $r['skype'] : null;
        $contact->position = $r['position'] != "" ? $r['position'] : null;
        $contact->type_id = $r['type'] != 0 ? $r['type'] : null;
        $contact->source_id = $r['source'] != 0 ? $r['source'] : null;
        $contact->responsible_id = $r['responsible'] != 0 ? $r['responsible'] : null;

        $contact->save();
    }

    public function editCompanyContact(Request $r) {
        $contact = \App\Company_Contact::find($r['id']);
        if($r->hasfile('photo')) {
            $photo = $r->file('photo');
            $path = '/uploads/company_contacts/';

            if($contact->photo != 'default.jpg') {
                File::Delete(public_path($path . $contact->photo));
            }

            $filename = Auth::user()->name . time() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path . $filename));

            $contact->photo = $filename;
        }
        $contact->name = $r['name'] != "" ? $r['name'] : null;
        $contact->url = $r['url'] != "" ? $r['url'] : null;
        $contact->responsiblePerson = $r['responsiblePerson'] != 0 ? $r['responsiblePerson'] : null;

        $contact->save();
    }

    public function removeContact(Request $r) {
        \App\Contact::find($r['id'])->delete();
    }
}
