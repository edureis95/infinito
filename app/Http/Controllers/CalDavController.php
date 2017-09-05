<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\External\simpleCalDAV\SimpleCalDAVClient;
date_default_timezone_set('Europe/London');


use Input;
use Auth;
use Sabre\VObject;

class CalDavController extends SchedulerController
{
    public function addEventToCalDav(Request $r) {
        $client = new SimpleCalDAVClient();
        $client->connect('https://mail.elementofinito.com:2080/rpc/calendars/' . Auth::user()->email . '/', Auth::user()->email, 'ElementoFinitoEmail0');

        $arrayOfCalendars = $client->findCalendars();

        $client->setCalendar($arrayOfCalendars[key($arrayOfCalendars)]);

        $vcalendar = new VObject\Component\VCalendar([
            'VEVENT' => [
                'UID' => 'infinito-' . $r['id'],
                'SUMMARY' => $r['text'],
                'DTSTART' => new \DateTime($r['start_date']),
                'DTEND'   => new \DateTime($r['end_date'])
            ]
        ]);

        return $vcalendar->serialize();
        //$client->create($vcalendar->serialize());

    }

    public function cenas() {
        $client = new SimpleCalDAVClient();
        $client->connect('https://mail.elementofinito.com:2080/rpc/calendars/' . Auth::user()->email . '/', Auth::user()->email, 'ElementoFinitoEmail0');

        $arrayOfCalendars = $client->findCalendars();

        $client->setCalendar($arrayOfCalendars[key($arrayOfCalendars)]);

        $vcalendar = new VObject\Component\VCalendar([
            'VEVENT' => [
                'UID' => 'infinito-191',
                'SUMMARY' => 'cenas',
                'DTSTART' => '20170812T080000',
                'DTEND'   => '20170812T090000'
            ]
        ]);

        $client->create($vcalendar->serialize());
    }

    function get_decorated_diff($old, $new){
        $from_start = strspn($old ^ $new, "\0");        
        $from_end = strspn(strrev($old) ^ strrev($new), "\0");

        $old_end = strlen($old) - $from_end;
        $new_end = strlen($new) - $from_end;

        $start = substr($new, 0, $from_start);
        $end = substr($new, $new_end);
        $new_diff = substr($new, $from_start, $new_end - $from_start);  
        $old_diff = substr($old, $from_start, $old_end - $from_start);

        $new = "$start<ins style='background-color:#ccffcc'>$new_diff</ins>$end";
        $old = "$start<del style='background-color:#ffcccc'>$old_diff</del>$end";
        return array("old"=>$old, "new"=>$new);
    }

    public function teste() {
        $client = new SimpleCalDAVClient();
        $client->connect('https://mail.elementofinito.com:2080/rpc/calendars/adm@elementofinito.com/calendar:22cd9602-bbd2-5fdb-42d2-91b80107b2c7', 'adm@elementofinito.com', 'Yzw9h8ez1');

        $arrayOfCalendars = $client->findCalendars();

        $client->setCalendar($arrayOfCalendars["calendar:22cd9602-bbd2-5fdb-42d2-91b80107b2c7"]);
        $events = $client->getEvents();
        $firstEvent = $events[0];
        $eventData = $events[0]->getData();

        
        $eventData = '{"' . $eventData . '""}';
        $eventData = str_replace(':', '":"', $eventData);

      
        $eventData = json_encode($eventData);

        $eventData = str_replace('\n', '", "', $eventData);
        
        $eventData = str_replace('\"', '"', $eventData);
        $eventData = str_replace('"{', '{', $eventData);
        $eventData = str_replace(', """}"', '}', $eventData);


        $numberBegin = substr_count($eventData, 'BEGIN');
        $numberEnd = substr_count($eventData, 'END');
        $i = 1;
        $j = 1;
        $eventData = preg_replace_callback('/"BEGIN"/', function($match) use (&$i) {
            return '"BEGIN' . $i++ . '"';
        }, $eventData);
        $eventData = preg_replace_callback('/"END"/', function($match) use (&$j) {
            return '"END' . $j++ . '"';
        }, $eventData);

        $eventData = (array)json_decode($eventData);
        $eventData['SUMMARY'] = 'Teste alteracao remota';
        $changed = json_encode($eventData);
        //$changed = str_replace('" "', '"' . chr(hexdec(0x0a)) . '"', $changed);
        $changed = str_replace('"', '', $changed);
        $changed = str_replace(',', chr(hexdec('0x0a')), $changed);
        $changed = str_replace('{', '', $changed);
        $changed = str_replace('}', '', $changed);



        for($k = 1; $k <= $numberBegin; $k++) {
            $begin = 'BEGIN' . $k;
            $changed = str_replace($begin, 'BEGIN', $changed);
        }

        for($k = 1; $k <= $numberEnd; $k++) {
            $end = 'END' . $k;
            $changed = str_replace($end, 'END', $changed);
        }

        $changed = str_replace('\/\/', '//', $changed);

        $client->change($firstEvent->getHref(), $changed, $firstEvent->getEtag());

    }

