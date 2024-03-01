const validation = new JustValidate("#signup");

validation
    .addField("#name", [
        {
            rule: "required"
        }
    ])
    .addField("#email", [
        {
            rule:"required"
        },
        {
            rule:"email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                        .then(function(response){
                            return response.json();
                        })
                        .then(function(json){
                            return json.available
                        });
            },
            errorMessage: "email already taken"
        }
    ])
    .addField("#password_confirmation", [
        {
            validator: (value, fields) => {
                return value === fields["#passwords"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .OnSuccess((event) => {
        document.getElementById("signup").submit();
    })