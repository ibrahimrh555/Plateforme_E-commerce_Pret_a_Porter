<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="image/logo.png" type="img/png">
    <title>BBR Paiement</title>
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
<br>
  <div class="checkout-container">
    <div class="details">    
      <h2>Détails du commande</h2>
      <h3>Total de la commande : {{ $commande->total }} MAD</h3>
      <h4>Date : {{ $commande->date_commandes }}</h4>
    </div>  

    <div class="table">
      <table>
        <thead>
          <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($commande->articles as $article)
          <tr>
            <td>{{ $article->idProduit }}</td>
            <td>{{ $article->quantite }}</td>
            <td>{{ $article->prix_unitaire }} MAD</td>
            <td>{{ $article->total }} MAD</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
          
    <div class="payment-method">
      <form action="{{ route('paypal.pay') }}" method="POST">
        @csrf
        <input type="hidden" name="amount" value="{{ $commande->total }}">

        <button type="submit" class="paypal" style="background-color: #193db0; color:white">
          <i class="fab fa-paypal" style="font-size: 20px;"></i>Paypal
        </button>
      </form>
      <form action="{{ route('stripe.pay') }}" method="POST">
        @csrf
        <input type="hidden" name="amount" value="{{ $commande->total }}">
        <button type="submit" class="stripe" style="background-color:white ;">
          <i class="fas fa-credit-card" style="font-size: 20px;"></i>Carte
        </button>
      </form>
    </div>
  </div>
<br>
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