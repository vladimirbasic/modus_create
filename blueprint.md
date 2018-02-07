FORMAT: 1A
HOST: http://modus_create.local

# Group Vehicles

## Vehicles fetching [/vehicles/{?withRating}]

+ Parameters
    + withRating (optional)(bool) - Whether crash rating should be displayed 

### Fetch vehicles based on user input via POST method [POST]

+ Request (application/json)
    
    + Attributes
        + year: `2015` (number) - Year of the model
        + manufacturer: `Audi` (string) - Manufacturer
        + model: `A3` (string) - Model

- Response 200 (application/json)

        {
            Count: 4,
            Results: [
                {
                    CrashRating: "5",
                    Description: "2015 Audi A3 4 DR AWD",
                    VehicleId: 9403
                },
                {
                    CrashRating: "5",
                    Description: "2015 Audi A3 4 DR FWD",
                    VehicleId: 9408
                },
                {
                    CrashRating: "Not Rated",
                    Description: "2015 Audi A3 C AWD",
                    VehicleId: 9405
                },
                {
                    CrashRating: "Not Rated",
                    Description: "2015 Audi A3 C FWD",
                    VehicleId: 9406
                }
            ]
        }

- Response 200 (application/json)

        {
            Count: 4,
            Results: [
                {
                    Description: "2015 Audi A3 4 DR AWD",
                    VehicleId: 9403
                },
                {
                    Description: "2015 Audi A3 4 DR FWD",
                    VehicleId: 9408
                },
                {
                    Description: "2015 Audi A3 C AWD",
                    VehicleId: 9405
                },
                {
                    Description: "2015 Audi A3 C FWD",
                    VehicleId: 9406
                }
            ]
        }

- Response 400 (application/json)

        {
            Count: 0,
            Results: []
        }

- Response 404 (application/json)

        {
            "error": {
                "message" => "No route found for \"POST /vehiclesr\""
             }
        }

- Response 405 (application/json)

        {
            "error": {
                "message": "No route found for \"PUT /vehicles\": Method Not Allowed (Allow: POST)"
            }
        }

- Response 502 (application/json)

        {
            "error": {
                "message" => "Bad gateway"
             }
        }

## Vehicles fetching [/vehicles/{year}/{manufacturer}/{model}{?withRating}]

+ Parameters
    + year (int) - Year of the model
    + manufacturer (string) - Manufacturer
    + model (string) - Model
    + withRating (optional)(bool) - Whether crash rating should be displayed 

### Fetch vehicles based on user input via GET method [GET]

- Response 200 (application/json)

        {
            Count: 4,
            Results: [
                {
                    CrashRating: "5",
                    Description: "2015 Audi A3 4 DR AWD",
                    VehicleId: 9403
                },
                {
                    CrashRating: "5",
                    Description: "2015 Audi A3 4 DR FWD",
                    VehicleId: 9408
                },
                {
                    CrashRating: "Not Rated",
                    Description: "2015 Audi A3 C AWD",
                    VehicleId: 9405
                },
                {
                    CrashRating: "Not Rated",
                    Description: "2015 Audi A3 C FWD",
                    VehicleId: 9406
                }
            ]
        }

- Response 200 (application/json)

        {
            Count: 4,
            Results: [
                {
                    Description: "2015 Audi A3 4 DR AWD",
                    VehicleId: 9403
                },
                {
                    Description: "2015 Audi A3 4 DR FWD",
                    VehicleId: 9408
                },
                {
                    Description: "2015 Audi A3 C AWD",
                    VehicleId: 9405
                },
                {
                    Description: "2015 Audi A3 C FWD",
                    VehicleId: 9406
                }
            ]
        }

- Response 400 (application/json)

        {
            Count: 0,
            Results: []
        }

- Response 404 (application/json)

        {
            "error": {
                "message" => "No route found for \"POST /vehiclesr\""
             }
        }

- Response 405 (application/json)

        {
            "error": {
                "message": "No route found for \"PUT /vehicles\": Method Not Allowed (Allow: POST)"
            }
        }

- Response 502 (application/json)

        {
            "error": {
                "message" => "Bad gateway"
             }
        }