# Logout

    GET logout
    
Returns a single [Account] and logs the user out

## Parameters
None

## Example
### Request

    GET https://foodapp.myware.be/api/v1/logout

### Response
``` json
{
    "data": {
        "user": {
            "id": 56,
            "email": "test@testing.com",
            "deleted_at": null,
            "created_at": "2020-07-26T19:41:21.000000Z",
            "updated_at": "2020-07-26T19:41:21.000000Z",
            "role": {
                "id": 1,
                "name": "Admin",
                "description": "I'm mad. You're mad.' 'How do you want to go with the Dormouse. 'Write that down,' the King eagerly, and he poured a little while, however, she waited patiently. 'Once,' said the cook."
            }
        },
        "token": "..."
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 19:43:39"
}
```

[Account]: README.md