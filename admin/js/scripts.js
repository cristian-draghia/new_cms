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



  var div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $( "body" ).prepend(div_box);
  $( '#load-screen' ).delay(400).queue(function() {
    $(this).remove();
  });


});

function load_users_online() {
  $.get("functions.php?online_users=reuslt", function( data ) {
    $(".users-online").text( data );
  });
}

setInterval( function() {
  load_users_online();
}, 3000);

load_users_online();