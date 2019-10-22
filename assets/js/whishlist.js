$(document).ready(function(){
  //CONTROL USERS WISHLIST
  whishlist();

  function whishlist(){
  //set main constants
  const siteDomain = window.location.origin + window.siteDomain;
  const targeturl = siteDomain +'whishlist/';

  const modal = $('.whishlist-modal');
  const whishlistBtn = $('#favorites-add');
  const addedItemName = $('.added-item-name');
  const errorNotices = $('.error-notice');
  const productHolder = $('.products-container');
  const closers = $('.closer');
  
  //hide modal window on x click
  $('.modal-closer').on('click', function(){
       modal.addClass('modal-hidden');
       addedItemName.html('');
  });

  //add to card
  whishlistBtn.on('click', function(){
    let productId = $(this).attr('data-id');
    let productName = $(this).attr('data-product');
    addToWhishlist(productId, productName, errorNotices, false);
  });

  //add to cart from page of multiple icons
  productHolder.on('click', function(e){
    let elemBtn =  e.target.parentElement;
    if(elemBtn.classList.contains('add-to-whishlist')){
       let productId = $(elemBtn).attr('data-id');
       let productName = $(elemBtn).attr('data-product');
       let errorEl = $(elemBtn).closest('div.product-addons').next();
       addToWhishlist(productId, productName, errorEl, elemBtn);    
    }
  });
   
  //AJAX CALL ADD PRODUCT TO WISHLIST
  function addToWhishlist(productId, productName, errorEl, element = false){
     jQuery.ajax({
         type: 'POST',
         async: true,
         url: targeturl + 'add/',
         data: {'id':productId},
         dataType: "json",
         success: function(data){
            if(data.error){
               errorNotices.html(data.error);
               errorNotices.slideDown().delay(3000).slideUp();
               showItemAddErrors(errorEl, data.error);
            }else if(data.success){
              if(element === false){
                showItemAddedModal(productName);
              }else{
                 showItemAddedOverlay(element);
              }  
            }  
         },
         error: function(error){
          errorNotices.html('Sorry, there was an error.');
          errorNotices.slideDown().delay(3000).slideUp();
          showItemAddErrors(errorEl, 'Sorry, there was an error.');
         }
        });
  }

  //HELPER FUNCTIONS
    function showItemAddErrors(errorEl, error){
      errorEl.html(error);
      errorEl.slideDown().delay(3000).slideUp();
    }

  //show products added success modal
    function showItemAddedModal(productName){
        addedItemName.html(productName); 
        modal.removeClass('modal-hidden');
    }

  //show success mini modal-overlay    
   function showItemAddedOverlay(element){
      let content = '<div class="product-overlay-inner">'+
          '<span>The product has been added to your whishlist.</span>'+
          '<span class="link-white"><i class="fi fi-angle-bottom"></i></span>'+
          '<a href="#" class="btn-golden-inverse d-block my-3 closer">Continue Shopping</a>'+
          '<a href="'+targeturl+'" class="btn-golden d-block my-3">Go To Whishlist</a>'+
          '</div>';
      let display = $(element).closest('div.single-product').find('.single-product-overlay');
      display.html(content);
      display.addClass('show-overlay');

      //close modal on click 
      let closerBtn = display.find(".closer");
      closerBtn.on('click', function(e){
         e.preventDefault();
         display.removeClass('show-overlay');
      });
    }
}
});

