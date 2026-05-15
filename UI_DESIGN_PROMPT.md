# UI DESIGN PROMPT - GRANDHIKA HOTEL ATTENDANCE SYSTEM

## 🎨 PROMPT UNTUK MEREPLIKASI UI

Gunakan prompt ini untuk menjelaskan desain UI ke AI assistant di laptop lain:

---

## DESKRIPSI SINGKAT

"Saya ingin membuat UI untuk sistem absensi hotel dengan tema luxury/elegant. Desain harus menggunakan 3 tone warna: putih/cream, abu-abu, dan cokelat/gold. Tidak boleh ada warna biru, hijau, atau merah kecuali untuk status indicator."

---

## COLOR PALETTE

```
WARNA UTAMA (3 TONE):

1. CREAM & WHITE:
   - Background utama: #faf8f5 (cream)
   - Background alternatif: #f5f3f0 (warm white)
   - Border/divider: #e8e4df (light gray)

2. GRAY:
   - Border input: #c4bdb5 (mid gray)
   - Text secondary: #7a7068 (dark gray)

3. BROWN & GOLD:
   - Primary: #9b7b5a (brown)
   - Dark: #6b4f35 (brown dark)
   - Deeper: #3a2a1a (brown deep)
   - Accent: #c9a84c (gold)
   - Light accent: #e8d5a3 (gold light)
   - Hover: #c8a882 (brown light)

STATUS COLORS (exception):
   - Success: #4a7c59 (green) - untuk Present, Active, Approved
   - Warning: #856404 (yellow-brown) - untuk Late, Pending
   - Danger: #8b3a3a (red-brown) - untuk Absent, Inactive, Rejected
```

---

## TYPOGRAPHY

```
FONT FAMILIES:
- Headers: 'Copperplate Gothic Bold', 'Copperplate', 'Playfair Display', Georgia, serif
- Body: 'Lato', sans-serif

FONT SIZES:
- Page title: 1.4rem (22px)
- Card header: 1rem - 1.125rem (16-18px)
- Body text: 0.875rem (14px)
- Small text: 0.72rem - 0.8rem (12px)

LETTER SPACING:
- Headers: 0.08em - 0.12em (wide/luxury feel)
- Body: 0.03em - 0.05em
- Uppercase labels: 0.1em - 0.3em
```

---

## KOMPONEN UTAMA

### 1. NAVBAR
```
- Position: Fixed top, sticky
- Background: Linear gradient dari #3a2a1a ke #6b4f35 ke #9b7b5a
- Border bottom: 2px solid gold (#c9a84c)
- Shadow: 0 2px 20px rgba(58,42,26,0.4)
- Logo: Lingkaran putih (#fff) dengan logo di dalamnya
- Text: White dengan accent amber-200
```

### 2. SIDEBAR
```
- Background: Cream (#faf8f5)
- Border: 1px solid light-gray
- Border-radius: 8px
- Header: Gradient brown dengan gold border bottom

SIDEBAR LINKS:
- Default: Transparent
- Hover: Gradient gold-light, translateX(3px), shadow
- Active: Gradient brown-light, font-weight bold
- Icon: SVG inline dengan currentColor (brown)
```

### 3. CARDS
```
- Background: Cream (#faf8f5)
- Border: 1px solid light-gray (#e8e4df)
- Border-radius: 8px
- Shadow: 0 2px 12px rgba(58,42,26,0.07)
- Hover: Shadow lebih besar

CARD HEADER:
- Background: Linear gradient brown-dark ke brown
- Border-bottom: 2px solid gold
- Text: White, uppercase, Copperplate font
```

### 4. BUTTONS
```
PRIMARY:
- Background: Linear gradient brown-dark ke brown
- Text: White
- Hover: Gradient lebih gelap, translateY(-1px), shadow

GOLD:
- Background: Linear gradient gold
- Text: Brown-deep
- Hover: Gradient lebih terang

OUTLINE:
- Background: Transparent
- Border: 1.5px solid brown-light
- Text: Brown-dark
- Hover: Background gold-light

SEMUA BUTTON:
- Border-radius: 6px
- Padding: 0.5rem 1.25rem
- Font-weight: 600
- Transition: all 0.2s ease
```

### 5. INPUT FIELDS
```
- Border: 1.5px solid mid-gray (#c4bdb5)
- Border-radius: 6px
- Padding: 0.55rem 0.9rem
- Background: White
- Font-size: 0.875rem

STATES:
- Hover: Border brown-light, background cream
- Focus: Border brown, shadow ring rgba(155,123,90,0.15)
- Placeholder: Mid-gray color

LABEL:
- Font-size: 0.8rem
- Font-weight: 700
- Color: Brown-dark
- Text-transform: uppercase
- Letter-spacing: 0.05em
```

