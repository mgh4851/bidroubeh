# Bidrubeh Municipality WordPress Theme

Production WordPress theme for the Bidrubeh Municipality website. The theme is
RTL-first, includes bundled Persian fonts, and is prepared for deployment on
Liara's dedicated WordPress service.

## Deployable artifact

Upload `bidrubeh-municipality.zip` from the repository root in WordPress under
**Appearance > Themes > Add New > Upload Theme**.

The ZIP contains one top-level directory named `bidrubeh-municipality`, as
required by WordPress. Its current theme version is `1.9.89`.

## Rebuild the theme ZIP

From PowerShell at the repository root:

```powershell
.\scripts\build-theme.ps1
```

The script validates the theme header and archive layout before replacing the
root-level ZIP.

## Liara deployment

Follow [LIARA-DEPLOY.md](LIARA-DEPLOY.md). The recommended target is Liara's
dedicated WordPress service using Apache, which supplies the database and
persistent storage automatically.

