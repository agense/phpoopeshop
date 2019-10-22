$(document).ready(function(){
  // CONTROL SHOPPING CART 
  cart();
  function cart(){
  //set main constants
  const siteDomain = window.location.origin + window.siteDomain;
  const targeturl = siteDomain +'cart/';

  const modal = $('.cart-modal');
  const productHolder = $('.products-container');
  const cartBtn = $('#card-add');
  const cartIcons = $('.icon-cart-initial');
  const whishlistBtn = $('#favorites-add');
  const qtySelector = $('#p-quantity');
  const qtySelectorCart = $('.quantity');
  const errorNotices = $('.error-notice');
  const cartCounter = $('#items-in-cart');
  //modal data
  const addedItemName = $('.added-item-name');
  const addedItemQty = $('.added-item-qty');

  const removeLinks = $('.remove-item'); 
  const subtotal = $('#subtotal'); 
  const tax = $('#tax'); 
  const total = $('#total'); 
  const itemsInCart = $('#items-in-cart');
  const cartHolder = $('.cart-holder');

  const moveBtn = $('.move-to-whishlist');

  //hide modal window on x click
  $('.modal-closer').on('click', function(){
       modal.addClass('modal-hidden');
       addedItemName.html('');
       addedItemQty.html('');
  });

  //add to card
  cartBtn.on('click', function(){
    let productId = $(this).attr('data-id');
    let productQty = qtySelector.val();
    addToCart(productId, productQty, errorNotices, false);
  });

  //add to cart from page of multiple icons
  productHolder.on('click', function(e){
    let elemBtn =  e.target.parentElement;
    if(elemBtn.classList.contains('add-to-cart')){
       let productId = $(elemBtn).attr('data-id');
       let productQty = 1;
       let errorEl = $(elemBtn).closest('div.product-addons').next();
       addToCart(productId, productQty, errorEl, elemBtn);
    }
  });

  // move to whishlist
    moveBtn.on('click', function(e){
    e.preventDefault();  
    let productId = $(this).attr('data-id');
    let itemRow = $(this).closest('div.cart-table-row');
    moveToWhishlist(productId, errorNotices, itemRow);
  });

  //REMOVE ITEM FROM CART   
  $.each(removeLinks, function(index, value){
      $(this).on('click', function(e){
        e.preventDefault();
        let itemId = $(this).attr('data-id');
        let itemRow = $(this).closest('div.cart-table-row');
        removeFromCart(itemId, itemRow);
      });
  })

//UPDATE ITEM QUANTITY
 $.each(qtySelectorCart, function(index, value){
    $(this).on('change', function(e){
        e.preventDefault();
        let itemId = $(this).attr('data-id');
        let qty = $(this).children("option:selected").val();
        let productSubtotalElement = $(this).parent().siblings('div.cart-item-subtotal').find("span:eq(1)");
        updateQuantity(itemId, qty, productSubtotalElement);
    }); 
 });

//AJAX FUNCTIONS
  //ADD PRODUCT TO CART
  function addToCart(productId, productQty, errorEl, element = false){
     jQuery.ajax({
         type: 'POST',
         async: true,
         url: targeturl + 'add/',
         data: {'id':productId, 'qty': productQty},
         dataType: "json",
         success: function(data){
            if(data.error){
               showItemAddErrors(errorEl, data.error);
            }else if(data.success){
              if(element === false){
                showItemAddedModal(data.success.product_name, productQty);
              }else{
                 showItemAddedOverlay(element);
              }  
              updateCartCounter(data.success.cartCount, true);
            }   
         },
         error: function(error){
            toastr.error('There was an error.');
         }
        });
  }

  //move item to whishlist
  function moveToWhishlist(itemId, errorEl, element = false){
    //ajax call
        jQuery.ajax({
         type: 'POST',
         async: true,
         url: targeturl + 'moveToWhishlist/',
         data: {'id':itemId},
         dataType: "json",
         success: function(data){
            if(data.error){
               showItemAddErrors(errorNotices, data.error);
            }else if(data.success.total){
               element.remove();
               updateTotals(data.success);
               updateCartCounter(1);
            }else if(data.success.empty){
               showEmptyCart();
            }
         },
         error: function(error){
            toastr.error('There was an error.');
          }
        });
  }

  //remove item from cart
  function removeFromCart(itemId, element){
         //ajax call
         jQuery.ajax({
         type: 'POST',
         async: true,
         url: targeturl + 'remove/',
         data: {'id':itemId},
         dataType: "json",
         success: function(data){
            if(data.error){
               showItemAddErrors(errorNotices, data.error);
            }else if(data.success.total){
               element.remove();
               updateTotals(data.success);
               updateCartCounter(1);
            }else if(data.success.empty){
               showEmptyCart()
            }
         },
         error: function(error){
            toastr.error('There was an error.');
          }
        }); 
  }

  //UPDATE CART QUNATITY
  function updateQuantity(itemId, qty, productSubtotalElement){
      jQuery.ajax({
         type: 'POST',
         async: true,
         url: targeturl + 'updateQuantity/',
         data: {'id':itemId, 'quantity':qty},
         dataType: "json",
         success: function(data){
            if(data.error){
               errorNotices.html(data.error);
               errorNotices.slideDown().delay(3000).slideUp();
            }
            else if(data.success.totals){
               productSubtotalElement.html(data.success.singleProductSubtotal);
               updateTotals(data.success.totals);
            }
         },
         error: function(error){
            toastr.error('There was an error.');
         }
      });
  }

  //HELPER FUNCTIONS
  //update cart counter in the menu
  /*If second argument is true, then the first argument represents the final quantity to display,
   otherwise it represents how many items to remove from cart quantity*/
  function updateCartCounter(qty, final = false){
      if(final){
        cartCounter.html(qty);
      }else{
        cartQty = itemsInCart.text();
        let newQty = (cartQty - qty);
        cartCounter.html(newQty);
      }
  }

//display if cart is empty
  function showEmptyCart(){
      const emptyCartNotice = '<div style="min-height: 30vh">'+
      '<div class="no-items">You cart is empty</div>'+
      '<div class="text-center">'+
      '<a href="'+siteDomain+'/categories" class="btn btn-golden"><i class="fi fi-diamond"></i>&nbsp;&nbsp;Continue Shopping</a></div>'+
      '</div>';
      cartHolder.empty();
      cartHolder.prepend(emptyCartNotice);
      cartCounter.html("0");
  }

  //show products added success modal
    function showItemAddedModal(productName, productQty){
        let item = (productQty == 1) ? "Item" : "Items";
        addedItemName.html(productName); 
        addedItemQty.html(`${productQty} ${item}`); 
        modal.removeClass('modal-hidden');
    }

    //show mini modal over product in pages with multiple product display
    function showItemAddedOverlay(element){
      let content = '<div class="product-overlay-inner">'+
      '<span>The product has been added to the cart.</span>'+
      '<span class="link-white"><i class="fi fi-angle-bottom"></i></span>'+
      '<a href="#" class="btn-golden-inverse d-block my-3 cart-overlay-closer">Continue Shopping</a>'+
      '<a href="'+targeturl+'" class="btn-golden d-block my-3">Go To Cart</a>'+
      '</div>';
      let display = $(element).closest('div.single-product').find('.single-product-overlay');
      display.html(content);
      display.addClass('show-overlay');

      //close modal on click 
      let closerBtn = display.find(".cart-overlay-closer");
      closerBtn.on('click', function(e){
         e.preventDefault();
         display.removeClass('show-overlay');
      });
    }

   //display errors
    function showItemAddErrors(errorEl, error){
      errorEl.html(error);
      errorEl.slideDown().delay(3000).slideUp();
    }

  //display new totals
  function updateTotals(data){
      subtotal.html(data.beforeTax);
      tax.html(data.tax);
      total.html(data.total);
  }
};
});

