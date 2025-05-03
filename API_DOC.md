# Dokumentasi API

Seluruh endpoint API berada di bawah prefix `/api`.  
Endpoint yang berada di bawah prefix `/api/admin` memerlukan autentikasi token (Sanctum) dan role admin.

---

## Autentikasi

### 1. Login

-   **Endpoint:** `POST /api/login`
-   **Body:**
    -   `email` (string, required)
    -   `password` (string, required)
-   **Response:**
    -   `user` (data user)
    -   `token` (string, token akses)
-   **Deskripsi:**  
    Login sebagai admin dan mendapatkan token akses.

### 2. Lupa Password

-   **Endpoint:** `POST /api/forgot-password`
-   **Body:**
    -   `email` (string, required)
-   **Response:**
    -   Pesan status
-   **Deskripsi:**  
    Mengirim link reset password ke email admin.

### 3. Reset Password

-   **Endpoint:** `POST /api/reset-password`
-   **Body:**
    -   `token` (string, required)
    -   `email` (string, required)
    -   `password` (string, required, min:8, confirmed)
-   **Response:**
    -   Pesan status
-   **Deskripsi:**  
    Melakukan reset password.

---

## Admin (Autentikasi & Role Admin Diperlukan)

### 1. Profil Pengguna

-   **Endpoint:** `GET /api/admin/profile`
-   **Response:**
    -   Data user
-   **Deskripsi:**  
    Mendapatkan data profil admin yang sedang login.

### 2. Logout

-   **Endpoint:** `POST /api/admin/logout`
-   **Response:**
    -   Pesan status
-   **Deskripsi:**  
    Logout dan mencabut token akses.

---

## Pengelolaan Pesanan

### 1. Daftar Pesanan

-   **Endpoint:** `GET /api/admin/orders`
-   **Response:**
    -   List pesanan
-   **Deskripsi:**  
    Mendapatkan semua data pesanan.

### 2. Detail Pesanan

-   **Endpoint:** `GET /api/admin/orders/{id}`
-   **Response:**
    -   Detail pesanan
-   **Deskripsi:**  
    Mendapatkan detail pesanan berdasarkan ID.

### 3. Buat Pesanan

-   **Endpoint:** `POST /api/admin/orders`
-   **Body:**
    -   Data pesanan (lihat validasi di OrderRequest)
-   **Response:**
    -   Data pesanan baru
-   **Deskripsi:**  
    Membuat pesanan baru.

### 4. Update Pesanan

-   **Endpoint:** `PUT /api/admin/orders/{id}`
-   **Body:**
    -   Data pesanan (lihat validasi di OrderRequest)
-   **Response:**
    -   Data pesanan yang diperbarui
-   **Deskripsi:**  
    Memperbarui data pesanan.

### 5. Hapus Pesanan

-   **Endpoint:** `DELETE /api/admin/orders/{id}`
-   **Response:**
    -   Pesan status
-   **Deskripsi:**  
    Menghapus pesanan.

### 6. Assign Driver ke Pesanan

-   **Endpoint:** `PUT /api/admin/orders/{id}/assign-driver`
-   **Body:**
    -   `driver_id` (integer, required)
-   **Response:**
    -   Data pesanan
-   **Deskripsi:**  
    Menugaskan driver ke pesanan.

### 7. Ubah Status Pesanan

-   **Endpoint:** `PUT /api/admin/orders/{id}/change-status`
-   **Body:**
    -   `status` (string, required, salah satu: waiting, approved, canceled)
-   **Response:**
    -   Data pesanan
-   **Deskripsi:**  
    Mengubah status pesanan.

---

## Pengelolaan Driver

### 1. Daftar Driver

-   **Endpoint:** `GET /api/admin/drivers`
-   **Response:**
    -   List driver
-   **Deskripsi:**  
    Mendapatkan semua data driver.

### 2. Detail Driver

-   **Endpoint:** `GET /api/admin/drivers/{id}`
-   **Response:**
    -   Detail driver
-   **Deskripsi:**  
    Mendapatkan detail driver berdasarkan ID.

### 3. Buat Driver

-   **Endpoint:** `POST /api/admin/drivers`
-   **Body:**
    -   Data driver (lihat validasi di DriverRequest)
-   **Response:**
    -   Data driver baru
-   **Deskripsi:**  
    Membuat driver baru.

### 4. Update Driver

-   **Endpoint:** `PUT /api/admin/drivers/{id}`
-   **Body:**
    -   Data driver (lihat validasi di DriverRequest)
-   **Response:**
    -   Data driver yang diperbarui
-   **Deskripsi:**  
    Memperbarui data driver.

### 5. Hapus Driver

-   **Endpoint:** `DELETE /api/admin/drivers/{id}`
-   **Response:**
    -   Pesan status
-   **Deskripsi:**  
    Menghapus driver.

---

## Pengelolaan Armada Kendaraan

### 1. Daftar Armada

-   **Endpoint:** `GET /api/admin/vehicles`
-   **Response:**
    -   List armada
-   **Deskripsi:**  
    Mendapatkan semua data armada kendaraan.

### 2. Detail Armada

-   **Endpoint:** `GET /api/admin/vehicles/{id}`
-   **Response:**
    -   Detail armada
-   **Deskripsi:**  
    Mendapatkan detail armada berdasarkan ID.

### 3. Buat Armada

-   **Endpoint:** `POST /api/admin/vehicles`
-   **Body:**
    -   Data armada (lihat validasi di VehicleRequest)
-   **Response:**
    -   Data armada baru
-   **Deskripsi:**  
    Membuat armada baru.

### 4. Update Armada

-   **Endpoint:** `PUT /api/admin/vehicles/{id}`
-   **Body:**
    -   Data armada (lihat validasi di VehicleRequest)
-   **Response:**
    -   Data armada yang diperbarui
-   **Deskripsi:**  
    Memperbarui data armada.

### 5. Hapus Armada

-   **Endpoint:** `DELETE /api/admin/vehicles/{id}`
-   **Response:**
    -   Pesan status
-   **Deskripsi:**  
    Menghapus armada.

### 6. Upload Foto Armada

-   **Endpoint:** `POST /api/admin/vehicles/upload-photo`
-   **Body:**
    -   `vehicle_id` (integer, required)
    -   `photo` (file, required, image, max:2MB)
-   **Response:**
    -   Data armada dan media
-   **Deskripsi:**  
    Mengunggah foto armada kendaraan.

---

## Pengelolaan Pembayaran

### 1. Daftar Pembayaran

-   **Endpoint:** `GET /api/admin/payments`
-   **Query Params (opsional):**
    -   `start_date` (YYYY-MM-DD)
    -   `end_date` (YYYY-MM-DD)
    -   `driver_id` (integer)
-   **Response:**
    -   List pembayaran
    -   `total_revenue` (total pendapatan)
    -   `count` (jumlah pembayaran)
-   **Deskripsi:**  
    Mendapatkan daftar pembayaran dari pesanan yang telah selesai, dapat difilter berdasarkan tanggal dan driver.

---

**Catatan:**

-   Semua endpoint di bawah `/api/admin` memerlukan header Authorization: `Bearer {token}`.
-   Untuk detail field pada request, silakan cek file request validation terkait (`OrderRequest`, `DriverRequest`, `VehicleRequest`).
