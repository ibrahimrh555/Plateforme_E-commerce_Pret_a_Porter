<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produit;
use Illuminate\Support\Facades\Storage;

class MigrateImages extends Command
{
   
    protected $signature = 'images:migrate';
    protected $description = 'Migrate existing product images to public/image directory';

    public function handle()
    {
        $this->info('🚀 Migration des images vers public/image...');
        
        // Créer le dossier s'il n'existe pas
        if (!file_exists(public_path('image'))) {
            mkdir(public_path('image'), 0755, true);
            $this->info('📁 Dossier public/image créé.');
        }

        $produits = Produit::whereNotNull('image')->get();
        $migratedCount = 0;
        $errorCount = 0;
        $alreadyMigratedCount = 0;

        $this->info("📊 Nombre de produits à traiter: " . $produits->count());

        if ($produits->count() === 0) {
            $this->warn('Aucun produit avec image trouvé dans la base de données.');
            return 0;
        }

        // Barre de progression
        $bar = $this->output->createProgressBar($produits->count());
        $bar->start();

        foreach ($produits as $produit) {
            try {
                $oldImagePath = $produit->image;
                
                // Si l'image commence par 'uploads/', c'est une ancienne image du storage
                if (str_starts_with($oldImagePath, 'uploads/')) {
                    $fullOldPath = storage_path('app/public/' . $oldImagePath);
                    
                    if (file_exists($fullOldPath)) {
                        // Générer un nouveau nom pour éviter les conflits
                        $extension = pathinfo($oldImagePath, PATHINFO_EXTENSION);
                        $newImageName = time() . '_' . uniqid() . '.' . $extension;
                        $newImagePath = public_path('image/' . $newImageName);
                        
                        // Copier l'image
                        if (copy($fullOldPath, $newImagePath)) {
                            // Mettre à jour la base de données
                            $produit->image = $newImageName;
                            $produit->save();
                            
                            $migratedCount++;
                        } else {
                            $this->newLine();
                            $this->error("❌ Erreur lors de la copie: {$oldImagePath}");
                            $errorCount++;
                        }
                    } else {
                        $this->newLine();
                        $this->warn("⚠️  Image introuvable: {$fullOldPath}");
                        $errorCount++;
                    }
                } else {
                    // Vérifier si l'image existe déjà dans public/image
                    if (file_exists(public_path('image/' . $oldImagePath))) {
                        $alreadyMigratedCount++;
                    } else {
                        // L'image n'existe nulle part, marquer comme erreur
                        $this->newLine();
                        $this->warn("⚠️  Image {$oldImagePath} introuvable pour le produit: {$produit->nom}");
                        $errorCount++;
                    }
                }
                
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("❌ Erreur pour le produit {$produit->id}: " . $e->getMessage());
                $errorCount++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Résumé
        $this->info("=== 📈 RÉSUMÉ DE LA MIGRATION ===");
        $this->info("✅ Images migrées: {$migratedCount}");
        $this->info("✔️  Images déjà migrées: {$alreadyMigratedCount}");
        $this->info("❌ Erreurs: {$errorCount}");
        $this->info("📊 Total traité: " . ($migratedCount + $alreadyMigratedCount + $errorCount));
        
        if ($migratedCount > 0) {
            $this->info("🎉 Migration terminée avec succès!");
        }

        if ($errorCount > 0) {
            $this->warn("⚠️  Certaines images n'ont pas pu être migrées. Vérifiez les erreurs ci-dessus.");
        }

        return 0;
    }
}