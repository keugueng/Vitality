# Vitality Inside - Configuration Finale

## ✅ Ce qui est déjà fait

- ✅ **13 migrations** créées et remplies (users, categories, programs, orders, order_items, subscriptions, user_programs, consultations, blog_posts, testimonials, pro_users, patients, patient_protocols, settings)
- ✅ **14 Models Laravel** avec relations complètes
- ✅ **9 Controllers** (PageController, ShopController, CartController, CheckoutController, AuthController, DashboardController, ConsultationController, ProController, AdminController)
- ✅ **Routes complètes** (web.php avec 100+ routes)
- ✅ **5 Layouts Vue.js** (AppLayout, AuthLayout, DashboardLayout, ProLayout, AdminLayout)
- ✅ **40+ Pages Vue.js** complètes
- ✅ **5 Seeders** avec 40+ programmes, témoignages, articles blog
- ✅ **Spatie Laravel Permission** publié
- ✅ **APP_KEY** généré
- ✅ **npm install** terminé

## 🔧 Configuration Base de Données MySQL

### Étape 1: Créer la base de données MySQL

Ouvrez MySQL (via phpMyAdmin, MySQL Workbench, ou ligne de commande) et créez la base de données:

```sql
CREATE DATABASE vitalitylaravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Étape 2: Modifier le fichier `.env`

Ouvrez `c:\Users\Audrey\Desktop\LOGICIELS\vitalitylaravel\.env` et modifiez ces lignes:

```env
APP_NAME="Vitality Inside"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vitalitylaravel
DB_USERNAME=root
DB_PASSWORD=VotreMotDePasseMySQL
```

**Important**: Remplacez `VotreMotDePasseMySQL` par votre mot de passe MySQL réel.

## 🚀 Lancement de l'application

### Étape 3: Exécuter les migrations + seeders

```bash
php artisan migrate:fresh --seed
```

Cette commande va:
- Créer toutes les tables (13 tables + Spatie permissions)
- Créer 3 utilisateurs de test:
  - **Admin**: admin@vitalityinside.com / Vitality2025!
  - **PRO**: pro@vitalityinside.com / ProVitality2025!
  - **User**: demo@vitalityinside.com / Demo2025!
- Créer 6 catégories
- Créer 40+ programmes
- Créer 12 témoignages
- Créer 5 articles de blog

### Étape 4: Compiler les assets frontend

```bash
npm run build
```

### Étape 5: Lancer le serveur de développement

```bash
php artisan serve
```

Le site sera accessible sur: **http://localhost:8000**

## 📋 Pages disponibles

### Pages Publiques
- **Home**: http://localhost:8000
- **Shop**: http://localhost:8000/shop
- **Consultation**: http://localhost:8000/consultation
- **About**: http://localhost:8000/about
- **Blog**: http://localhost:8000/blog

### Authentification
- **Login**: http://localhost:8000/login
- **Register**: http://localhost:8000/register

### Dashboard User
- **Dashboard**: http://localhost:8000/dashboard
- **Profile**: http://localhost:8000/dashboard/profile
- **Orders**: http://localhost:8000/dashboard/orders

### Espace PRO
- **PRO Home**: http://localhost:8000/pro
- **PRO Dashboard**: http://localhost:8000/pro/dashboard

### Panel Admin
- **Admin Dashboard**: http://localhost:8000/admin/dashboard
- **Programs**: http://localhost:8000/admin/programs
- **Categories**: http://localhost:8000/admin/categories
- **Orders**: http://localhost:8000/admin/orders
- **Consultations**: http://localhost:8000/admin/consultations
- **Blog**: http://localhost:8000/admin/blog
- **Testimonials**: http://localhost:8000/admin/testimonials
- **Users**: http://localhost:8000/admin/users
- **Settings**: http://localhost:8000/admin/settings

## 🎨 Stack Technique

- **Backend**: Laravel 10 + Inertia.js
- **Frontend**: Vue 3 + Vite
- **Styling**: Tailwind CSS (couleurs personnalisées Vitality)
- **Database**: MySQL
- **Auth**: Laravel Sanctum + Spatie Laravel Permission
- **Routes**: Ziggy (routes Laravel dans Vue.js)

## 📦 Données de test

### Utilisateurs
- Admin: admin@vitalityinside.com / Vitality2025!
- PRO: pro@vitalityinside.com / ProVitality2025!
- User: demo@vitalityinside.com / Demo2025!

### Programmes
40+ programmes répartis en 6 catégories:
- 🦴 Locomotor (7 programmes)
- 🫁 Digestive (5 programmes)
- 💚 Emotional (7 programmes)
- 👂 ENT & Immunity (6 programmes)
- ⚡ Hormonal (6 programmes)
- 🧠 Neurological (6 programmes)

## 🔄 Commandes utiles

```bash
# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Compiler les assets en mode dev (watch)
npm run dev

# Compiler les assets en mode production
npm run build

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Lancer le serveur
php artisan serve

# Voir les routes
php artisan route:list
```

## ✅ Checklist finale

- [ ] Créer la base de données MySQL `vitalitylaravel`
- [ ] Modifier le `.env` avec vos identifiants MySQL
- [ ] Exécuter `php artisan migrate:fresh --seed`
- [ ] Exécuter `npm run build`
- [ ] Exécuter `php artisan serve`
- [ ] Tester la connexion admin sur http://localhost:8000/login
- [ ] Vérifier que les 40+ programmes s'affichent sur /shop

## 🎯 Prochaines étapes (optionnel)

1. **Stripe Integration**: Ajouter les clés Stripe dans `.env` pour les paiements
2. **Email**: Configurer SMTP pour l'envoi d'emails
3. **Images**: Uploader les vraies images des programmes
4. **Audio**: Ajouter les fichiers audio des protocoles
5. **Production**: Déployer sur un serveur (Netlify, Vercel, ou serveur dédié)

---

**Projet créé par Cascade AI** • Vitality Inside Clone • Laravel + Vue.js + Inertia
