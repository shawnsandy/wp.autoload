/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//Theme scripts
jQuery(document).ready(function($){
    $(".info-bar-btn").click(function(){
        $("#info-bar").slideToggle("slow");
        $(this).toggleClass("active");
    })
})
