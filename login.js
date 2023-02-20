$(document).ready(function() {
  $('#button').click(function() {

    var email = $('#email').val();
    var password = $('#password').val();

  $.ajax({
      type: "POST",
      url: "login.php", 
      data: {  email: email, password: password },
      dataType: "json",
      success: function(response) {
            console.log(response);
            var data = response;
                var status = data.status;
                var id = data.id;
                var email = data.email;
                var password = data.password;
                console.log("Status: " + status);
                    console.log("ID: " + id);
                    console.log("Email: " + email);
                    console.log("Password: " + password);
                    window.location.href="profile.html";
        

      },
      error: function(jqXHR, textStatus, errorThrown) {
        
        console.error("AJAX error: " + textStatus, errorThrown);
      }
    });



  });
});