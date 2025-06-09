<?php
/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class jourferie extends eqLogic {
  /*     * *************************Attributs****************************** */

    public static function cronDaily() {
        // Vérifie si c'est un jour férié
        $isHoliday = self::isHoliday();
        // Vérifie si c'est une période de vacances
        $isVacation = self::isVacation();

        foreach (eqLogic::byType('jourferie') as $eqLogic) {
            $eqLogic->checkAndUpdateCmd('isHoliday', $isHoliday);
            $eqLogic->checkAndUpdateCmd('isVacation', $isVacation);
        }
    }

    private static function isHoliday() {
        $year = date('Y');
        $today = date('Y-m-d');

        // Récupérer la région configurée ou utiliser 'metropole' par défaut
        $region = config::byKey('holidayRegion', 'jourferie', 'metropole');
        $url = "https://calendrier.api.gouv.fr/jours-feries/$region/$year.json";

        $json = file_get_contents($url);
        if ($json === false) {
            log::add('jourferie', 'error', 'Erreur lors de l\'accès à l\'API des jours fériés');
            return 0; // Erreur d'accès à l'API
        }

        $holidays = json_decode($json, true);
        return in_array($today, array_keys($holidays)) ? 1 : 0;
    }

    private static function isVacation() {
        $today = date('Y-m-d');

        // Récupérer la zone académique configurée ou utiliser 'FR-IDF' (Zone C) par défaut
        $academicZone = config::byKey('academicZone', 'jourferie', 'FR-IDF');
        if (empty($academicZone)) {
            $academicZone = 'FR-IDF'; // Zone C par défaut si non configuré
        }

        $url = "https://openholidaysapi.org/SchoolHolidays?countryIsoCode=FR&subdivisionCode=$academicZone&validFrom=$today&validTo=$today";

        $response = file_get_contents($url);
        if ($response === false) {
            log::add('jourferie', 'error', 'Erreur lors de l\'accès à l\'API des vacances scolaires');
            return 0; // Erreur d'accès à l'API
        }

        $data = json_decode($response, true);
        return !empty($data) ? 1 : 0;
    }
  /*     * *********************Méthodes d'instance************************* */

  // Fonction exécutée automatiquement avant la création de l'équipement
  public function preInsert() {
  }

  // Fonction exécutée automatiquement après la création de l'équipement
  public function postInsert() {
  }

  // Fonction exécutée automatiquement avant la mise à jour de l'équipement
  public function preUpdate() {
  }

  // Fonction exécutée automatiquement après la mise à jour de l'équipement
  public function postUpdate() {
  }

  // Fonction exécutée automatiquement avant la sauvegarde (création ou mise à jour) de l'équipement
  public function preSave() {
  }

  // Fonction exécutée automatiquement après la sauvegarde (création ou mise à jour) de l'équipement
  public function postSave() {
    // Création des commandes si elles n'existent pas déjà
    $isHolidayCmd = $this->getCmd(null, 'isHoliday');
    if (!is_object($isHolidayCmd)) {
      $isHolidayCmd = new jourferieCmd();
      $isHolidayCmd->setName(__('Jour férié', __FILE__));
      $isHolidayCmd->setEqLogic_id($this->getId());
      $isHolidayCmd->setLogicalId('isHoliday');
      $isHolidayCmd->setType('info');
      $isHolidayCmd->setSubType('binary');
      $isHolidayCmd->save();
    }

    $isVacationCmd = $this->getCmd(null, 'isVacation');
    if (!is_object($isVacationCmd)) {
      $isVacationCmd = new jourferieCmd();
      $isVacationCmd->setName(__('Vacances scolaires', __FILE__));
      $isVacationCmd->setEqLogic_id($this->getId());
      $isVacationCmd->setLogicalId('isVacation');
      $isVacationCmd->setType('info');
      $isVacationCmd->setSubType('binary');
      $isVacationCmd->save();
    }

    // Mise à jour immédiate des valeurs
    $this->checkAndUpdateCmd('isHoliday', self::isHoliday());
    $this->checkAndUpdateCmd('isVacation', self::isVacation());
  }

  // Fonction exécutée automatiquement avant la suppression de l'équipement
  public function preRemove() {
  }

  // Fonction exécutée automatiquement après la suppression de l'équipement
  public function postRemove() {
  }

  /*
  * Permet de crypter/décrypter automatiquement des champs de configuration des équipements
  * Exemple avec le champ "Mot de passe" (password)
  public function decrypt() {
    $this->setConfiguration('password', utils::decrypt($this->getConfiguration('password')));
  }
  public function encrypt() {
    $this->setConfiguration('password', utils::encrypt($this->getConfiguration('password')));
  }
  */

  /*
  * Permet de modifier l'affichage du widget (également utilisable par les commandes)
  public function toHtml($_version = 'dashboard') {}
  */

  /*     * **********************Getteur Setteur*************************** */
}

class jourferieCmd extends cmd {
    public function execute($_options = null) {
        return $this->getConfiguration('value');
    }
}
