//main slider
$(function(){
  $('.main-slider').slick({
    autoplay: true,
    dots: true,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear'
  });
});

//collection slider
$(function(){
  $('.collections-slider').slick({
    /*autoplay: true,*/
    dots: true,
    infinite: true,
    speed: 500,
  });
});

//Product Slider
$(function(){
    $('.product-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        asNavFor: '.product-slider-nav'
      });
      $('.product-slider-nav').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        asNavFor: '.product-slider',
        centerMode: true,
        focusOnSelect: true,
        infinite:true
      });

      $('.product-slider-item').zoom({
        magnify: 0.8, 
        touch: true, 
        duration:500,
        onZoomIn: function(){
          $('.product-slider-image').hide();
        },
        onZoomOut:function(){
          $('.product-slider-image').show();
        }
      }); 
});

// Suggestions slider
$(function(){
    $('.suggestion-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        /*autoplay: true,*/
        autoplaySpeed: 3000,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });
});

// Featured items slider
$(function(){
    $('.featured-items-slider').slick({
        dots: true,
        arrows:false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        /*autoplay: true,*/
        autoplaySpeed: 3000,
        responsive: [
          {
            breakpoint: 1124,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
           {
            breakpoint: 821,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });
});