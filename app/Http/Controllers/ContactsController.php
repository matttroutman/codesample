<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contacts;
use App\ContactDetails;
use Auth;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $contacts = Contacts::where('user_id',Auth::user()->id)->get();
         return view('contacts', array('contacts' => $contacts));
    }

    public function showall()
    {
         $contacts = Contacts::where('user_id',Auth::user()->id)->get();
         $contacts = json_encode($contacts);
         return response()->json($contacts);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
          $get = $request->get('first_name');
          $contacts = new Contacts;
          $contacts->first_name = $request->get('first_name');
          $contacts->last_name = $request->get('last_name');
          $contacts->email = $request->get('email');
          $contacts->phone = $request->get('phone');
          $contacts->user_id = $request->get('user_id');
          $contacts->save();

          $newContactData = array(
               'first_name' => $request->get('first_name'),
               'last_name' => $request->get('last_name'),
               'email' => $request->get('email'),
               'phone' => $request->get('phone')
          );
          $ac = app('ActiveCampaign');
          $acresponse  = $this->syncContact($newContactData, $ac);

          return view('response', array('response' => 'Created! '.$get));
    }

    public function syncContact(array $newContactData, \ActiveCampaign $ac)
    {
        return $ac->api('contact/sync', $newContactData)->success;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $contact = Contacts::find($id);
        $contactDetails = ContactDetails::where('contact_id',$id)->get();
        $contact['details'] = $contactDetails;
        $contact = json_encode($contact);
        //return view('response', array('response' => $contact));
        return response()->json($contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request)
    {
        //
          $id = $request->get('id');
          $contacts = Contacts::find($id);
          $contacts->first_name = $request->get('efirst_name');
          $contacts->last_name = $request->get('elast_name');
          $contacts->phone = $request->get('ephone');
          $contacts->save();

          $newContactData = array(
               'first_name' => $request->get('efirst_name'),
               'last_name' => $request->get('elast_name'),
               'email' => $request->get('hemail'),
               'phone' => $request->get('ephone')
          );
          $ac = app('ActiveCampaign');
          $acresponse  = $this->syncContact($newContactData, $ac);

          return view('response', array('response' => 'updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function createDetail(Request $request)
    {

          $contactDetails = new ContactDetails;
          $contactDetails->value = $request->get('custom_field');
          $contactDetails->contact_id = $request->get('id');
          $contactDetails->save();

          return view('response', array('response' => 'Created Detail'));
    }

    public function removeDetail($id)
    {

          ContactDetails::destroy($id);
          return view('response', array('response' => 'Removed Detail'));
    }
}
