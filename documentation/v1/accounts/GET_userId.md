# User By Id

    GET users/{id}
    
Returns a single [Account]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
Id | integer | Y | The id of the account that you want to change

## Example
### Request

    GET https://foodapp.myware.be/api/v1/users/1

### Response
``` json
{
    "data": {
        "id": 1,
        "email": "test@testing.com",
        "deleted_at": null,
        "created_at": "2020-07-24T13:09:14.000000Z",
        "updated_at": "2020-07-24T13:09:14.000000Z",
        "role": {
            "id": 1,
            "name": "Admin",
            "description": "I'm mad. You're mad.' 'How do you want to go with the Dormouse. 'Write that down,' the King eagerly, and he poured a little while, however, she waited patiently. 'Once,' said the cook."
        }
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 20:02:16"
}
```

[Account]: README.md