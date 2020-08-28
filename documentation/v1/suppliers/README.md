# Supplier Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
name | string | Y | The name of the company
phone | string | Y | The phone number of the company
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated

user -> user_id | integer | Y | Unique identifier
user -> email | string | N | 

address -> id | integer | Y | Unique identifier
address -> street | string | Y | 
address -> number | string | Y | 
address -> city | string | Y | 
address -> province | string | Y | 
address -> country | string | Y | 

timesheet -> id | integer | Y | Unique identifier
timesheet -> date | date | Y | 
timesheet -> time | time | Y | 
timesheet -> created_at | timestamp | Y | Shows the date when the account is created
timesheet -> updated_at | timestamp | Y | Shows the date when the account is updated