window.modalAuth = function () {

    this.modalWindow = $('#modal-auth-container');
    this.loginBtn = $('#login-btn')

    this.authContainer = $('#modal-authorization');
    this.loginAuthField = $('#login-auth');
    this.passAuthField = $('#pass-auth');
    this.authBtn = $('#auth-btn');
    this.toRegBtn = $('#go-to-register-btn');

    this.regContainer = $('#modal-registration');
    this.loginRegField = $('#login-reg');
    this.passRegField = $('#pass-reg');
    this.repeatPassField = $('#repeat-pass-reg');
    this.regBtn = $('#reg-btn');
    this.toAuthBtn = $('#go-to-auth-btn');

    this.init();
}

window.modalAuth.prototype = {
    init: function () {
        this.loginBtn.on('click', function () {
            $.fancybox.open( ModalAuth.modalWindow, {
                touch: false
            });
        });

        this.toRegBtn.on('click', function () {
           ModalAuth.authContainer.hide();
           ModalAuth.regContainer.css('display', 'flex');
        });

        this.toAuthBtn.on('click', function () {
            ModalAuth.regContainer.hide();
            ModalAuth.authContainer.css('display', 'flex');
        });

        this.authBtn.on('click', $.proxy(this.authorize, this));
        this.regBtn.on('click', $.proxy(this.register, this));
    },

    authorize: function () {
        let login = this.loginAuthField.val();
        let pass = this.passAuthField.val();

        if (login == '') {
            $.toast({
                text : "Вы не заполнили имя пользователя",
                bgColor : '#c0392b',              // Background color for toast
                textColor : '#bdc3c7',            // text color
                allowToastClose : true,       // Show the close button or not
                position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                icon: 'error'
            });
            return 0;
        } else if (pass == '') {
            $.toast({
                text : "Вы не заполнили пароль",
                bgColor : '#c0392b',              // Background color for toast
                textColor : '#bdc3c7',            // text color
                allowToastClose : true,       // Show the close button or not
                position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                icon: 'error'
            });
            return 0;
        }

        $.ajax({
            type: "GET",
            url: baseAPIURL + 'users/authorize',
            data: {
                username: login,
                password: pass
            },
            dataType: 'json',
            success: function () {
                location.reload();
            },
            error: function (data) {
                console.error(data);
                $.toast({
                    text : data.responseJSON.error,
                    bgColor : '#c0392b',              // Background color for toast
                    textColor : '#bdc3c7',            // text color
                    allowToastClose : true,       // Show the close button or not
                    position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'error'
                })
            }
        });
    },

    register: function () {
        let login = this.loginRegField.val();
        let pass = this.passRegField.val();
        let rePass = this.repeatPassField.val();

        if (login === '') {
            $.toast({
                text : "Вы не заполнили имя пользователя",
                bgColor : '#c0392b',              // Background color for toast
                textColor : '#bdc3c7',            // text color
                allowToastClose : true,       // Show the close button or not
                position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                icon: 'error'
            });
            return 0;
        } else if (pass === '') {
            $.toast({
                text : "Вы не заполнили пароль",
                bgColor : '#c0392b',              // Background color for toast
                textColor : '#bdc3c7',            // text color
                allowToastClose : true,       // Show the close button or not
                position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                icon: 'error'
            });
            return 0;
        } else if (rePass !== pass) {
            $.toast({
                text : "Введенные вами пароли не совпадают",
                bgColor : '#c0392b',              // Background color for toast
                textColor : '#bdc3c7',            // text color
                allowToastClose : true,       // Show the close button or not
                position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                icon: 'error'
            });
            return 0;
        }

        $.ajax({
            type: "POST",
            url: baseAPIURL + 'users/registration',
            data: {
                username: login,
                password: pass
            },
            dataType: 'json',
            success: function () {
                location.reload();
            },
            error: function (data) {
                console.error(data);
                $.toast({
                    text : data.responseJSON.error,
                    bgColor : '#c0392b',              // Background color for toast
                    textColor : '#bdc3c7',            // text color
                    allowToastClose : true,       // Show the close button or not
                    position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'error'
                })
            }
        });
    }
}