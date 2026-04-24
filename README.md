<div align="center">

<!-- Animated Header -->
<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=6,11,20&height=200&section=header&text=⚡%20SnapFit&fontSize=80&fontAlignY=35&desc=Creative%20Economy%20Hub%20•%20UMKM%20Kreatif%20Malang&descSize=18&descAlignY=55&animation=twinkling&fontColor=ffffff" width="100%" />

<!-- Badges -->
<p>
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white" alt="Vue.js" />
  <img src="https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS" />
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Midtrans-Payment-0091EA?style=for-the-badge&logo=stripe&logoColor=white" alt="Midtrans" />
</p>

<p>
  <img src="https://img.shields.io/badge/API_Endpoints-52-blueviolet?style=flat-square" alt="Endpoints" />
  <img src="https://img.shields.io/badge/Database_Tables-11-success?style=flat-square" alt="Tables" />
  <img src="https://img.shields.io/badge/Controllers-12-orange?style=flat-square" alt="Controllers" />
  <img src="https://img.shields.io/badge/License-MIT-blue?style=flat-square" alt="License" />
</p>

<br />

> **🏆 INTERCOMP 2026 — Sub-Tema: Creative Economy Hub**
>
> Platform web yang membantu UMKM kreatif Malang (batik, kerajinan, fashion, kuliner) untuk meningkatkan kualitas produk dan pemasaran melalui teknologi digital.

<br />

</div>

---

## 🎯 Apa itu SnapFit?

**SnapFit** bukan marketplace biasa. Platform ini menggabungkan **kolaborasi UMKM × Desainer** dengan fitur teknologi modern untuk mendorong ekonomi kreatif Malang.

<div align="center">

| 🤖 AI Product Studio | 📱 Web AR Try-On | 🎨 Realtime Co-Create |
|:---:|:---:|:---:|
| Upload foto produk HP → AI hasilkan foto studio profesional & caption marketing | Pembeli coba produk langsung di kamera HP, tanpa install aplikasi | UMKM & desainer kolaborasi desain produk secara realtime |

</div>

---

## ✨ Fitur Lengkap

<table>
  <tr>
    <td width="50%">
      <h3>🛍️ Marketplace UMKM</h3>
      <ul>
        <li>Browse produk tanpa login</li>
        <li>Filter kategori, harga, search</li>
        <li>Sorting by terbaru, harga, views</li>
        <li>Pagination otomatis</li>
        <li>Detail produk + view counter</li>
      </ul>
    </td>
    <td width="50%">
      <h3>⭐ Rating & Ulasan</h3>
      <ul>
        <li>Review hanya setelah beli & terima produk</li>
        <li>Rating 1-5 bintang + komentar</li>
        <li>Summary distribusi bintang</li>
        <li>Denormalized avg_rating (performa tinggi)</li>
        <li>Edit/hapus review milik sendiri</li>
      </ul>
    </td>
  </tr>
  <tr>
    <td>
      <h3>💳 Pembayaran Midtrans</h3>
      <ul>
        <li>Snap Token API (popup payment)</li>
        <li>Webhook otomatis (signature verified)</li>
        <li>Status tracking realtime</li>
        <li>Notifikasi otomatis saat bayar berhasil</li>
      </ul>
    </td>
    <td>
      <h3>❤️ Wishlist</h3>
      <ul>
        <li>Toggle wishlist (add/remove)</li>
        <li>Cek status wishlist per produk</li>
        <li>List semua wishlist</li>
        <li>Clear all wishlist</li>
      </ul>
    </td>
  </tr>
  <tr>
    <td>
      <h3>🤖 AI Product Studio</h3>
      <ul>
        <li>Upload foto original dari HP</li>
        <li>Simpan hasil generasi AI</li>
        <li>Riwayat semua generasi</li>
      </ul>
    </td>
    <td>
      <h3>🎨 Co-Create Room</h3>
      <ul>
        <li>Buat room kolaborasi UMKM × Desainer</li>
        <li>Join room yang aktif</li>
        <li>Tutup room saat selesai</li>
        <li>List partisipan realtime</li>
      </ul>
    </td>
  </tr>
  <tr>
    <td>
      <h3>📤 Upload Multi-Format</h3>
      <ul>
        <li>Foto produk (JPG/PNG/WebP, max 5MB)</li>
        <li>Avatar profil (max 2MB)</li>
        <li>Foto AI source (max 10MB)</li>
        <li>Model AR .glb/.gltf (max 50MB)</li>
      </ul>
    </td>
    <td>
      <h3>🔐 Multi-Role Authentication</h3>
      <ul>
        <li>4 role: Admin, UMKM, Desainer, Pembeli</li>
        <li>Sanctum token-based auth</li>
        <li>Forgot & reset password via email</li>
        <li>Change password saat login</li>
      </ul>
    </td>
  </tr>
