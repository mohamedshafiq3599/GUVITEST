$(document).ready(function() {
  $('#button').click(function() {
    
    var email= $('#email').val();
    var password = $('#password').val();
    var firstname= $('#firstname').val();
    var lastname = $('#lastname').val();
    var phoneno= $('#phoneno').val();
    var address = $('#address').val();   
    $.ajax({
      type: "POST",
      url: "register.php",
      data: { email: email, password: password,firstname: firstname, lastname: lastname,phoneno: phoneno, address: address },
      success: function(response) {
       

        console.log(response); 
        window.location.href = "login.html";

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("AJAX error: " + textStatus, errorThrown);
      }
    });
  });
});
