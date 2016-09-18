/*!
*   FSVS - Full Screen Vertical Scroller
*   https://github.com/lukesnowden/FSVS
*   Copyright 2014 Luke Snowden
*   Released under the MIT license:
*   http://www.opensource.org/licenses/mit-license.php
*/

;( function($){
  $.fn.fsvs = function( options ) {

    options = options || {};
    if (navigator.platform == 'Linux x86_64') {
       var lux_speed = 2000;  
    } else if (navigator.platform == 'MacIntel') {
        var lux_speed = 2000; 
    } else {
        var lux_speed = 5000;
    }
    /**
     * [defaults description]
     * @type {Object}
     */

    var defaults = {
      el : null,
      speed : lux_speed,