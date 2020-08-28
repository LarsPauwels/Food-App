# Employee Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
firstname | string | Y | 
lastname | string | Y | 
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated

user -> user_id | integer | Y | Unique identifier
user -> email | string | N |

company -> id | integer | Y | Unique identifier
company -> name | string | Y | The name of the company
company -> phone | string | Y | The phone number of the company
company -> created_at | timestamp | Y | Shows the date when the account is created
company -> updated_at | timestamp | Y | Shows the date when the account is updated

company -> address -> id | integer | Y | Unique identifier
company -> address -> street | string | Y | 
company -> address -> number | string | Y | 
company -> address -> city | string | Y | 
company -> address -> province | string | Y | 
company -> address -> country | string | Y | 