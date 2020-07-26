# Login

    POST login
    
Returns a single [Account] and logs the user in

## Parameters
### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
email | string | Y | 
password | string | Y | 

## Example
### Request

    POST https://foodapp.myware.be/api/v1/login

#### Request Body
```json 
{
    "email": "test@testing.com",
    "password": "test123"
}   
```

### Response
``` json
{
    "data": {
        "user": {
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
        "token": "..."
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Fri, 24 Jul 2020 13:30:07"
}
```

[Account]: README.md
