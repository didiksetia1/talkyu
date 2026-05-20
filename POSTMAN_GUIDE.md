# 📌 Talkyu API - Postman Testing Guide

## 🚀 Setup Postman

### 1. Import Collection
1. Buka Postman
2. Klik **Import** → pilih file `Talkyu_API.postman_collection.json`
3. Collection sudah siap digunakan

### 2. Setup Environment Variable
1. Klik **Environments** (kiri bawah)
2. Klik **+** atau buat environment baru
3. Tambah variable:
   ```
   Key: token
   Value: (kosong dulu, akan diisi setelah login)
   ```
4. Save environment

---

## 🔐 Testing Flow

### Step 1: Login & Dapatkan Token
**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
  "nim": "12345678",
  "password": "password123"
}
```

**Expected Response:**
```json
{
  "message": "Login berhasil",
  "token": "1|abcd1234xyz...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "nim": "12345678",
    "jurusan": "Teknik Informatika",
    "prodi": "S1",
    "role": "user"
  }
}
```

**Cara copy token:**
1. Klik tab **Tests** di request login
2. Paste script ini:
```javascript
if (pm.response.code === 200) {
    pm.environment.set("token", pm.response.json().token);
}
```
3. Send request → token otomatis tersimpan di environment variable `{{token}}`

---

### Step 2: Test Agenda API

#### 2.1 List Semua Agenda
**Endpoint:** `GET /api/agenda`

**Headers:**
```
Authorization: Bearer {{token}}
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Rapat Koordinasi",
      "category": "Kalender & Agenda Akademik",
      "content": "Rapat koordinasi dosen...",
      "image_url": null,
      "image_path": null,
      "comments_count": 5,
      "likes_count": 12,
      "created_at": "2026-05-03T15:31:54.000000Z",
      "updated_at": "2026-05-03T15:31:54.000000Z"
    }
  ]
}
```

---

#### 2.2 Get Agenda Detail
**Endpoint:** `GET /api/agenda/1`

**Headers:**
```
Authorization: Bearer {{token}}
```

---

#### 2.3 Tambah Komentar
**Endpoint:** `POST /api/agenda/1/comment`

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

**Body:**
```json
{
  "content": "Agenda ini keren!"
}
```

---

#### 2.4 Like Agenda
**Endpoint:** `POST /api/agenda/1/like`

**Headers:**
```
Authorization: Bearer {{token}}
```

---

### Step 3: Test Aduan API

#### 3.1 Buat Aduan
**Endpoint:** `POST /api/aduan`

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: multipart/form-data
```

**Body (Form Data):**
- `kategori`: Fasilitas
- `judul`: AC Rusak
- `deskripsi`: AC di ruang 301 tidak berfungsi
- `gambar`: (upload file gambar - optional)

**Response:**
```json
{
  "message": "Aduan berhasil dikirim.",
  "data": {
    "id": 1,
    "user_id": 1,
    "kategori": "Fasilitas",
    "judul": "AC Rusak",
    "deskripsi": "AC di ruang 301 tidak berfungsi",
    "gambar": "aduans/abc123.jpg",
    "status": "dibuka",
    "created_at": "2026-05-03T15:31:54.000000Z"
  }
}
```

---

#### 3.2 Get Riwayat Aduan
**Endpoint:** `GET /api/aduan/history`

**Headers:**
```
Authorization: Bearer {{token}}
```

---

#### 3.3 Get Detail Aduan
**Endpoint:** `GET /api/aduan/1`

**Headers:**
```
Authorization: Bearer {{token}}
```

---

### Step 4: Test Aspirasi API

#### 4.1 Get Active Events
**Endpoint:** `GET /api/aspirasi/events`

**Headers:**
```
Authorization: Bearer {{token}}
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Form Aspirasi 2026",
      "description": "Aspirasi mahasiswa untuk perbaikan fasilitas",
      "is_active": true,
      "created_at": "2026-05-03T15:31:54.000000Z"
    }
  ]
}
```

---

#### 4.2 List Semua Aspirasi
**Endpoint:** `GET /api/aspirasi?q=lab&status=submitted`

**Query Parameters:**
- `q`: search keyword (opsional)
- `status`: filter status (opsional)

**Headers:**
```
Authorization: Bearer {{token}}
```

---

#### 4.3 Get Detail Aspirasi
**Endpoint:** `GET /api/aspirasi/1`

**Headers:**
```
Authorization: Bearer {{token}}
```

---

#### 4.4 Buat Aspirasi
**Endpoint:** `POST /api/aspirasi/1`

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: multipart/form-data
```

**Body (Form Data):**
- `judul`: Tambah Lab Komputer
- `kategori`: fasilitas
- `deskripsi`: Laboratorium komputer perlu ditambah
- `tujuan_manfaat`: Meningkatkan efisiensi pembelajaran
- `anonim`: false
- `lampiran`: (file - opsional)

---

#### 4.5 Vote Aspirasi
**Endpoint:** `POST /api/aspirasi/1/vote`

**Headers:**
```
Authorization: Bearer {{token}}
```

**Response:**
```json
{
  "message": "Vote ditambahkan.",
  "voted": true
}
```

Panggil lagi untuk remove vote.

---

#### 4.6 Komentar Aspirasi
**Endpoint:** `POST /api/aspirasi/1/comment`

**Headers:**
```
Authorization: Bearer {{token}}
Content-Type: application/json
```

**Body:**
```json
{
  "comment": "Setuju dengan aspirasi ini!"
}
```

---

## 📝 Kategori Aspirasi

Valid kategori untuk aspirasi:
- `akademik` - Akademik
- `fasilitas` - Fasilitas
- `kesejahteraan` - Kesejahteraan Mahasiswa
- `kegiatan` - Kegiatan
- `lingkungan` - Lingkungan Kampus
- `teknologi` - Teknologi & Sistem
- `lainnya` - Lainnya

---

## ⚠️ Catatan

1. **Token Expiration**: Token tidak akan expire (kecuali di revoke)
2. **File Upload**: Gunakan `multipart/form-data` untuk upload file
3. **Authorization**: Semua endpoint (kecuali login) memerlukan Bearer token
4. **Base URL**: http://127.0.0.1:8000

---

## 🔍 Testing Tips di Postman

### Auto-set Token setelah Login
1. Buka request Login
2. Ke tab **Tests**
3. Paste:
```javascript
if (pm.response.code === 200) {
    pm.environment.set("token", pm.response.json().token);
}
```

### Run Collection Otomatis
1. Klik tombol **Run** di collection
2. Pilih urutan request
3. Klik **Run Talkyu API**

---

## ✅ Status Code

| Code | Meaning |
|------|---------|
| 200 | OK - Request berhasil |
| 201 | Created - Data berhasil dibuat |
| 400 | Bad Request - Data tidak valid |
| 401 | Unauthorized - Token tidak valid/expired |
| 404 | Not Found - Data tidak ditemukan |
| 422 | Unprocessable Entity - Validasi error |
| 500 | Server Error |