    public function getEventsFormatted() {
        if(Auth::user()->email_password != null) {
            /*$client = new SimpleCalDAVClient();
            $client->connect('https://mail.elementofinito.com:2080/rpc/calendars/' . Auth::user()->email . '/', Auth::user()->email, decrypt(Auth::user()->email_password));


            $arrayOfCalendars = $client->findCalendars();

            $client->setCalendar($arrayOfCalendars[key($arrayOfCalendars)]);

            $events = $client->getEvents();

            $eventsJSON = array();

            foreach ($events as $event) {
                $eventData = $event->getData();

                $split = explode('END:VEVENT', $eventData);

                $eventData = $split[0];

                $eventData = '{"' . $eventData . '""}';
                $eventData = str_replace(':', '":"', $eventData);

              
                $eventData = json_encode($eventData);

                $eventData = str_replace('\n', '", "', $eventData);
                
                $eventData = str_replace('\"', '"', $eventData);
                $eventData = str_replace('"{', '{', $eventData);
                $eventData = str_replace(', """}"', '}', $eventData);


                $numberBegin = substr_count($eventData, 'BEGIN');
                $numberEnd = substr_count($eventData, 'END');
                $i = 1;
                $j = 1;
                $eventData = preg_replace_callback('/"BEGIN"/', function($match) use (&$i) {
                    return '"BEGIN' . $i++ . '"';
                }, $eventData);
                $eventData = preg_replace_callback('/"END"/', function($match) use (&$j) {
                    return '"END' . $j++ . '"';
                }, $eventData);

                $eventData = (array)json_decode($eventData);

                if(!empty($eventData['DTSTART;TZID=Europe/Lisbon'])) {
                    $text = $eventData['SUMMARY'];
                    $start_date = $eventData['DTSTART;TZID=Europe/Lisbon'];
                    $end_date = $eventData['DTEND;TZID=Europe/Lisbon'];
                    $start_date = date_create($start_date);
                    $start_date = $start_date->format('Y-m-d H:i:s');

                    $end_date = date_create($end_date);
                    $end_date = $end_date->format('Y-m-d H:i:s');

                } else if(empty($eventData['DTSTART']) || empty($eventData['DTEND'])) {
                    $text = $eventData['SUMMARY'];
                    $start_date = $eventData['DTSTART;TZID=Europe/London'];
                    $end_date = $eventData['DTEND;TZID=Europe/London'];
                    $start_date = date_create($start_date);
                    $start_date = $start_date->format('Y-m-d H:i:s');

                    $end_date = date_create($end_date);
                    $end_date = $end_date->format('Y-m-d H:i:s');

                } else {
                    $text = $eventData['SUMMARY'];
                    $start_date = $eventData['DTSTART'];
                    $end_date = $eventData['DTEND'];

                    $start_date = date_create($start_date);
                    date_add($start_date, date_interval_create_from_date_string('1 hours'));
                    $start_date = $start_date->format('Y-m-d H:i:s');

                    $end_date = date_create($end_date);
                    date_add($end_date, date_interval_create_from_date_string('1 hours'));
                    $end_date = $end_date->format('Y-m-d H:i:s');
                }
                $eventsJSON[] = array('start_date' => $start_date, 'end_date' => $end_date, 'text' => $text);
            }

            $fp = fopen('calendars/'. Auth::user()->email . '.json', 'w');
            fwrite($fp, json_encode($eventsJSON));
            fclose($fp);*/

            return $this->showCalendar();
        } else {
            return $this->showCalendar();
        }
    }
    
}
