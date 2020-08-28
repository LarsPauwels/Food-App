# Account Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
user -> id | integer | Y | Unique identifier
user -> email | string | N | 
user -> deleted_at | timestamp | Y | Returns the date when the user is deleted or null when not deleted
user -> created_at | timestamp | Y | Shows the date when the account is created
user -> updated_at | timestamp | Y | Shows the date when the account is updated

role -> id | integer | Y | Unique identifier
role -> name | string | Y | The name of the role that is given to this account
role -> description | string | Y | The description summarizing what this role entails
token | string | Y | Unique Bearer token needed to login