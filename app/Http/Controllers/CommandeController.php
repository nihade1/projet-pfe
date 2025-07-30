<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\ArticleCommande;
use App\Models\Produit;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['user', 'articles.produit'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        
        return view('commandes.index', compact('commandes'));
    }

    public function afficher(Commande $commande)
    {
        // Vérifier que la commande appartient à l'utilisateur connecté
        if ($commande->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        
        $commande->load(['articles.produit.boutique', 'user']);
        return view('commandes.show', compact('commande'));
    }
    
    public function paiement()
    {
        $panier = session()->get('panier', []);
        
        if (empty($panier)) {
            return redirect()->route('panier.index')
                ->with('error', 'Votre panier est vide.');
        }
        
        $produits = Produit::whereIn('id', array_keys($panier))->get();
        $total = 0;
        
        foreach ($produits as $produit) {
            $total += $produit->prix * $panier[$produit->id];
        }
        
        return view('commandes.paiement', compact('produits', 'panier', 'total'));
    }

    public function enregistrer(Request $request)
    {
        $messages = [
            'nom_carte.required' => 'Le nom sur la carte est obligatoire.',
            'nom_carte.regex' => 'Le nom sur la carte doit contenir uniquement des lettres et des espaces.',
            'numero_carte.required' => 'Le numéro de carte est obligatoire.',
            'numero_carte.min' => 'Le numéro de carte doit contenir au moins 13 chiffres.',
            'numero_carte.max' => 'Le numéro de carte ne doit pas dépasser 19 chiffres.',
            'numero_carte.regex' => 'Le numéro de carte doit contenir uniquement des chiffres et des espaces.',
            'expiration.required' => 'La date d\'expiration est obligatoire.',
            'expiration.size' => 'La date d\'expiration doit être au format MM/AA.',
            'expiration.regex' => 'La date d\'expiration doit être au format MM/AA.',
            'cvv.required' => 'Le code CVV est obligatoire.',
            'cvv.min' => 'Le code CVV doit contenir au moins 3 chiffres.',
            'cvv.max' => 'Le code CVV ne doit pas dépasser 4 chiffres.',
            'cvv.regex' => 'Le code CVV doit contenir uniquement des chiffres.',
        ];
        
        $validator = \Validator::make($request->all(), [
            'adresse_livraison' => 'required|string|max:255',
            'code_postal_livraison' => 'required|string|max:10',
            'ville_livraison' => 'required|string|max:100',
            'pays_livraison' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
            'nom_carte' => 'required|string|max:100',
            'numero_carte' => 'required|string|min:13|max:19',
            'expiration' => 'required|string|size:5',
            'cvv' => 'required|string|min:3|max:4',
        ], $messages);

        // Vérifier que la date d'expiration n'est pas dans le passé et qu'elle est au bon format
        $validator->after(function ($validator) use ($request) {
            // Validation du nom de la carte (lettres et espaces uniquement)
            if ($request->has('nom_carte')) {
                $nomCarte = $request->nom_carte;
                if (!ctype_alpha(str_replace(' ', '', $nomCarte))) {
                    $validator->errors()->add('nom_carte', 'Le nom sur la carte doit contenir uniquement des lettres et des espaces.');
                }
            }
            
            // Validation du numéro de carte (chiffres et espaces uniquement)
            if ($request->has('numero_carte')) {
                $numeroCarte = $request->numero_carte;
                $numeroSansEspaces = str_replace(' ', '', $numeroCarte);
                if (!ctype_digit($numeroSansEspaces)) {
                    $validator->errors()->add('numero_carte', 'Le numéro de carte doit contenir uniquement des chiffres et des espaces.');
                }
                
                if (strlen($numeroSansEspaces) < 13 || strlen($numeroSansEspaces) > 19) {
                    $validator->errors()->add('numero_carte', 'Le numéro de carte doit contenir entre 13 et 19 chiffres.');
                }
            }
            
            // Validation du CVV (chiffres uniquement)
            if ($request->has('cvv')) {
                $cvv = $request->cvv;
                if (!ctype_digit($cvv)) {
                    $validator->errors()->add('cvv', 'Le code CVV doit contenir uniquement des chiffres.');
                }
                
                if (strlen($cvv) < 3 || strlen($cvv) > 4) {
                    $validator->errors()->add('cvv', 'Le code CVV doit contenir 3 ou 4 chiffres.');
                }
            }
            
            // Validation de la date d'expiration
            if ($request->has('expiration')) {
                // Vérifier le format MM/YY
                if (strlen($request->expiration) === 5 && substr($request->expiration, 2, 1) === '/') {
                    $month = substr($request->expiration, 0, 2);
                    $year = substr($request->expiration, 3, 2);
                    
                    // Vérifier que le mois est valide (01-12)
                    if (!is_numeric($month) || $month < 1 || $month > 12) {
                        $validator->errors()->add('expiration', 'Le mois d\'expiration doit être entre 01 et 12.');
                        return;
                    }
                    
                    // Vérifier que l'année est valide
                    if (!is_numeric($year)) {
                        $validator->errors()->add('expiration', 'L\'année d\'expiration doit être un nombre.');
                        return;
                    }
                    
                    try {
                        $expDate = \Carbon\Carbon::createFromDate('20'.$year, $month, 1)->endOfMonth();
                        
                        if ($expDate->isPast()) {
                            $validator->errors()->add('expiration', 'La date d\'expiration de la carte est dépassée.');
                        }
                    } catch (\Exception $e) {
                        $validator->errors()->add('expiration', 'Date d\'expiration invalide.');
                    }
                } else {
                    $validator->errors()->add('expiration', 'Le format de la date d\'expiration doit être MM/AA.');
                }
            }
        });
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $panier = session()->get('panier', []);
        
        if (empty($panier)) {
            return redirect()->route('panier.index')
                ->with('error', 'Votre panier est vide.');
        }
        
        $produits = Produit::whereIn('id', array_keys($panier))->get();
        $total = 0;
        
        // Vérifier le stock
        foreach ($produits as $produit) {
            if ($produit->stock < $panier[$produit->id]) {
                return back()->with('error', "Stock insuffisant pour le produit {$produit->nom}");
            }
            $total += $produit->prix * $panier[$produit->id];
        }
        
        // Créer la commande avec le statut payé
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'statut' => 'payé', // Changé de "en_attente" à "payé"
            'montant_total' => $total,
            'adresse_livraison' => $request->adresse_livraison,
            'code_postal_livraison' => $request->code_postal_livraison,
            'ville_livraison' => $request->ville_livraison,
            'pays_livraison' => $request->pays_livraison,
            'telephone' => $request->telephone,
        ]);
        
        // Créer les articles de commande et mettre à jour le stock
        foreach ($produits as $produit) {
            ArticleCommande::create([
                'commande_id' => $commande->id,
                'produit_id' => $produit->id,
                'quantite' => $panier[$produit->id],
                'prix' => $produit->prix,
            ]);
            
            // Réduire le stock
            $produit->decrement('stock', $panier[$produit->id]);
        }
        
        // Vider le panier
        session()->forget('panier');
        
        return redirect()->route('commandes.afficher', $commande)
            ->with('success', 'Votre commande a été enregistrée avec succès !');
    }
}
