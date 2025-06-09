# Plugin Jour Férié & Vacances pour Jeedom

Ce plugin permet de détecter si le jour actuel est un jour férié ou un jour de vacances scolaires en France.

## Fonctionnalités

* Détection des jours fériés en France (métropole et DOM-TOM)
* Détection des périodes de vacances scolaires selon les zones académiques A, B et C
* Mise à jour quotidienne automatique
* Configuration simple de la zone académique et de la région

## Installation

* Téléchargez le plugin depuis le Market Jeedom
* Activez le plugin dans la gestion des plugins
* Créez un nouvel équipement et configurez-le

## Configuration

### Configuration du plugin

Dans la configuration du plugin, vous pouvez définir :
* **Zone académique** : Sélectionnez votre zone académique (A, B ou C) pour les vacances scolaires
* **Région pour jours fériés** : Sélectionnez votre région pour les jours fériés (métropole, Alsace-Moselle, DOM-TOM, etc.)

### Configuration de l'équipement

Aucune configuration spécifique n'est nécessaire pour l'équipement. Une fois créé, il disposera automatiquement de deux commandes info :
* **Jour férié** : Indique si aujourd'hui est un jour férié (1) ou non (0)
* **Vacances scolaires** : Indique si aujourd'hui est un jour de vacances scolaires (1) ou non (0)

## Utilisation

Les informations sont mises à jour automatiquement chaque jour. Vous pouvez utiliser ces informations dans vos scénarios pour adapter le comportement de votre domotique en fonction des jours fériés et des vacances scolaires.

## API utilisées

* API Calendrier du gouvernement français : https://calendrier.api.gouv.fr/
* API Open Holidays : https://openholidaysapi.org/
