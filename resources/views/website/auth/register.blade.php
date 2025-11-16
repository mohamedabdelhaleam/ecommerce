@extends('website.layout.app')

@section('title', 'Register')

@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-12">
        <div class="layout-content-container mx-auto flex max-w-md flex-col flex-1">
            <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-8">
                <h1 class="text-3xl font-bold mb-2 text-center">Create Account</h1>
                <p class="text-gray-500 dark:text-gray-400 text-center mb-8">Join us and start shopping today</p>

                @if ($errors->any())
                    <div
                        class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Full Name
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                autofocus
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                placeholder="John Doe">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                placeholder="your@email.com">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Password
                            </label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                placeholder="••••••••">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Must be at least 8 characters</p>
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirm Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                placeholder="••••••••">
                        </div>

                        <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