</table>

---

## 🏗️ Arsitektur

```
┌─────────────────────────────────────────────────────┐
│                    Frontend (Vue 3)                  │
│              TailwindCSS 4 + Vite                    │
└────────────────────────┬────────────────────────────┘
                         │ REST API (JSON)
                         ▼
┌─────────────────────────────────────────────────────┐
│                  Backend (Laravel 13)                 │
│                                                      │
│  ┌──────────┐ ┌────────────┐ ┌───────────────────┐  │
│  │   Auth   │ │ Middleware │ │  Form Requests    │  │
│  │ Sanctum  │ │   Role     │ │  (Validation)     │  │
│  └──────────┘ └────────────┘ └───────────────────┘  │
│                                                      │
│  ┌──────────────────────────────────────────────┐   │
│  │            12 Controllers                     │   │
│  │  Auth · Profile · Product · Order · Payment   │   │
│  │  Review · Wishlist · Upload · CoCreate        │   │
│  │  AI Generation · Notification · Admin         │   │
│  └──────────────────────────────────────────────┘   │
│                                                      │
│  ┌──────────┐ ┌────────────┐ ┌───────────────────┐  │
│  │  Models  │ │  Resources │ │   Services        │  │
│  │  (10)    │ │   (JSON)   │ │  (Midtrans)       │  │
│  └──────────┘ └────────────┘ └───────────────────┘  │
└────────────────────────┬────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│              MySQL (11 Tables)                       │
│  users · profiles · products · orders · order_items  │
│  reviews · wishlists · cocreate_rooms                │
│  room_participants · ai_generations · notifications  │
└─────────────────────────────────────────────────────┘
```

---

## 📡 API Endpoints (52 Total)

### 🔓 Public (Tanpa Login)

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/api/v1/auth/register` | Daftar akun baru (UMKM/Desainer) |
| `POST` | `/api/v1/auth/login` | Login |
| `POST` | `/api/v1/auth/forgot-password` | Kirim link reset password |
| `POST` | `/api/v1/auth/reset-password` | Reset password via token |
| `GET` | `/api/v1/products` | Browse marketplace (filter, search, sort) |
| `GET` | `/api/v1/products/{id}` | Detail produk |
| `GET` | `/api/v1/products/{id}/reviews` | Ulasan produk |
| `POST` | `/api/v1/payment/webhook` | Midtrans webhook callback |

### 🔐 Authenticated (Semua Role)

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/api/v1/auth/logout` | Logout |
| `GET` | `/api/v1/auth/me` | Data user login |
| `POST` | `/api/v1/auth/change-password` | Ganti password |
| `GET` | `/api/v1/profile` | Lihat profil |
| `PUT` | `/api/v1/profile` | Update profil |
| `POST` | `/api/v1/upload/avatar` | Upload foto profil |
| `POST` | `/api/v1/upload/product-image` | Upload foto produk |
| `POST` | `/api/v1/upload/ai-source` | Upload foto AI Studio |
| `POST` | `/api/v1/upload/ar-model` | Upload model AR (.glb) |
| `GET` | `/api/v1/wishlist` | List wishlist |
| `POST` | `/api/v1/wishlist/{id}/toggle` | Toggle wishlist |
| `GET` | `/api/v1/wishlist/{id}/check` | Cek status wishlist |
| `DELETE` | `/api/v1/wishlist/clear` | Hapus semua wishlist |
| `GET` | `/api/v1/notifications` | List notifikasi |
| `PATCH` | `/api/v1/notifications/{id}/read` | Tandai dibaca |
| `PATCH` | `/api/v1/notifications/read-all` | Tandai semua dibaca |
| `POST` | `/api/v1/payment/orders/{id}/snap-token` | Buat Snap Token Midtrans |
| `GET` | `/api/v1/payment/orders/{id}/status` | Cek status pembayaran |

