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
var eqType = 'jourferie';

// Gestion de l'ajout d'un équipement
$(document).on('click', '.addEqLogic', function () {
  var _eqLogic = {type: eqType};
  bootbox.prompt("{{Nom de l'équipement}}", function (result) {
    if (result !== null) {
      _eqLogic.name = result;
      jeedom.eqLogic.save({
        type: eqType,
        eqLogics: [_eqLogic],
        error: function (error) {
          $('#div_alert').showAlert({message: error.message, level: 'danger'});
        },
        success: function (data) {
          var vars = getUrlVars();
          var url = 'index.php?';
          for (var i in vars) {
            if (i != 'id' && i != 'saveSuccessFull' && i != 'removeSuccessFull') {
              url += i + '=' + vars[i] + '&';
            }
          }
          url += 'id=' + data.id + '&saveSuccessFull=1';
          loadPage(url);
        }
      });
    }
  });
});

// Gestion du clic sur un équipement existant
$(document).on('click', '.eqLogicDisplayCard', function () {
  if (!$(this).hasClass('addEqLogic')) {
    var id = $(this).attr('data-eqLogic_id');
    $('.eqLogicThumbnailDisplay').hide();
    $('.eqLogic').show();
    jeedom.eqLogic.cache.getCmd = Array();
    if (id == '') {
      $('.eqLogic').empty();
      return;
    }
    jeedom.eqLogic.byId({
      id: id,
      error: function (error) {
        $('#div_alert').showAlert({message: error.message, level: 'danger'});
      },
      success: function (data) {
        $('.eqLogic').setValues(data, '.eqLogicAttr');
        jeedom.cmd.displayActionsOption({
          params: {
            eqLogic_id: id
          }
        });
        $('.eqLogicAction[data-action=returnToThumbnailDisplay]').show();

        // Chargement des commandes
        loadCmdsByEqLogicId(id)

      }
    });
  }
});

// Gestion des actions sur les équipements
$(document).on('click', '.eqLogicAction[data-action=returnToThumbnailDisplay]', function () {
  $('.eqLogic').hide();
  $('.eqLogicThumbnailDisplay').show();
});

$(document).on('click', '.eqLogicAction[data-action=save]', function () {
  var eqLogic = $('.eqLogic').getValues('.eqLogicAttr')[0];
  jeedom.eqLogic.save({
    type: eqType,
    eqLogics: [eqLogic],
    error: function (error) {
      $('#div_alert').showAlert({message: error.message, level: 'danger'});
    },
    success: function (data) {
      $('.eqLogic').hide();
      $('.eqLogicThumbnailDisplay').show();
      window.location.reload();
    }
  });
});

$(document).on('click', '.eqLogicAction[data-action=remove]', function () {
  var eqLogic = $('.eqLogic').getValues('.eqLogicAttr')[0];
  jeedom.eqLogic.remove({
    type: eqType,
    id: eqLogic.id,
    error: function (error) {
      $('#div_alert').showAlert({message: error.message, level: 'danger'});
    },
    success: function () {
      $('.eqLogic').hide();
      $('.eqLogicThumbnailDisplay').show();
      window.location.reload();
    }
  });
});

/* Permet la réorganisation des commandes dans l'équipement */
$("#table_cmd").sortable({
  axis: "y",
  cursor: "move",
  items: ".cmd",
  placeholder: "ui-state-highlight",
  tolerance: "intersect",
  forcePlaceholderSize: true
})

/* Fonction permettant l'affichage des commandes dans l'équipement */
function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = { configuration: {} };
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {};
  }

  // Construction de la ligne HTML
  var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';

  // ID (hidden)
  tr += '<td class="hidden-xs">';
  tr += '<span class="cmdAttr" data-l1key="id">' + _cmd.id + '</span>';
  tr += '</td>';

  // Nom + icône
  tr += '<td>';
  tr += '<div class="input-group">';
  tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="name" value="' + htmlspecialchars(_cmd.name || '') + '" placeholder="Nom de la commande">';
  tr += '<span class="input-group-btn"><a class="cmdAction btn btn-sm btn-default" data-l1key="chooseIcon" title="Choisir une icône"><i class="fas fa-icons"></i></a></span>';
  tr += '<span class="cmdAttr input-group-addon roundedRight" data-l1key="display" data-l2key="icon" style="font-size:19px;padding:0 5px 0 0!important;">' + (_cmd.display.icon || '') + '</span>';
  tr += '</div>';

  // Select valeur (vide pour l'instant)
  tr += '<select class="cmdAttr form-control input-sm" data-l1key="value" style="display:none;margin-top:5px;" title="Commande info liée">';
  tr += '<option value="">{{Aucune}}</option>';
  tr += '</select>';
  tr += '</td>';


  // Options: visible, historisé, inversé + min/max/unité
  tr += '<td>';
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" ' + (_cmd.isVisible == '1' ? 'checked' : '') + '>Afficher</label> ';
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" ' + (_cmd.isHistorized == '1' ? 'checked' : '') + '>Historiser</label> ';
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary" ' + ((_cmd.display && _cmd.display.invertBinary) ? 'checked' : '') + '>Inverser</label> ';
  tr += '</td>';

  // Etat HTML (affichage dynamique)
  tr += '<td><span class="cmdAttr" data-l1key="htmlstate"></span></td>';

  // Boutons config/test/suppression
  tr += '<td>';
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> ';
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> Tester</a>';
  }
  tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove" title="Supprimer la commande"></i>';
  tr += '</td>';

  tr += '</tr>';

  // Ajoute au tableau
  $('#table_cmd tbody').append(tr);

  // Récupère la dernière ligne créée
  var $tr = $('#table_cmd tbody tr').last();

  // Remplissage dynamique de la liste des commandes liées (pour select)
  jeedom.eqLogic.buildSelectCmd({
    id: $('.eqLogicAttr[data-l1key=id]').value(),
    filter: { type: 'info' },
    error: function (error) {
      $('#div_alert').showAlert({ message: error.message, level: 'danger' });
    },
    success: function (result) {
      $tr.find('.cmdAttr[data-l1key=value]').append(result);
      $tr.setValues(_cmd, '.cmdAttr');
      jeedom.cmd.changeType($tr, init(_cmd.subType ));
    }
  });


  // Récupérer l'état actuel de la commande
  getCmdState(_cmd.id)
}

// Petite fonction d'échappement HTML (pour éviter les injections)
function htmlspecialchars(str) {
  if (!str) return '';
  return str.replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}
function loadCmdsByEqLogicId(eqLogicId) {
  $.ajax({
    type: "POST",
    url: "core/ajax/cmd.ajax.php",
    data: { action: "byEqLogic", eqLogic_id: eqLogicId },
    dataType: 'json',
    success: function(response) {
      if (response.state === 'ok') {
        $('#table_cmd tbody').empty();
        response.result.forEach(function(cmd) {
          addCmdToTable(cmd);
        });
      } else {
        $('#div_alert').showAlert({message: response.result, level: 'danger'});
      }
    },
    error: function(xhr, status, error) {
      $('#div_alert').showAlert({message: error, level: 'danger'});
    }
  });
}

function getCmdState(id){
  jeedom.cmd.execute({
    id: id,
    success: function (result) {
      $('#table_cmd tbody tr[data-cmd_id="' + id + '"] .cmdAttr[data-l1key=htmlstate]').html(result);
    },
    error: function (error) {
      stateCell.html('Erreur');
      console.error('Erreur de récupération de l\'état :', error);
    }
  });

}