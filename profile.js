$(document).ready(function() {
  $("#toggleFormBtn").click(function() {
    $("#myForm").show();
  });
});

$.get('profile.php', function(response) 
{  
  var result = response;
  var email=result.email;
  var firstname=result.firstname;
  var lastname=result.lastname;
  var phoneno=result.phoneno;
  var address=result.address;
  $('#firstname').val(firstname);
  $('#lastname').val(lastname);
 $('#email').val(email);
 $('#phoneno').val(phoneno);
 $('#address').val(address);
});

$(document).ready(function() {
  $('#button').click(function() {
    var firstnamepass = $('#edit-firstname').val();
    var lastnamepass = $('#edit-lastname').val();
    var phonenopass = $('#edit-phoneno').val();
    var addresspass = $('#edit-address').val();
  $.ajax({
      type: "POST",
      url: "profile.php", 
      data: {  firstname: firstnamepass, lastname: lastnamepass, phoneno: phonenopass, address: addresspass},
      success: function(response) {
        console.log(response);
        var final = response;
  var emailnew=final.email;
  var firstnamenew=final.firstname;
  var lastnamenew=final.lastname;
  var phonenonew=final.phoneno;
  var addressnew=final.address;
  $('#edit-firstname').val('');
  $('#edit-lastname').val('');
  $('#edit-phoneno').val('');
  $('#edit-address').val('');
        $('#firstname').val(firstnamenew);
        $('#lastname').val(lastnamenew);
       $('#email').val(emailnew);
       $('#phoneno').val(phonenonew);
       $('#address').val(addressnew);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("AJAX error: " + textStatus, errorThrown);
      }
    });
  });
});
