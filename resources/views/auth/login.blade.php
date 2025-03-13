@extends("layouts.auth.auth_layout")
@section( "title", "Stara - Login") {{-- Updated title to be more specific --}}
@section('auth-title', 'Welcome Back') {{-- More welcoming auth title --}}
@section('auth-subtitle', 'Sign in to continue your Stara journey.') {{-- More brand-aligned subtitle --}}

@section('content')
    <div class="w-full">
            <h2 class="text-2xl font-bold text-warm-black dark:text-warm-white mb-8 text-center">Login to Stara</h2> {{-- Updated heading style and margin --}}

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6"> {{-- Increased margin bottom --}}
                    <label for="email" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Email Address {{-- More user-friendly label text --}}
                    </label>
                    <input id="email" type="email" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="your@email.com"> {{-- Updated input style, added placeholder, form-input class --}}
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>

                <div class="mb-8"> {{-- Increased margin bottom --}}
                    <label for="password" class="block text-sm font-medium text-warm-black dark:text-warm-white mb-2"> {{-- Updated label style --}}
                        Password
                    </label>
                    <input id="password" type="password" class="form-input appearance-none border rounded w-full py-2 px-3 text-warm-black dark:text-warm-white dark:bg-warm-black leading-tight focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:border-muted-sage-green transition-colors duration-200 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password" placeholder="********"> {{-- Updated input style, added placeholder, form-input class --}}
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Added margin top for error message --}}
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-muted-sage-green hover:bg-muted-sage-green-darker text-warm-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-muted-sage-green focus:ring-offset-1 transition-colors duration-200 dark:bg-antique-gold dark:hover:bg-antique-gold-darker dark:text-warm-black" type="submit"> {{-- Updated button style to use Stara colors and rounded corners, added transition --}}
                        Login
                    </button>
                    <a class="inline-block align-baseline font-medium text-sm text-muted-sage-green hover:text-muted-sage-green-darker dark:text-antique-gold dark:hover:text-antique-gold-darker transition-colors duration-200" href="/register"> {{-- Updated register link style to use Stara colors and transition --}}
                        Register
                    </a>
                </div>
            </form>
    </div>
@endsection