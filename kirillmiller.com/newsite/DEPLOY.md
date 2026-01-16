# Railway Deployment Guide

## Quick Start

1. **Push to GitHub**
   ```bash
   git add .
   git commit -m "Add Railway deployment configuration"
   git push origin main
   ```

2. **Create Railway Project**
   - Go to [railway.app](https://railway.app)
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Connect your GitHub account and select this repository

3. **Configure Root Directory**
   - In Railway dashboard, go to Settings
   - Set **Root Directory** to: `kirillmiller.com/newsite`
   - This tells Railway to deploy from the newsite subdirectory

4. **Set Environment Variables**
   In the Railway dashboard, add these variables:

   | Variable | Description | Example |
   |----------|-------------|---------|
   | `ADMIN_USERNAME` | Admin login username | `admin` |
   | `ADMIN_PASSWORD` | Admin login password | `your-secure-password` |
   | `SITE_TITLE` | Website title | `Kirill Miller` |
   | `APP_ENV` | Environment mode | `production` |
   | `APP_DEBUG` | Enable debug mode | `false` |

5. **Deploy**
   - Railway will automatically detect the PHP application
   - It uses nixpacks.toml for build configuration
   - The app will be available at your Railway-provided URL

## Project Structure

```
newsite/
├── railway.json      # Railway deployment config
├── nixpacks.toml     # Nixpacks build config
├── public/           # Web root (document root)
│   ├── index.php     # Main entry point
│   ├── router.php    # PHP built-in server router
│   ├── app.php       # Application logic
│   ├── config.php    # Configuration (uses env vars)
│   ├── admin/        # Admin panel
│   ├── assets/       # CSS, JS, fonts, images
│   ├── partials/     # Template partials
│   └── uploads/      # User uploads
└── storage/
    ├── data/         # JSON data files
    └── tmp/          # Temporary files
```

## Configuration Files

### railway.json
Defines the deployment configuration:
- Uses Nixpacks builder
- Starts PHP built-in server on Railway's PORT
- Configures health checks

### nixpacks.toml
Defines the build process:
- Installs PHP 8.3 with extensions (gd, mbstring, json)
- Creates required directories
- Sets permissions for storage and uploads

### router.php
Handles URL routing for PHP's built-in server:
- Serves static files directly
- Routes all other requests to index.php
- Protects sensitive PHP files

## Persistent Storage

**Important**: Railway containers are ephemeral. For persistent storage:

1. **Option A: Railway Volume** (Recommended)
   - Add a volume in Railway dashboard
   - Mount it to `/app/storage`
   - Your JSON data and uploads will persist

2. **Option B: External Storage**
   - Use S3 or similar for uploads
   - Use a database for data (requires code changes)

## Custom Domain

1. Go to Railway project settings
2. Click "Generate Domain" or "Add Custom Domain"
3. For custom domain, add CNAME record pointing to Railway

## Troubleshooting

### App not loading
- Check Railway logs for errors
- Verify root directory is set correctly
- Ensure environment variables are set

### Admin login not working
- Verify ADMIN_USERNAME and ADMIN_PASSWORD are set
- Check if users.json has valid user entries

### Uploads not persisting
- Add Railway volume for persistent storage
- Mount to `/app/storage` and `/app/public/uploads`

### 404 errors on pages
- Router.php handles URL rewriting
- Check if .htaccess is being ignored (shouldn't matter with PHP server)
