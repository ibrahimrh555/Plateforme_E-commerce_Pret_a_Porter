<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBR Enfant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/accueil.js"></script>
    <link rel="shortcut icon" href="image/logo.png" type="img/png">
    
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

    <main>  
        <!-- 
        @if(Auth::check())
            <p>Connecté en tant que : {{ Auth::user()->nom }}</p>
        @else
            <p>Non connecté</p>
        @endif
        -->

        <div class="card">
            @if ($produits->count() > 0)
            @foreach ($produits as $produit)
                <div class="product-card">
                    <div class="image-contenus">
                        <img src="{{ asset('image/' . $produit->image) }}" alt="{{ $produit->nom }}" class="product-image">
                        @if(Auth::check())
                            <form action="{{ route('favoris.ajouter',$produit->id) }}" method="POST">
                                @csrf                                  
                                <button type="submit" onclick="toggleFavorite(this)" class="favorite-icon">❤</button>
                            </form>
                        @else
                            <div class="favorite-icon" onclick="alert('Connectez-vous pour ajouter le produit aux favoris')" >❤</div>
                        @endif                       
                    </div>
                    <h2 class="product-name">
                        <form action="{{ route('produit.detail.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $produit->id }}">
                            <button title="detail de produit" type="submit" class="product-name-button">
                                {{ $produit->nom }}
                            </button>
                        </form>
                    </h2>
                    <p class="product-price">{{ $produit->prix }} MAD</p>
                    <button class="product-button"
                    onclick="afficherDetail(this)"
                    nom="{{ $produit->nom }}"
                    description="{{ $produit->description }}"
                    prix="{{ $produit->prix }} MAD"
                    image="{{ asset('image/' . $produit->image) }}"
                    couleur="{{ $produit->couleur }}"
                    taille="{{ $produit->taille }}"
                    id="{{ $produit->id }}">
                    Aperçu rapide
                    </button>
                </div>
            @endforeach
            @else
                @if (!$message)
                  <p>Aucun produit disponible pour le moment.</p>
                @endif
            @endif
        </div> 
    </main>


    <aside id="aside" class="aside">
        <button class="close-btn" onclick="fermerDetail()"><i class="fas fa-arrow-left"></i></button>
        @if(Auth::check())
            <form id="favoriForm" method="POST">
                @csrf                                  
                <button type="submit" onclick="return toggleFavorite(this)" class="favorite-icon">❤</button>
            </form><br>
        @else
            <div class="favorite-icon" onclick="alert('Connectez-vous pour ajouter le produit aux favoris')">❤</div><br>
        @endif        
        <div class="aside-image">
            <img id="imageProduit" src="" alt="Image du produit" class="product-image-aside">
            <div class="info-produit">
                <h3 id="titreProduit">Nom du Produit</h3>
            </div>
        </div>
        <p id="prixProduit" class="price">Prix: XX.XX MAD</p><br>
        <p id="descriptionProduit" class="description">Description détaillée du produit.</p>
        <hr><br><p class="couleur">Couleur : <span id="couleurChoisie">couleur</span></p><br><hr><br>
        <p class="taille">Taille : <span id="tailleChoisie">taille</span></p>
        <p style="color: rgb(255, 255, 255)">id: <span id="idPro">taille</span></p>
        @if(Auth::check())
            <form action="{{ route('panier.ajouter') }}" method="POST">
                @csrf 
                <input type="hidden" name="idProduit" id="inputIdProduit" value="">
                <input type="hidden" name="quantite" value="1">
                <button type="submit" class="ajouter-panier">AJOUTER AU PANIER</button>
            </form>
        @else
            <button class="ajouter-panier" onclick="alert('Connectez-vous pour ajouter le produit aux paniers d achats')"  onclick="ajouterAuPanier()">AJOUTER AU PANIER</button>
        @endif
    </aside>
         
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
