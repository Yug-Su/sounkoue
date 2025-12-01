#!/bin/bash

# Créer des copies de l'icône SVG en tant que PNG (placeholder)
# En production, utilisez un outil comme ImageMagick ou un service en ligne

cd public/icons

# Créer des fichiers placeholder pour les différentes tailles
sizes=(72 96 128 144 152 192 384 512)

for size in "${sizes[@]}"; do
    cp icon.svg "icon-${size}x${size}.png"
done

echo "Icônes générées (placeholder). Remplacez par de vraies images PNG."