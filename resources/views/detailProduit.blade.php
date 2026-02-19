<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBR Prduit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/produit.css') }}">
    <script src="{{ asset('js/accueil.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('image/logo.png') }}" type="image/png">
    
</head>
<body>
    <header class="navbar">
        <div class="contact">
            <p class="contact-info">
              <span><i class="fas fa-phone"></i> +212 511 111 111</span>  
              <span><i class="fas fa-envelope"></i> BBR123@gmail.com</span>   
            </p>
            <ul class="social">
                  <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                  <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                  <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
            </ul>     
        </div>
        <div class="menu">
            <div class="logo">
                <a href="/"><span class="BBR">BBR</span><span class="CLOTHES">-CLOTHE</span></a>
            </div>
            <div class="rechercher">
                <form action="{{ route('accueil') }}" method="GET">
                    <input type="text" name="q" placeholder="Rechercher par nom " value="{{ request('q') }}">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="stor">
                <div class="utilisateur">
                    <a><i class="fas fa-user" style="color: #205ee4;"></i></a>
                    <div class="menu-inscription">
                        <button><a href="{{ route('showLogin') }}">Connxion</a></button>
                        <form id="logout-form" action="{{ route('Logout') }}" method="POST" >
                            @csrf
                            <button style="background-color: #170cbd; color: white;" type="submit">Deconnexion</button>
                        </form>
                        
                    </div>
                </div>
                @if(Auth::check())
                    <a title="favoris" href="favoris"><i class="fas fa-heart" style="color: #205ee4;"></i></a>
                @else
                    <a title="favoris" href="/" onclick="alert('Connectez-vous pour accéder à vos favoris')"><i class="fas fa-heart" style="color: #205ee4;"></i></a>
                @endif

                @if(Auth::check())
                    <a title="panier" href="panier" ><i class="fas fa-shopping-cart" style="color: #205ee4;"></i></a>
                @else
                    <a title="panier" href="/" onclick="alert('Connectez-vous pour accéder à vos paniers d achat')"><i class="fas fa-shopping-cart" style="color: #205ee4;"></i></a>
                @endif   
            </div>            
        </div>
        <div class="categorie">
            <nav>
                <ul class="menu-nav">
                    <li class="cat">
                        <a href="femmes">Femmes</a>
                    </li>
                    <li class="cat">
                        <a href="hommes">Hommes</a>
                    </li>
                    <li class="cat">
                        <a href="enfants">Enfants</a>
                    </li>
                    <li class="cat">
                        <a href="bebe">&nbsp;&nbsp;Bébé&nbsp;&nbsp;</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    
    <main class="main">
        <!--
        @if(Auth::check())
            <p>Connecté en tant que : {{ Auth::user()->nom }}</p>
        @else
            <p>Non connecté</p>
        @endif
        -->
        <div class="menu-produit">
            <div class="image">
                <img class="product-image" src="{{ asset('image/' . $produit->image) }}" alt="{{ $produit->nom }}">
            </div>
            <div class="info-produit">
                <div class="nom-produit">
                    <h3>{{ $produit->nom }}</h3>                  
                </div>
                <br>
                <p class="price">Prix: {{ $produit->prix }} MAD</p><br>
                <p class="description">{{ $produit->description }}</p>
                <hr><br>
                <p class="couleur">Couleur : <span>{{ $produit->couleur }}</span></p><br><hr><br>
                <p class="taille">Taille : <span>{{ $produit->taille }}</span></p>
                <br><br>
                <a href="/"><button type="submit" href="/" class="ajouter-panier"><Strong>A L' Accueil</Strong></button></a>                
            </div>
        </div>    
    </main>

  
    <footer class="footer">
        <div class="footer-contenus">
          <div class="footer-site">
            <a href="/" class="logo">BBR-CLOTHE</a>
            <p class="des">
              Votre destination mode pour un style unique et tendance
            </p>
          </div>
          <div class="objectif">
            <h4>À propos</h4><br>
            <p>
              Découvrez nos collections pour hommes, femmes, enfants et bébé,
              pensées pour allier confort, qualité et élégance.
            </p>
          </div>
          <div class="adresse">
            <h4>Suivez-nous</h4><br>
            <ul class="social">
                <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li> 
            </ul>
          </div>
        </div>
        <div class="copyright">
          <p>&copy; 2025 BBR-CLOTHE. Tous droits réservés.</p>
        </div>
    </footer>  
</body>
</html>

