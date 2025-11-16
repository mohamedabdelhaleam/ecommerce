@extends('website.layout.app')

@section('title', 'My Profile')

@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-12">
        <div class="layout-content-container mx-auto flex max-w-3xl flex-col flex-1">
            <h1 class="text-3xl font-bold mb-8">My Profile</h1>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-8">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                            </div>

                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                placeholder="+1234567890">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Address
                            </label>
                            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                placeholder="123 Main Street">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="city"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    City
                                </label>
                                <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                            </div>

                            <div>
                                <label for="state"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    State
                                </label>
                                <input type="text" id="state" name="state" value="{{ old('state', $user->state) }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                            </div>

                            <div>
                                <label for="zip"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    ZIP Code
                                </label>
                                <input type="text" id="zip" name="zip" value="{{ old('zip', $user->zip) }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Country
                            </label>
                            <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold mb-4">Change Password</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Leave blank if you don't want to change
                                your password</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        New Password
                                    </label>
                                    <input type="password" id="password" name="password"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                        placeholder="••••••••">
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Confirm New Password
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white"
                                        placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div
                                class="p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-primary text-white py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                Update Profile
                            </button>
                            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full border border-gray-300 dark:border-gray-700 text-brand-charcoal dark:text-white py-3 rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
