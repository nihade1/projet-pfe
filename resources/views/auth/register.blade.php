<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Créez votre compte sur ArtisanMarket
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Rejoignez notre communauté d'acheteurs et d'artisans passionnés
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Type de compte')" />
            
            <div class="mt-2 space-y-4">
                <label class="flex items-start p-3 border rounded-md border-gray-300 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                    <input type="radio" name="role" value="customer" class="mt-1" checked>
                    <div class="ml-3">
                        <div class="font-medium text-gray-800 dark:text-gray-200">Client</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Je souhaite découvrir et acheter des produits artisanaux de qualité. 
                            Vous pourrez parcourir le catalogue, suivre vos commandes et laisser des avis.
                        </p>
                    </div>
                </label>
                
                <label class="flex items-start p-3 border rounded-md border-gray-300 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                    <input type="radio" name="role" value="artisan" class="mt-1">
                    <div class="ml-3">
                        <div class="font-medium text-gray-800 dark:text-gray-200">Artisan</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Je souhaite vendre mes créations sur la plateforme. 
                            Après inscription, vous pourrez créer votre boutique en ligne et gérer vos produits.
                        </p>
                    </div>
                </label>
            </div>
            
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmez le mot de passe')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Déjà inscrit?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
