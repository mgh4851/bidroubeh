# Deploy Bidrubeh Municipality on Liara

This repository contains a WordPress theme, not an entire WordPress
installation. Deploy it on Liara's **Dedicated WordPress** product and then
upload the included theme package.

## 1. Create the Liara site

1. Sign in to <https://console.liara.ir>.
2. Choose the correct personal or team account.
3. Open **Dedicated WordPress** (`وردپرس اختصاصی`) and select **Create site**.
4. Enter a unique application ID.
5. Select **Apache** as the web server. Apache is the compatibility-first choice
   for WordPress permalinks and `.htaccess` rules.
6. Select the required resource plan and create the site.

Liara creates and connects the database automatically. Its dedicated WordPress
service also provides persistent site storage, so no Docker volume or separate
database configuration is needed for this deployment route.

## 2. Complete WordPress setup

Open the generated `*.liara.run` address and finish the WordPress installer:

- Site title: `شهرداری بیدروبه`
- Language: Persian (`fa_IR`)
- Administrator: use a non-obvious username and a unique strong password
- Search-engine visibility: keep indexing disabled until the site is ready

Do not put administrator or database credentials in this repository.

## 3. Install the theme

1. In WordPress, open **Appearance > Themes > Add New > Upload Theme**.
2. Upload `bidrubeh-municipality.zip` from this repository.
3. Install and activate **Bidrubeh Municipality**.
4. Confirm that the displayed version is `1.9.89`.

The checked-in ZIP has been verified to contain the same files as the
`bidrubeh-municipality/` source directory and only one top-level theme folder.

## 4. Install the Persian date plugin

In **Plugins > Add New**, install and activate `wp-parsidate`. The theme includes
a safe Jalali fallback, but the plugin is recommended for consistent Persian
date handling throughout the WordPress administration area.

## 5. Configure the site

### General settings

- Timezone: `Tehran`
- Date format: `Y/m/d`
- Permalinks: **Post name**

After saving permalinks, open `/wp-json/` and confirm that WordPress returns a
JSON response instead of a 404 page.

### Content structure

1. Create the About, Contact, and FAQ pages as needed.
2. Create the notices category with slug `etelaeieh`.
3. Create a menu and assign it to the **Primary** location.
4. Add featured images to news posts; the homepage slider and cards use them.
5. Open **Appearance > Customize > Municipality settings** and enter the phone,
   email, address, population, area, hotline, notices category, and item counts.
6. Upload the municipality logo and annual slogan image where applicable.

## 6. Connect the production domain

Add the domain from the site's domain section in Liara, apply the DNS records
shown by the console, and wait for Liara to issue HTTPS. Only after HTTPS works:

1. Set both WordPress Address and Site Address to the final `https://` URL.
2. Enable search-engine indexing when the content is ready for publication.
3. Resave **Settings > Permalinks** once.

Avoid changing the WordPress URLs before the domain and certificate are active;
doing so can lock the administrator interface behind a redirect.

## 7. Production verification

Check all of the following before announcing the site:

- Homepage, slider controls, latest news, notices, search, and 404 page
- About, Contact, FAQ, archive, single-post, and comments layouts
- Mobile navigation at phone and tablet widths
- Persian text direction, Jalali dates, and bundled font requests returning 200
- Featured images and newly uploaded media surviving an application restart
- `/wp-admin/` login, `/wp-json/`, and post-name permalinks
- HTTPS redirect with no mixed-content warnings
- Liara backups enabled for both files and database

## Updating the theme later

1. Increase `Version:` in `bidrubeh-municipality/style.css`.
2. Run `.\scripts\build-theme.ps1`.
3. Upload the new ZIP in WordPress and replace the installed theme.
4. Purge any WordPress, proxy, or browser cache and repeat the smoke tests.

## Current deployment blocker

The Liara console requires an authenticated account. Resource-plan selection may
also create a charge. Sign in first; then the remaining console actions are site
ID selection, plan confirmation, theme upload, and WordPress configuration.

