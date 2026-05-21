# Rafi Al Amien Akbar — Portfolio Monorepo

> Portfolio interaktif dengan smooth scroll, dibangun dari nol dengan Admin Panel kustom tersembunyi.

**Stack**

- **Frontend**: Nuxt 4 (compat mode di Nuxt 3.13+), Composition API, TailwindCSS, GSAP, Lenis, Pinia
- **Backend**: Laravel 11 (Headless REST API), Sanctum auth
- **Database**: PostgreSQL
- **Hosting**: Vercel (FE) + Railway (BE + Postgres)

> 🚀 **Mau langsung deploy?** Baca **[DEPLOY.md](./DEPLOY.md)** — panduan 5 langkah copy-paste.
> Atau jalankan `./deploy.sh` untuk script otomatis yang menyiapkan everything.

---

## 🔐 Tentang Admin Panel

Admin panel **tidak ditampilkan** di UI publik mana pun — tidak ada link di navigasi, footer, atau halaman manapun. HR atau visitor yang mengunjungi portofolio Anda hanya akan melihat halaman publik biasa.

Untuk mengakses admin (hanya Anda yang tahu):

```
https://your-portfolio.vercel.app/admin/login
```

`robots.txt` juga sudah set `Disallow: /admin` agar tidak ter-index oleh search engine.

---

## 📁 Struktur

```
portfolio-rafi/
├── backend/        # Laravel 11 API
└── frontend/       # Nuxt 4 SPA + Admin Panel
```

---

## 🚀 Quick Start — Local Development

### Prasyarat

- PHP 8.2+ dengan ekstensi `pdo_pgsql`
- Composer 2.x
- Node.js 20+ & npm
- PostgreSQL 14+

### 1. Backend (Laravel)

```bash
cd backend

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Edit .env — sesuaikan kredensial PostgreSQL
# DB_DATABASE=portfolio_rafi
# DB_USERNAME=postgres
# DB_PASSWORD=your_password

# Buat database
createdb portfolio_rafi
# atau via psql:
#   psql -U postgres -c "CREATE DATABASE portfolio_rafi;"

# Migrate & seed (sudah berisi data Rafi + 9 proyek GTK)
php artisan migrate --seed

# Jalankan dev server
php artisan serve
# → http://localhost:8000
```

**Default admin credentials** (ubah segera!):

- Email: `rafialamienakbar27@gmail.com`
- Password: `password`

### 2. Frontend (Nuxt)

```bash
cd frontend

# Install
npm install

# Setup environment
cp .env.example .env
# Edit jika perlu — default sudah pointing ke localhost:8000

# Run dev
npm run dev
# → http://localhost:3000
```

Akses:

- **Public site**: http://localhost:3000
- **Admin login**: http://localhost:3000/admin/login

---

## 🎨 Design System

| Token        | Value                         |
| ------------ | ----------------------------- |
| Background   | `#0A0A0F` (ink-900)           |
| Text         | `#F2F1EA` (bone-100)          |
| Accent       | `#FF6A3D` (ember)             |
| Display font | **Fraunces** (variable serif) |
| Body font    | **Inter Tight**               |
| Mono font    | **JetBrains Mono**            |

Tema dark editorial dengan accent amber. Diinspirasi blend dari Brittany Chiang (typography editorial + mono-accent) dan Dennis Snellenberg (motion playfulness + bold display).

---

## 🧩 Fitur

### Public (Frontend)

- ✅ Hero atraktif — staggered text reveal dengan GSAP, magnetic cursor, noise overlay
- ✅ About + skills (kategorized)
- ✅ Experience timeline dengan scroll reveal
- ✅ 9 project cards grid + halaman detail per-project
- ✅ Tombol **Download CV** di Hero + Nav (URL terikat ke DB, bukan hardcode!)
- ✅ Contact section dengan socials (GitHub, LinkedIn, Instagram)
- ✅ **Lenis smooth scroll** terintegrasi penuh dengan **GSAP ScrollTrigger**
- ✅ Page transitions, marquee, big-text scroll-driven effects
- ✅ Mobile-first responsive, prefers-reduced-motion safe

### Admin Panel (CMS)

- ✅ Login secure (Sanctum token, 7 hari)
- ✅ Dashboard dengan stats
- ✅ CRUD **Projects** (judul, slug, deskripsi, cover, tech stack, featured/published, urutan)
- ✅ CRUD **Experiences** (perusahaan, role, tanggal, deskripsi, tech)
- ✅ Edit **Profile** singleton (bio, **CV URL — bisa diupdate kapan saja**, socials, skills)
- ✅ Auto-redirect ke login bila token kedaluwarsa

---

## 🔌 API Endpoints

### Public (no auth)

