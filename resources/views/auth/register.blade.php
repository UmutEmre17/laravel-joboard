<x-layout>
    <h1 class="my-16 text-center text-4xl font-medium text-slate-600">Create an account</h1>
    <x-card class="py-8 px-16">
        <form action="{{ route('auth.signup') }}" method="POST">
            @csrf
            <div class="mb-8">
                <x-label for="name" :required="true">Name</x-label>
                <x-text-input name="name" />
            </div>

            <div class="mb-8">
                <x-label for="email" :required="true">E-mail</x-label>
                <x-text-input name="email" />
            </div>

            <div class="mb-8">
                <x-label for="password" :required="true">
                    Password
                </x-label>
                <x-text-input name="password" type="password" />
            </div>

            <div class="mb-8">
                <x-label for="password_confirmation" :required="true">
                    Confirm Password
                </x-label>
                <x-text-input name="password_confirmation" type="password" />
            </div>

            <x-button class="w-full bg-green-50">Sign up</x-button>
        </form>
    </x-card>
</x-layout>