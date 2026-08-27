# KeralamLiveNews — WordPress Theme

By **Tahseen Ashrafi**

A widget-driven Kerala/Malayalam news theme. Every homepage section (The Lead,
In The News, Mangalam Specials, Today's Mangalam, Entertainment, Inside
Mangalam, Health, News in Reels, Photo Gallery) plus the right sidebar is
powered by one flexible **"News Category Block"** widget — so you assign the
category, number of posts, and author/date visibility yourself from
**Appearance → Widgets**, with no code edits.

## Install

1. Zip already built for you — in WordPress go to **Appearance → Themes → Add
   New → Upload Theme** and upload `keralamlivenews.zip`, then **Activate**.
2. **Settings → Reading** → set "Your homepage displays" to **A static
   page** and choose/create a page for it (the theme's `front-page.php` will
   render the full homepage automatically regardless of which page you pick,
   as long as a static front page is selected).
3. **Appearance → Menus** → create a menu, assign it to the **Primary Menu**
   location, for the red nav bar.
4. **Appearance → Customize → Site Identity** → upload your logo.

## Assigning category + post count to each section

Go to **Appearance → Widgets**. You'll see one widget area per homepage
section, e.g. *"Homepage: The Lead (left column)"*, *"Homepage: In The News"*,
*"Homepage: Mangalam Specials"*, etc., plus *"Right Sidebar (used
site-wide)"*.

For each one:
1. Add a **"News Category Block"** widget.
2. Pick a **Layout** (Lead / Simple list / Magazine / Tabbed categories /
   Four columns / Video strip / Photo gallery strip) — matched to what that
   section looked like in the reference site.
3. Pick the **Category** (or, for the "Tabbed categories" layout used by
   Today's Mangalam, pick 2–5 categories — one becomes a tab).
4. Set **Number of posts**.
5. Tick/untick **Show author name** and **Show post date**.
6. Save.

Leave a widget area empty and that whole section (including the sidebar)
simply disappears from the page — that's how you remove the sidebar if you
don't want it.

For the sidebar specifically, add several widgets stacked (e.g. an **"Ad
Slot"** widget for the "Advertisement" boxes, then a few "News Category
Block" widgets set to layout = *Simple list*, for "Trending Now", "Off Beat",
"Astrology", "Crime", "English Edition" — one widget per box, each with its
own category).

## Header

**Appearance → Customize → Header**:
- Left side text (temperature/city)
- Show/hide the date under the logo
- Right side text (optional)
- Show/hide the search icon

## Single post display

**Appearance → Customize → Single Post Display**: toggle author name, date,
and "N min read" — applies to every post ("Open Story" page).

## Colors

**Appearance → Customize → Theme Colors**: primary/accent color (section
headings + nav bar), link color, background color.

## Footer credit

**Appearance → Customize → Footer**: edit the bottom credit line (defaults to
"Made with love by Tahseen Ashrafi").

## Video posts ("News in Reels")

Open any post → in the **"Video URL (optional)"** box in the sidebar, paste a
YouTube/video link. If left blank, the video-strip widget just links to the
post itself.

## File structure

```
keralamlivenews/
├── style.css              Theme header + base reset
├── index.php              Fallback blog loop
├── front-page.php         Homepage layout (widget areas)
├── functions.php          Theme setup, widget-area registration
├── header.php / footer.php / sidebar.php
├── single.php             "Open Story" layout
├── page.php / archive.php ("Menu Click" layout) / search.php / 404.php
├── comments.php / searchform.php
├── screenshot.png
├── assets/css/custom.css  All section styling
├── assets/js/custom.js    Tabs, mobile nav, strip arrows, search toggle
└── inc/
    ├── customizer.php             Header/colors/footer/single-post options
    ├── template-functions.php     Breadcrumb, post-meta, thumbnail helpers
    ├── enqueue.php                CSS/JS loading
    ├── class-klm-news-widget.php  The main "News Category Block" widget
    ├── class-klm-ad-widget.php    "Ad Slot" widget
    └── meta-boxes.php             Per-post "Video URL" field
```

## License

GPL v2 or later — see `LICENSE`. Copyright © 2026 Tahseen Ashrafi.