### 6. TABLES
```
HEADER:
- Background: Linear gradient brown-dark ke brown
- Text: White, Copperplate font, uppercase
- Border-bottom: 2px solid gold
- Padding: 0.75rem 1rem

BODY ROWS:
- Border-bottom: 1px solid light-gray
- Alternating: rgba(232,228,223,0.4)
- Hover: Gradient gold-light, scale(1.002), shadow
- Padding: 0.7rem 1rem
- Font-size: 0.875rem
```

### 7. BADGES
```
- Border-radius: 20px (pill shape)
- Padding: 0.2rem 0.65rem
- Font-size: 0.72rem
- Font-weight: 700
- Border: 1px solid (darker shade)

SUCCESS: Background #d4edda, text #2d6a3f
WARNING: Background #fef3cd, text #856404
DANGER: Background #f8d7da, text #842029
INFO: Background gold-light, text brown-deep
GRAY: Background light-gray, text dark-gray
```

### 8. ALERTS
```
- Padding: 0.85rem 1.25rem
- Border-radius: 6px
- Border-left: 4px solid
- Display: flex dengan icon SVG
- Gap: 0.5rem

SUCCESS: Background #f0faf3, border #4a7c59
ERROR: Background #fdf0f0, border #8b3a3a
INFO: Background gold-light, border gold
```

### 9. STAT CARDS (Dashboard)
```
- Background: Cream
- Border: 1px solid light-gray
- Border-radius: 8px
- Padding: 1.25rem 1rem
- Text-align: center

ICON: 2rem x 2rem, brown color
VALUE: 1.75rem, font-weight 800, brown-deep
LABEL: 0.65rem, uppercase, gray

HOVER: Border brown-light, translateY(-2px), shadow
```

### 10. QUICK MENU CARDS
```
- Display: flex column
- Align-items: center
- Gap: 0.6rem
- Padding: 1.25rem 0.75rem
- Background: Cream
- Border: 1px solid light-gray
- Border-radius: 8px

HOVER:
- Background: Gradient gold-light ke cream
- Border: Brown-light
- TranslateY(-2px)
- Icon scale(1.1)
```

---

## ICONS

```
GUNAKAN SVG INLINE (bukan emoji):
- Semua icon menggunakan stroke="currentColor"
- Stroke-width: 1.5 - 2
- Size: 1rem - 2rem tergantung konteks
- Color: Inherit dari parent (brown/gold)

CONTOH ICON:
- Dashboard: Grid/squares
- Users: User/users icon
- Department: Building icon
- Shift: Clock icon
- Schedule: Calendar icon
- Attendance: Check/clipboard icon
- Profile: User circle icon
```

---

## EFFECTS & ANIMATIONS

```
HOVER EFFECTS:
- Buttons: translateY(-1px) + shadow
- Cards: Shadow lebih besar
- Table rows: Background gradient + scale(1.002)
- Sidebar links: translateX(3px)
- Quick cards: translateY(-2px) + icon scale(1.1)

TRANSITIONS:
- All: transition: all 0.2s ease
- Smooth dan subtle

SHADOWS:
- Default: 0 2px 12px rgba(58,42,26,0.07)
- Hover: 0 4px 20px rgba(58,42,26,0.13)
- Navbar: 0 2px 20px rgba(58,42,26,0.4)
```

---

## SPACING SYSTEM

```
- Extra small: 0.25rem (4px)
- Small: 0.5rem (8px)
- Medium: 1rem (16px)
- Large: 1.5rem (24px)
- Extra large: 2rem (32px)

PADDING:
- Card: 1.25rem - 1.5rem (20-24px)
- Button: 0.5rem 1.25rem (8px 20px)
- Input: 0.55rem 0.9rem (9px 14px)
- Table cell: 0.7rem 1rem (11px 16px)

MARGIN:
- Section gap: 1.25rem - 1.5rem
- Element gap: 0.5rem - 1rem
```

---

## RESPONSIVE BREAKPOINTS

```
MOBILE: < 640px
- Single column layout
- Hamburger menu
- Stack cards vertically
- Hide non-essential table columns
- Full-width buttons

TABLET: 640px - 1024px
- Two column grid
- Sidebar masih drawer
- Show more table columns

DESKTOP: >= 1024px
- Multi-column grid (3-4 columns)
- Sticky sidebar visible
- Full table
- Optimal spacing
```

