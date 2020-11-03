# Parking Lot REST API

### Setup

Pre requisites:

PHP, node, mysql

* Start the mysql server 

```mysql
    mysql -u root -p
```

* create a data base

```mysql
    CREATE DATABASE parking_lot
```

* Update the .env file with the mysql credentials

```json
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=parking_lot
    DB_USERNAME=root ==> username
    DB_PASSWORD=     ==> password   
```
* Install Authentication client

```mysql
    php artisan passport:install
```

* Migrate all required tables

```mysql
    php artisan migrate
```

*Install all required libraries

```mysql
    npm install
```

*Start Server

```mysql
    php artisan serve
```

The REST API along with CRUD UI is accessible at `http://127.0.0.1:8000/`



## Open Endpoints

Open endpoints require no Authentication.

* [Register] : `POST /api/regsiter`
* [Login] : `POST /api/login/`

# Register

Used to regist a User.

**URL** : `/api/register/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "name": "[username]",
    "email": "[valid email address]",
    "password": "[password in plain text]",
    "c_passord": "[password in palin text]"
}
```

**Data example**

```json
{
    "name": "aakash",
    "email": "aakash@example.com",
    "password": "aakash1234",
    "c_password": "aakash1234"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjYyMmVlYmQ3YzczYTA0OWQwMjA2MDQyZTQ4YTFhYjIyMmUwNmZiYzBlMDczOTZhNTIxNzQyNDdiNzQ0NWI0YzIzODY0ZjFkNzk4OThiZWYiLCJpYXQiOjE2MDQ0MTkyMDMsIm5iZiI6MTYwNDQxOTIwMywiZXhwIjoxNjM1OTU1MjAzLCJzdWIiOiIzIiw...",
        "name": "Aakash"
    }
}
```

# Login

Used to collect a Token for a registered User.

**URL** : `/api/login/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "username": "[valid email address]",
    "password": "[password in plain text]"
}
```

**Data example**

```json
{
    "username": "aakash@example.com",
    "password": "aakash1234"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "success": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzQ4NTUxM2NjY2I3NzBhZTU1YzIwYjIyMThiNWI0ZjJhYTI1ZTM1OWI2YmM0MTA1ZTM5Y2QwNmNhYjkxMWQzZGE5Njk0M2ZmNTI0YWQ0MTUiLCJpYXQiOjE2MDQzNDMyNzQsIm5iZiI6MTYwNDM0MzI3NCwiZXhwIjoxNjM1ODc5Mjc0LCJzdWIiOiIyIiw...."
    }
}
```

## Endpoints that require Authentication

Closed endpoints require a valid Token to be included in the header of the
request. A Token can be acquired from the Login view above.

### User related

Each endpoint manipulates or displays information related to the User whose
Token is provided with the request:

* users: `POST /api/user`

### Vehicle

Each endpoint manipulates or displays information related to the Vehicle with 
Authorization Token provided with the request:

The headers should have following parameter set: 

```json
{
    "Authorization": "Bearer [Access Token]",
    "Content-Type": "application/json",
    "Accept": "application/json"
}
```

## Get Vehicle 

**URL** : `/api/vehicle/` / `/api/vehicle/:id`

**Method** : `GET`

**Auth required** : YES

## Add Vehicle

**URL** : `/api/vehicle/`

**Method** : `POST`

**Auth required** : YES

**Data constraints**

```json
{
    "model": "Text",
    "manufacturer": "Text",
    "category": "[car / bus / motorbike]"
}
```

**Data example**

```json
{
    "model": "320D",
    "manufacturer": "BMW",
    "category": "car"
}
```

## Parking Lot

**URL** : `/api/parking-lot/` / `/api/parking-lot/:id`

**Method** : `GET`

**Auth required** : YES

**Data constraints**

## Park Vehicle

**URL** : `/api/park/:vehicleId/:parkingLotId`

**Method** : `POST`

**Auth required** : YES

## Depart Vehicle

**URL** : `/api/depart/:vehicleId`

**Method** : `POST`

**Auth required** : YES

It also calculates the cost and the rate can be set in App\Http\Controllers\API\ParkingLotController.

## CRUD using UI

* `http://127.0.0.1:8000`
* `http://127.0.0.1:8000/view/vehicle`
* `http://127.0.0.1:8000/view/lot`
* `http://127.0.0.1:8000/view/parking`
