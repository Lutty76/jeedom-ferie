<?php

if (!isConnect('admin')) {
    throw new Exception(__('401 - Accès non autorisé', __FILE__));
}
include_file('desktop', 'jourferie', 'js', 'jourferie');
include_file('core', 'cmd', 'js');
sendVarToJS('eqType', 'jourferie');
$eqLogics = eqLogic::byType('jourferie');
?>

<div class="eqLogicThumbnailDisplay">
  <legend><i class="fas fa-cogs"></i> {{Mes équipements}}</legend>
  <div class="eqLogicThumbnailContainer">
    <?php foreach ($eqLogics as $eqLogic) { ?>
      <div class="eqLogicDisplayCard cursor" data-eqLogic_id="<?php echo $eqLogic->getId() ?>">
        <img src="plugins/jourferie/plugin_info/jourferie_icon.png" />
        <br />
        <span><?php echo $eqLogic->getHumanName(true) ?></span>
      </div>
    <?php } ?>
    <div class="eqLogicDisplayCard cursor addEqLogic">
      <i class="fas fa-plus-circle"></i>
      <br />
      <span>{{Ajouter}}</span>
    </div>
  </div>
</div>

<div class="eqLogic" style="display: none;">
  <div class="input-group pull-right" style="margin-top: 5px;">
    <span class="input-group-btn">
      <a class="btn btn-default btn-sm eqLogicAction" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i> {{Retour}}</a>
      <a class="btn btn-success btn-sm eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a>
      <a class="btn btn-danger btn-sm eqLogicAction" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
    </span>
    <input class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}" />
    <input type="hidden" class="eqLogicAttr" data-l1key="id" />
  </div>

  <div class="form-horizontal">
    <fieldset>
      <legend><i class="fas fa-cog"></i> {{Configuration}}</legend>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Objet parent}}</label>
        <div class="col-sm-6">
          <select class="eqLogicAttr form-control" data-l1key="object_id">
            <?php foreach (jeeObject::all() as $object) { ?>
              <option value="<?php echo $object->getId(); ?>"><?php echo $object->getName(); ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Activer}}</label>
        <div class="col-sm-6">
          <input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Visible}}</label>
        <div class="col-sm-6">
          <input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Zone académique}}
          <sup><i class="fas fa-question-circle tooltips" title="{{Sélectionnez votre zone académique pour les vacances scolaires}}"></i></sup>
        </label>
        <div class="col-sm-6">
          <select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="academicZone">
            <option value="">{{Sélectionnez une zone}}</option>
            <option value="FR-ARA">{{Zone A - Académies: Besançon, Bordeaux, Clermont-Ferrand, Dijon, Grenoble, Limoges, Lyon, Poitiers}}</option>
            <option value="FR-OCC">{{Zone B - Académies: Aix-Marseille, Amiens, Caen, Lille, Nancy-Metz, Nantes, Nice, Orléans-Tours, Reims, Rennes, Rouen, Strasbourg}}</option>
            <option value="FR-IDF">{{Zone C - Académies: Créteil, Montpellier, Paris, Toulouse, Versailles}}</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Région pour jours fériés}}
          <sup><i class="fas fa-question-circle tooltips" title="{{Sélectionnez votre région pour les jours fériés}}"></i></sup>
        </label>
        <div class="col-sm-6">
          <select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="holidayRegion">
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
  </div>

  <div class="form-horizontal">
    <fieldset>
      <legend><i class="fas fa-list-alt"></i> {{Commandes}}</legend>
      <table id="table_cmd" class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th style="width: 300px;">{{Nom}}</th>
            <th style="width: 200px;">{{Type}}</th>
            <th style="width: 300px;">{{Options}}</th>
            <th style="width: 150px;">{{Etat}}</th>
            <th style="width: 150px;">{{Action}}</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </fieldset>
  </div>
</div>
