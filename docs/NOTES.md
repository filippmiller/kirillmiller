# Project Notes - Kirill Miller Website

## Project Overview
- **Date**: January 16, 2026
- **Task**: Migrate website to Railway hosting platform

## Current Structure

### Two Websites in Repository:
1. **Legacy WordPress** (`kirillmiller.com/www/`)
   - PHP/MySQL WordPress installation
   - External database at `timecafe.mysql.tools`
   - Not suitable for Railway without database migration

2. **New Custom Site** (`kirillmiller.com/newsite/`) - **TARGET FOR RAILWAY**
   - Custom PHP application (no framework)
   - JSON-based flat-file storage (no database needed!)
   - Bootstrap frontend
   - Admin panel included
   - Perfect for Railway deployment

## Technology Stack (New Site)
- **Language**: PHP 8.x
- **Storage**: JSON files in `storage/data/`
- **Frontend**: Bootstrap CSS, jQuery, Fancybox
- **Auth**: Session-based with password_verify()

## Railway Deployment Strategy

### Why Deploy `newsite/`:
1. No database dependency - uses JSON files
2. Self-contained PHP application
3. Simpler deployment and maintenance
4. Lower hosting costs

### Required Configuration:
- PHP runtime via Nixpacks
- Document root: `public/`
- Writable storage directory for JSON data
- Session handling

### Files Created:
- `railway.json` - Railway platform configuration
- `nixpacks.toml` - Build configuration (PHP 8.3 + extensions)
- `router.php` - PHP built-in server routing
- `DEPLOY.md` - Full deployment documentation

### Files Modified:
- `config.php` - Updated to support environment variables

## Environment Variables Needed
| Variable | Description | Default |
|----------|-------------|---------|
| `ADMIN_USERNAME` | Admin login username | `admin` |
| `ADMIN_PASSWORD` | Admin login password | `change-this-password` |
| `SITE_TITLE` | Site title | `Kirill Miller` |
| `APP_ENV` | Environment mode | `production` |
| `APP_DEBUG` | Debug mode | `false` |

## Deployment Steps
1. Push to GitHub repository
2. Connect Railway to repository
3. **CRITICAL: Set Root Directory** to `kirillmiller.com/newsite`
   - In Settings → Source → Click "Add Root Directory"
   - Enter: `kirillmiller.com/newsite`
   - Without this, Railway won't find the PHP files!
4. Set environment variables in Railway dashboard
5. Deploy

## Important Notes
- Storage directory needs write permissions for JSON files
- Uploads directory needs write permissions for media
- **Add Railway Volume** for persistent storage (mounted to `/app/storage` and `/app/public/uploads`)
- Sessions are managed via PHP's built-in session handler

## Completion Status
- [x] Project structure analyzed
- [x] Railway configuration created (railway.json, nixpacks.toml)
- [x] PHP router for built-in server created
- [x] Config updated for environment variables
- [x] Deployment documentation created
- [x] Deployed to Railway via CLI
- [x] Site live at: https://kirillmiller-production.up.railway.app

## Deployment Notes (January 16, 2026)
- Used `railway up` from `kirillmiller.com/newsite` directory
- Excluded `public/uploads/` (1.2GB) via `.railwayignore`
- Removed `php83Extensions.json` from nixpacks (built-in in PHP 8)
- Build time: ~80 seconds
- Healthcheck passed

## Next Steps
- [ ] Add Railway volume for uploads (persistent media storage)
- [ ] Upload media files to volume or external CDN
- [ ] Set secure ADMIN_PASSWORD via `railway variables --set`
- [ ] Configure custom domain if needed
