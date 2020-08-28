# All Admins

    GET admins
    
Returns a list of [Admins]

## Parameters
None

## Example
### Request

    GET https://foodapp.myware.be/api/v1/admins

### Response
``` json
{
    "data": [
        {
            "id": 1,
            "firstname": "test",
            "lastname": "testing",
            "created_at": "2020-07-24T13:09:16.000000Z",
            "updated_at": "2020-07-24T13:09:16.000000Z",
            "user": {
                "user_id": "1",
                "email": "test@testing.com"
            }
        },
        {
            "id": 2,
            "firstname": "test",
            "lastname": "testing",
            "created_at": "2020-07-24T13:09:16.000000Z",
            "updated_at": "2020-07-24T13:09:16.000000Z",
            "user": {
                "user_id": "6",
                "email": "test2@testing.com"
            }
        },
    ],
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 20:28:25"
}
```

[Admins]: README.md