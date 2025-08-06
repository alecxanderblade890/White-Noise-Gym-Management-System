@if ($errors->any())
    <div class="mb-4">
        <div class="text-red-600 font-semibold">Please fix the following errors:</div>
        <ul class="list-disc list-inside text-red-500">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif