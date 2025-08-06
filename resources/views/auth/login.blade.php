<x-auth-layout>
    <div class="max-w-md mx-auto mt-5 bg-black rounded-xl shadow-md p-4">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-30 w-28" src="{{asset('images/white_noise_gym_logo.png')}}" alt="White Noise Gym" />
                <h2 class="text-center text-2xl/9 font-bold tracking-tight text-white">Whitenoise Gym</h2>
            </div>

            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <!-- validation errors -->
            @if ($errors->any())
            <ul class="px-4 py-2 bg-white">
                @foreach ($errors->all() as $error)
                <li class="my-2 text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <form class="space-y-6" action="{{ route('login.auth') }}" method="POST">
                @csrf
                <div>
                    <label for="username" class="block text-sm/6 font-medium text-white">Username</label>
                    <div class="mt-2">
                        <input type="text" name="username" id="username" autocomplete="username" required class="block w-full rounded-md bg-gray-900 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-white sm:text-sm/6" />
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
                        <!-- <div class="text-sm">
                            <a href="#" class="font-semibold text-black hover:text-gray-500">Forgot password?</a>
                        </div> -->
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-gray-900 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-white sm:text-sm/6" />
                    </div>
                </div>
                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2 bg-white text-gray-900 hover:bg-gray-300">
                        Sign in
                    </button>                
                </div>
            </form>
        </div>
    </div>
    </div>
</x-auth-layout>