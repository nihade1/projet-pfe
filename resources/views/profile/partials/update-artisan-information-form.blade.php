<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informations du profil artisan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Mettez à jour vos informations personnelles et professionnelles.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Informations de base -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Nom" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" placeholder="Email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Informations artisan -->
        <div class="mt-4">
            <h3 class="text-md font-medium text-gray-900 mb-3">Informations professionnelles</h3>

            <div class="mb-3">
                <label for="photo" class="block text-sm font-medium text-gray-700">Photo de profil</label>
                <input type="file" name="photo" id="photo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @if($artisan->photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $artisan->photo) }}" alt="Photo de profil" class="h-20 w-20 object-cover rounded-full">
                        <div class="mt-1">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="delete_photo" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Supprimer la photo</span>
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="specialite" class="block text-sm font-medium text-gray-700">Spécialité</label>
                <input type="text" name="specialite" id="specialite" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('specialite', $artisan->specialite) }}" placeholder="Ex: Poterie, Bijouterie, Vannerie...">
            </div>

            <div class="mb-3">
                <label for="experience" class="block text-sm font-medium text-gray-700">Années d'expérience</label>
                <input type="number" name="experience" id="experience" min="0" max="100" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('experience', $artisan->experience) }}">
            </div>

            <div class="mb-3">
                <label for="bio" class="block text-sm font-medium text-gray-700">Biographie</label>
                <textarea name="bio" id="bio" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Partagez votre histoire, votre passion et votre expertise...">{{ old('bio', $artisan->bio) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text" name="telephone" id="telephone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('telephone', $artisan->telephone) }}" placeholder="Ex: 06 12 34 56 78">
            </div>

            <div class="mb-3">
                <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                <input type="text" name="adresse" id="adresse" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('adresse', $artisan->adresse) }}" placeholder="Votre adresse">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                    <input type="text" name="ville" id="ville" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('ville', $artisan->ville) }}" placeholder="Votre ville">
                </div>
                <div>
                    <label for="code_postal" class="block text-sm font-medium text-gray-700">Code postal</label>
                    <input type="text" name="code_postal" id="code_postal" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('code_postal', $artisan->code_postal) }}" placeholder="Code postal">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>
