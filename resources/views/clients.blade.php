<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/material-icons@1.13.14/iconfont/material-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="aside">
            <div class="top">
                <div class="logo">
                    <img src="C:\Users\USER\Desktop\PROGRAMATION WEB\ProjetClothes\Tan_Brown_Closet_Collection_Clothing_Fashion_Logo-removebg-preview.png" class="imgpr">
                    <h2 class="quote">Dress well <span class="danger">With Us</span></h2>
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">close</span>
                    </div>
                </div>
                <div class="sidebar">
                    <a href="{{ route('dashboard') }}">
                        <span class="material-icons-sharp">dashboard</span>
                        <h3>Dashboard</h3>
                    </a>
                    <a href="{{route('vendeur.clients', ['id' => 1])}}">
                            <span class="material-icons-sharp">
                                person
                            </span>
                            <h3>Customers</h3>
                    </a>
                    <a href="{{ route('commandes.index') }}">
                        <span class="material-icons-sharp">add_shopping_cart</span>
                        <h3>Orders</h3>
                    </a>
                    <a href="{{ route('produits.index') }}">
                        <span class="material-icons-sharp">inventory</span>
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

        <!-- Main content -->
        <main>
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date">
            </div>

            <div class="CrudTable">
                <h2 style="text-align: center;">Clients</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->nom }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->telephone }}</td>
                                <td>{{ $client->adresse }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Top bar (profil, thème) -->
        <div class="topcreud">
            <div class="btton">
                <button id="menu-btn" style="visibility: hidden;">
                    <span class="material-icons-sharp">menu</span>
                </button>
            </div>
            <div class="theme-toggler">
                <span class="material-icons-sharp">light_mode</span>
                <span class="material-icons-sharp">dark_mode</span>
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
                    <img src="C:\Users\USER\Desktop\PROGRAMATION WEB\ProjetClothes\WhatsApp Image 2024-11-26 at 22.02.05_4009479c.jpg">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
