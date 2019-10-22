
// dom event listener
document.addEventListener('DOMContentLoaded', function(){
    contentHandler();
});

//event listeners
function contentHandler(){

//Open mobile side menu
const closer = jQuery('#side-nav-closer');
const sidebar = jQuery('.admin-sidebar');
closer.on('click', function(){
  if(sidebar.css('width') == '33px'){
    sidebar.css('width', '250px');
    closer.html('&#8592;');
  }else{
    sidebar.css('width', '33px');
    closer.html('&#8594;');
  }
});


//SHOW IMAGES MODAL
jQuery('#img_updater').on('click', function(e){
   e.preventDefault();
   let productId = jQuery(this).attr('data-product_id');
   imgModal(productId);
});

// FILL IN THE SUBCATEGORIES FOR CATEGORIES IN SELECT LISTS
const quantities = jQuery('#quantity-updater');
if(quantities){
 quantities.on('submit', function(e){
  e.preventDefault();
  updateQuantity(e.target);
 });
}

const selection  = document.getElementById('parent_category_id');
if(selection){
  selection.addEventListener('change', function(){
    if(selection.parentElement.classList.contains('edit')){
      getSubcategories("../ajaxInput/");
    }else{
      getSubcategories("ajaxInput/");
    }    
});
}

// DISPLAY DISCOUNT PRICE
const priceform = jQuery('#price-change-form');
priceform.on('input', function(){
  displayDiscountPrice(priceform);
});

//RESTORE DELETED
const restorelink = jQuery('.restore-deleted');
if(restorelink){
  jQuery.each(restorelink, function(index, element){
    element.addEventListener('click', function(e){
      e.preventDefault();
      let id = jQuery(e.target).attr('data-target');
       
    jQuery.ajax({
    type: 'POST',
    async: true,
    url: "restoreDeleted/",
    data: {'id':id},
    dataType: "json",
    success: function(data){
      if(data == "success"){
        jQuery(e.target).parent().parent().css('display', 'none');
        jQuery('#result-alert').html("Restore successful").removeClass('alert-success', 'alert-danger').addClass('alert-success').slideDown().delay(2000).slideUp();
      }else{
        jQuery('#result-alert').html("Restore failed.Please try again.").removeClass('alert-success', 'alert-danger').addClass('alert-danger').slideDown().delay(2000).slideUp();
      }
    },
    error: function(error){
      jQuery('#result-alert').html("Restore failed.Please try again.").removeClass('alert-success', 'alert-danger').addClass('alert-danger').slideDown().delay(2000).slideUp();
    }
   }); 
    });
  });
}

//SET/UNSET FEATURED ITEM
const featuredInput = jQuery('.featured-checkbox');
if(featuredInput){
  jQuery.each(featuredInput, function(index, element){
    element.addEventListener(
    'click', function(e){
       controlFeatured(e.target);
    });
  });
}

//SET/UNSET PAGE AS MENU ITEM
const checkboxInputs = jQuery('.in-menu-checkbox');
if(checkboxInputs){
  jQuery.each(checkboxInputs, function(index, element){
    element.addEventListener(
    'click', function(e){
       controlMenuItems(e.target);
    });
  });
}
}

// FUNCTIONS FOR EVENT LISTENERS
// FILL SELECT LISTS WITH SUBCATEGORIES FOR CATEGORIES
function getSubcategories(url){
   var val = jQuery("#parent_category_id option:selected").val();
   var dataArr;
   var selector = jQuery('#product_category_id'); 

   jQuery.ajax({
    type: 'POST',
    async: true,
    url: url,
    data: {'id':val},
    dataType: "json",
    success: function(data){ 
        dataArr = JSON.parse(data); 
        selector.empty();
        selector.append('<option value="0">...</option>');
        for(var key in dataArr){
          selector.append('<option value="'+dataArr[key]+'">'+key+'</option>');   
        }
    }
   });
}

//MODALS
//Categories modal
function detailsModal(args){
   // Get site domain
   const domain = window.siteDomain;
   var imgPath = domain + "images/category_images/";
   var editPath = domain + "admin/categories/edit/";
   var imgSrc;  
   jQuery('#modal-header').text(args['category_name']);
   if(args['parent_category_id'] !== "0"){
   jQuery('#modal-parent_category').text(args['parent_category']);
   }else{
   jQuery('#modal-parent_category').text("Top Category");
   }
   if(args['featured'] !== "0"){
   jQuery('#modal-featured').text("Yes");
   }else{
   jQuery('#modal-featured').text("No");
   }
   jQuery('#modal-description').text(args['category_description']);
   if(args['category_image'] != ""){
     imgSrc = imgPath + args['category_image'];
   }else{
     imgSrc = imgPath + '""';
   }
   jQuery('#modal_featured_img').attr('src', imgSrc);
   jQuery('#modal_edit_btn').attr('href', editPath + args['id']);
   jQuery('#categoryDetailsModal').modal('toggle');
  }

