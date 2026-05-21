#!/usr/bin/env bash
# =============================================================================
# Portfolio Deploy Helper
# Mempersiapkan repo Anda untuk push ke GitHub → deploy ke Railway + Vercel
# =============================================================================
set -e

BOLD='\033[1m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
NC='\033[0m'

print_step() { echo -e "\n${CYAN}${BOLD}▶ $1${NC}"; }
print_ok()   { echo -e "${GREEN}✓ $1${NC}"; }
print_warn() { echo -e "${YELLOW}⚠ $1${NC}"; }
print_err()  { echo -e "${RED}✗ $1${NC}"; }
ask() { read -p "$(echo -e "${YELLOW}? $1 ${NC}")" REPLY; echo "$REPLY"; }

clear
echo -e "${BOLD}╔════════════════════════════════════════════════════╗${NC}"
echo -e "${BOLD}║   Portfolio Rafi — Deploy Helper                  ║${NC}"
echo -e "${BOLD}║   Vercel (Frontend) + Railway (Backend + DB)      ║${NC}"
echo -e "${BOLD}╚════════════════════════════════════════════════════╝${NC}"

# ----------------------------------------------------------------------------
# 1. Cek prerequisites
# ----------------------------------------------------------------------------
print_step "1/5 — Memeriksa prerequisites"

MISSING=()
command -v git >/dev/null 2>&1 || MISSING+=("git")
command -v node >/dev/null 2>&1 || MISSING+=("node")
command -v php >/dev/null 2>&1 || MISSING+=("php")
command -v composer >/dev/null 2>&1 || MISSING+=("composer")

if [ ${#MISSING[@]} -ne 0 ]; then
  print_err "Tools berikut belum terinstall: ${MISSING[*]}"
  echo "Install dulu lalu jalankan script ini lagi."
  exit 1
fi
print_ok "Semua tools tersedia."

# ----------------------------------------------------------------------------
# 2. Generate APP_KEY
# ----------------------------------------------------------------------------
print_step "2/5 — Generate Laravel APP_KEY"

cd backend
if [ ! -d "vendor" ]; then
  echo "Installing composer dependencies (sekali saja, agak lama)..."
  composer install --no-interaction --quiet
fi

if [ ! -f ".env" ]; then
  cp .env.example .env
fi

php artisan key:generate --no-interaction --force
APP_KEY=$(grep "^APP_KEY=" .env | cut -d= -f2-)
print_ok "APP_KEY generated: ${APP_KEY:0:30}..."
echo -e "${YELLOW}  → COPY APP_KEY ini, nanti dipakai di Railway env vars${NC}"
cd ..

# ----------------------------------------------------------------------------
# 3. Test build frontend
# ----------------------------------------------------------------------------
print_step "3/5 — Test build frontend (memastikan tidak ada error)"

cd frontend
if [ ! -d "node_modules" ]; then
  echo "Installing npm dependencies (sekali saja)..."
  npm install --silent
fi

if [ ! -f ".env" ]; then
  cp .env.example .env
fi

echo "Building..."
if npm run build > /tmp/nuxt-build.log 2>&1; then
  print_ok "Frontend build sukses."
else
  print_err "Build gagal. Lihat log di /tmp/nuxt-build.log"
  tail -20 /tmp/nuxt-build.log
  exit 1
fi
cd ..

# ----------------------------------------------------------------------------
# 4. Inisialisasi Git
# ----------------------------------------------------------------------------
print_step "4/5 — Setup Git repository"

if [ ! -d ".git" ]; then
  git init -q
  print_ok "Git initialized."
fi

# Tambahkan .gitignore root
cat > .gitignore <<'EOF'
.DS_Store
*.log
.env
.env.*
!.env.example
.idea/
.vscode/
EOF

git add -A > /dev/null
if git diff --cached --quiet; then
  print_ok "Tidak ada perubahan untuk commit."
else
  git commit -m "chore: prepare for deployment" -q
  print_ok "Commit dibuat."
fi

REMOTE=$(git remote get-url origin 2>/dev/null || echo "")
if [ -z "$REMOTE" ]; then
  echo ""
  print_warn "Belum ada remote GitHub. Buat repo baru di github.com lalu jalankan:"
  echo -e "  ${CYAN}git remote add origin https://github.com/USERNAME/REPO.git${NC}"
  echo -e "  ${CYAN}git branch -M main${NC}"
  echo -e "  ${CYAN}git push -u origin main${NC}"
else
  print_ok "Remote: $REMOTE"
  PUSH=$(ask "Push ke remote sekarang? [y/N]")
  if [[ "$PUSH" =~ ^[Yy]$ ]]; then
    git push -u origin $(git branch --show-current) || true
  fi
fi

# ----------------------------------------------------------------------------
# 5. Tampilkan checklist deployment
# ----------------------------------------------------------------------------
print_step "5/5 — Checklist deployment manual"

cat <<EOF

${BOLD}📋 LANGKAH SELANJUTNYA (dilakukan via browser):${NC}

  ${GREEN}A. BACKEND → Railway${NC} ── https://railway.app/new
     1. New Project → Deploy from GitHub repo
     2. Pilih repo Anda, root directory: ${CYAN}backend${NC}
     3. Add service → PostgreSQL
     4. Buka service backend → Variables → tambahkan:

        ${CYAN}APP_KEY=${APP_KEY}${NC}
        APP_ENV=production
        APP_DEBUG=false
        APP_URL=https://\${{RAILWAY_PUBLIC_DOMAIN}}
        DB_CONNECTION=pgsql
        DB_HOST=\${{Postgres.PGHOST}}
        DB_PORT=\${{Postgres.PGPORT}}
        DB_DATABASE=\${{Postgres.PGDATABASE}}
        DB_USERNAME=\${{Postgres.PGUSER}}
        DB_PASSWORD=\${{Postgres.PGPASSWORD}}
        FRONTEND_URL=https://your-frontend.vercel.app
        RUN_SEEDER=true

     5. Settings → Networking → ${CYAN}Generate Domain${NC}
        ▶ COPY URL backend (misal: https://xxx.up.railway.app)

  ${GREEN}B. FRONTEND → Vercel${NC} ── https://vercel.com/new
     1. Import Project dari GitHub repo
     2. Root directory: ${CYAN}frontend${NC}
     3. Framework: Nuxt (auto-detect)
     4. Environment Variables → tambahkan:

        NUXT_PUBLIC_API_BASE=https://xxx.up.railway.app/api

     5. Deploy
        ▶ COPY URL Vercel (misal: https://your-portfolio.vercel.app)

  ${GREEN}C. UPDATE CORS di Railway${NC}
     Kembali ke Railway → Variables, ubah:
        FRONTEND_URL=https://your-portfolio.vercel.app
     Hapus RUN_SEEDER (set false atau hapus).
     Restart service.

  ${GREEN}D. SELESAI 🎉${NC}
     Buka: ${CYAN}https://your-portfolio.vercel.app${NC}
     Admin: ${CYAN}https://your-portfolio.vercel.app/admin/login${NC}

     ⚠️  GANTI password admin default segera!
        Login → tidak ada UI ganti password di v1, ganti via Tinker:
        ${CYAN}railway run php artisan tinker${NC}
        > User::first()->update(['password' => Hash::make('YOUR_STRONG_PASSWORD')])

EOF

print_ok "Script selesai. Ikuti checklist di atas."
