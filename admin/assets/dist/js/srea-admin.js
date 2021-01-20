"use strict";

document.addEventListener("DOMContentLoaded", function (event) {
  var nonce = document.getElementById('_wpnonce');
  var $selects = document.querySelectorAll('select');
  $selects.forEach(function (element) {
    element.addEventListener('change', sreaSaveSettings);
  });

  function sreaSaveSettings(e) {
    var spinner = showLoader();
    e.target.insertAdjacentElement('afterend', spinner);
    var formData = new FormData();
    formData.append('action', 'srea_save_settings');
    formData.append('nonce', nonce.value);
    formData.append('option', e.target.name);
    formData.append('value', e.target.value);
    fetch(ajaxurl, {
      method: 'POST',
      body: formData
    }).then(function (response) {
      return response.json();
    }).then(function (res) {
      e.target.parentNode.removeChild(spinner);
      var badge = showResults(res.success, res.data.results);
      e.target.insertAdjacentElement('afterend', badge);
      setTimeout(function () {
        e.target.parentNode.removeChild(badge);
      }, 500);
    });
  }

  function showLoader() {
    var loader = document.createElement('div');
    loader.className = 'srea-loader';
    return loader;
  }

  function showResults(status, text) {
    var badge = document.createElement('div');
    badge.className = status ? 'srea-badge-success' : 'srea-badge-error';
    badge.textContent = text;
    return badge;
  }
});