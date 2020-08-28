# Supplier By Id

    GET supplier/{id}
    
Returns a single [Supplier]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
Id | integer | Y | The id of the account that you want to change
Timesheet | boolean | N | If `True` it will also return the timesheets (default `False`)

## Example
### Request

    GET https://foodapp.myware.be/api/v1/suppliers/2?timesheet=true

### Response
``` json
{
    "data": {
        "id": 2,
        "name": "O'Connell, Wunsch and Brekke",
        "phone": "1-608-948-3090 x23634",
        "created_at": "2020-07-24T13:09:16.000000Z",
        "updated_at": "2020-07-24T13:09:16.000000Z",
        "user": {
            "user_id": "7",
            "email": "test@testing.com"
        },
        "address": {
            "id": 2,
            "street": "Ankunding Fields",
            "number": "591",
            "city": "New Vance",
            "province": "Texas",
            "country": "Croatia"
        },
        "timesheet": [
            {
                "id": 1,
                "date": "2010-07-20",
                "time": "07:49:55",
                "created_at": "2020-07-24T13:09:16.000000Z",
                "updated_at": "2020-07-24T13:09:16.000000Z"
            },
            {
                "id": 2,
                "date": "1993-10-25",
                "time": "22:00:08",
                "created_at": "2020-07-24T13:09:16.000000Z",
                "updated_at": "2020-07-24T13:09:16.000000Z"
            }
        ]
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 21:03:01"
}
```

[Supplier]: README.md