---

## SPECIAL ELEMENTS

### GOLD DIVIDER
```
- Height: 2px
- Background: linear-gradient(90deg, transparent, gold, transparent)
- Margin: 1.5rem 0
- Digunakan sebagai section separator
```

### PAGE TITLE
```
- Font: Copperplate
- Font-size: 1.4rem
- Color: Brown-deep
- Letter-spacing: 0.1em
- Border-bottom: 2px solid gold
- Padding-bottom: 0.5rem
- Margin-bottom: 1.25rem
```

### MODAL/OVERLAY
```
- Background: rgba(0,0,0,0.6)
- Position: fixed, inset 0
- Z-index: 50
- Display: flex, center items

MODAL CONTENT:
- Card style (cream background)
- Max-width: 500px
- Border-radius: 8px
- Shadow: Large
```

---

## CONTOH IMPLEMENTASI

### LOGIN PAGE
```
- Full-page gradient background (brown-deep ke brown-dark ke brown)
- Centered card (max-width 420px)
- Logo dalam lingkaran putih (background #fff)
- Header dengan gradient brown
- Form dengan input-hotel style
- Gold divider
- Button full-width
```

### DASHBOARD USER
```
- Card dengan header gradient
- User info cards (3 cards horizontal)
- Gold divider
- Today's schedule section dengan gradient background
- Real-time clock
- Check-in/out buttons (success/danger)
- Recent attendance table
```

### TABLE PAGE
```
- Card dengan header
- Add button (gold) di header kanan
- Table dengan hover effect
- Action buttons (outline & danger)
- Pagination (jika ada)
```

### FORM PAGE
```
- Card max-width 2xl, centered
- Grid 2 columns (1 di mobile)
- Label uppercase dengan letter-spacing
- Input dengan hover/focus states
- Gold divider sebelum buttons
- Button group (primary & outline)
```

---

## CHECKLIST IMPLEMENTASI

Saat membuat UI, pastikan:

✅ Hanya gunakan 3 tone warna (cream, gray, brown/gold)
✅ Status colors hanya untuk badges/alerts
✅ Semua icon menggunakan SVG inline (bukan emoji)
✅ Font Copperplate untuk headers
✅ Letter-spacing lebar untuk efek luxury
✅ Hover effect pada semua interactive elements
✅ Gradient pada headers dan buttons
✅ Border-radius 6-8px untuk rounded corners
✅ Shadow subtle dengan hover effect
✅ Responsive di semua breakpoints
✅ Logo dalam lingkaran putih (#fff)

---

## PROMPT SINGKAT UNTUK AI

Jika ingin prompt cepat, gunakan ini:

```
"Buat UI sistem absensi hotel dengan tema luxury. Gunakan HANYA 3 tone warna:
1. Cream/putih (#faf8f5, #f5f3f0, #e8e4df)
2. Abu-abu (#c4bdb5, #7a7068)
3. Cokelat/gold (#9b7b5a, #6b4f35, #3a2a1a, #c9a84c)

Font: Copperplate untuk headers, Lato untuk body.
Semua icon pakai SVG inline (bukan emoji).
Navbar: gradient brown dengan gold border.
Cards: cream background, gradient brown header, gold border.
Buttons: gradient dengan hover effect translateY(-1px).
Tables: brown header, hover row dengan gradient gold-light.
Input: border mid-gray, hover brown-light, focus brown dengan shadow ring.
Badges: pill shape untuk status (success/warning/danger).
Responsive: mobile hamburger menu, desktop sticky sidebar.
Logo: dalam lingkaran putih solid (#fff).

Semua elemen harus punya hover effect yang smooth (0.2s transition).
Letter-spacing lebar untuk headers (0.08em-0.12em).
Border-radius 6-8px untuk semua komponen.
Shadow subtle: 0 2px 12px rgba(58,42,26,0.07).
"
```

---

## TIPS TAMBAHAN

1. **Konsistensi**: Gunakan CSS variables untuk warna agar mudah maintain
2. **Performance**: Inline critical CSS, gunakan SVG untuk icons
3. **Accessibility**: Pastikan contrast ratio minimal 4.5:1
4. **Mobile-first**: Desain dari mobile dulu, lalu scale up
5. **Testing**: Test di Chrome, Firefox, Safari, Edge

---

**File ini untuk memudahkan replikasi UI di laptop/environment lain**

Simpan file ini dan gunakan sebagai referensi saat bekerja di laptop lain!
