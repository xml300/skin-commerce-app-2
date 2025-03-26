@extends('layouts.admin.admin_dashboard') {{-- Assuming this is your redesigned layout --}}

@section('content')
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            My Profile
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Manage your profile information and password.
        </p>
    </div>

    {{-- Success/Error Messages --}}
    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-300" role="alert">
            Profile information saved successfully.
        </div>
    @endif
     @if (session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-300" role="alert">
            Password updated successfully.
        </div>
    @endif
     {{-- Add similar blocks for error messages if needed --}}


    <div class="space-y-6">
        {{-- Profile Information Card --}}
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Profile Information</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Update your account's profile information and email address.
                </p>
            </div>

            {{-- Assuming you have route like 'admin.profile.update' --}}
            <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch') {{-- Or PUT, depending on your route definition --}}

                <div class="p-6 space-y-6">

                    {{-- Name Input --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', Auth::user()->first_name) }}" required
                               class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                         @enderror
                    </div>

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', Auth::user()->email) }}" required
                               class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('email')
                             <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                         @enderror
                        {{-- Add message if email requires verification after change --}}
                    </div>

                    {{-- Display Role and Joined Date (Non-Editable) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white capitalize">{{ Auth::user()->user_type == 1 ? 'Admin' : 'Customer' }}</dd> {{-- Adjust based on your role field --}}
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ Auth::user()->created_at->format('M d, Y') }}</dd>
                        </div>
                    </div>

                </div>

                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
                        Save Changes
                    </button>
                </div>
            </form>
        </div> {{-- End Profile Information Card --}}


        {{-- Update Password Card --}}
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Update Password</h3>
                 <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Ensure your account is using a long, random password to stay secure.
                </p>
            </div>

            {{-- Assuming you have route like 'admin.password.update' --}}
            <form method="post" action="{{ route('admin.password.update') }}">
                 @csrf
                 @method('put') {{-- Standard method for password updates --}}

                <div class="p-6 space-y-4">
                     {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="current_password" id="current_password" required autocomplete="current-password"
                               class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                         @error('current_password', 'updatePassword') {{-- Target specific error bag --}}
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                         @enderror
                    </div>

                     {{-- New Password --}}
                    <div>
                         <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                               class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                         @error('password', 'updatePassword')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                         @enderror
                    </div>

                     {{-- Confirm New Password --}}
                    <div>
                         <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                               class="p-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                         @error('password_confirmation', 'updatePassword')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                         @enderror
                    </div>
                </div>

                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 dark:focus:ring-indigo-700 disabled:opacity-25 transition ease-in-out duration-150">
                        Update Password
                    </button>
                </div>
            </form>
        </div> {{-- End Update Password Card --}}
    </div> {{-- End space-y-6 --}}

@endsection
{{-- Notes:
1. Controller Logic:
   - You need controllers and methods to handle the form submissions for `admin.profile.update` and `admin.password.update`.
   - Profile Update: Validate name, email (potentially check for uniqueness if changed), handle avatar upload (store file, update path in DB).
   - Password Update: Use Laravel's built-in `Password::rules()` for validation. Validate `current_password` against the user's actual password. Hash the new password before saving. Use specific error bags (e.g., 'updatePassword') to separate validation errors.
2. Routes: Define PATCH/PUT route for profile and PUT route for password update in your `routes/web.php` or `admin.php`.
3. User Model:
   - Ensure `name`, `email`, `password`, `avatar` (or similar) fields exist.
   - Consider an accessor like `getAvatarUrlAttribute()` to generate the full URL for the avatar, handling defaults.
4. File Storage: Configure your `config/filesystems.php` and run `php artisan storage:link`. Store avatars in a public disk location (e.g., `storage/app/public/avatars`).
7. Error Display: Uses standard Laravel `@error` directives. Added specific error bag targeting (`'updatePassword'`) for password validation errors to prevent them from showing under the profile form if both fail.
--}}