//products modal
function productModal(args){  
   var imgPath = window.siteDomain + "images/product_images/";
   var editPath = window.siteDomain + "admin/products/edit/";
   var imgSrc; 
   var name = (args['product_name'] != "") ? args['product_name'] : "";
   var code = (args['product_code'] != "") ? args['product_code'] : "";
   var price = (args['product_price'] != "") ? args['product_price'] : "";
   var disc_price = (args['product_price_discounted'] != "") ? args['product_price_discounted'] : "";
   var brand = (args['product_brand'] != "") ? args['product_brand'] : "";
   var material = (args['product_material'] != "") ? args['product_material'] : "";
   var color = (args['product_color'] != "") ? args['product_color'] : "";
   var category = (args['product_category'] != "") ? args['product_category'] : "";
   var parentCat = (args['parent_category'] != "") ? args['parent_category'] : "";
   var featured = (args['featured'] != "0") ? "Yes" : "No";
   var description = (args['product_description'] != "") ? args['product_description'] : "";
   var imgSrc = (args['product_featured_image'] != "") ? imgPath + args['product_featured_image'] : imgPath +"no-image.jpg";

   jQuery('#product-name').text(name);
   jQuery('#product-code').text(code);
   jQuery('#product-price').text(price);
   jQuery('#product_price_disc').text(disc_price);
   jQuery('#product-category').text(category);
   jQuery('#product-top-category').text(parentCat);
   jQuery('#product-brand').text(brand);
   jQuery('#product-material').text(material);
   jQuery('#product-color').text(color);
   jQuery('#product-featured').text(featured);
   // description
    jQuery('#product-description').text(description);
   // featured image
   jQuery('#product_featured_img').attr('src', imgSrc);
   jQuery('#modal_edit_btn').attr('href', editPath + args['id']);
   jQuery('#productDetailsModal').modal('toggle');
}

//IMAGE UPDATE MODAL AND FUNCTIONALITY
function imgModal(args){
let id = args;
const selector = jQuery('#product-update-grid');

 jQuery.ajax({
    type: 'POST',
    async: true,
    url: "../imageUpdate/",
    data: {'id':id},
    dataType: "json",
    success: function(data){
        selector.empty();
        if(data.length > 0){
        displayImages(data, selector);
        }else{
            selector.append('<p class="no-img">There are no images for this product.</p>');
        }
        //set delete event listeners
        const deleteimgs = jQuery('.delete-image');
        deleteSingleImg();
    }
   });
 
   jQuery('#imgDetailsModal').modal('toggle');
   jQuery('#imgDetailsModal').on('shown.bs.modal', function (e) {   
        //set upload event listeners
        const uploadForm = jQuery('#image-upload-form');
        uploadNewImages(uploadForm, selector);
   });
}

//format image output for single image
function displayImages(dataArr, selector){
  var imgPath = window.siteDomain + "images/product_images/";
      jQuery.each(dataArr, function(index, value){
           selector.append(
            '<div class="single-img">'
            +'<img src="'+imgPath+dataArr[index].product_image+'" alt="">'+  
            '<span class="delete-image" id="'+ dataArr[index].id+'">&times;</span>' +
            '</div>'
            );
        });
  return selector;
}

//delete image functionality
function deleteSingleImg(){
   const imgHolder = jQuery('#product-update-grid');
   imgHolder[0].addEventListener('click', function(e){
     if(e.target.classList.contains('delete-image')){
      let id = e.target.attributes.id.nodeValue;
      let elem = e.target.parentElement;
      deleteSingleImageAjax(id, elem);
     }
  });
}

// delete single image helper function
function deleteSingleImageAjax(imgId, element){
   const imgHolder = jQuery('#product-update-grid');
   jQuery.ajax({
    type: 'POST',
    async: true,
    url: "../imageDelete/",
    data: {'id':imgId},
    dataType: "json",
    success: function(data){
       if(data[0] === "success"){
          element.remove(); 
          if(imgHolder.children().length == 0){
            imgHolder.append('<p class="no-img">There are no images for this product.</p>');
          }
       }else{
          jQuery('#update-errors').html(data[1]).slideDown().delay(2000).slideUp();
       }
    },
    error: function(error){
      jQuery('#update-errors').html('Sorry, there was an error.').slideDown().delay(2000).slideUp();
    }
   });
}

