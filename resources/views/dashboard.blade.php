<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Vendeur Dashboard </title>
    <!-- Material icons link to them -->
     <!--<link> est une balise HTML utilisée pour lier des ressources externes à un document HTML-->
     <!--rel : Spécifie le type de relation entre le document actuel et la ressource liée.stylesheet, icon,preload-->
     <!--href pour définir le lien de l'élément externe-->
     <link href="
     https://cdn.jsdelivr.net/npm/material-icons@1.13.14/iconfont/material-icons.min.css
     " rel="stylesheet">
    <!-- styleshet -->
     <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
</head>
@if(session('success'))
    <div id="success-alert" style="position: fixed; top: 30px; left: 50%; transform: translateX(-50%); background: #e6ffed; color: #218838; border: 1px solid #b7ebc6; padding: 14px 28px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); font-size: 1rem; z-index: 9999; transition: opacity 0.5s;">
        <span style="margin-right: 8px; vertical-align: middle;">&#10003;</span>
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            var alert = document.getElementById('success-alert');
            if(alert){
                alert.style.opacity = '0';
                setTimeout(function(){ alert.style.display = 'none'; }, 500);
            }
        }, 3000);
    </script>
@endif

<body>
    <div class="container">

        <!--------- Aside Bar ------------------->
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

            <div class="stats-container">
                    <!-- Ventes -->
                    <div class="stat-card ventes">
                        <span class="material-icons-sharp">trending_up</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Ventes Totales</h3>
                                <h1>{{ number_format($ventesTotal, 2) }} DH</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx="38" cy="38" r="36" />
                                    <circle cx="38" cy="38" r="36" style="stroke-dasharray: {{ $pourcentageVentes * 2.26 }}, 226;" />
                                </svg>
                                <div class="number">
                                    <p>{{ round($pourcentageVentes) }}%</p>
                                </div>
                            </div>
                        </div>
                        <small>Ce mois</small>
                    </div>

                    <!-- Commandes -->
                    <div class="stat-card commandes">
                        <span class="material-icons-sharp">receipt</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Commandes Vendues</h3>
                                <h1>{{ $nombreCommandes }}</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx="38" cy="38" r="36" />
                                    <circle cx="38" cy="38" r="36" style="stroke-dasharray: {{ $pourcentageCommandes * 2.26 }}, 226;" />
                                </svg>
                                <div class="number">
                                    <p>{{ round($pourcentageCommandes) }}%</p>
                                </div>
                            </div>
                        </div>
                        <small>Ce mois</small>
                    </div>

                    <!-- Clients -->
                    <div class="stat-card clients">
                        <span class="material-icons-sharp">people</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Clients</h3>
                                <h1>{{ $nombreClients }}</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx="38" cy="38" r="36" />
                                    <circle cx="38" cy="38" r="36" style="stroke-dasharray: {{ $pourcentageClients * 2.26 }}, 226;" />
                                </svg>
                                <div class="number">
                                    <p>{{ round($pourcentageClients) }}%</p>
                                </div>
                            </div>
                        </div>
                        <small>Ce mois</small>
                    </div>
            </div>

            
            <!--Tableau Dyal details of last  orders -->

            <div class="recent-order">
    <h2>Recent Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>  
                <th>Order ID</th>
                <th>Payment</th>  
                <th>Status</th>   
                <th>City</th>     
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
                <tr>
                    <td>{{ $commande->produit->nom ?? 'Produit supprimé' }}</td>
                    <td>{{ $commande->id }}</td>
                    <td>{{ $commande->total }} DH</td>
                    <td style="color:
                        {{ $commande->statut === 'Delivered' ? 'green' :
                           ($commande->statut === 'Shipped' ? 'rgb(218, 205, 30)' :
                           ($commande->statut === 'Pending' ? 'rgb(19, 0, 128)' :
                           ($commande->statut === 'Declined' ? 'rgb(163, 0, 0)' : 'black'))) }};
                    ">
                        {{ $commande->statut }}
                    </td>
                    <td>{{ $commande->utilisateur->ville ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('commandes.index') }}">Show All </a>
