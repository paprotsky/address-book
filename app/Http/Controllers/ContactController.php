<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::where(['user_id' => Auth::user()->id])->get();

        return response()->json([
            'contacts' => $contacts,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact_data = json_decode($request->contact);

        $contact = Contact::create([
            'first_name' => $contact_data->first_name,
            'last_name' => $contact_data->last_name,
            'address' => $contact_data->address,
            'email' => $contact_data->email,
            'notes' => $contact_data->notes,
            'phone' => $contact_data->phone,
            'user_id' => Auth::user()->id
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->storeAs(
                'public/avatars', $contact->id . '.' . $request->file('file')->getClientOriginalExtension()
            );
            $contact->avatar = str_replace("public", "storage", $path);
            $contact->save();
        }

        return response()->json([
            'contact' => $contact,
            'message' => 'Contact have been created successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact_data = json_decode($request->contact);

        $contact = Contact::find($id);
        if ($request->hasFile('file')) {
            $path = $request->file('file')->storeAs(
                'public/avatars', $id . '.' . $request->file('file')->getClientOriginalExtension()
            );
            $contact->avatar = str_replace("public", "storage", $path);
        }
        $contact->first_name = $contact_data->first_name;
        $contact->last_name = $contact_data->last_name;
        $contact->address = $contact_data->address;
        $contact->email = $contact_data->email;
        $contact->notes = $contact_data->notes;
        $contact->phone = $contact_data->phone;
        $contact->save();

        return response()->json([
            'message' => 'Contact have been updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'message' => 'Contact have been deleted successfully!'
        ], 200);
    }

    public function upload(Request $request)
    {
        return response()->json([
            'message' => 'Upload success!',
        ], 200);
    }
}
