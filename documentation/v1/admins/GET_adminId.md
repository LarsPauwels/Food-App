# Admin By Id

    GET admins/{id}
    
Returns a single [Admin]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
Id | integer | Y | The id of the account that you want to change

## Example
### Request

    GET https://foodapp.myware.be/api/v1/admins/1

### Response
``` json
{
    "data": {
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
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 20:34:19"
}
```

[Admin]: README.md