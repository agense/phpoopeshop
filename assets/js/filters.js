
class Filters{
   constructor(filterType){
    this.filterType = filterType;
    this.filterOptions = [];
   }
   
   addFilterOption(option){
      if(!option instanceof Array && !this.filterOptions.includes(option)){
            this.filterOptions.push(option);
      }else{
         option = option.split(',');
         option.forEach((optvalue) => {
            if(!this.filterOptions.includes(optvalue)){
              this.filterOptions.push(optvalue);  
            }   
         });
      }
   }

   removeFilterOption(option){
      if(!option instanceof Array){
      this.filterOptions = this.filterOptions.filter(function(item){
          return item != option; 
      });
      }else{
        option = option.split(',');
        option.forEach((optvalue) => {
             if(this.filterOptions.includes(optvalue) == true){
                let i = this.filterOptions.indexOf(optvalue);
                if(i > -1){
                this.filterOptions.splice(i, 1);
                }
             }
        });
      }
   }
   resetFilters(){
    this.filterOptions = [];
   }
}

(function(){
    //set main constants
    const siteDomain = window.location.origin + window.siteDomain;
    const pageurl = siteDomain +'products/';
    var filteredData;
    
    //call functions on page load
    //show filters
    displayFilters();
    //filter data
    filteredData = filterItems();
    //sort items
    sortProducts(filteredData);

    //EVENT LISTENERS
    function displayFilters(){
        var filterIcons = document.querySelectorAll('.filter-icon');
        var filterClose =document.querySelectorAll('.icon-minus');
        var filtersBtn = document.getElementById('filter-btn');
        var filterHolder = document.querySelector('.filters');

        //set simgle filters to closed position on small screens, open position otherwise on document load
        document.addEventListener('DOMContentLoaded', function(){
            let filters = document.querySelectorAll('.filter-content');
            if(window.innerWidth < 768){
                filters.forEach(function(item){
                   item.classList.add('filter-hide');
                   filterClose.forEach(function(filterIcon){
                       filterIcon.style.display="none";
                       filterIcon.nextElementSibling.style.display = "inline-block";
                   });
                });
            }
        });
        filtersBtn.addEventListener('click', function(){
              filterHolder.classList.toggle('show-filters');
        });

        //toggle single filters
        filterIcons.forEach(function(icon){
           icon.addEventListener('click', function(e){
               let filter = e.target.parentElement.parentElement.querySelector('.filter-content');
               controlFilter(filter, e.target);
           });
        });
    }      

// FILTER DISPLAY HELPER FUNCTIONS
//show.hide single filter
function controlFilter(filter, icon){
   if(!filter.classList.contains('filter-hide')){
       filter.classList.add('filter-hide');
       icon.style.display = "none";
       icon.nextElementSibling.style.display = "inline-block";
   }else{
       filter.classList.remove('filter-hide');
       icon.style.display = "none";
       icon.previousElementSibling.style.display = "inline-block";
   }
}

//FILTER ITEMS MAIN FUNCTION
function filterItems(){
  //select dom elements
  var filterTypes = document.querySelectorAll('.filter');
  var filtersOptions = document.querySelectorAll('.filter-option');
  var filterData;

  //create an array of Filter class objects passing filter type as argument
  var filters = [];
  filterTypes.forEach(function(filterType){
      let filter = new Filters(filterType.dataset.filter);
      filters.push(filter);
  });

  filtersOptions.forEach(function(filterItem){
      // set initial filters
      if(filterItem.checked){
        setFilters(filterItem, filters);
      }
      //listen for change on each option
      filterItem.addEventListener('change', function(){ 
          //manage category filters
          if(filterItem.name == 'product_category_id'){
               setCategoryFilters(filterItem, filters);
           }
          //set filter data
           filterData = setFilters(filterItem, filters);
                
        //make ajax call to get filtered products
        getFilteredProducts(filterData);
      });
  })
  return filters;
    
}  

//FILTERING ITEMS HELPER FUNCTIONS
//arguments: option clicked, array of filter types
function setFilters(filterItem, filterArr){
    filterArr.forEach(function(filterObj){
      if(filterObj.filterType == filterItem.name){
        if(filterItem.checked){
          filterObj.addFilterOption(filterItem.value);
        }else{
          filterObj.removeFilterOption(filterItem.value);
        }
      }
  });
    //if category filter is empty, select all subcategories
    if(filterArr[1].filterType == "product_category_id" && filterArr[1].filterOptions.length == 0){
      document.querySelectorAll('.filter-subcategory').forEach(function(item){
         filterObj.addFilterOption(item.value);
      });
      let topcategory = document.querySelector('.filter-topcategory');
      topcategory.checked = true;
      topcategory.setAttribute("disabled", "disabled");
    }
   return JSON.stringify(filterArr);
}

function setCategoryFilters(filterItem, filterArr){
  const topcategory = document.querySelector('.filter-topcategory');
  const subcategories = document.querySelectorAll('.filter-subcategory');
  
    //get specific filter object from filter objects array
    filterObj = filterArr[1];
    
    //check if the item clicked is not top category item, and if top category is checked, remove checked attribute from it
    //then reset filterOptions property of the object to empty array
    if(!filterItem.classList.contains('filter-topcategory') && topcategory.checked){
        topcategory.checked = false;
        topcategory.removeAttribute("disabled");
        filterObj.resetFilters();
    
    //check if the item clicked is top category item,if it is, remove checked attributed from all subcategory items 
    //then reset filterOptions property of the object to empty array
    }else if(filterItem.classList.contains('filter-topcategory')){ 
        topcategory.setAttribute("disabled", "disabled");   
        subcategories.forEach(function(subcategory){
          if(subcategory.checked){
              subcategory.checked = false;
              filterObj.resetFilters();
          }
        });
    }    
    //check if at least one checkbox is cheched, if not, check top category item in order to have category value
    let checked = [];
    subcategories.forEach(function(subcategory){
        if(subcategory.checked){
           checked.push(subcategory.value);     
        }
    });
}

//sorting options
function sortProducts(filterData){
  let sort = document.querySelector('#sort');

  sort.addEventListener('change', function(){
    var sortValue = sort[sort.selectedIndex].value;

    if(sortValue != ""){
       let sortDirection = sort[sort.selectedIndex].dataset.direction;
       let sortObj = {"sortType": sortValue, "sortDirection": sortDirection};

       let lastItem = filterData[filterData.length -1];
       if(!lastItem.hasOwnProperty("sortType")){
         filterData.push(sortObj);
       }else{
         filterData.splice((filterData.length -1), 1 ,sortObj);
       }
       let fullData = JSON.stringify(filterData);
      
       //ajax call to sort data
       getFilteredProducts(fullData);
    }
  }, false);
}

//ajax call to get filtered products
function getFilteredProducts(filterData){
   const url = pageurl + 'getFilteredProducts';

   const xhr = new XMLHttpRequest();
   xhr.open('POST', url, true);
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
   xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
   xhr.responseType = 'json';
   xhr.onload = function(){
      if(this.status === 200){
        //display filtered  data
        displayFilteredProducts(this.response);
      }
   }
   xhr.send("data="+filterData);       
}

//Display filtered products
function displayFilteredProducts(products){
 const holder = document.querySelector('.category-content');
 const countHolder = document.querySelector('#results-number');

 let productCount = products.length;
 countHolder.innerHTML = productCount;
 
 let newhtml = "";

 if(productCount > 0){
  products.forEach(function(product){
    newhtml += '<div class="col-sm-6 col-md-6 col-lg-4 grid-single-product">'+
                '<div class="single-product  hoverable">'+
                    '<div class="product-addons">';
    if(product.new == "true"){
      newhtml += '<div class="new-item">New In</div>';
    }
    newhtml += '<div class="product-icons">'+
                          '<div class="heart-icon-group">'+
                              '<span class="product-icon icon-heart-initial add-to-whishlist" data-id="'+product.id+'"><i class="fi fi-heart-line"></i></span>'+
                              '<span class="product-icon icon-heart-changed"><i class="fi fi-heart-black"></i></span>'+
                          '</div>'+
                          '<div class="cart-icon-group">'+
                              '<span class="product-icon icon-cart-initial add-to-cart" data-id="'+product.id+'">'+
                                  '<i class="fi fi-shopping-bag"></i>'+
                              '</span>'+
                              '<span class="product-icon icon-cart-changed"><i class="fi fi-shopping-bag-option"></i></span>'+
                          '</div>'+
                        '</div>'+
                '</div><div class="errorMsg"></div>';
    if(product.product_price_discounted != null){
    newhtml += '<span class="sale sale-btn sale-positioned"><span class="btn-icon"><i class="fi fi-forward-all-arrow"></i></span>On Sale</span>';
    }
    newhtml +=  '<div class="product-image"><img src="'+product.product_featured_image +'" alt=""></div>'+
                '<div class="product-info">'+
                '<div class="product-info-box">'+
                        '<div class="product-brand"><span class="cat-brand">'+product.product_brand+'</span></div>'+  
                        '<div class="product-title">'+ product.product_name +'</div><div class="product-price">';
      if(product.product_price_discounted != null){
        newhtml += '<span class="product-price-amount golden">'+product.product_price_discounted+'</span>';
      }else{
        newhtml += '<span class="product-price-amount">'+product.product_price+'</span>';
      }
      newhtml += '</div>'+
                '</div>'+ 
                '<div class="more-link-holder"><a href="'+pageurl+'product/'+product.id+'" class="more-link">Details</a></div>'+
                '</div>'+ 
                '<div class="single-product-overlay">'+
                    '<div class="product-overlay-inner">'+
                        '<span>The product has been added to the cart.</span>'+
                        '<span class="link-white"><i class="fi fi-angle-bottom"></i></span>'+
                            '<a href="" class="btn-golden-inverse d-block my-3">Continue Shopping</a>'+
                            '<a href="'+siteDomain+'/cart'+'" class="btn-golden d-block my-3">Go To Cart</a>'+
                    '</div>'+
                '</div>'+
          '</div>'+ 
      '</div>';
 });
 }else{
  newhtml += '<div class="no-items">No Products Found</div>';
 }
 holder.innerHTML = newhtml; 
}
})();
