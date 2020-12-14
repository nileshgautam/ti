$(function() {
    // setting userdata into the login form
    if (hasData("remember_me")) {
        let data = JSON.parse(localStorage.getItem("remember_me"));
        $('#user-name').val(data.username);
        $('#password').val(data.password);
        $('#remember_me').prop('checked', true);
    }

    //login function
    $('.login-form').submit(function(e) {
        e.preventDefault();
        let form_data = $(this).serialize();
        let username = $('#user-name').val();
        let password = $('#password').val();
        let message;
        // alert('You clicked on submit');
        if (form_data) {
            $.ajax({
                type: 'POST',
                url: BASEURL + 'Login/user_login',
                data: form_data,
                success: function(responce) {
                    // console.log(data);
                    let data = JSON.parse(responce);
                    // console.log(data);

                    if (data.msg == 'true') {
                        if (data.remember_me == 1) {
                            let arr = { "username": username, "password": password };
                            saveData("remember_me", arr);
                        } else if (data.remember_me == 0) {
                            removeData('remember_me');
                        }
                        if (data.role === 'User') {
                            window.location.href = BASEURL + 'Employee/dailytimesheet';
                        } else if (data.role === 'Manager') {
                            window.location.href = BASEURL + 'Manager/project';
                        } else if (data.role === 'Admin') {
                            window.location.href = BASEURL + 'Admin/project';
                        }

                        // console.log(data.role)

                    } else {
                        $('#notification').empty();
                        message = `<p class='text-${data.type}'>${data.msg}</p>`;
                        $('#notification').append(message);
                    }
                }
            });
        }
    });
});

// Local storage function
function retriveData(FILE_KEY) {
    return localStorage.getItem(FILE_KEY);
}

function saveData(FILE_KEY, data) {
    localStorage.setItem(FILE_KEY, JSON.stringify(data));
}

function hasData(FILE_KEY) {
    return localStorage.hasOwnProperty(FILE_KEY) ? true : false;
    // localStorage 
}

function removeData(FILE_KEY) {
    localStorage.removeItem(FILE_KEY);
    // localStorage 
}