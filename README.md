## UAT testing checklist

> **Notes**
>
> - Prefer running this checklist on **staging** or a **production clone** before testing. Use the live site (`https://mahar.stringinnovation.com/`) only when necessary.
> - For every **Fail**, record the time tested, **browser / OS version**, and attach a **screenshot**.
> - If admin testing may change or delete data, take a **backup** first.
> - Each line has **Pass** and **Fail** slots. Mark **only one** outcome per row: **Pass** → ✅, **Fail** → ❌ (never both).

**Pass / Fail markers**

**Pass:** ✅ **Fail:** ❌

| Outcome | How to mark on each checklist line |
|---------|-------------------------------------|
| **Pass** — criterion met | `Pass: (✅)` and keep `Fail: ( )` |
| **Fail** — criterion not met | `Fail: (❌)` and keep `Pass: ( )` |

Empty slots look like `( )`. After testing, put **✅** inside the Pass parentheses, or **❌** inside the Fail parentheses. If ✅ / ❌ do not show in your viewer, use plain text **`PASS`** or **`FAIL`** in the same place instead.

**Base URL:** `https://mahar.stringinnovation.com/`

Use this checklist on the live deployment, **staging**, or a safe clone before release. Prefer a non-production database when exercising admin flows.

### Home (`https://mahar.stringinnovation.com/`)

- Pass: ( ) | Fail: ( ) — Page loads without errors; no broken layout
- Pass: ( ) | Fail: ( ) — Hero, services, “why choose”, partners, reviews, and other blocks match content configured in admin
- Pass: ( ) | Fail: ( ) — Internal links and CTAs resolve to the correct URLs
- Pass: ( ) | Fail: ( ) — Scroll-to-top and image lightbox (if present) behave correctly

### Locale (`https://mahar.stringinnovation.com/locale/{locale}`)

- Pass: ( ) | Fail: ( ) — Switching locale (e.g. EN ↔ MY) updates visible copy site-wide
- Pass: ( ) | Fail: ( ) — After switching, navigation and deep links still work as expected
- Pass: ( ) | Fail: ( ) — Locale choice persists across refresh (cookie/session)

### Portfolio listing (`https://mahar.stringinnovation.com/portfolio`)

- Pass: ( ) | Fail: ( ) — Listing renders; no visual glitches

### Portfolio detail (`https://mahar.stringinnovation.com/portfolio/{slug}`)

- Pass: ( ) | Fail: ( ) — Correct item for a valid slug
- Pass: ( ) | Fail: ( ) — Invalid or unknown slug — appropriate 404 (or error) handling
- Pass: ( ) | Fail: ( ) — Gallery / images display when configured

### CV download (`https://mahar.stringinnovation.com/cv`)

- Pass: ( ) | Fail: ( ) — File downloads successfully with expected name/type
- Pass: ( ) | Fail: ( ) — Missing asset or server error surfaces a sensible message (if applicable)

### Contact — form display (`https://mahar.stringinnovation.com/contact`)

- Pass: ( ) | Fail: ( ) — Form and page copy render correctly
- Pass: ( ) | Fail: ( ) — Optional Google Maps embed loads when `GOOGLE_MAPS_EMBED_URL` is set
- Pass: ( ) | Fail: ( ) — Service interest checkboxes appear and match labels (branding, identity, campaign, packaging, digital, other)

### Contact — form submit (`https://mahar.stringinnovation.com/contact`)

- Pass: ( ) | Fail: ( ) — Valid submission redirects back with success flash message
- Pass: ( ) | Fail: ( ) — Required fields: empty name, email, or message show validation errors
- Pass: ( ) | Fail: ( ) — Invalid email format rejected
- Pass: ( ) | Fail: ( ) — Message length within limits (e.g. max length) enforced
- Pass: ( ) | Fail: ( ) — When services are selected, stored message includes the selected service labels (verify in **Contact messages** in admin)
- Pass: ( ) | Fail: ( ) — CSRF: request without valid token is rejected

### FAQ (`https://mahar.stringinnovation.com/faq`)

- Pass: ( ) | Fail: ( ) — Questions/answers match admin data
- Pass: ( ) | Fail: ( ) — Expand/collapse or accordion behavior works if implemented

### Legal — privacy (`https://mahar.stringinnovation.com/privacy`)

- Pass: ( ) | Fail: ( ) — Privacy content loads
- Pass: ( ) | Fail: ( ) — Copy is correct under each supported locale

### Legal — terms (`https://mahar.stringinnovation.com/terms`)

- Pass: ( ) | Fail: ( ) — Terms content loads
- Pass: ( ) | Fail: ( ) — Copy is correct under each supported locale

### Redirects (`https://mahar.stringinnovation.com/partnership`)

- Pass: ( ) | Fail: ( ) — `GET https://mahar.stringinnovation.com/partnership` → `https://mahar.stringinnovation.com/#partnerships` with **301** status

### Theme and responsive UI (`https://mahar.stringinnovation.com/`)

- Pass: ( ) | Fail: ( ) — Dark/light (if applicable) toggles and survives refresh
- Pass: ( ) | Fail: ( ) — Layout is usable on mobile, tablet, and desktop widths

### Admin panel (`https://mahar.stringinnovation.com/admin`)

- Pass: ( ) | Fail: ( ) — Login: valid credentials succeed; invalid credentials fail clearly
- Pass: ( ) | Fail: ( ) — Dashboard and sidebar navigation load
- Pass: ( ) | Fail: ( ) — **Website settings** — save changes; home/branding/logo/favicon reflect updates on the public site
- Pass: ( ) | Fail: ( ) — **Portfolio items** — create, read, update, delete; slug uniqueness; hero/gallery media
- Pass: ( ) | Fail: ( ) — **FAQs** — CRUD; order/visibility if used
- Pass: ( ) | Fail: ( ) — **Contact messages** — list and view submissions from the public form
- Pass: ( ) | Fail: ( ) — **Design tools**, **Partners**, **Why choose points**, **Customer reviews** — CRUD and visibility on the home page
- Pass: ( ) | Fail: ( ) — Admin-only features remain inaccessible when logged out

### Cross-cutting (`https://mahar.stringinnovation.com/`)

- Pass: ( ) | Fail: ( ) — Production-like HTTPS: cookies and no mixed-content warnings for assets
- Pass: ( ) | Fail: ( ) — Basic keyboard navigation and visible focus on main interactive elements
- Pass: ( ) | Fail: ( ) — Slow network: avoid accidental double-submit on the contact form (UX)
