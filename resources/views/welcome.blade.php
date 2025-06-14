<x-guest-layout >
<p class="text-amber-500 text-lg font-semibold">
        Bem vindo
    </p>
<br>
<a href="{{ route('login') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
    {{ __('Login') }}
</a>
<br>
<a href="{{ route('register') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
    {{ __('Register') }}
</a>
</x-guest-layout>