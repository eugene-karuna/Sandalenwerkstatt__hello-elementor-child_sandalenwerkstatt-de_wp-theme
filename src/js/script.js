/*! elementor-pro - v1.1 - 21-03-2021 */
var $emptyDivs = $(".elementor-tab-content > div:empty");
   $emptyDivs.each(function(){
   $(this).parent('elementor-tab-content').hide();
});