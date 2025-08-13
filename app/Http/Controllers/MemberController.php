<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Cloudinary\Cloudinary;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DailyLog;
use App\Models\SalesReport;
use Carbon\Carbon;

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
    
    public function showManageMembers()
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
    public function validateMemberId($id)
    {
        $member = Member::where('id', $id)->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'error' => 'Member ID is invalid',
                'member_id' => null
            ]);
        }
    
        return response()->json([
            'success' => true,
            'error' => null,
            'member_id' => $member->id,
            'member_type' => $member->member_type,
            'membership_term_gym_access' => $member->membership_term_gym_access,
            'with_pt' => $member->with_pt
        ]);
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
            'member_type' => 'required|string|max:100',
            // The following fields are required only when creating a new member.
            'membership_term_gym_access' => $memberId ? 'sometimes|string|max:100' : 'required|string|max:100',
            'membership_term_billing_rate' => $memberId ? 'sometimes|numeric|min:0' : 'required|numeric|min:0',
            'with_pt' => $memberId ? 'sometimes|string|max:100' : 'required|string|max:100',
            'with_pt_billing_rate' => $memberId ? 'sometimes|numeric|min:0' : 'required|numeric|min:0',
            'gym_access_start_date' => 'nullable|date',
            'gym_access_end_date' => 'nullable|date',
            'pt_start_date' => 'nullable|date',
            'pt_end_date' => 'nullable|date',
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
            
            if ($validated['membership_term_gym_access'] === '1 month') {
                $validated['gym_access_start_date'] = now()->toDateString();
                $validated['gym_access_end_date'] = now()->addMonth()->toDateString();
            }
            else if ($validated['membership_term_gym_access'] === '3 months') {
                $validated['gym_access_start_date'] = now()->toDateString();
                $validated['gym_access_end_date'] = now()->addMonths(3)->toDateString();
            }

            if($validated['with_pt'] === '1 month'){
                $validated['pt_start_date'] = now()->toDateString();
                $validated['pt_end_date'] = now()->addMonth()->toDateString();
            }

            Member::create([
                'photo_url' => $result['secure_url'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'date_of_birth' => $validated['date_of_birth'],
                'weight_kg' => $validated['weight_kg'],
                'height_cm' => $validated['height_cm'],
                'id_presented' => $validated['id_presented'],
                'id_number' => $validated['id_number'],
                'address' => $validated['address'],
                'membership_start_date' => now()->toDateString(),
                'membership_end_date' => now()->addYear()->toDateString(), 
                'gym_access_start_date' => $validated['gym_access_start_date'] ?? null,
                'gym_access_end_date' => $validated['gym_access_end_date'] ?? null,
                'pt_start_date' => $validated['pt_start_date'] ?? null,
                'pt_end_date' => $validated['pt_end_date'] ?? null,
                'membership_term_gym_access' => $validated['membership_term_gym_access'],
                'member_type' => $validated['member_type'],
                'with_pt' => $validated['with_pt'],
                'with_pt_billing_rate' => $validated['with_pt_billing_rate'],
                'membership_term_billing_rate' => $validated['membership_term_billing_rate'],
                'emergency_contact_person' => $validated['emergency_contact_person'],
                'emergency_contact_number' => $validated['emergency_contact_number'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $this->salesReportEntry(now()->toDateString(), $validated);

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
        return redirect()->route('manage-members.index')->with('success', 'Member added successfully!');
    }
    public function updateMember(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $staffUser = User::where('username', 'staff_access')->first();

        if($request->password === $staffUser->password){
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
                return redirect()->route('member-details.show', $member->id)->with('success', 'Member updated successfully!');
            } catch (ValidationException $e) {
                return redirect()->back()->withErrors($e->validator)->withInput();
            }
        }
        else if($request->password !== $staffUser->password){
            return redirect()->back()->with('error', 'Incorrect staff password. Update cancelled.');
        }
        else{
            return redirect()->back()->with('error', 'Error updating member. Please try again.');
        }
    }
    public function deletedMember(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        // Find the admin user and verify the password
        $adminUser = User::where('username', 'admin_access')->first();
        
        if (!$adminUser || $adminUser->password !== $request->password) {
            return redirect()->back()->with('error', 'Incorrect admin password. Deletion cancelled.');
        }

        $member = Member::findOrFail($id);

        try {
            $member->delete();
            return redirect()->route('manage-members.index')->with('success', 'Member deleted successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
    public function searchMember(Request $request)
    {
        $query = Member::query();
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('full_name', 'LIKE', "%{$search}%");
            });
        }
        
        $members = $query->orderBy('id', 'desc')->get();
        
        // If it's an AJAX request (for future implementation)
        if ($request->ajax()) {
            return response()->json($members);
        }
        
        return view('pages.members', compact('members'));
    }
    public function salesReportEntry($date, $request)
    {
        $salesReport = SalesReport::where('date', $date)->first();
        
        if($salesReport){
            //update
        }
        else{

            SalesReport::create([
                'date' => $date,
                'memberships_only' => 1,
                'walk_in_regular_on_sign_up' => 0,
                'walk_in_student_on_sign_up' => 0,
                'personal_trainer_on_sign_up' => 0,
                '1_month_regular' => 0,
                '1_month_student' => 0,
                '3_months_regular' => 0,
                '3_months_student' => 0,
                'walk_in_regular' => 0,
                'walk_in_student' => 0,
                'gym_access_1_month_regular' => 0,
                'gym_access_1_month_student' => 0,
                'gym_access_3_months_regular' => 0,
                'gym_access_3_months_student' => 0,
                'personal_trainer_1_month' => 0,
                'personal_trainer_walk_in' => 0,
                'total_sales' => 0,
            ]);
        }        
    }
}
