# Documentation du plugin JourFerie pour Jeedom

## Présentation

Le plugin **JourFerie** permet de savoir automatiquement si aujourd’hui est un jour férié ou une période de vacances scolaires, selon la région et la zone académique configurées. Il s’appuie sur des APIs publiques pour obtenir ces informations.

---

## Installation

1. Installez le plugin depuis le market Jeedom.
2. Activez-le dans la gestion des plugins.

---

## Configuration

### Création d’un équipement

- Depuis la page du plugin, cliquez sur **Ajouter** pour créer un nouvel équipement.
- Donnez un nom à l’équipement.

### Paramètres de l’équipement

- **Nom de l’équipement** : nom libre.
- **Objet parent** : rattachez l’équipement à un objet Jeedom.
- **Activer** : cochez pour activer l’équipement.
- **Visible** : cochez pour le rendre visible sur le dashboard.
- **Zone académique** : sélectionnez la zone pour les vacances scolaires (A, B ou C).
- **Région pour jours fériés** : sélectionnez la région pour les jours fériés (Métropole, Alsace-Moselle, DOM-TOM, etc.).

---

## Fonctionnalités

Deux commandes sont créées automatiquement :

- **Jour férié** (`isHoliday`) : retourne 1 si aujourd’hui est un jour férié dans la région sélectionnée, sinon 0.
- **Vacances scolaires** (`isVacation`) : retourne 1 si aujourd’hui est un jour de vacances scolaires dans la zone sélectionnée, sinon 0.

Ces commandes sont de type `info` binaire et peuvent être utilisées dans vos scénarios, designs, ou autres automatisations.

---

## Utilisation

- Ajoutez le widget de l’équipement sur votre dashboard pour visualiser l’état.
- Utilisez les commandes dans vos scénarios pour adapter vos automatismes (ex : ne pas déclencher le réveil les jours fériés ou pendant les vacances).

---

## Mise à jour des données

Les états sont mis à jour automatiquement chaque jour via le cron quotidien de Jeedom.

---

## Support

Pour toute question ou problème, utilisez le forum Jeedom ou ouvrez un ticket sur le dépôt GitHub du plugin.