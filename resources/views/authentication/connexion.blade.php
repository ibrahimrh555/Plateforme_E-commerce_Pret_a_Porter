<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBR Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/connexionStyle.css') }}">
    <link rel="shortcut icon" href="image/logo.png" type="img/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header class="navbar">
        
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

    <div class="container">
            <form action="{{ route('Login') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <label for="email">
                <b style="text-align: center">Identifiant</b>
            </label>
            <div class="email-div">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
            </div>
            <div class="password-div">
                <i class="fa-solid fa-key"></i>
                <input type="password" id="password" name="motPasse" placeholder="Votre mot de passe" required>
            </div>
            <div>
                <input type="checkbox" name="souviens"><label for="checkbox">Souviens-toi de moi</label>
            </div>
            <div>
                <button type="submit" name="connexion">Connexion</button>
            </div>
            <div class="ou">ou</div>
            <div style="text-align: center;">
                Pas encore inscrit? <a href="{{ route('showRegister') }}" style="color:darkcyan;font-size: 15px;font-weight: 400;">S'inscrire</a>
            </div>
            <br>
            </form>
    </div>

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