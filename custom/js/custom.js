(function(document, window, $){
  $(function(){
    $(document).on('click', 'a.smoothscroll', function(event){
      event.preventDefault();

      $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
      }, 500);
    });

    var waypoint = $('.widgetpin').waypoint({
      handler: function(direction) {
        if(direction === 'down'){
          $(this.element).width( $(this.element).parent().width() );
          this.element.classList.add('pinned');
        } else {
          $(this.element).width('auto');
          this.element.classList.remove('pinned');
        }
      },
      offset: 60
    });
  });
})(document,window,jQuery);
