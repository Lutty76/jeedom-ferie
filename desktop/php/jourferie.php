<?php

if (!isConnect('admin')) {
    throw new Exception(__('401 - Accès non autorisé', __FILE__));
}

sendVarToJS('eqType', 'jourferie');
$eqLogics = eqLogic::byType('jourferie');
?>

<div class="eqLogicThumbnailDisplay">
  <legend><i class="fas fa-cogs"></i> {{Mes équipements}}</legend>
  <div class="eqLogicThumbnailContainer">
    <?php foreach ($eqLogics as $eqLogic) { ?>
      <div class="eqLogicDisplayCard cursor" data-eqLogic_id="<?php echo $eqLogic->getId() ?>">
        <img src="plugins/jourferie/plugin_icon.png" />
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
    <input class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}" />
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
    </fieldset>
  </div>
</div>
