# Company Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
name | string | N | The name of the company
phone | string | N | The phone number of the company
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated

user -> user_id | integer | Y | Unique identifier
user -> email | string | N |

company -> address -> id | integer | N | Unique identifier
company -> address -> street | string | N | 
company -> address -> number | string | N | 
company -> address -> city | string | N | 
company -> address -> province | string | N | 
company -> address -> country | string | N | 

company -> employees -> id | integer | N | Unique identifier
company -> employees -> firstname | string | N | 
company -> employees -> lastname | string | N | 
company -> employees -> user_id | integer | N | Unique identifier
company -> employees -> created_at | timestamp | Y | Shows the date when the account is created
company -> employees -> updated_at | timestamp | Y | Shows the date when the account is updated