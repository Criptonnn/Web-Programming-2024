
console.log("HELLO");

ProductService.reload_product_datatable();
UserService.reload_user_datatable();

$("#add-product-form").validate({
    rules: {
        "name": {
            required: false
        },
        "brand": {
            required: true
        },
        "description": {
            required: true
        },
        "gender": {
            required: true
        },
        "category": {
            required: true
        },
        "rating": {
            required: true
        },
        "price": {
            required: true
        },
        "image": {
            required: false
        }
    },
    submitHandler: function(form, event) {
        // ProductService.reload_product_datatable(); // HTTP GET REQUEST

        console.log("HELLO 2");
        event.preventDefault(); // da mi ne submita
        Utils.block_ui("body");

        let product = serializeForm(form);
        console.log("PRODUCT: " + product);
        console.log(JSON.stringify(product));

        $.post(Constants.API_BASE_URL + "add_product.php", product)
        .done(function (product) {

            Utils.unblock_ui("body");
            $("#admin-modal").modal("toggle");
            
            console.log("UTILS: " + JSON.stringify(Utils));
            
            // Utils.get_datatable("admin-table-products", Constants.API_BASE_URL + "get_products.php",
            //     //[{data: "user-firstname"}, {data: "user-lastname"}, {data: "user-email"}, {data: "user-created-at"}], NE RADI OVAKO, dole stavimo index umjesto name
            //     [{data: 0}, {data: 1}, {data: 2}, {data: 3}, {data: 4}, {data: 5}, {data: 6}, {data: 7}],
            //     null,
            //     function() {
            //         console.log("datatable drawn");
            //     }
            // );

           ProductService.reload_product_datatable();

            toastr.success("Product added successfully");

        })

        // RestClient.post(Constants.API_BASE_URL + "add_product.php", product, function (response) {
        //     Utils.unblock_ui("body");
        //     toastr.success("Product added successfully");
        // },
        // function (error) {
        // toastr.error(error);
        // });


        $("#add-product-form")[0].reset();
    }
})

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

serializeForm_noviKojiIstoNeRadi = (form) => { // NE RADI NI OVAJ SA IMAGEOM
    let formData = new FormData(form);
    let jsonResult = {};
   
    formData.forEach((value, key) => {
      jsonResult[key] = value;
    });
  
    return jsonResult;
  }