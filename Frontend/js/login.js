$('#logn-button').on('click', function () {
    login();
});

$('#login-form').keypress(function (e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
        login();
    }
});

function login() {
    let login = $('#login');
    let pass = $('#password');
    let vals = [login, pass];

    let errorCont = $('#error-container')
    errorCont.hide();

    vals.forEach(element => {
        let invalid = false;
        if (element.val() == '') {
            element.removeClass('bg-[#e8f5fa]');
            element.addClass('bg-red-400');
            errorCont.html('Empty fields');
            errorCont.show();
            element.on('change', function () {
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
        url: BASE_URL + BASE_PATH_API + 'login.php',
        headers: {
            'Content-Type': 'application/json'
        },
        xhrFields: {
            withCredentials: true
        },
        data: JSON.stringify({
            'login': login.val(),
            'password': pass.val(),
        }),
        error: function (request, status, error) {
            errorCont.html(request.responseText);
            errorCont.show();
        },
        success: function (data, text) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + BASE_PATH_API + 'login.php',
                headers: {
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    'login': login.val(),
                    'password': pass.val(),
                }),
                success: function (data, text) {
                    setCookie('jwt', data.jwt, 7);
                    window.location.href = BASE_URL + BASE_PATH_SITE + 'index.php';
                }
            });
        }
    }
    );
}