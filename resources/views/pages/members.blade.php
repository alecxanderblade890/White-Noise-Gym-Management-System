<x-layout>

<div class="bg-white shadow-md rounded-lg p-6 mb-8">
    <!-- Back button -->
    <a href="{{ route('manage-members.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Gym Members</h1>

    @if($members->isEmpty())
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
        <p class="font-bold">No Members Found</p>
        <p>It looks like there are no members registered yet.</p>
    </div>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
            <table class="min-w-full leading-normal table-container">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left w-16">ID</th>
                        <th class="py-3 px-6 text-left w-16">Photo</th>             
                        <th class="py-3 px-6 text-left w-48">Name</th>             
                        <th class="py-3 px-6 text-left w-64">Email</th>
                        <th class="py-3 px-6 text-left w-32">Phone</th>
                        <th class="py-3 px-6 text-left w-32">Member Type</th>
                        <th class="py-3 px-6 text-left w-40">Membership Start Date</th>
                        <th class="py-3 px-6 text-left w-48">Membership End Date</th>
                        <th class="py-3 px-6 text-left w-32">Gym Access Start Date</th>
                        <th class="py-3 px-6 text-left w-32">Gym Access End Date</th>
                        <th class="py-3 px-6 text-left w-32">With PT</th>
                        <th class="py-3 px-6 text-left w-32">Membership Term Billing Rate</th>
                        <th class="py-3 px-6 text-left w-32">With PT Billing Rate</th>
                        <th class="py-3 px-6 text-left w-80">Address</th>          
                        <th class="py-3 px-6 text-left w-32">Date of Birth</th>
                        <th class="py-3 px-6 text-left w-32">ID Presented</th>
                        <th class="py-3 px-6 text-left w-32">ID Number</th>
                        <th class="py-3 px-6 text-left w-48">Contact Person</th>
                        <th class="py-3 px-6 text-left w-48">Emergency Contact No.</th>
                        <th class="py-3 px-6 text-left w-24">Weight (kg)</th>
                        <th class="py-3 px-6 text-left w-24">Height (cm)</th>
                        <th class="py-3 px-6 text-left w-64">Notes</th>            
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr class="border-b border-gray-200 hover:bg-gray-100" onclick="window.location='{{ route('member-details.show', $member->id) }}'" style="transition: background-color 0.2s;">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->id }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                @if($member->photo_url)
                                    <img src="{{ $member->photo_url }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('images/default_avatar.png') }}" class="w-10 h-10 rounded-full object-cover">
                                @endif
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->full_name }}</td> 
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->email }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->phone_number }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->member_type }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ \Carbon\Carbon::parse($member->membership_start_date)->format('M d, Y') }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ \Carbon\Carbon::parse($member->membership_end_date)->format('M d, Y') }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->gym_access_start_date ? \Carbon\Carbon::parse($member->gym_access_start_date)->format('M d, Y') : '' }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->gym_access_end_date ? \Carbon\Carbon::parse($member->gym_access_end_date)->format('M d, Y') : '' }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->with_pt }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->membership_term_billing_rate }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->with_pt_billing_rate }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->address }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($member->date_of_birth)->age }} yrs)</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->id_presented }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->id_number }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->emergency_contact_person }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->emergency_contact_number }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->weight_kg }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $member->height_cm }}</td>
                            <td class="py-3 px-6 text-left text-sm">{{ $member->notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @endif
</div>
</x-layout>