# Admin Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
firstname | string | Y | 
lastname | string | Y | 
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated

user -> user_id | integer | Y | Unique identifier
user -> email | string | N | 