</div>
            
        </main>

        <!------------------------------------La Partie droit  ----------------------------------->

        <div class="right">
            <div class="top">
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
                <div class="profile">
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

            <!---End of TOP PARTY-->

            <div class="prodplus">
                <h2>Les produits les plus vendus</h2>
                <ul>
                    @foreach ($produitsPlusVendus as $produit)
                        <li style="display: flex; align-items: center; margin-bottom: 10px;">
                            <img src="{{ asset('image/' . $produit->image) }}" alt="{{ $produit->nom }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; margin-right: 10px;">
                            <div>
                                <strong>{{ $produit->nom }}</strong><br>
                                <small>Vendus : {{ $produit->total_vendu }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>


            <!-- Derniers partie dyal sales Aalytiques  -->

            <div class="salesan">
                <h3>Commandes ce mois</h3>
                <canvas id="commandesChart" width="275" height="300"></canvas>
    
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const ctx = document.getElementById('commandesChart').getContext('2d');

                        const ordersChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($dates) !!}, // remplace $jours par $dates ici
                                datasets: [{
                                    label: 'Commandes du mois',
                                    data: {!! json_encode($totals) !!},
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    borderRadius: 4,
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    </script>



                </div>
            </div>
            <style>
                .add-product-fixed-btn {
                    position: fixed;
                    bottom: 32px;
                    right: 32px;
                    z-index: 10000;
                }
                .add-product-fixed-btn button {
                    width: 64px;
                    height: 64px;
                    border-radius: 50%;
                    background: #7380ec;
                    color: #fff;
                    border: none;
                    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 2rem;
                    cursor: pointer;
                    transition: background 0.2s, box-shadow 0.2s;
                }
                .add-product-fixed-btn button:hover {
                    background: #5561c9;
                    box-shadow: 0 6px 24px rgba(0,0,0,0.18);
                }
                .add-product-fixed-btn .material-icons-sharp {
                    font-size: 2.2rem;
                    margin: 0;
                }
                @media (max-width: 600px) {
                    .add-product-fixed-btn {
                        right: 16px;
                        bottom: 16px;
                    }
                    .add-product-fixed-btn button {
                        width: 52px;
                        height: 52px;
                        font-size: 1.5rem;
                    }
                }
            </style>
            <div class="add-product-fixed-btn">
                <button id="addProductBtn" title="Add Product">
                    <span class="material-icons-sharp">
                        add
                    </span>
                </button>
            </div>
            
            
        </div>

        <!--***************** Modal for Add Product Form outside lcontainer *************************************-->

        <div id="addProductModal" class="modal-overlay">
            <div class="modal">
                <div class="modal-header">
                    <h2 class="modal-title">Add New Product</h2>
                    <button class="close-btn" id="closeModalBtn">&times;</button>
                </div>
                
                <form id="addProductForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
            <!-- Formulaire ghytlier m3a lcontroller b method='post' action='controller.php' -->

                    <div class="form-group">
                        <label for="productName">Product Name*</label>
                        <input type="text" id="productName" name="productName" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productDescription">Description</label>
                        <textarea id="productDescription" name="productDescription"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="productPrice">Price*</label>
                        <input type="number" id="productPrice" name="productPrice" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productCategory">Category</label>
                        <select id="productCategory" name="productCategory">
                            <option value="">Select a category</option>
                            <option value="hommes">Hommes</option>
                            <option value="femmes">Femmes</option>
                            <option value="babies">Babies</option>
                            <option value="enfants ">Enfants</option>
                            
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Product Image*</label>
                        <div class="image-upload-container" id="dropZone">
                            <span class="material-icons-sharp upload-icon">cloud_upload</span>
                            <p>Drag & drop an image here or click to select</p>
                            <img id="imagePreview" class="image-preview" alt="Image preview">
                            <label for="productImage" class="image-upload-label">
                                <span class="material-icons-sharp" style="vertical-align: middle; margin-right: 5px;">
                                    photo_camera
                                </span>
                                Choose File
                            </label>
                            <input type="file" id="productImage" name="productImage" class="image-upload-input" accept="image/*" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="productStock">Stock Quantity*</label>
                        <input type="number" id="productStock" name="productStock" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="productColor">Color</label>
                        <input type="text" id="productColor" name="productColor" required>
                    </div>

                    <div class="form-group">
                        <label for="productSize">Size</label>
                        <input type="text" id="productSize" name="productSize" required>
                    </div>
                    <button type="submit" class="submit-btn">
                        <span class="material-icons-sharp" style="vertical-align: middle; margin-right: 5px;">
                            save
                        </span>
                        Add Product
                    </button>
                </form>
            </div>
        </div>
        
        <script>
        // DOM Elements
        const addProductBtn = document.getElementById('addProductBtn');
        const addProductModal = document.getElementById('addProductModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const addProductForm = document.getElementById('addProductForm');
        const productImage = document.getElementById('productImage');
        const imagePreview = document.getElementById('imagePreview');
        const dropZone = document.getElementById('dropZone');
        
        // Show modal when Add Product button is clicked
        addProductBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent the default anchor behavior
            addProductModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        });
        
        // Close modal when close button is clicked
        closeModalBtn.addEventListener('click', () => {
            addProductModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        });
        
        // Close modal when clicking outside the modal
        addProductModal.addEventListener('click', (e) => {
            if (e.target === addProductModal) {
                addProductModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        // Handle image preview
        productImage.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropZone.style.borderColor = '#7380ec';
            dropZone.style.backgroundColor = 'rgba(115, 128, 236, 0.05)';
        }
        
        function unhighlight() {
            dropZone.style.borderColor = '#ddd';
            dropZone.style.backgroundColor = 'transparent';
        }
        
        dropZone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                productImage.files = files;
                const event = new Event('change');
                productImage.dispatchEvent(event);
            }
        }
    </script>
    
</body>
</html>