# Food App Rest API

## Overview
This API is a multi-channel communications platform that allows the sending, receiving and automating of conversations between a Business and a Customer. Zingle is typically interacted with by Businesses via a web browser to manage these conversations with their customers. The Zingle API provides functionality to developers to act on behalf of either the Business or the Customer. The Zingle iOS SDK provides mobile application developers an easy-to-use layer on top of the Zingle API.

## Tutorial
We provide a [Postman](https://www.getpostman.com/) collection with a set of requests that introduce the basic concepts of the API.  You will need an existing Zingle account with API access to run this tutorial. The Postman collection and more information are available [here](https://github.com/Zingle/rest-api/tree/master/.postman_tutorial).

### Support
For API support, please email lars.pauwels@telenet.be.

## Authentication
Access to the API is granted by providing your Bearer authentication token. This token is given when login in with you email and password.

```no-highlight
GET [domain] /api/v1/login

{
    "data": {
        "user": {
            "id": 1,
            "email": "lars.pauwels@telenet.be",
            "deleted_at": null,
            "created_at": "2020-07-24T13:09:14.000000Z",
            "updated_at": "2020-07-24T13:09:14.000000Z",
            "role": {
                "id": 1,
                "name": "Admin",
                "description": "I'm mad. You're mad.' 'How do you want to go with the Dormouse. 'Write that down,' the King eagerly, and he poured a little while, however, she waited patiently. 'Once,' said the cook."
            }
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZWI4MTM4NmVmMWEwZjM1ZDU3NzVkZWViN2NmZGVlY2MwZTIzOTdiNDU4YzA1Y2I2NzNiNjlkZTcwMmQzZDg1Y2U2YjlhYWZiN2VmYzI3NWUiLCJpYXQiOjE1OTU1OTc0MDcsIm5iZiI6MTU5NTU5NzQwNywiZXhwIjoxNjI3MTMzNDA3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.kCYNRAgdVY9jQ-pV-okMu_7UFXgauYX7Ig2_GYlmy6oAnR70BbzIZjUd2Fv4MlvHhAhIx1YdYR_j8Sucx4zC2wyIiRSQyQ63pe7Q3_HcAKzRcGTF4JrAEAsaAzyMCF3qX2Z0Qqyup-0HoGOQKU875ovv7G0C3l4BbKxfnli33V3MWpJxEivgHyzRl7zoNALHDzIqfnmPFuECdFuD_H5KXXX5SnoHohsdJ_5pfMRgz5yp3JHvWe1jPkdtuwj1QipzksprgeCR7nUoPTeUiWsP9HN8Bpk1CcpXYUDRRSDDqlzH61zqG5JnpxWk7Yc6T4dbbsbEwhii4C3cLn13lD_vEiLqyO2Jnaj6tcZ-4btQ2hSnMH91w5A39wIGaa2N3iZbGi0IURPeaJyXpIGXnMdV-MJv5ydOgB4ZC_1h_RjtBhP2bke88aCcHZWj7N0XBpsZgT3E61b_FHwgNjDGtQRDVOcKlP2H2JGdnPDtzZev21c6sW-Jl8aPLJLgggbRXl7e4vERjstl7eSi18_8pLwcM36JlvAwLSZ6A505YO6ZnElPd3GCLPtfndI044kaz26tKXb2EqcPm6c0bpAnSOCQL8tQ07S0J-_yjWwk97eS9_iJ-i9lcHwLLbTaRm3mJvDFtE1K4kbUgPwI2bt62q59A7xI_PJBH0LPXCU9mKlCEC4"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Fri, 24 Jul 2020 13:30:07"
}
```

## API Versioning
The first part of the URI path specifies the API version you wish to access in the format `v{version_number}`. 

For example, version 1 of the API (most current) is accessible via:

```no-highlight
[domain]/api/v1
```

## HTTP requests
All API requests are made by sending a secure HTTPS request using one of the following methods, depending on the action being taken:

* `POST` Create a resource
* `PUT` Update a resource
* `GET` Get a resource or list of resources
* `DELETE` Delete a resource

For PUT and POST requests the body of your request may include a JSON payload, and the URI being requested may include a query string specifying additional filters or commands, all of which are outlined in the following sections.

## HTTP Responses
Each response will include a `status` object, (if successful) a `data` result (`data` will be an object for single-record queries and an array for list queries) also the `version` of the api and the `valid_as_of` with the date of when the request was made. The `code` object contains an HTTP `status_code`, or `error_code` (if an error occurred - see [Error Codes]). The `data` contains the result of a successful request.  For example:

```no-highlight
{
    "data": {
        ...
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Fri, 24 Jul 2020 13:30:07"
}
```

## HTTP Response Codes
Each response will be returned with one of the following HTTP status codes:

* `200` `OK` The request was successful
* `400` `Bad Request` There was a problem with the request (security, malformed, data validation, etc.)
* `401` `Unauthorized` The supplied API credentials are invalid
* `403` `Forbidden` The credentials provided do not have permission to access the requested resource
* `404` `Not found` An attempt was made to access a resource that does not exist in the API
* `405` `Method not allowed` The resource being accessed doesn't support the method specified (GET, POST, etc.).
* `500` `Server Error` An error on the server occurred

## Resources
For a description of the available resources see the [Resource Overview](resource_overview.md) or the [Online Documentation](http://foodapp.myware.be/api/documentation).

### Account
- **[<code>POST</code> Login](/time_zones/GET_list.md)**
- **[<code>POST</code> Register](/available_phone_numbers/GET_list.md)**
- **[<code>GET</code> Logout](/time_zones/GET_list.md)**
- **[<code>GET</code> All Users](/available_phone_numbers/GET_list.md)**
- **[<code>GET</code> Get User By Id](/time_zones/GET_list.md)**
- **[<code>PUT</code> Update User By Id](/available_phone_numbers/GET_list.md)**
- **[<code>DELETE</code> Delete User By Id](/time_zones/GET_list.md)**

[domain]: http://foodapp.myware.be/