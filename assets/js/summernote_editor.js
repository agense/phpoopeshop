$(document).ready(function(){
  $('#summernote').summernote({
    tabsize: 2,
    height: 500,
    callbacks: {
      onImageUpload: function(files, editor, welEditable) {
         for(let i = 0; i < files.length; i++){
          upoadPageFile(files[i], editor, welEditable);
         }
     },
     onMediaDelete : function($target, editor, $editable) {
      deletePageFile($target);   
      }
    },
    disableDragAndDrop: true,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['insert', ['hr', 'link','picture']],
      ['table', ['table']]
    ], 
  });
  function upoadPageFile(file, editor, welEditable) {
    const url = window.siteDomain + 'admin/pages/uploadPageImage';
    let form_data = new FormData();
    form_data.append('file', file);
    $.ajax({
        data: form_data,
        type: "POST",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          if(data.url){
           let url = data.url;
           $("#summernote").summernote("insertImage", url);
          }else{
            displayUploadErrors(data.errors)
          }
        },
        error: function(error){
          toastr.error("Sorry, there was an error");
        }
    });
  };

  function deletePageFile($target){
    let file = $target[0].currentSrc;
    const url = window.siteDomain + 'admin/pages/deletePageImage';
    let form_data = new FormData();
    form_data.append('file', file);
    $.ajax({
      data: form_data,
      type: "POST",
      url: url,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        if(data.errors){
          displayUploadErrors(data.errors)
        }
      }
  });
  }
  function displayUploadErrors(errors){
    let html = "<ul>";
    errors.forEach(function(error){
      if(typeof error === 'string' ){
        html += "<li>"+error+"</li>";
      }else{
        if(error[1]){
          html += "<li>"+error[1]+"</li>";
        }else{
          html += "<li>"+error[0]+"</li>";
        }
      }
    });
    html += "</ul>";
    toastr.error(html);
  }
})
