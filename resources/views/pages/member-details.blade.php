<x-layout>
    <!-- Edit Profile Modal -->
    <x-modals.edit-profile-modal :member="$member"/>
    <!-- Delete Member Modal -->
    <x-modals.delete-modal 
        modalId="deleteMemberModal"
        title="Delete Member"
        message="Are you sure you want to delete this member?"
        routeName="delete-member"
        :itemId="$member->id"
    />
    <div class="container mx-auto px-4 py-8">
        <!-- Back button -->
        <x-navigate-back :href="route('members.index')">
            Back to Members
        </x-navigate-back>
        <x-alert/>
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Profile Photo -->
                <div class="md:w-1/4 bg-gray-100 p-6 flex flex-col items-center py-10">
                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-md">
                        @if($member->photo_url)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->full_name }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default_avatar.png') }}" alt="Default Avatar" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <h1 class="mt-4 text-2xl font-bold text-gray-800 text-center">{{ $member->full_name }}</h1>
                    @if($member->white_noise_id)
                        <p class="text-gray-600 mb-5">{{ $member->white_noise_id }}</p>
                    @endif
                    <p class="text-gray-600">Member Since {{ \Carbon\Carbon::parse($member->created_at)->format('M Y') }}</p>
                    
                    <!-- Membership Status Badge -->
                    @php
                        $now = now();
                        $membershipStartDate = \Carbon\Carbon::parse($member->membership_start_date);
                        $membershipEndDate = \Carbon\Carbon::parse($member->membership_end_date);
                        $gymAccessStartDate = \Carbon\Carbon::parse($member->gym_access_start_date);
                        $gymAccessEndDate = \Carbon\Carbon::parse($member->gym_access_end_date);
                        $ptStartDate = \Carbon\Carbon::parse($member->pt_start_date);
                        $ptEndDate = \Carbon\Carbon::parse($member->pt_end_date);
                        $isActiveMembership = $now->betweenIncluded($membershipStartDate, $membershipEndDate);
                        $isActiveGymAccess = $now->betweenIncluded($gymAccessStartDate, $gymAccessEndDate);
                        $isActivePT = $now->betweenIncluded($ptStartDate, $ptEndDate);
                    @endphp
                    <span class="mt-2 px-4 py-1 rounded-full text-sm font-medium {{ $isActiveMembership ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $isActiveMembership ? 'Active' : 'Expired' }} Membership
                    </span>
                    @if($member->gym_access_start_date && $member->gym_access_end_date)
                        <span class="mt-2 px-4 py-1 rounded-full text-sm font-medium {{ $isActiveGymAccess ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $isActiveGymAccess ? 'Active' : 'Expired' }} Gym Access
                        </span>
                    @endif
                    @if($member->membership_term_gym_access === 'Walk in')
                        <span class="mt-2 px-4 py-1 rounded-full text-sm font-medium {{ $isActiveMembership ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $isActiveMembership ? 'Active' : 'Expired' }} Walk In
                        </span>
                    @endif
                    @if($member->pt_start_date && $member->pt_end_date)
                        <span class="mt-2 px-4 py-1 rounded-full text-sm font-medium {{ $isActivePT ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $isActivePT ? 'Active' : 'Expired' }} Personal Training
                        </span>
                    @endif
                </div>
                <!-- Member Details -->
                <div class="md:w-3/4 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contact Information -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Contact Information</h2>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $member->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium">{{ $member->phone_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="font-medium">{{ $member->address }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date of Birth</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('F j, Y') }} ({{ \Carbon\Carbon::parse($member->date_of_birth)->age }} years old)</p>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Emergency Contact</h2>
                            <div>
                                <p class="text-sm text-gray-500">Contact Person</p>
                                <p class="font-medium">{{ $member->emergency_contact_person }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Contact Number</p>
                                <p class="font-medium">{{ $member->emergency_contact_number }}</p>
                            </div>
                        </div>

                        <!-- Membership Details -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Membership Details</h2>
                            <div>
                                <p class="text-sm text-gray-500">Membership Term</p>
                                <p class="font-medium">{{ $member->membership_term_gym_access == 'none' ? 'None' : $member->membership_term_gym_access }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Membership Start Date</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($member->membership_start_date)->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Membership End Date</p>
                                <p class="font-medium {{ $isActiveMembership ? 'text-green-600' : 'text-red-600' }}">
                                    {{ \Carbon\Carbon::parse($member->membership_end_date)->format('F j, Y') }}
                                    @if($isActiveMembership)
                                        ({{ (int)abs(\Carbon\Carbon::parse($member->membership_end_date)->addDay()->diffInDays(now())) }} days remaining)
                                    @else
                                        (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->membership_end_date))) }} days ago)
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Gym Access Start Date</p>
                                <p class="font-medium">{{ $member->gym_access_start_date ? \Carbon\Carbon::parse($member->gym_access_start_date)->format('F j, Y') : 'No Term Active' }}</p>
                            </div>
                            <div>
                                @if($member->gym_access_end_date)
                                    <p class="text-sm text-gray-500">Gym Access End Date</p>
                                    <p class="font-medium {{ $isActiveGymAccess ? 'text-green-600' : 'text-red-600' }}">
                                        {{ \Carbon\Carbon::parse($member->gym_access_end_date)->format('F j, Y') }}
                                        @if($isActiveGymAccess)
                                            ({{ (int)abs(\Carbon\Carbon::parse($member->gym_access_end_date)->addDay()->diffInDays(now())) }} days remaining)
                                        @else
                                            (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->gym_access_end_date))) }} days ago)
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Personal Trainer Start Date</p>
                                <p class="font-medium">{{ $member->pt_start_date ? \Carbon\Carbon::parse($member->pt_start_date)->format('F j, Y') : 'No Personal Trainer Active' }}</p>
                            </div>
                            <div>
                                @if($member->with_pt === '1 month')
                                    <p class="text-sm text-gray-500">Personal Trainer End Date</p>
                                    <p class="font-medium {{ $isActivePT ? 'text-green-600' : 'text-red-600' }}">
                                        {{ \Carbon\Carbon::parse($member->pt_end_date)->format('F j, Y') }}
                                        @if($isActivePT)
                                            ({{(int)abs(\Carbon\Carbon::parse($member->pt_end_date)->addDay()->diffInDays(now())) }} days remaining)
                                        @else
                                            (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->pt_end_date))) }} days ago)
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        <!-- Billing Rates -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Billing Rates</h2>
                            <div>
                                <p class="text-sm text-gray-500">Member Type:</p>
                                <p class="font-medium"> {{ $member->member_type }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Membership Rate:</p>
                                <p class="font-medium"> ₱ 500/year</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Gym Access Rate:</p>
                                @if($member->membership_term_gym_access == 'None')
                                    <p class="font-medium">None</p>
                                @elseif($member->membership_term_gym_access == 'Walk in')
                                    <p class="font-medium">{{ $member->member_type == 'Student' ? '₱ 100/day' : '₱ 150/day' }}</p>
                                @elseif($member->membership_term_gym_access == '1 month')
                                    <p class="font-medium">{{ $member->member_type == 'Student' ? '₱ 1,000/month' : '₱ 1,500/month' }}</p>
                                @elseif($member->membership_term_gym_access == '3 months')
                                    <p class="font-medium">{{ $member->member_type == 'Student' ? '₱ 2,500 per quarter' : '₱ 4,500 per quarter' }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Personal Trainer Rate:</p>
                                @if($member->with_pt == 'None')
                                    <p class="font-medium">None</p>
                                @elseif($member->with_pt == '1 month')
                                    <p class="font-medium"> ₱ 3,000/month</p>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Additional Information</h2>
                            <div>
                                <p class="text-sm text-gray-500">ID Presented</p>
                                <p class="font-medium">{{ $member->id_presented }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">ID Number</p>
                                <p class="font-medium">{{ $member->id_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Height</p>
                                <p class="font-medium">{{ $member->height_cm }} cm</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Weight</p>
                                <p class="font-medium">{{ $member->weight_kg }} kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($member->notes)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Notes</h2>
                            <p class="text-gray-700">{{ $member->notes }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex space-x-2">
                        <a href="#" data-edit-profile class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Edit Profile
                        </a>
                        <a href="#" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                            Print Details
                        </a>
                        <a href="#" data-delete-member class="px-4 py-2 text-white rounded-md hover:bg-red-700 bg-red-600 transition-colors">
                            Delete Member
                        </a>
                        <a href="{{ route('renew-membership.index', ['renewalType' => 'membership', 'id' => $member->id]) }}" class="px-4 py-2 text-white rounded-md hover:bg-gray-700 bg-black transition-colors">
                            Renew Membership
                        </a>
                        <a href="{{ route('renew-membership.index', ['renewalType' => 'membership_term', 'id' => $member->id]) }}" class="px-4 py-2 text-white rounded-md hover:bg-gray-700 bg-black transition-colors">
                            Renew Membership Term
                        </a>
                        <a href="{{ route('renew-membership.index', ['renewalType' => 'personal_trainer', 'id' => $member->id]) }}" class="px-4 py-2 text-white rounded-md hover:bg-gray-700 bg-black transition-colors">
                            Renew Personal Trainer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>