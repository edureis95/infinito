<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;
use Auth;

class EmailController extends Controller
{
    public function teste() {
    	if(Auth::user()->email_password == null)
    		return view('/mail_client');

    	$mailbox = 'mail.elementofinito.com:993';
		$username = Auth::user()->email;
		$password = decrypt(Auth::user()->email_password);
		$encryption = Imap::ENCRYPT_SSL;

		try{
		    $imap = new Imap($mailbox, $username, $password, $encryption);
		    // You can also check out example-connect.php for more connection options

		    $folders = $imap->getFolders();
			
			$imap->selectFolder('INBOX');
			$overallMessages = $imap->countMessages();
			$unreadMessages = $imap->countUnreadMessages();

			$emails = $imap->getMessages();
			$simplifiedEmails = array();
			foreach ($emails as $key => $email) {
				$date = $email->header->date;
				$date = date_create($date);
				$date = $date->format('d-m-y H:i');
				$email->header->dateFormatted = $date;

				$email->header->key = $key;

				$simplifiedEmail = array();
				array_push($simplifiedEmail, $email->header->subject);
				array_push($simplifiedEmail, $email->header->dateFormatted);
				array_push($simplifiedEmail, $email->header->from);
				array_push($simplifiedEmail, $email->message->text->body);
				array_push($simplifiedEmail, $email->header->uid);
				if(!empty($email->message->html)) {
					array_push($simplifiedEmail, $email->message->html->body);
				}
				array_push($simplifiedEmails, $simplifiedEmail);
			}

			return view('/mail_client', array('emailsInbox' => $emails, 'unreadMessagesInbox' => $unreadMessages, 'simplifiedEmails' => json_encode($simplifiedEmails)));

		}catch (ImapClientException $error){
		    echo $error->getMessage().PHP_EOL; // You know the rule, no errors in production ...
		    die(); // Oh no :( we failed
		}
    }

    public function setSeen(Request $r) {
    	$mailbox = 'mail.elementofinito.com:993';
		$username = Auth::user()->email;
		$password = decrypt(Auth::user()->email_password);
		$encryption = Imap::ENCRYPT_SSL;
		try{
	    	$imap = new Imap($mailbox, $username, $password, $encryption);
	    	$imap->selectFolder('INBOX');
	    	$imap->setseenMessage($r['message_id']);
	    } catch (ImapClientException $error){
		    echo $error->getMessage().PHP_EOL; // You know the rule, no errors in production ...
		    die(); // Oh no :( we failed
		}
    }

    public function setMailPassword(Request $r) {
    	$user = \App\User::find(Auth::user()->id);
    	$user->email_password = encrypt($r['password']);
    	$user->save();

    	return redirect()->back();
    }

    public function getRoundCubeMail() {
    	return view('/mail_client');
    }
}
