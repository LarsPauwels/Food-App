# Delete Supplier By Id

    DELETE supplier/{id}
    
Deletes and returns a single [Supplier]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
Id | integer | Y | The id of the account that you want to change

## Example
### Request

    DELETE https://foodapp.myware.be/api/v1/suppliers/1

### Response
``` json
{
    "data": {
        "id": 1,
        "name": "Hoeger, Volkman and Langworth",
        "phone": "923.535.9347 x06066",
        "created_at": "2020-07-24T13:09:16.000000Z",
        "updated_at": "2020-07-24T13:09:16.000000Z",
        "user": {
            "user_id": "21",
            "email": "test@testing.com"
        },
        "address": {
            "id": 4,
            "street": "Elmer Forges",
            "number": "708",
            "city": "East Petefort",
            "province": "Arizona",
            "country": "Vietnam"
        },
        "timesheet": []
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 21:14:59"
}
```

[Supplier]: README.md