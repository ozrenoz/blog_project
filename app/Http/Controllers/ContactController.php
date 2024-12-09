<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

class ContactController extends Controller
{
    public function contactUs(){
        return view('front.pages.contact_us');
        }
    
    /*metoda za slanje maila*/
    public function formUpload(Request $request){
     
    
    /*recaptcha*/    
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LfU_k0qAAAAAPLG1kUL4PnrSEaen1O3_pg9laqC'; 
    $recaptcha_response = $request->input('g-recaptcha-response');

    
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    
    if (!$recaptcha->success) {
        return back()->withErrors(['captcha' => 'ReCAPTCHA verification failed. Please try again.']);
    }
        
    /*validacija&slanje maila*/    
         $formData = $request->validate([
            'name' => ['required','string','min:2','max:30'],
            'email' => ['required','email'],
            'message' => ['required','string','min:10','max:500']
        ]);
         
         Mail::to('ozrenop@gmail.com')->send(new ContactUs($formData['name'],$formData['email'],$formData['message']));
         
         session()->put('system_message', 'Your message has been recived');
         
         return redirect()->route('contact_us_page');
    }
}
