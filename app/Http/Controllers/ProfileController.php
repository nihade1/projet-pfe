<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Remplir les informations de l'utilisateur
        $user->fill($request->safe()->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        
        // Si c'est un artisan, mettre à jour ses informations supplémentaires
        if ($user->isArtisan() && $user->artisan) {
            $artisan = $user->artisan;
            
            // Mettre à jour les informations de l'artisan
            $artisan->bio = $request->bio;
            $artisan->telephone = $request->telephone;
            $artisan->adresse = $request->adresse;
            $artisan->ville = $request->ville;
            $artisan->code_postal = $request->code_postal;
            $artisan->specialite = $request->specialite;
            $artisan->experience = $request->experience;
            
            // Traitement de la photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($artisan->photo) {
                    Storage::disk('public')->delete($artisan->photo);
                }
                
                $path = $request->file('photo')->store('artisans', 'public');
                $artisan->photo = $path;
            }
            
            // Si la case "supprimer la photo" est cochée
            if ($request->has('delete_photo') && $request->delete_photo) {
                if ($artisan->photo) {
                    Storage::disk('public')->delete($artisan->photo);
                    $artisan->photo = null;
                }
            }
            
            $artisan->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's profile dashboard.
     */
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        
        // Vérifier si l'utilisateur est un artisan
        if ($user->isArtisan()) {
            $artisan = $user->artisan;
            $boutique = $artisan->boutique;
            
            // Si l'artisan a une boutique, afficher ses informations
            if ($boutique) {
                $produits = $boutique->produits()->latest()->take(5)->get();
                $totalProduits = $boutique->produits()->count();
                $totalCommandes = $boutique->commandes()->count();
                $avis = $boutique->avis()->with(['produit', 'user'])->latest()->take(5)->get();
                $totalAvis = $boutique->avis()->count();
                
                return view('profile.artisan-dashboard', [
                    'user' => $user,
                    'artisan' => $artisan,
                    'boutique' => $boutique,
                    'produits' => $produits,
                    'totalProduits' => $totalProduits,
                    'totalCommandes' => $totalCommandes,
                    'avis' => $avis,
                    'totalAvis' => $totalAvis,
                ]);
            }
            // Si l'artisan n'a pas encore de boutique
            return view('profile.artisan-dashboard', [
                'user' => $user,
                'artisan' => $artisan,
                'boutique' => null,
            ]);
        }
        
        // Si c'est un client normal, afficher son profil client standard
        $commandes = $user->commandes()->with('articles.produit')->latest()->get();
        $avis = $user->avis()->with(['produit', 'boutique'])->latest()->get();
        
        return view('profile.dashboard', [
            'user' => $user,
            'commandes' => $commandes,
            'avis' => $avis,
        ]);
    }
}
