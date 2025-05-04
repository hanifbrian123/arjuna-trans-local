# API Documentation for Arjuna Trans Android App

This document provides documentation for the API endpoints used by the Arjuna Trans Android application.

## Base URL

```
https://your-domain.com/api
```

## Authentication

The API uses Laravel Sanctum for authentication. All protected routes require a valid Bearer token in the Authorization header.

### Login

- **Endpoint:** `POST /login`
- **Body:**
  ```json
  {
    "email": "admin@example.com",
    "password": "password123"
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Login berhasil",
    "data": {
      "user": {
        "id": 1,
        "name": "Admin",
        "email": "admin@example.com",
        "phone": "081234567890",
        "roles": ["admin"]
      },
      "token": "1|abcdefghijklmnopqrstuvwxyz"
    }
  }
  ```
- **Description:**  
  Authenticates a user and returns a token for API access. Only users with the admin role can login through this API.

### Forgot Password

- **Endpoint:** `POST /forgot-password`
- **Body:**
  ```json
  {
    "email": "admin@example.com"
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "We have emailed your password reset link!"
  }
  ```
- **Description:**  
  Sends a password reset link to the specified email address. Only works for users with the admin role.

### Reset Password

- **Endpoint:** `POST /reset-password`
- **Body:**
  ```json
  {
    "token": "reset-token-from-email",
    "email": "admin@example.com",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Your password has been reset!"
  }
  ```
- **Description:**  
  Resets the user's password using the token received via email.

### Logout

- **Endpoint:** `POST /admin/logout`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Logout berhasil"
  }
  ```
- **Description:**  
  Invalidates the current access token.

### Get User Profile

- **Endpoint:** `GET /admin/profile`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Profil pengguna berhasil dimuat",
    "data": {
      "id": 1,
      "name": "Admin",
      "email": "admin@example.com",
      "phone": "081234567890",
      "roles": ["admin"],
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Returns the profile information of the authenticated user.

## Orders Management

### List Orders

- **Endpoint:** `GET /admin/orders`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Query Parameters (optional):**
  - `start_date` (YYYY-MM-DD)
  - `end_date` (YYYY-MM-DD)
  - `status` (waiting, approved, canceled)
  - `driver_id` (integer)
  - `vehicle_type` (string)
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Daftar pesanan berhasil dimuat",
    "data": [
      {
        "id": 1,
        "order_num": "AT-20230101-001",
        "name": "John Doe",
        "phone_number": "081234567890",
        "address": "Jl. Example No. 123",
        "start_date": "2023-01-01T08:00:00.000000Z",
        "end_date": "2023-01-03T17:00:00.000000Z",
        "start_date_formatted": "01/01/2023, 08:00",
        "end_date_formatted": "03/01/2023, 17:00",
        "pickup_address": "Jl. Pickup No. 456",
        "destination": "Yogyakarta",
        "route": "Jakarta - Bandung - Yogyakarta",
        "vehicle_count": 1,
        "vehicle_type": "ISUZU ELF LONG",
        "driver_name": "Driver 1",
        "rental_price": 3000000,
        "rental_price_formatted": "Rp 3.000.000",
        "down_payment": 1000000,
        "down_payment_formatted": "Rp 1.000.000",
        "remaining_cost": 2000000,
        "remaining_cost_formatted": "Rp 2.000.000",
        "is_paid": false,
        "status": "waiting",
        "status_label": "Menunggu",
        "additional_notes": "Additional notes here",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ]
  }
  ```
- **Description:**  
  Returns a list of orders with optional filtering.

### Get Order Details