| Method | Endpoint                      | Deskripsi                         |
| ------ | ----------------------------- | --------------------------------- |
| GET    | `/api/public/bootstrap`       | Agregat: profile + exp + projects |
| GET    | `/api/public/profile`         | Singleton profile                 |
| GET    | `/api/public/experiences`     | Published experiences             |
| GET    | `/api/public/projects`        | Published projects                |
| GET    | `/api/public/projects/{slug}` | Detail proyek                     |

### Auth

| Method | Endpoint           |
| ------ | ------------------ |
| POST   | `/api/auth/login`  |
| POST   | `/api/auth/logout` |
| GET    | `/api/auth/me`     |

### Admin (Bearer token)

| Method  | Endpoint                        |
| ------- | ------------------------------- |
| GET/PUT | `/api/admin/profile`            |
| ALL     | `/api/admin/experiences[/{id}]` |
| ALL     | `/api/admin/projects[/{id}]`    |

---

## 🌐 Deployment

### Backend → Railway

1. Push backend folder ke repo GitHub
2. **railway.app** → New Project → Deploy from GitHub
3. Tambahkan **PostgreSQL plugin** dari Railway
4. Set environment variables di Railway:

   ```
   APP_KEY=base64:...           # generate dengan: php artisan key:generate --show
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://YOUR_APP.up.railway.app

   DB_CONNECTION=pgsql
   DB_HOST=${{Postgres.PGHOST}}
   DB_PORT=${{Postgres.PGPORT}}
   DB_DATABASE=${{Postgres.PGDATABASE}}
   DB_USERNAME=${{Postgres.PGUSER}}
   DB_PASSWORD=${{Postgres.PGPASSWORD}}

   FRONTEND_URL=https://your-portfolio.vercel.app
   SANCTUM_STATEFUL_DOMAINS=your-portfolio.vercel.app

   RUN_SEEDER=true   # only first deploy!
   ```

5. Railway akan auto-build pakai `Dockerfile`. Migrasi otomatis di entrypoint.
6. Hapus `RUN_SEEDER` setelah deploy pertama.

### Frontend → Vercel

1. Push frontend folder ke repo GitHub
2. **vercel.com** → Import Project
3. Framework preset: **Nuxt**
4. Environment Variables:
   ```
   NUXT_PUBLIC_API_BASE=https://YOUR_BACKEND.up.railway.app/api
   ```
5. Deploy. Vercel akan otomatis re-deploy setiap push ke main.

### Update CORS setelah deploy

Di backend `.env` (Railway), set:

```
FRONTEND_URL=https://your-portfolio.vercel.app
```

Lalu redeploy.

---

## 🔒 Security Checklist (Production)

- [ ] Ganti password admin default (login → admin/profile harusnya juga ada change-password — TODO)
- [ ] Set `APP_DEBUG=false` di production
- [ ] `APP_KEY` unik dan disimpan aman
- [ ] HTTPS aktif di Railway & Vercel (otomatis)
- [ ] CORS hanya izinkan domain frontend production
- [ ] Hapus `RUN_SEEDER=true` setelah seed pertama agar tidak overwrite

---

## 🛠 Customization

### Mengganti URL CV

Login admin → **Profile** → ubah field **CV URL** → Save.  
Tombol Download CV di hero & nav langsung mengikuti.

### Menambah proyek

Login admin → **Projects** → **+ New project**.  
Centang **Featured** untuk badge di card, atur **Order** untuk urutan.

### Mengubah tema warna

Edit `frontend/tailwind.config.js` → palette `ink`, `bone`, `ember`.

---

## 🐛 Troubleshooting

| Masalah                           | Solusi                                                                  |
| --------------------------------- | ----------------------------------------------------------------------- |
| CORS error di frontend            | Pastikan `FRONTEND_URL` di backend `.env` cocok dengan URL aktual Nuxt  |
| 401 di admin                      | Token expired (7 hari). Login ulang.                                    |
| Migrasi gagal connect ke Postgres | Cek kredensial DB & pastikan database sudah dibuat                      |
| Smooth scroll tidak jalan         | Lenis hanya aktif di client. Cek bahwa `lenis.client.ts` ada di plugins |
| Animasi GSAP tidak trigger        | Cek bahwa ScrollTrigger di-register di `lenis.client.ts`                |

---

## 📝 Catatan tentang Nuxt 4

Nuxt 4 (stable) saat ini di-roll out via opsi compat di Nuxt 3.13+:

```ts
future: {
  compatibilityVersion: 4;
}
```

Struktur file di proyek ini sudah mengikuti tata letak Nuxt 4 (folder `app/` sebagai source root). Begitu Nuxt 4 stable rilis, cukup `npm i nuxt@latest` tanpa perubahan struktur.

---

## 📄 License

MIT — bebas digunakan & dimodifikasi.

Built with ❤️ for Rafi Al Amien Akbar.
