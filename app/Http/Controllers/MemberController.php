<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Cloudinary\Cloudinary;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    private $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }
    public function index()
    {
        return view('pages.manage-members');
    }

    public function getMembers()
    {
        $members = Member::all();
        return view('pages.members', compact('members'));
    }
    public function showMemberDetails($id)
    {
        $member = Member::find($id);
        return view('pages.member-details', compact('member'));
    }   
    public function registerMemberForm()
    {
        return view('pages.create-member');
    }

    public function validateMember(Request $request, $memberId = null)
    {
        $rules = [
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:' . now()->subYears(13)->format('Y-m-d'),
            'weight_kg' => 'required|numeric|min:0',
            'height_cm' => 'required|numeric|min:0',
            'id_presented' => 'required|string|max:50',
            'id_number' => 'required|numeric',
            'address' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'end_date' => 'required|date|after_or_equal:start_date',
            'billing_rate' => 'required|numeric|min:0',
            'payment_date_membership' => 'required|date',
            'payment_date_gym_access' => 'required|date',
            'membership_term_gym_access' => 'required|string|max:100',
            'emergency_contact_person' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ];

        if ($memberId) {
            $rules['email'] = 'required|email|max:255|unique:members,email,' . $memberId;
        }

        return Validator::make($request->all(), $rules);
    }
    public function addMember(Request $request)
    {
        $validator = $this->validateMember($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $result = $this->cloudinary->uploadApi()->upload($request->file('photo')->getRealPath(), [
            'folder' => 'members',
        ]);

        try {
            Member::create([
                'photo_url' => $result['secure_url'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'weight_kg' => $validated['weight'],
                'height_cm' => $validated['height'],
                'id_presented' => $validated['id_type'],
                'id_number' => $validated['id_number'],
                'address' => $validated['address'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'billing_rate' => $validated['billing_rate'],
                'payment_date_membership' => $validated['payment_date_membership'],
                'payment_date_gym_access' => $validated['payment_date_gym_access'],
                'membership_term_gym_access' => $validated['membership_term'],
                'emergency_contact_person' => $validated['emergency_contact_name'],
                'emergency_contact_number' => $validated['emergency_contact_phone'],
                'notes' => $validated['notes'] ?? null,
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
        return redirect()->route('manage-members.index')->with('success', 'Member added successfully!');
    }
    public function updateMember(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validator = $this->validateMember($request, $member->id);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo')) {
            $result = $this->cloudinary->uploadApi()->upload($request->file('photo')->getRealPath(), [
                'folder' => 'members',
            ]);
            $validated['photo_url'] = $result['secure_url'];
        }

        try {
            $member->update($validated);
            return redirect()->route('member-details.show', $member->id)->with('success', '');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
    public function deletedMember($id)
    {
        $member = Member::findOrFail($id);

        try {
            $member->delete();
            return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
}