// HANDLE PRODUCT IMAGE UPLOAD FORM
function uploadNewImages(uploadForm, selector){
  let productId = uploadForm.data('product');  
  let input = uploadForm.find('input#product_images');
   input.on('change', function(e){
     let fileArray = e.target.files;
       //create form data 
       let form_data = new FormData();  
       form_data.append('id', productId);
       jQuery.each(fileArray, function(index, value){
       form_data.append(index, value);
       });   
       input.val('');
       fileArray = [];
       uploadNewImagesAjax(form_data, selector);
   });
}
function uploadNewImagesAjax(form_data, selector){
       const imgHolder = jQuery('#product-update-grid');
       $.ajax({
        url: '../imagesUpload/',  
        dataType: 'JSON',  
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data){
           if(data['success']){
            //remove the no-images paragraph
            if(imgHolder.children().length > 0 && imgHolder.children()[0].classList.contains('no-img')){
              $(imgHolder.children()[0]).remove();
            }
            displayImages(data['success'], selector);
           }
           if(data['errors']){
             jQuery('#update-errors-content').html(data['errors']).parent().fadeIn();
           } 
             jQuery('#close-alert').on('click', function(){
                 jQuery(this).parent().fadeOut();
             });
        },
        error: function(error){
          jQuery('#update-errors-content').html('Sorry, there was an error.').parent().fadeIn();
        }
     });
}

//UPDATE PRODUCT QUANTITY
function updateQuantity(fm){
    let formData = new FormData(fm);

    jQuery.ajax({
    type: 'POST',
    async: true,
    url: "quantities",
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    dataType: "json",
    success: function(data){
      if(data !== 'Update Error'){
        let displayRow = jQuery(fm).parent().parent();
        displayRow.find('.quantity-display').html(data);
        displayRow.find('.quantity-message').html('Quantity Updated');
      }else{
        displayRow.find('.quantity-message').html(data);
      } 
    },
    error: function(error){
      toastr.error('There was an error.');
    }
   });

}

//DISPLAY DISCOUNT PRICE
function displayDiscountPrice(pricefm){
  let initPrice = pricefm.find('#product_price').val();
  let discType = pricefm.find('#product_discount_type').val();
  let discAmount = pricefm.find('#discount_amount').val();
  let discPrice = pricefm.find('#discounted_price');

  let form_data = new FormData();
  form_data.append('product_price', initPrice);
  form_data.append('product_discount_type', discType);
  form_data.append('discount_amount', discAmount);

  jQuery.ajax({
    type: 'POST',
    async: true,
    url: "../displayDiscountedPrice/",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    dataType: "json",
    success: function(data){
        discPrice.val(data);  
    },
    error: function(error){
      toastr.error('There was an error.');
    }
   });
}

//SET/UNSET FEATURED ITEM
function controlFeatured(input){
let id = jQuery(input).attr('data-id');
  
jQuery.ajax({
    type: 'POST',
    async: true,
    url: "updateFeatured/",
    data: {'id': id},
    dataType: "json",
    success: function(data){
      if(data !== 'success'){
          let errors = jQuery('.error-display');
          errors.html('<div class="alert alert-danger">An Error Occurred.Please try again.</div>');
          errors.slideDown().delay(2000).slideUp();
      } 
    },
    error: function(error){
          let errors = jQuery('.error-display');
          errors.html('<div class="alert alert-danger">An Error Occurred.Please try again.</div>');
          errors.slideDown().delay(2000).slideUp();
    }
   });
}

//SET/UNSET PAGE AS MENU ITEM
function controlMenuItems(input){
let id = jQuery(input).attr('data-id');
jQuery.ajax({
    type: 'POST',
    async: true,
    url: "setInMenuItem/",
    data: {'id': id},
    dataType: "json",
    success: function(data){
      if(data !== 'success'){
          let errors = jQuery('.error-display');
          errors.html('<div class="alert alert-danger">An Error Occurred.Please try again.</div>');
          errors.slideDown().delay(2000).slideUp();
      } 
    },
    error: function(error){
          let errors = jQuery('.error-display');
          errors.html('<div class="alert alert-danger">An Error Occurred.Please try again.</div>');
          errors.slideDown().delay(2000).slideUp();
    }
   });
}