$(function () {
  
  var url = window.location.href;
  var activeTab = url.substring(url.indexOf('#') + 1);

  if (url.indexOf('#') !== -1) {
    $('.nav-link').removeClass('active');
    $('a[href="#' + activeTab + '"]').addClass('active');
    $('.tab-pane').removeClass('active show');
    $('#' + activeTab).addClass('active show');
  }

});