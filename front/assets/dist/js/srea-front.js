"use strict";

var srea = {
  handleAction: function handleAction(e) {
    var _e$currentTarget$data = e.currentTarget.dataset,
        id = _e$currentTarget$data.sreaPostId,
        sreaSlug = _e$currentTarget$data.sreaSlug,
        n = _e$currentTarget$data.nonce,
        currentReaction = _e$currentTarget$data.reacted;
    var $clickedButton = e.target.closest('.srea-button');
    var sreaAction = $clickedButton.dataset.sreaAction;
    var $parent = e.target.closest('.srea-template');

    if (!sreaAction || !id) {
      return false;
    }

    var counterElement = jQuery(e.target).siblings('.srea-template-count');
    var currentReactionElement = jQuery($parent).find("[data-srea-action=\"".concat(currentReaction, "\"]")).siblings('.srea-template-count');
    counterElement.html(srea.getLoader());
    $clickedButton.disabled = true;
    var data = {
      action: 'srea_handle_post_reactions',
      current: currentReaction,
      srea_action: sreaAction,
      slug: sreaSlug,
      post_id: id,
      n: n
    };
    jQuery.post(SREA.ajaxurl, data, function (res) {
      if (res.success) {
        $parent.setAttribute('data-reacted', sreaAction);
        currentReactionElement.html(res.data.old_count);
        counterElement.html(res.data.count);
        $clickedButton.disabled = false;
      }
    });
  },
  getLoader: function getLoader() {
    var loader = document.createElement('div');
    loader.className = 'srea-loader';
    return loader;
  }
};
window.addEventListener('DOMContentLoaded', function () {
  var sreaElement = document.querySelectorAll('.srea-template');
  sreaElement.forEach(function (el, i) {
    el.addEventListener('click', srea.handleAction);
  });
});