<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Ordres </title>
    <link href="
     https://cdn.jsdelivr.net/npm/material-icons@1.13.14/iconfont/material-icons.min.css
     " rel="stylesheet">
    <!-- styleshet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    
    <div class="container">
        <!---------------------Dashboard list--------------------------->

        <div class="aside">
            <div class="top">
                <div class="logo">
                    <img src="C:\Users\USER\Desktop\PROGRAMATION WEB\ProjetClothes\Tan_Brown_Closet_Collection_Clothing_Fashion_Logo-removebg-preview.png" class="imgpr">
                    <h2 class="quote">Dress well <span class="danger">With Us</span></h2>
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">
                            close
                        </span>
                    </div>
                </div>
                    
                <div class="sidebar">

                    <!--<a href="https://www.example.com" target="_blank">Visitez Example</a> c'est pour définir un lien target="blank" est pour l'ouvrir dans un nouveau onglet  -->

                        <a href="{{ route('dashboard') }}">
                            <!--span sont l'icons lijebnaha mn site dyal google font -->
                            <span class="material-icons-sharp">
                                dashboard
                            </span>
                            <h3>Dashboard</h3>
                        </a>
                        <a href="{{route('vendeur.clients', ['id' => 1])}}">
                            <span class="material-icons-sharp">
                                person
                            </span>
                            <h3>Customers</h3>
                        </a>
                        <a href="{{ route('commandes.index') }}">
                            <span class="material-icons-sharp">
                                add_shopping_cart
                                </span>
                            <h3>Orders </h3>
                        </a>
                        
                        <a href="{{ route('produits.index') }}">
                            <span class="material-icons-sharp">
                                inventory
                                </span>
                            <h3>Products</h3>
                        </a>
                        <a href="{{ route('vendeur.settings', ['id' => 1]) }}">
                            <span class="material-icons-sharp">
                                settings
                                </span>
                            <h3>Settings</h3>
                        </a>
                        
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="material-icons-sharp">
                                logout
                            </span>
                            <h3>Log out</h3>
                        </a>
                        <form id="logout-form" action="{{ route('Logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        
                         
                    </div>
                    
                
            </div>
    
        </div>

        
        <!----------------- ------------------ Style dyal main  ----------------- ------->        
        
        <main>
            
            <h1>Dashboard</h1>

            <div class="date">
                <input type="date">
            </div>
            <div class="CrudTable" >
                <h2 style="align-items: center;">Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Numéro de Commande</th>  
                            <th>Client</th>
                            <th>Montant Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commandes as $commande)
                            <tr>
                                <td>{{ $commande->id }}</td>
                                <td>{{ $commande->idUtilisateur }}</td> <!-- ou nom client si tu as une relation -->
                                <td>{{ $commande->total }} DH</td>
                                <td style="color:
                                    @if($commande->statut == 'livrée') green
                                    @elseif($commande->statut == 'expédiée') rgb(218, 205, 30)
                                    @elseif($commande->statut == 'en cours') rgb(19, 0, 128)
                                    @elseif($commande->statut == 'annulée') rgb(163, 0, 0)
                                    @else black
                                    @endif;">
                                    {{ ucfirst($commande->statut) }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($commande->date_commandes)->format('d/m/Y') }}</td>
                                <td>
                                    <!-- bouton modifier -->
                                    <button onclick="openEditModal({{ $commande->id }}, {{ $commande->idUtilisateur }}, {{ $commande->idProduit }}, '{{ $commande->date_commandes }}', '{{ $commande->statut }}', {{ $commande->total }})"
                                        style="color: green; cursor:pointer;">
                                        <span class="material-icons-sharp">edit</span>
                                    </button>

                                    <!-- bouton supprimer -->
                                    <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: red; cursor:pointer;">
                                            <span class="material-icons-sharp">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                



            </div>


        </main>

        <!--------------Profil avec light mode----------------->
        <div class="topcreud">
            <div class="btton">
                <button id="menu-btn" style="visibility: hidden;">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
            </div>
            
            <div class="theme-toggler">
                <span class="material-icons-sharp">
                    light_mode
                    </span>
                <span class="material-icons-sharp">
                    dark_mode
                    </span>
            </div>
            <div class="profilecreud">
                <div class="info">
                        @auth
                            @if(Auth::user()->role === 'vendeur')
                                <p id="smiyadmin">Hey <b>{{ Auth::user()->nom }}</b></p>
                                <small>Vendeur</small>
                            @else
                                <p id="smiyadmin">Hey <b>{{ Auth::user()->nom }}</b></p>
                                <small>{{ ucfirst(Auth::user()->role) }}</small>
                            @endif
                        @else
                            <p id="smiyadmin">Hey <b>Invité</b></p>
                            <small>Non connecté</small>
                        @endauth
                    </div>
                <div class="photo-profil">
                    <img src="C:\Users\USER\Desktop\PROGRAMATION WEB\ProjetClothes\WhatsApp Image 2024-11-26 at 22.02.05_4009479c.jpg" >
                </div>
            </div>
            
        </div>
        

    </div>
        
    <script>
    function openEditModal(id, utilisateur, produit, date, statut, total) {
        document.getElementById('editModal').style.display = 'block';

        document.getElementById('editCommandeId').value = id;
        document.getElementById('editClient').value = utilisateur;
        document.getElementById('editProduit').value = produit;
        document.getElementById('editDate').value = date;
        document.getElementById('editStatut').value = statut;
        document.getElementById('editTotal').value = total;

        const form = document.getElementById('editForm');
        form.action = `/commandes/${id}`; // Assure-toi que cette route fonctionne
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    </script>

</body>

<!-- Modal de Modification -->

<div id="editModal" style="display: none;" class="modaledit">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="editCommandeId" name="id">
        <label>Client:</label>
        <input type="text" name="idUtilisateur" id="editClient">
        <label>Produit:</label>
        <input type="text" name="idProduit" id="editProduit">
        <label>Date:</label>
        <input type="date" name="date_commandes" id="editDate">
        <label>Statut:</label>
        <input type="text" name="statut" id="editStatut">
        <label>Total:</label>
        <input type="number" name="total" id="editTotal" step="0.01">
        <br>
        <button type="submit">OK</button>
        <button type="button" onclick="closeModal()">Annuler</button>
    </form>
</div>
</html>