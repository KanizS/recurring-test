 'use strict';
// NOTE: this code runs on the client so needs to be written defensively and for multi-browser compatibility

var jQ = jQuery.noConflict();
(function () {

  window.addEventListener('load', init);

  var formInputTarget = 'streamthing_delivery_date';  // value of form input data-target

  function init(){
    // get settings
    getSettings(function(datetimepickerOptions, appSettings){
      if(appSettings.enabled){
        createDatePicker(appSettings);
        jQ('#' + formInputTarget).datetimepicker(datetimepickerOptions);
      }

    })
  }

  function getSettings(callback){
    var request = new XMLHttpRequest();
    var destination = 'apps/delivery-date/handy/shopify/settings?source=cart';
    var method = 'GET';
    request.open(method, destination);
    request.send();
    request.onreadystatechange = function(){
      if(request.readyState === XMLHttpRequest.DONE && request.status === 200){
        var settings;
        try {
          settings = JSON.parse(request.responseText);
          applySettings(settings, callback);
        }
        catch(err){
          console.log('error\n', err);
        }
      }
    }
  }


  function applySettings(settings, callback){
    // defaults are hard-coded as fall back in case something goes wrong
    var defaultSettings = {
      enabled: true,                // app is enabled
      latest_future_delivery: 30,   // maximum future delivery date relative to today
      delivery_lead_time: 3,        // lead time for earliest delivery
      daily_cutoff: 13,             // daily cut-off time
      timezone: 'est',              // timezone for daily cutoff
      no_delivery_days_of_the_week: [], // days of the week where there is no delivery
      blackout_dates: [Date.now() + 7 * 24 * 60 * 60 * 1000 ],           // specific delivery blackout dates
      label_text: 'Please select your delivery date',  // text label
    }

    settings = typeof settings !== 'object' ? defaultSettings : settings;

    var datetimepickerOptions = {
      format: 'MMMM Do, YYYY',
      useCurrent: false,
      minDate: earliestDelivery(settings),
      maxDate: latestDelivery(settings),
      daysOfWeekDisabled: disabledDays(settings),
      disabledDates: disabledDates(settings),
    };

    var appSettings = {
      enabled: settings.enabled,
      label_text: settings.label_text,
    };

    return callback(datetimepickerOptions, appSettings);
  }

  function earliestDelivery(settings={}){
    // should calculate the current time at the shop - using timezone -
    //  then if the cutoff is past, add one day to the earliest delivery date
    var cutoff = settings.cutoff;
    var delivery_lead_time = settings.delivery_lead_time;
    var timezone = settings.timezone

    delivery_lead_time = isPastCutOff(cutoff, timezone) ? delivery_lead_time++ : delivery_lead_time;
    var today = Date.now();
    var earliestDelivery = new Date(today + delivery_lead_time * 24 * 60 * 60 * 1000);
    return earliestDelivery;
  }

  function isPastCutOff(cutoff){
    // calculate if cutoff time has passed
    return false;
  }

  function latestDelivery(settings){
    // calculate latest delivery date
    var latestDelivery = new Date(Date.now() + settings.latest_future_delivery * 24 * 60 * 60 * 1000);
    return latestDelivery;
  }

  function disabledDays(settings){
    // convert settings.no_delivery_days_of_the_week to array if necessary
    var disabledDays = Array.isArray(settings.no_delivery_days_of_the_week) ? settings.no_delivery_days_of_the_week : [];

    return disabledDays;
  }

  function disabledDates(settings){
    // create array of specific delivery blackout dates
    var disabledDateArray = settings.blackout_dates || [];
    var disabledDates = [];
    disabledDateArray.forEach((disabledDate)=>{
      disabledDates.push(new Date(disabledDate))
    })
    return disabledDates;
  }

  function createDatePicker(appSettings){
    var deliveryDatePicker = document.getElementById('streamthing_delivery_date_picker');

    var datePicker = "\
        <div class='form-group'>\
          <label for='" + formInputTarget + "_input" + "'>" + appSettings.label_text + "</label>\
          <div class='input-group date' id='" + formInputTarget + "' data-target-input='nearest'>\
            <input onchange=console.log("senuri") class='form-control datetimepicker-input' type='text' data-target='#" + formInputTarget + "' name='attributes[" + formInputTarget + "]' id='" + formInputTarget + "_input" + "' value='{{ cart.attributes." + formInputTarget + " }}' />\
            <span class='input-group-addon' data-target='#streamthing_delivery_date' data-toggle='datetimepicker'>\
              <span class='glyphicon glyphicon-calendar'></span>\
            </span>\
          </div>\
        </div>\
        ";


    /*
    var datePicker = "\
        <div class='form-group'>\
          <label for='streamthing_delivery_date_input'>" + appSettings.label_text + "</label>\
          <div class='input-group date' id='" + formInputTarget + "' data-target-input='nearest'>\
            <input class='form-control datetimepicker-input' type='text' data-target='#" + formInputTarget + "' name='attributes[streamthing_delivery_date]' id='streamthing_delivery_date_input' value='{{ cart.attributes.streamthing_delivery_date }}' />\
            <span class='input-group-addon' data-target='#" + formInputTarget + "' data-toggle='datetimepicker'>\
              <span class='glyphicon glyphicon-calendar'></span>\
            </span>\
          </div>\
        </div>\
        ";
    */
    deliveryDatePicker.innerHTML = datePicker;
  }

})(jQ);
