# 🚀 Panduan Deploy — 5 Langkah ke Production

Total waktu: **±30 menit**. Hasil akhir: portofolio Anda live di URL publik gratis.

> Saya **tidak bisa mendeploy untuk Anda** karena butuh login akun pribadi Anda. Tapi script `deploy.sh` sudah menyiapkan 80% pekerjaan. Anda tinggal klik-klik di browser untuk 20% sisanya.

---

## 📋 Sebelum mulai

Akun yang perlu Anda punya (semua gratis):
- [ ] [GitHub](https://github.com/signup) — untuk hosting source code
- [ ] [Railway](https://railway.app/) — hosting backend Laravel + PostgreSQL (free trial $5)
- [ ] [Vercel](https://vercel.com/signup) — hosting frontend Nuxt (free forever)

Software yang harus terinstall di komputer Anda:
- [ ] Git
- [ ] Node.js 20+
- [ ] PHP 8.2+ dan Composer

---

## ⚡ LANGKAH 1 — Jalankan script otomatis

Di terminal, buka folder hasil unzip lalu jalankan:

```bash
cd portfolio-rafi
./deploy.sh
```

Script akan:
- ✅ Validasi semua tool terinstall
- ✅ Generate `APP_KEY` Laravel yang aman
- ✅ Install dependencies & test build frontend
- ✅ Inisialisasi Git
- ✅ **COPY `APP_KEY`** yang muncul — Anda butuhkan di langkah 3

---

## ⚡ LANGKAH 2 — Push ke GitHub

Di browser:
1. Buka https://github.com/new
2. Repository name: `portfolio-rafi` (atau apapun)
3. **Public** atau Private (terserah)
4. **Jangan** centang "Initialize with README"
5. Create repository

Di terminal:
```bash
git remote add origin https://github.com/USERNAME/portfolio-rafi.git
git branch -M main
git push -u origin main
```

(Ganti `USERNAME` dengan username GitHub Anda)

---

## ⚡ LANGKAH 3 — Deploy Backend ke Railway

1. Buka https://railway.app/new
2. Klik **Deploy from GitHub repo** → pilih repo Anda
3. Saat ditanya root directory, isi: `backend`
4. Tunggu build pertama (akan gagal — ini normal, kita belum set DB)
5. Klik **+ New** di canvas → **Database** → **PostgreSQL**
6. Buka service **backend** Anda → tab **Variables** → klik **Raw Editor** → paste:

```env
APP_KEY=PASTE_APP_KEY_DARI_LANGKAH_1
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

FRONTEND_URL=https://placeholder.vercel.app
SANCTUM_STATEFUL_DOMAINS=placeholder.vercel.app

LOG_CHANNEL=stderr
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

RUN_SEEDER=true
```

7. Klik **Update Variables** → Railway akan auto-redeploy
8. Tab **Settings** → **Networking** → **Generate Domain**
9. **COPY URL backend** Anda — bentuknya: `https://portfolio-rafi-production-XXXX.up.railway.app`

Cek kerja: buka `URL_BACKEND/api/health` di browser. Harus muncul:
```json
{"status":"ok","time":"2026-..."}
```

---

## ⚡ LANGKAH 4 — Deploy Frontend ke Vercel

1. Buka https://vercel.com/new
2. **Import** repo GitHub Anda
3. Root Directory: klik **Edit** → pilih `frontend`
4. Framework Preset: **Nuxt** (auto-detect)
5. Sebelum klik Deploy, expand **Environment Variables**:

   | Name                  | Value                                              |
   | --------------------- | -------------------------------------------------- |
   | `NUXT_PUBLIC_API_BASE` | `https://YOUR-RAILWAY-URL/api`                    |

   (ganti `YOUR-RAILWAY-URL` dengan URL dari langkah 3)

6. **Deploy**
7. Tunggu ~2 menit. **COPY URL Vercel** Anda — bentuknya: `https://portfolio-rafi-xxx.vercel.app`

---

## ⚡ LANGKAH 5 — Sambungkan CORS & finalisasi

Kembali ke **Railway** → service backend → Variables, ubah:

```env
FRONTEND_URL=https://portfolio-rafi-xxx.vercel.app
SANCTUM_STATEFUL_DOMAINS=portfolio-rafi-xxx.vercel.app
RUN_SEEDER=false
```

(ganti dengan URL Vercel asli Anda — **tanpa** trailing slash, **tanpa** `https://` untuk SANCTUM)

Update → Railway redeploy.

### Ganti password admin

Buka terminal di komputer Anda:
```bash
# Install Railway CLI sekali saja
npm install -g @railway/cli
railway login

# Hubungkan project
cd portfolio-rafi
railway link

# Ganti password
railway run --service backend php artisan tinker
```

Di Tinker prompt:
```php
User::first()->update(['password' => Hash::make('PASSWORD_KUAT_ANDA')]);
exit
```

---

## 🎉 SELESAI!

Akses portofolio Anda:
- **Public** → `https://portfolio-rafi-xxx.vercel.app`
- **Admin** → `https://portfolio-rafi-xxx.vercel.app/admin/login`
  (login dengan email Anda + password baru)

---

## 🌐 Custom Domain (Opsional)

### Vercel (untuk URL portofolio)
1. Beli domain (Namecheap, Cloudflare, dsb)
2. Vercel → Project → Settings → Domains → Add `rafi.com`
3. Update DNS sesuai instruksi Vercel
4. Update juga `FRONTEND_URL` & `SANCTUM_STATEFUL_DOMAINS` di Railway

### Railway (untuk API — opsional)
Sebenarnya tidak perlu, karena visitor tidak pernah lihat URL API. Tapi kalau mau:
1. Railway → Settings → Networking → Custom Domain → `api.rafi.com`
2. Update CNAME di DNS provider

---

## 🐛 Troubleshooting

| Gejala                              | Solusi                                                      |
| ----------------------------------- | ----------------------------------------------------------- |
| Frontend tampil tapi data kosong    | Cek Network tab: error CORS? → update `FRONTEND_URL` Railway |
| `502 Bad Gateway` di Railway        | Cek logs Railway. Biasanya migrasi gagal → cek DB env vars  |
| Login admin error "Unauthenticated" | `APP_KEY` Railway tidak cocok dengan yang dipakai saat seed |
| Build Vercel gagal                  | Cek `NUXT_PUBLIC_API_BASE` jangan ada typo                  |
| Smooth scroll tidak jalan di prod   | Vercel auto-strip env? cek deployed env vars di dashboard   |

---

## 💰 Biaya estimasi

- **Vercel**: gratis selamanya untuk personal portfolio
- **Railway**: $5 free credit/bulan, biasanya cukup. Setelah credit habis (~30 hari), ~$5/bulan untuk projek kecil
- **Domain**: opsional, ~Rp 200rb/tahun

Total: **Rp 0** kalau pakai subdomain `.vercel.app`, atau **±Rp 200rb/tahun** kalau pakai custom domain.

Selamat berbangga dengan portofolio production Anda! 🚀
