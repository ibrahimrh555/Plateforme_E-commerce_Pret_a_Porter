<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBR Panier</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/panier.css">
    <script src="js/panier.js"></script>
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


    @if($panierArticles->count() > 0) 
    <main style="display: flex; flex-wrap: wrap; gap: 20px;">
        <!--
        @if(Auth::check())
            <p>Connecté en tant que : {{ Auth::user()->nom }}</p>
        @else
            <p>Non connecté</p>
        @endif
        -->       
        <div class="panier" style="flex: 2;">
            <h2 style="margin: 20px; font-size: 2rem; color: #0b046b;">Mon panier</h2>
                @if($panierArticles->count() > 0) 
                    @foreach($panierArticles as $article)
                        <div class="article" id="article-{{ $article->id }}">
                            <img src="{{ asset('image/' . $article->image) }}" alt="{{ $article->nom }}">
                            <div class="info">
                                <h4>{{ $article->nom }}</h4>
                                <p><strong>Taille:</strong> {{ $article->taille }}</p>
                                <p><strong>Couleur:</strong> {{ $article->couleur }}</p>
                                <p style="color: #0b046b; font-size: 1rem;"><strong>Quantite:</strong> {{ $article->quantite }}</p>
                                <!--<div class="quantite">               
                                    <form action="{{ route('panier.modifier-quantite') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="idPanierArticle" value="{{ $article->id }}">
                                        <input type="hidden" name="action" value="diminuer">
                                        <button type="submit" class="btn-quantite">-</button>
                                    </form>                                
                                    <span class="valeur" style="min-width: 30px; text-align: center; font-weight: bold;">{{ $article->quantite }}</span>
                                    <form action="{{ route('panier.modifier-quantite') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="idPanierArticle" value="{{ $article->id }}">
                                        <input type="hidden" name="action" value="augmenter">
                                        <button type="submit" class="btn-quantite">+</button>
                                    </form>
                                </div> -->
                            </div>
                            <div class="actions">
                                <p class="prix">{{ number_format($article->prix, 2, ',', ' ') }} MAD</p>
                                <form action="{{ route('panier.supprimer', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="supp">
                                    <span class="material-icons-sharp">delete</span>
                                    </button>
                                </form>
                                    
                                <form action="{{ route('favoris.ajouter',$article->id) }}" method="POST" >
                                    @csrf                                  
                                    <button type="submit" onclick="toggleFavorite(this)" class="favori">❤</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif   
        </div>

        <aside class="commande-resume">
            <h3>Résumé de la commande</h3><br>
            <p><strong>Articles :</strong> {{ $panierArticles->sum('quantite') }}</p><br>
            <p><strong>Sous-total :</strong> {{ number_format($total, 2, ',', ' ') }} MAD</p><br>
            <p><strong>Frais de livraison :</strong> 30,00 MAD</p><br>
            <hr>
            <br><p style="color: #170cbd;"><strong>Total :</strong> {{ number_format($total + 30, 2, ',', ' ') }} MAD</p>
            <br>
            <form action="{{ route('commande.passer') }}" method="POST">
                @csrf
                <button type="submit" class="button-paiement">Valider la commande</button>
            </form>
        </aside> 
    </main> 
    
    @else
        <div class="empty-cart">
            <img src="image/panier.png" alt="Liste de souhaits vide" class="empty-cart-image">
            <h1>Il n'y a aucun article dans votre panier</h1><br>
            <p>Des milliers d'articles vous attendent chez BBR-CLOTHE.</p><br>                    
            <a href="{{ route('accueil') }}" class="btn-primary">Découvrir nos produits</a>
        </div>
    @endif

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









                            