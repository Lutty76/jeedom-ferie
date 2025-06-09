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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
  include_file('desktop', '404', 'php');
  die();
}
?>
<form class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label class="col-md-4 control-label">{{Zone académique}}
        <sup><i class="fas fa-question-circle tooltips" title="{{Sélectionnez votre zone académique pour les vacances scolaires}}"></i></sup>
      </label>
      <div class="col-md-4">
        <select class="configKey form-control" data-l1key="academicZone">
          <option value="">{{Sélectionnez une zone}}</option>
          <option value="FR-ARA">{{Zone A - Académies: Besançon, Bordeaux, Clermont-Ferrand, Dijon, Grenoble, Limoges, Lyon, Poitiers}}</option>
          <option value="FR-OCC">{{Zone B - Académies: Aix-Marseille, Amiens, Caen, Lille, Nancy-Metz, Nantes, Nice, Orléans-Tours, Reims, Rennes, Rouen, Strasbourg}}</option>
          <option value="FR-IDF">{{Zone C - Académies: Créteil, Montpellier, Paris, Toulouse, Versailles}}</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">{{Région pour jours fériés}}
        <sup><i class="fas fa-question-circle tooltips" title="{{Sélectionnez votre région pour les jours fériés}}"></i></sup>
      </label>
      <div class="col-md-4">
        <select class="configKey form-control" data-l1key="holidayRegion">
          <option value="metropole">{{Métropole}}</option>
          <option value="alsace-moselle">{{Alsace-Moselle}}</option>
          <option value="guadeloupe">{{Guadeloupe}}</option>
          <option value="guyane">{{Guyane}}</option>
          <option value="martinique">{{Martinique}}</option>
          <option value="mayotte">{{Mayotte}}</option>
          <option value="nouvelle-caledonie">{{Nouvelle-Calédonie}}</option>
          <option value="polynesie-francaise">{{Polynésie française}}</option>
          <option value="reunion">{{La Réunion}}</option>
          <option value="saint-barthelemy">{{Saint-Barthélemy}}</option>
          <option value="saint-martin">{{Saint-Martin}}</option>
          <option value="saint-pierre-et-miquelon">{{Saint-Pierre-et-Miquelon}}</option>
          <option value="wallis-et-futuna">{{Wallis-et-Futuna}}</option>
        </select>
      </div>
    </div>
  </fieldset>
</form>
