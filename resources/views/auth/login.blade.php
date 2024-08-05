<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div id="form_wrapper">
        <div id="form_left">
            <img src="{{tracesciimg('login_picture.jpg')}}" alt="">
            <img class="logo-tracesci mx-auto" src="{{tracesciimg('logo.png')}}" alt="computer icon">
            <!-- <img src="{{tracesciimg('old_logo2.jpg')}}" alt="image"> -->
        </div>

        <form method="POST" action="{{ route('login') }}">
    @csrf
    <!-- Email Address -->
    <div id="form_right">
        <div style="font-size: xx-large; font-weight: 900;">SIGN IN</div>

        <!-- Email Input -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                <h3 style="margin-top: 45px;">Email:</h3>
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                required 
                autocomplete="username" 
                class="input_container border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm input_field"
                placeholder="Enter your email"
            >
            @error('email')
                <p class="text-red-500 text-sm mt-1" style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Input -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                <h3 style="margin: 10px;">Password:</h3>
            </label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" 
                class="input_container border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm input_field"
                placeholder="Enter your password"
            >
            @error('password')
                <p class="text-red-500 text-sm mt-1" style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center" style="margin-left: 10px;">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember" 
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                >
                <span class="text-sm text-gray-600 dark:text-gray-400" style="margin-left: 10px;">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Forgot Password -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a 
                    href="{{ route('password.request') }}" 
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    style="margin-left: 10px;"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <x-primary-button id="input_submit">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </div>
</form>



    </div>

</x-guest-layout>