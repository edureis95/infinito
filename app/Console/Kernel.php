<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\External\cardDav\carddav;
use Sabre\VObject;
use stdClass;
use Image;
use File;
use DateTime;
use Auth;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
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
        })->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
