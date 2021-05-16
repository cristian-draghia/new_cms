$(document).ready(function() {

  $('#summernote').summernote({
    height: 200,
  });


  $('#check_all_boxes').click(function(event){

    if(this.checked) {
      $('.check_box').each(function(){
        this.checked = true;
      });
    } else {
      $('.check_box').each(function(){
        this.checked = false;
      });

    }


  });


});