- **Endpoint:** `GET /admin/orders/{id}`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Detail pesanan berhasil dimuat",
    "data": {
      "id": 1,
      "order_num": "AT-20230101-001",
      "name": "John Doe",
      "phone_number": "081234567890",
      "address": "Jl. Example No. 123",
      "start_date": "2023-01-01T08:00:00.000000Z",
      "end_date": "2023-01-03T17:00:00.000000Z",
      "start_date_formatted": "01/01/2023, 08:00",
      "end_date_formatted": "03/01/2023, 17:00",
      "pickup_address": "Jl. Pickup No. 456",
      "destination": "Yogyakarta",
      "route": "Jakarta - Bandung - Yogyakarta",
      "vehicle_count": 1,
      "vehicle_type": "ISUZU ELF LONG",
      "driver_name": "Driver 1",
      "rental_price": 3000000,
      "rental_price_formatted": "Rp 3.000.000",
      "down_payment": 1000000,
      "down_payment_formatted": "Rp 1.000.000",
      "remaining_cost": 2000000,
      "remaining_cost_formatted": "Rp 2.000.000",
      "is_paid": false,
      "status": "waiting",
      "status_label": "Menunggu",
      "additional_notes": "Additional notes here",
      "customer": {
        "id": 2,
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "081234567890"
      },
      "driver": {
        "id": 1,
        "name": "Driver 1",
        "phone": "087654321098",
        "address": "Driver Address",
        "license_type": ["A", "B"]
      },
      "vehicles": [
        {
          "id": 1,
          "name": "Bus 001",
          "license_plate": "AB 1234 CD",
          "type": "ISUZU ELF LONG",
          "capacity": 20,
          "facilities": ["AC", "TV", "WiFi"],
          "status": "ready"
        }
      ],
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Returns detailed information about a specific order.

### Create Order

- **Endpoint:** `POST /admin/orders`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Body:**
  ```json
  {
    "name": "John Doe",
    "phone_number": "081234567890",
    "address": "Jl. Example No. 123",
    "start_date": "2023-01-01 08:00:00",
    "end_date": "2023-01-03 17:00:00",
    "pickup_address": "Jl. Pickup No. 456",
    "destination": "Yogyakarta",
    "route": "Jakarta - Bandung - Yogyakarta",
    "vehicle_count": 1,
    "vehicle_type": "ISUZU ELF LONG",
    "rental_price": 3000000,
    "down_payment": 1000000,
    "status": "waiting",
    "additional_notes": "Additional notes here",
    "vehicle_ids": [1]
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Pesanan berhasil dibuat",
    "data": {
      "id": 1,
      "order_num": "AT-20230101-001",
      "name": "John Doe",
      "phone_number": "081234567890",
      "address": "Jl. Example No. 123",
      "start_date": "2023-01-01T08:00:00.000000Z",
      "end_date": "2023-01-03T17:00:00.000000Z",
      "start_date_formatted": "01/01/2023, 08:00",
      "end_date_formatted": "03/01/2023, 17:00",
      "pickup_address": "Jl. Pickup No. 456",
      "destination": "Yogyakarta",
      "route": "Jakarta - Bandung - Yogyakarta",
      "vehicle_count": 1,
      "vehicle_type": "ISUZU ELF LONG",
      "driver_name": null,
      "rental_price": 3000000,
      "rental_price_formatted": "Rp 3.000.000",
      "down_payment": 1000000,
      "down_payment_formatted": "Rp 1.000.000",
      "remaining_cost": 2000000,
      "remaining_cost_formatted": "Rp 2.000.000",
      "is_paid": false,
      "status": "waiting",
      "status_label": "Menunggu",
      "additional_notes": "Additional notes here",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Creates a new order.

### Update Order

- **Endpoint:** `PUT /admin/orders/{id}`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Body:**
  ```json
  {
    "name": "John Doe Updated",
    "phone_number": "081234567890",
    "address": "Jl. Example No. 123 Updated",
    "start_date": "2023-01-01 08:00:00",
    "end_date": "2023-01-03 17:00:00",
    "pickup_address": "Jl. Pickup No. 456 Updated",
    "destination": "Yogyakarta Updated",
    "route": "Jakarta - Bandung - Yogyakarta Updated",
    "vehicle_count": 1,
    "vehicle_type": "ISUZU ELF LONG",
    "rental_price": 3500000,
    "down_payment": 1500000,
    "status": "waiting",
    "additional_notes": "Additional notes here updated",
    "vehicle_ids": [1, 2],
    "driver_id": 1
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Pesanan berhasil diperbarui",
    "data": {
      "id": 1,
      "order_num": "AT-20230101-001",
      "name": "John Doe Updated",
      "phone_number": "081234567890",
      "address": "Jl. Example No. 123 Updated",
      "start_date": "2023-01-01T08:00:00.000000Z",
      "end_date": "2023-01-03T17:00:00.000000Z",
      "start_date_formatted": "01/01/2023, 08:00",
      "end_date_formatted": "03/01/2023, 17:00",
      "pickup_address": "Jl. Pickup No. 456 Updated",
      "destination": "Yogyakarta Updated",
      "route": "Jakarta - Bandung - Yogyakarta Updated",
      "vehicle_count": 1,
      "vehicle_type": "ISUZU ELF LONG",
      "driver_name": "Driver 1",
      "rental_price": 3500000,
      "rental_price_formatted": "Rp 3.500.000",
      "down_payment": 1500000,
      "down_payment_formatted": "Rp 1.500.000",
      "remaining_cost": 2000000,
      "remaining_cost_formatted": "Rp 2.000.000",
      "is_paid": false,
      "status": "waiting",
      "status_label": "Menunggu",
      "additional_notes": "Additional notes here updated",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Updates an existing order.

### Delete Order

- **Endpoint:** `DELETE /admin/orders/{id}`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Pesanan berhasil dihapus"
  }
  ```
- **Description:**  
  Deletes an order.

### Assign Driver to Order

- **Endpoint:** `PUT /admin/orders/{id}/assign-driver`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Body:**
  ```json
  {
    "driver_id": 1
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Driver berhasil ditugaskan",
    "data": {
      "id": 1,
      "order_num": "AT-20230101-001",
      "name": "John Doe",
      "phone_number": "081234567890",
      "address": "Jl. Example No. 123",
      "start_date": "2023-01-01T08:00:00.000000Z",
      "end_date": "2023-01-03T17:00:00.000000Z",
      "start_date_formatted": "01/01/2023, 08:00",
      "end_date_formatted": "03/01/2023, 17:00",
      "pickup_address": "Jl. Pickup No. 456",
      "destination": "Yogyakarta",
      "route": "Jakarta - Bandung - Yogyakarta",
      "vehicle_count": 1,
      "vehicle_type": "ISUZU ELF LONG",
      "driver_name": "Driver 1",
      "rental_price": 3000000,
      "rental_price_formatted": "Rp 3.000.000",
      "down_payment": 1000000,
      "down_payment_formatted": "Rp 1.000.000",
      "remaining_cost": 2000000,
      "remaining_cost_formatted": "Rp 2.000.000",
      "is_paid": false,
      "status": "approved",
      "status_label": "Disetujui",
      "additional_notes": "Additional notes here",
      "driver": {
        "id": 1,
        "name": "Driver 1",
        "phone": "087654321098",
        "address": "Driver Address",
        "license_type": ["A", "B"]
      },
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Assigns a driver to an order and changes the status to 'approved'.

### Change Order Status

- **Endpoint:** `PUT /admin/orders/{id}/change-status`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Body:**
  ```json
  {
    "status": "approved"
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Status pesanan berhasil diperbarui",
    "data": {
      "id": 1,
      "order_num": "AT-20230101-001",
      "name": "John Doe",
      "phone_number": "081234567890",
      "address": "Jl. Example No. 123",
      "start_date": "2023-01-01T08:00:00.000000Z",
      "end_date": "2023-01-03T17:00:00.000000Z",
      "start_date_formatted": "01/01/2023, 08:00",
      "end_date_formatted": "03/01/2023, 17:00",
      "pickup_address": "Jl. Pickup No. 456",
      "destination": "Yogyakarta",
      "route": "Jakarta - Bandung - Yogyakarta",
      "vehicle_count": 1,
      "vehicle_type": "ISUZU ELF LONG",
      "driver_name": "Driver 1",
      "rental_price": 3000000,
      "rental_price_formatted": "Rp 3.000.000",
      "down_payment": 1000000,
      "down_payment_formatted": "Rp 1.000.000",
      "remaining_cost": 2000000,
      "remaining_cost_formatted": "Rp 2.000.000",
      "is_paid": false,
      "status": "approved",
      "status_label": "Disetujui",
      "additional_notes": "Additional notes here",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Changes the status of an order.

### Get Calendar Events

- **Endpoint:** `GET /admin/calendar`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Query Parameters (optional):**
  - `start` (YYYY-MM-DD)
  - `end` (YYYY-MM-DD)
  - `driver_id` (integer)
  - `vehicle_type` (string)
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Data kalender berhasil dimuat",
    "data": [
      {
        "id": 1,
        "title": "John Doe - ISUZU ELF LONG",
        "start": "2023-01-01T08:00:00",
        "end": "2023-01-03T17:00:00",
        "extendedProps": {
          "order_num": "AT-20230101-001",
          "customer": "John Doe",
          "phone": "081234567890",
          "destination": "Yogyakarta",
          "route": "Jakarta - Bandung - Yogyakarta",
          "pickup_address": "Jl. Pickup No. 456",
          "driver_name": "Driver 1",
          "vehicle_type": "ISUZU ELF LONG",
          "status": "approved"
        },
        "backgroundColor": "#4CAF50",
        "borderColor": "#4CAF50"
      }
    ]
  }
  ```
- **Description:**  
  Returns a list of orders formatted for calendar display. Only shows orders with 'approved' status.

## Payments Management

### List Payments

- **Endpoint:** `GET /admin/payments`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Query Parameters (optional):**
  - `start_date` (YYYY-MM-DD)
  - `end_date` (YYYY-MM-DD)
  - `payment_status` (paid, unpaid)
  - `driver_id` (integer)
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Daftar pembayaran berhasil dimuat",
    "data": {
      "payments": [
        {
          "id": 1,
          "order_num": "AT-20230101-001",
          "name": "John Doe",
          "phone_number": "081234567890",
          "address": "Jl. Example No. 123",
          "start_date": "2023-01-01T08:00:00.000000Z",
          "end_date": "2023-01-03T17:00:00.000000Z",
          "start_date_formatted": "01/01/2023, 08:00",
          "end_date_formatted": "03/01/2023, 17:00",
          "pickup_address": "Jl. Pickup No. 456",
          "destination": "Yogyakarta",
          "route": "Jakarta - Bandung - Yogyakarta",
          "vehicle_count": 1,
          "vehicle_type": "ISUZU ELF LONG",
          "driver_name": "Driver 1",
          "rental_price": 3000000,
          "rental_price_formatted": "Rp 3.000.000",
          "down_payment": 1000000,
          "down_payment_formatted": "Rp 1.000.000",
          "remaining_cost": 2000000,
          "remaining_cost_formatted": "Rp 2.000.000",
          "is_paid": false,
          "status": "approved",
          "status_label": "Disetujui",
          "additional_notes": "Additional notes here",
          "created_at": "2023-01-01T00:00:00.000000Z",
          "updated_at": "2023-01-01T00:00:00.000000Z"
        }
      ],
      "total_revenue": 3000000,
      "total_down_payment": 1000000,
      "total_remaining": 2000000,
      "count": 1
    }
  }
  ```
- **Description:**  
  Returns a list of payments with optional filtering.

### Complete Payment

- **Endpoint:** `POST /admin/payments/complete`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Body:**
  ```json
  {
    "order_id": 1
  }
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Pembayaran berhasil dilunasi",
    "data": {
      "id": 1,
      "order_num": "AT-20230101-001",
      "name": "John Doe",
      "phone_number": "081234567890",
      "address": "Jl. Example No. 123",
      "start_date": "2023-01-01T08:00:00.000000Z",
      "end_date": "2023-01-03T17:00:00.000000Z",
      "start_date_formatted": "01/01/2023, 08:00",
      "end_date_formatted": "03/01/2023, 17:00",
      "pickup_address": "Jl. Pickup No. 456",
      "destination": "Yogyakarta",
      "route": "Jakarta - Bandung - Yogyakarta",
      "vehicle_count": 1,
      "vehicle_type": "ISUZU ELF LONG",
      "driver_name": "Driver 1",
      "rental_price": 3000000,
      "rental_price_formatted": "Rp 3.000.000",
      "down_payment": 1000000,
      "down_payment_formatted": "Rp 1.000.000",
      "remaining_cost": 0,
      "remaining_cost_formatted": "Rp 0",
      "is_paid": true,
      "status": "approved",
      "status_label": "Disetujui",
      "additional_notes": "Additional notes here",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Completes the payment for an order by setting the remaining cost to 0 and ensuring the status is 'approved'.

## Drivers Management

### List Drivers

- **Endpoint:** `GET /admin/drivers`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Daftar driver berhasil dimuat",
    "data": [
      {
        "id": 1,
        "name": "Driver 1",
        "phone": "087654321098",
        "address": "Driver Address",
        "license_type": ["A", "B"],
        "status": "active",
        "notes": "Driver notes",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ]
  }
  ```
- **Description:**  
  Returns a list of all drivers.

### Get Driver Details

- **Endpoint:** `GET /admin/drivers/{id}`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Detail driver berhasil dimuat",
    "data": {
      "id": 1,
      "name": "Driver 1",
      "phone": "087654321098",
      "address": "Driver Address",
      "license_type": ["A", "B"],
      "status": "active",
      "notes": "Driver notes",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Returns detailed information about a specific driver.

## Vehicles Management

### List Vehicles

- **Endpoint:** `GET /admin/vehicles`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Daftar armada berhasil dimuat",
    "data": [
      {
        "id": 1,
        "name": "Bus 001",
        "license_plate": "AB 1234 CD",
        "type": "ISUZU ELF LONG",
        "capacity": 20,
        "facilities": ["AC", "TV", "WiFi"],
        "status": "ready",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ]
  }
  ```
- **Description:**  
  Returns a list of all vehicles.

### Get Vehicle Details

- **Endpoint:** `GET /admin/vehicles/{id}`
- **Headers:**
  ```
  Authorization: Bearer {token}
  ```
- **Response:**
  ```json
  {
    "status": "success",
    "message": "Detail armada berhasil dimuat",
    "data": {
      "id": 1,
      "name": "Bus 001",
      "license_plate": "AB 1234 CD",
      "type": "ISUZU ELF LONG",
      "capacity": 20,
      "facilities": ["AC", "TV", "WiFi"],
      "status": "ready",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  }
  ```
- **Description:**  
  Returns detailed information about a specific vehicle.
