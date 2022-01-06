jQuery(document).ready( function($){
  // Some event will trigger the ajax call, you can push whatever data to the server, 
  // simply passing it to the "data" object in ajax call
    $.ajax({
        alert("sdfd");
        url: ajax_object.ajaxurl, // this is the object instantiated in wp_localize_script function
        type: 'POST',
        data:{ 
            action: 'myaction', // this is the function in your functions.php that will be triggered
            name: 'John',
            age: '38'
        },
        success: function( data ){
            //Do something with the result from server
            console.log( data );
        }   
    });
});