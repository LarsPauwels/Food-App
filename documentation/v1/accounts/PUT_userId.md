# Update Account By Id

    PUT users/{id}
    
Updates and returns a single [Account]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
Id | integer | Y | The id of the account that you want to change

### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
email | string | Y | 
password | string | Y | 
role_id | string | Y | The id that links the user and the role of the user

## Example
### Request

    PUT https://foodapp.myware.be/api/v1/users/1

#### Request Body
```json 
{
    "email": "test2@testing.com",
    "password": "test123",
    "role_id": 1
}   
```

### Response
``` json
{
    "data": {
        "id": 1,
        "email": "test2@testing.com",
        "deleted_at": null,
        "created_at": "2020-07-24T13:09:14.000000Z",
        "updated_at": "2020-07-26T20:13:32.000000Z",
        "role": {
            "id": 1,
            "name": "Admin",
            "description": "I'm mad. You're mad.' 'How do you want to go with the Dormouse. 'Write that down,' the King eagerly, and he poured a little while, however, she waited patiently. 'Once,' said the cook."
        }
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 20:13:32"
}
```

[Account]: README.md