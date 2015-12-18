$(document).ready(function() {
 
  $('a[href^="#"]').click(function(){
          var el = $(this).attr('href');
          $('html').animate({
              scrollTop: $(el).offset().top+40}, 2000);
          $('body').animate({
              scrollTop: $(el).offset().top+40}, 2000);
          return false; 
  });  
});
