let registers = [];

$("#register-form").validate({
    rules: {
        "register-first_name" : {
            required: true
        },
        "register-last_name" : {
            required: true
        },
        "register-email": {
            required: true,
            email: true
        },
        "register-password": {
            required: true
        },
        "register-repeat_password" : {
            required: true,
            equalTo: "#register-password"
        },
    },
    messages: {
        "register-first_name": {
            required: "Please enter your first name"
        },
        "register-last_name": {
            required: "Please enter your last name"
        },
        "register-email": {
            required: "Please enter your email",
            email: "Please enter a valid email address"
        },
        "register-password": {
            required: "Please enter a password"
        },
        "register-repeat_password": {
            required: "Please repeat your password",
            equalTo: "Passwords do not match" // Message for password confirmation mismatch
        }
    },
    submitHandler: function(form, event) {
        event.preventDefault(); // da mi ne submita
        blockUi("body");
        let register = serializeForm(form);
        console.log(JSON.stringify(register));

        registers.push(register);
        console.log("CONTACTS = ", registers);
        $("#register-form")[0].reset();

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