### 🏪 UMKM Only

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/api/v1/umkm/products` | Produk milik saya |
| `POST` | `/api/v1/umkm/products` | Buat produk baru |
| `PUT` | `/api/v1/umkm/products/{id}` | Edit produk |
| `DELETE` | `/api/v1/umkm/products/{id}` | Hapus produk |
| `PATCH` | `/api/v1/umkm/products/{id}/publish` | Toggle publish/draft |
| `GET` | `/api/v1/umkm/ai-generations` | Riwayat AI Studio |
| `POST` | `/api/v1/umkm/ai-generations` | Simpan hasil AI |
| `DELETE` | `/api/v1/umkm/ai-generations/{id}` | Hapus riwayat AI |

### 🎨 UMKM + Desainer

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/api/v1/cocreate/rooms` | List room aktif |
| `GET` | `/api/v1/cocreate/rooms/{id}` | Detail room |
| `POST` | `/api/v1/cocreate/rooms` | Buat room baru |
| `POST` | `/api/v1/cocreate/rooms/{id}/join` | Bergabung ke room |
| `PATCH` | `/api/v1/cocreate/rooms/{id}/close` | Tutup room |

### 🛒 Orders (Semua Role)

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/api/v1/orders` | Riwayat order saya |
| `GET` | `/api/v1/orders/{id}` | Detail order |
| `POST` | `/api/v1/orders` | Checkout (buat order) |

### ⭐ Reviews (Authenticated)

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/api/v1/products/{id}/reviews` | Buat ulasan (wajib sudah beli) |
| `PUT` | `/api/v1/products/{id}/reviews/{reviewId}` | Edit ulasan |
| `DELETE` | `/api/v1/products/{id}/reviews/{reviewId}` | Hapus ulasan |

### 🛡️ Admin Only

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/api/v1/admin/stats` | Dashboard analytics |
| `GET` | `/api/v1/admin/users` | Kelola user |
| `GET` | `/api/v1/admin/orders` | Semua order |
| `GET` | `/api/v1/admin/products` | Semua produk |
| `PATCH` | `/api/v1/admin/orders/{id}/status` | Update status order |
| `DELETE` | `/api/v1/admin/products/{id}` | Hapus produk |
| `DELETE` | `/api/v1/admin/reviews/{id}` | Hapus ulasan |

---

## 🗄️ Database Schema

```
┌───────────────┐     ┌──────────────┐     ┌──────────────────┐
│    users      │────▶│   profiles   │     │    wishlists      │
│               │     └──────────────┘     │  user_id          │
│  id           │                          │  product_id       │
│  name         │────▶┌──────────────┐     └──────────────────┘
│  email        │     │   products   │
│  password     │     │              │◀────┌──────────────────┐
│  role (enum)  │     │  id          │     │    reviews        │
│               │     │  name        │     │  user_id          │
└───────┬───────┘     │  price       │     │  product_id       │
        │             │  category    │     │  rating (1-5)     │
        │             │  images[]    │     │  comment          │
        │             │  ar_model_url│     └──────────────────┘
        │             │  avg_rating  │
        │             │  reviews_cnt │
        │             └──────┬───────┘
        │                    │
        ▼                    ▼
┌──────────────┐     ┌──────────────┐     ┌──────────────────┐
│   orders     │────▶│ order_items  │     │  ai_generations   │
│  buyer_id    │     │  order_id    │     │  user_id          │
│  total       │     │  product_id  │     │  original_image   │
│  status      │     │  quantity    │     │  generated_images │
│  midtrans_id │     │  price       │     │  prompt           │
└──────────────┘     └──────────────┘     └──────────────────┘

┌──────────────────┐     ┌────────────────────┐
│ cocreate_rooms   │────▶│ room_participants  │
│  creator_id      │     │  room_id           │
│  name            │     │  user_id           │
│  status          │     │  joined_at         │
└──────────────────┘     └────────────────────┘

┌──────────────────┐
│  notifications   │
│  user_id         │
│  title           │
│  message         │
│  is_read         │
└──────────────────┘
```

---

## 🚀 Getting Started

### Prerequisites

- **PHP** ≥ 8.3
- **Composer** ≥ 2.x
- **Node.js** ≥ 18.x
- **MySQL** ≥ 8.0

### Installation

```bash
# 1. Clone repository
git clone https://github.com/Adidtiasmara/SnapFit.git
cd SnapFit

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=snapfit
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migration + seed data demo
php artisan migrate --seed
php artisan storage:link

# 6. Jalankan server
php artisan serve        # Backend → http://localhost:8000
npm run dev              # Frontend → http://localhost:5173
```

### 🔑 Midtrans Setup

1. Daftar di [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com)
2. Ambil **Server Key** dan **Client Key**
3. Isi di `.env`:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxx
```

---

## 👥 Demo Credentials

