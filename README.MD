# Create Projet

```
composer create-project symfony/website-skeleton MONPROJET 4.4.*
```

# Dependancies

## Sluglify
> https://packagist.org/

Packagist est le référentiel principal de Composer . Il agrège les packages PHP publics installables avec Composer.

install :
```
composer require cocur/slugify
```
---
## Form
La création et le traitement de formulaires HTML sont difficiles et répétitifs. Vous devez gérer le rendu des champs de formulaire HTML, la validation des données soumises, le mappage des données du formulaire en objets et bien plus encore. Symfony inclut une fonction de formulaire puissante qui fournit toutes ces fonctionnalités et bien d'autres pour des scénarios vraiment complexes.

Installation :
```
composer require symfony/form
```

Créer un formulaire
```
php bin/console make:form
```