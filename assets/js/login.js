let logins = [];

$("#login-form").validate({
    rules: {
        "login-email": {
            required: true,
            email: true
        },
        "login-password": {
            required: true
        },
    },
    messages: {
        "login-email": {
            required: "Please enter your email",
            email: "Please enter a correct email"
        },
        "login-password": {
            required: "Please enter a password"
        }
        
    },
    submitHandler: function(form, event) {
        event.preventDefault(); // da mi ne submita
        blockUi("body");
        let login = serializeForm(form);
        console.log(JSON.stringify(login));

        logins.push(login);
        console.log("CONTACTS = ", logins);
        $("#login-form")[0].reset();

        unblockUi("body");
    }
});

blockUi = (element) => {
    $(element).block({
        message: '<div class="spinner-border text-primary" role="status"></div>',
        css: {
            backgroundColor: "transparent",
            border: "0"
        },
        overlayCSS: {
            backgroundColor: "#000000",
            opacity: 0.25
        }
    });
}

unblockUi = (element) => {
    $(element).unblock({});
}

serializeForm = (form) => {
    let jsonResult = {};
    //console.log($(form).serializeArray());
    //serializeArray() reutrns an array of: name: [name of filed], value: [value of filed] for each field in the form
    $.each($(form).serializeArray(), function() {
        jsonResult[this.name] = this.value;
    });
    return jsonResult;
}