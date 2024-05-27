var Constants = {
    // "API_BASE_URL": "http://localhost/web-programming-2024/assets/php/" BILO OVAKO, nije mi radio FlightPHP
    //"API_BASE_URL": "http://localhost/Web-Programming-2024/assets/php/",
    get_api_base_url: function() {
        if(location.hostname == "localhost") {
            return "http://localhost/Web-Programming-2024/assets/php/";
        } else {
            //return "https://king-prawn-app-rtyg8.ondigitalocean.app/assets/php/";
            return "https://goldfish-app-vdz96.ondigitalocean.app/assets/php/";
        }
    }
};