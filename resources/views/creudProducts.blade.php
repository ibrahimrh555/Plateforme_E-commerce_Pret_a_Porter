<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/material-icons@1.13.14/iconfont/material-icons.min.css" rel="stylesheet">
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
                    <a href="{{ route('dashboard') }}">
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

        <!----------------- Style dyal main ----------------------->        
        
        <main>
            <h1>Dashboard</h1>

            <div class="date">
                <input type="date">
            </div>
            
            <!-- Affichage des messages de succès -->
            @if(session('success'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="CrudTable">
                <h2>Produits</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Catégorie</th>
                            <th>Image</th>
                            <th>Date d'ajout</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produits as $produit)
                            <tr>
                                <td>{{ $produit->nom }}</td>
                                <td>{{ $produit->prix }} DH</td>
                                <td>{{ $produit->stock }}</td>
                                <td>{{ $produit->categorie->nom }}</td>
                                <td>
                                    @if($produit->image)
                                        <img src="{{ asset('image/' . $produit->image) }}" 
                                             width="60" 
                                             height="60" 
                                             style="object-fit: cover; border-radius: 5px;"
                                             alt="{{ $produit->nom }}"
                                             onerror="this.src='{{ asset('images/default-product.png') }}'; this.onerror=null;">
                                    @else
                                        <img src="{{ asset('images/default-product.png') }}" 
                                             width="60" 
                                             height="60" 
                                             style="object-fit: cover; border-radius: 5px;"
                                             alt="Image par défaut">
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($produit->dateAjout)->format('d/m/Y') }}</td>
                                <td>
                                    <button onclick="openEditModal(
                                        {{ $produit->id }},
                                        '{{ addslashes($produit->nom) }}',
                                        {{ $produit->prix }},
                                        {{ $produit->stock }},
                                        {{ $produit->idCategorie }},
                                        '{{ \Carbon\Carbon::parse($produit->dateAjout)->format('Y-m-d') }}'
                                    )" style="color: green; border: none; background: none; cursor: pointer;">
                                        <span class="material-icons-sharp">edit</span>
                                    </button>

                                    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: red; border: none; background: none; cursor: pointer;">
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

    <!-- Modal de Modification -->
    <div id="editModal" class="modaledit" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 10px; width: 400px; max-height: 80vh; overflow-y: auto;">
            <h3>Modifier le produit</h3>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">

                <div style="margin-bottom: 15px;">
                    <label for="editNom" style="display: block; margin-bottom: 5px;">Nom:</label>
                    <input type="text" name="nom" id="editNom" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="editPrix" style="display: block; margin-bottom: 5px;">Prix:</label>
                    <input type="number" name="prix" id="editPrix" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="editStock" style="display: block; margin-bottom: 5px;">Stock:</label>
                    <input type="number" name="stock" id="editStock" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="editCategorie" style="display: block; margin-bottom: 5px;">Catégorie:</label>
                    <select name="idCategorie" id="editCategorie" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->idCategorie }}">{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="editImage" style="display: block; margin-bottom: 5px;">Image (optionnel):</label>
                    <input type="file" name="image" id="editImage" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <small style="color: #666;">Laissez vide pour conserver l'image actuelle</small>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="editDateAjout" style="display: block; margin-bottom: 5px;">Date d'ajout:</label>
                    <input type="date" name="dateAjout" id="editDateAjout" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="text-align: right;">
                    <button type="button" onclick="closeModal()" style="padding: 8px 16px; margin-right: 10px; background: #ccc; border: none; border-radius: 4px; cursor: pointer;">Annuler</button>
                    <button type="submit" style="padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
        
    <script>
        function openEditModal(id, nom, prix, stock, categorieId, dateAjout) {
            document.getElementById('editModal').style.display = 'block';

            document.getElementById('editId').value = id;
            document.getElementById('editNom').value = nom;
            document.getElementById('editPrix').value = prix;
            document.getElementById('editStock').value = stock;
            document.getElementById('editCategorie').value = categorieId;
            document.getElementById('editDateAjout').value = dateAjout;

            const form = document.getElementById('editForm');
            form.action = `/produits/${id}`;
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

</body>
</html>