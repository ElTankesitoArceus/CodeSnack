const BASE_PATH_SITE = "/TFG/Frontend/";
const BASE_PATH_API = "/TFG/Backend/api/";
const BASE_URL = window.location.protocol + "//" + window.location.host;

$('#register-button').on('click', function() {
    let username = $('#username');
    let email = $('#email');
    let pass = $('#password');
    let confpass = $('#confirm-password');
    let vals = [username, email, pass, confpass];

    let errorCont = $('#error-container')
    errorCont.hide();
    console.log(username, pass)
    if (pass.val() !== confpass.val()) {
        errorCont.html('Passwords do not match');
        errorCont.show();
    } else  {
        vals.forEach(element => {
            let invalid = false;
            if (element.val() == '') {
                element.removeClass('bg-[#e8f5fa]');
                element.addClass('bg-red-400');
                errorCont.html('Empty fields');
                errorCont.show();
                element.on('change', function() {
                    element.removeClass('bg-red-400');
                    element.addClass('bg-[#e8f5fa]');
                    errorCont.hide();
                });
                invalid = true;
            }
            if (invalid) return;
        });
        $.ajax({
            type: 'POST',
            url: BASE_URL + BASE_PATH_API + 'create_user.php', 
            headers: { 
                'Content-Type': 'application/json' 
            }, 
            data: JSON.stringify({
                'username': username.val(),
                'email': email.val(),
                'password': pass.val(),
            }),
            error: function(request, status, error) {
                errorCont.html(request.responseText);
                errorCont.show();
            },
            success: function(data, text) {
                $.ajax({
                    type: 'POST',
                    url: BASE_URL + BASE_PATH_API + 'login.php', 
                    headers: { 
                        'Content-Type': 'application/json' 
                    },
                    data: JSON.stringify({
                        'login': username.val(),
                        'password': pass.val(),
                    }),
                    success: function(data, text) {
                        console.log(data.jwt);
                        document.cookie = "token=" + data.jwt;
                        window.location.href = BASE_URL + BASE_PATH_SITE + 'index.php';
                    }
                });
            }
            }
        );
    }
});