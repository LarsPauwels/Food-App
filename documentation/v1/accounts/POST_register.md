# Register

    POST register
    
Returns a single [Account], creates a new account and logs the user in

## Parameters
### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
email | string | Y | 
password | string | Y | 
role_id | string | Y |

## Example
### Request

    POST https://foodapp.myware.be/api/v1/register

#### Request Body
```json 
{
    "email": "test@testing.com",
    "password": "test123",
    "role_id": 1
}   
```

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
    "valid_as_of": "Sun, 26 Jul 2020 19:41:21"
}
```

[Account]: README.md
