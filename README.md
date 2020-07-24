# Food App Rest API

## Overview

This API is a multi-channel communications platform that allows the sending, receiving and automating of conversations between a Business and a Customer. Zingle is typically interacted with by Businesses via a web browser to manage these conversations with their customers. The Zingle API provides functionality to developers to act on behalf of either the Business or the Customer. The Zingle iOS SDK provides mobile application developers an easy-to-use layer on top of the Zingle API.

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Support

For API support, please email lars.pauwels@telenet.be.

## Authentication

Access to the API is granted by providing your Bearer authentication token. This token is given when login in with you email and password.

```no-highlight
GET https://foodapp.myware.be/api/v1/login

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
        **"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZWI4MTM4NmVmMWEwZjM1ZDU3NzVkZWViN2NmZGVlY2MwZTIzOTdiNDU4YzA1Y2I2NzNiNjlkZTcwMmQzZDg1Y2U2YjlhYWZiN2VmYzI3NWUiLCJpYXQiOjE1OTU1OTc0MDcsIm5iZiI6MTU5NTU5NzQwNywiZXhwIjoxNjI3MTMzNDA3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.kCYNRAgdVY9jQ-pV-okMu_7UFXgauYX7Ig2_GYlmy6oAnR70BbzIZjUd2Fv4MlvHhAhIx1YdYR_j8Sucx4zC2wyIiRSQyQ63pe7Q3_HcAKzRcGTF4JrAEAsaAzyMCF3qX2Z0Qqyup-0HoGOQKU875ovv7G0C3l4BbKxfnli33V3MWpJxEivgHyzRl7zoNALHDzIqfnmPFuECdFuD_H5KXXX5SnoHohsdJ_5pfMRgz5yp3JHvWe1jPkdtuwj1QipzksprgeCR7nUoPTeUiWsP9HN8Bpk1CcpXYUDRRSDDqlzH61zqG5JnpxWk7Yc6T4dbbsbEwhii4C3cLn13lD_vEiLqyO2Jnaj6tcZ-4btQ2hSnMH91w5A39wIGaa2N3iZbGi0IURPeaJyXpIGXnMdV-MJv5ydOgB4ZC_1h_RjtBhP2bke88aCcHZWj7N0XBpsZgT3E61b_FHwgNjDGtQRDVOcKlP2H2JGdnPDtzZev21c6sW-Jl8aPLJLgggbRXl7e4vERjstl7eSi18_8pLwcM36JlvAwLSZ6A505YO6ZnElPd3GCLPtfndI044kaz26tKXb2EqcPm6c0bpAnSOCQL8tQ07S0J-_yjWwk97eS9_iJ-i9lcHwLLbTaRm3mJvDFtE1K4kbUgPwI2bt62q59A7xI_PJBH0LPXCU9mKlCEC4"**
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Fri, 24 Jul 2020 13:30:07"
}
```

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