| Role | Email | Password |
|:----:|:-----:|:--------:|
| 🛡️ Admin | `admin@snapfit.id` | `password` |
| 🏪 UMKM | `sari@snapfit.id` | `password` |
| 🏪 UMKM | `budi@snapfit.id` | `password` |
| 🎨 Desainer | `reza@snapfit.id` | `password` |
| 🛒 Pembeli | `pembeli@snapfit.id` | `password` |

---

## 📂 Struktur Project

```
snapfit/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # 12 controllers
│   │   │   ├── Auth/          # AuthController, PasswordResetController
│   │   │   ├── Admin/         # AdminDashboardController
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── ReviewController.php
│   │   │   ├── WishlistController.php
│   │   │   ├── UploadController.php
│   │   │   ├── CocreateRoomController.php
│   │   │   ├── AiGenerationController.php
│   │   │   ├── NotificationController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/        # RoleMiddleware
│   │   ├── Requests/          # 7 Form Requests
│   │   └── Resources/        # 6 API Resources
│   ├── Models/                # 10 Eloquent models
│   └── Services/              # MidtransService
├── config/
│   ├── cors.php               # CORS configuration
│   └── midtrans.php           # Midtrans configuration
├── database/
│   ├── migrations/            # 4 migration files (11 tables)
│   └── seeders/               # 3 seeders (demo data)
├── routes/
│   ├── api.php                # 52 API endpoints
│   └── web.php                # SPA entry point
└── resources/
    ├── js/                    # Vue 3 frontend
    └── css/                   # TailwindCSS 4
```

---

## 💰 Payment Flow

```
┌──────────┐      ┌──────────┐      ┌──────────┐      ┌──────────┐
│  Pembeli │      │  SnapFit │      │ Midtrans │      │  SnapFit │
│ Frontend │      │  Backend │      │  Server  │      │  Backend │
└────┬─────┘      └────┬─────┘      └────┬─────┘      └────┬─────┘
     │                  │                  │                  │
     │ POST /orders     │                  │                  │
     │─────────────────▶│ Buat order       │                  │
     │                  │ (status:pending) │                  │
     │                  │                  │                  │
     │ POST /snap-token │                  │                  │
     │─────────────────▶│ Request token    │                  │
     │                  │─────────────────▶│                  │
     │                  │◀─────────────────│                  │
     │◀─────────────────│ Return token     │                  │
     │                  │                  │                  │
     │ Tampilkan popup  │                  │                  │
     │ Midtrans Snap    │                  │                  │
     │─────────────────────────────────────▶│                  │
     │                  │                  │                  │
     │                  │                  │ POST /webhook    │
     │                  │                  │─────────────────▶│
     │                  │                  │                  │ Verify signature
     │                  │                  │                  │ Update status → paid
     │                  │                  │                  │ Kirim notifikasi
     │                  │                  │◀─────────────────│
     │                  │                  │                  │
     │ GET /status      │                  │                  │
     │─────────────────▶│ Return: paid ✅  │                  │
     │◀─────────────────│                  │                  │
```

---

## 🛠️ Tech Stack

<div align="center">

| Layer | Teknologi |
|:-----:|:---------:|
| **Backend** | ![Laravel](https://img.shields.io/badge/Laravel_13-FF2D20?style=flat-square&logo=laravel&logoColor=white) ![PHP](https://img.shields.io/badge/PHP_8.3-777BB4?style=flat-square&logo=php&logoColor=white) |
| **Frontend** | ![Vue.js](https://img.shields.io/badge/Vue_3-4FC08D?style=flat-square&logo=vuedotjs&logoColor=white) ![TailwindCSS](https://img.shields.io/badge/Tailwind_4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white) |
| **Database** | ![MySQL](https://img.shields.io/badge/MySQL_8-4479A1?style=flat-square&logo=mysql&logoColor=white) |
| **Auth** | ![Sanctum](https://img.shields.io/badge/Sanctum-FF2D20?style=flat-square&logo=laravel&logoColor=white) |
| **Payment** | ![Midtrans](https://img.shields.io/badge/Midtrans-0091EA?style=flat-square&logo=stripe&logoColor=white) |
| **Build** | ![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat-square&logo=vite&logoColor=white) |

</div>

---

## 👨‍💻 Tim Pengembang

<div align="center">

**INTERCOMP 2026 — Creative Economy Hub**

*Platform kolaborasi UMKM Kreatif Malang*

---

<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=6,11,20&height=100&section=footer&animation=twinkling" width="100%" />

</div>
