$("#form_check_password").validate({
  rules: {
                    password_first: { 
                    required: true,
                    minlength: 3,
                    maxlength: 40,

               } , 
                    password_second: { 
                    equalTo: "#inputPassword_first",
                    minlength: 3,
                    maxlength: 40,
               }
           },
    messages: {
      password: {
        required: "the password is required"
      }
    }
});