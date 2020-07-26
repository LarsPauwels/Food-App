# All Users

    GET users
    
Returns a list of [Accounts] belonging to the specified service

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
Active | boolean | N | If `False` also deleted accounts will be given (`True`)
Amount | integer | N | The amount of accounts you want to display on one page (default 50, max. 200)
Page | integer | N | The page number in the result set to return (default 1)

## Example
### Request

    GET https://foodapp.myware.be/api/v1/users?active=false&amount=2

### Response
``` json
{
    "data": [
        {
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
        {
            "id": 2,
            "email": "test2@testing.com",
            "deleted_at": null,
            "created_at": "2020-07-24T13:09:14.000000Z",
            "updated_at": "2020-07-24T13:09:14.000000Z",
            "role": {
                "id": 1,
                "name": "Admin",
                "description": "I'm mad. You're mad.' 'How do you want to go with the Dormouse. 'Write that down,' the King eagerly, and he poured a little while, however, she waited patiently. 'Once,' said the cook."
            }
        }
    ],
    "links": {
        "first": "https://foodapp.myware.be/api/v1/users?page=1",
        "last": "https://foodapp.myware.be/api/v1/users?page=28",
        "prev": null,
        "next": "https://foodapp.myware.be/api/v1/users?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 28,
        "path": "https://foodapp.myware.be/api/v1/users",
        "per_page": 2,
        "to": 2,
        "total": 56
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Sun, 26 Jul 2020 19:53:59"
}
```

[Accounts]: README.md