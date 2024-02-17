/*
 * Script from NETTUTS.com [by James Padolsey]
 * @requires jQuery($), jQuery UI & sortable/draggable UI modules
 */

//Pendientes
var column1Array = [];
//En proceso
var column2Array = [];
//Terminadas
var column3Array = [];

var iNettuts = {
  jQuery: jQuery,

  settings: {
    columns: '.column',
    widgetSelector: '.widget',
    handleSelector: '.contenedor',
    contentSelector: '.widget-content',
    widgetDefault: {
      movable: true,
    },
    widgetIndividual: {
      intro: {
        movable: false,
      },
    },
  },

  init: function () {
    //this.attachStylesheet('css/inettuts.js.css');
    this.makeSortable();
  },

  getWidgetSettings: function (id) {
    var jQuery = this.jQuery,
      settings = this.settings;
    return id && settings.widgetIndividual[id]
      ? jQuery.extend({}, settings.widgetDefault, settings.widgetIndividual[id])
      : settings.widgetDefault;
  },

  attachStylesheet: function (href) {
    var jQuery = this.jQuery;
    return jQuery(
      '<link href="' + href + '" rel="stylesheet" type="text/css" />'
    ).appendTo('head');
  },

  makeSortable: function () {
    var iNettuts = this,
      jQuery = this.jQuery,
      settings = this.settings,
      $sortableItems = (function () {
        var notSortable = '';
        jQuery(settings.widgetSelector, jQuery(settings.columns)).each(
          function (i) {
            if (!iNettuts.getWidgetSettings(this.id).movable) {
              if (!this.id) {
                this.id = 'widget-no-id-' + i;
              }
              notSortable += '#' + this.id + ',';
            }
          }
        );
        return jQuery('> li:not(' + notSortable + ')', settings.columns);
      })();

    $sortableItems
      .find(settings.handleSelector)
      .css({
        cursor: 'move',
      })
      .mousedown(function (e) {
        $sortableItems.css({ width: '' });
        jQuery(this)
          .parent()
          .css({
            width: jQuery(this).parent().width() + 'px',
          });
      })
      .mouseup(function () {
        if (!jQuery(this).parent().hasClass('dragging')) {
          jQuery(this).parent().css({ width: '' });
        } else {
          jQuery(settings.columns).sortable('disable');
        }
        //

        //
        setTimeout(() => {
          //const id = jQuery(this).attr('id');
          //const col = jQuery(this).parent().parent().attr('id');
          //console.log(id, 'id,', col, 'col');
          //console.log(jQuery(this).parent('li', 'ul').index(), 'indice');

          //Pendientes
          column1Array = [];
          //En proceso
          column2Array = [];
          //Terminadas
          column3Array = [];

          jQuery('#column1 li').each(function () {
            column1Array.push(jQuery(this).attr('id'));
          });

          jQuery('#column2 li').each(function () {
            column2Array.push(jQuery(this).attr('id'));
          });

          jQuery('#column3 li').each(function () {
            column3Array.push(jQuery(this).attr('id'));
          });

          actualizarEstadoAcciones();
        }, 2000);
      });

    jQuery(settings.columns).sortable({
      items: $sortableItems,
      connectWith: jQuery(settings.columns),
      handle: settings.handleSelector,
      placeholder: 'widget-placeholder',
      forcePlaceholderSize: true,
      revert: 300,
      delay: 100,
      opacity: 0.8,
      containment: 'document',
      start: function (e, ui) {
        jQuery(ui.helper).addClass('dragging');
      },
      stop: function (e, ui) {
        jQuery(ui.item).css({ width: '' }).removeClass('dragging');
        jQuery(settings.columns).sortable('enable');
      },
    });
  },
};

iNettuts.init();
