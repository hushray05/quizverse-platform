---
name: Kinetic Intellect
colors:
  surface: '#f8f9fd'
  surface-dim: '#d9dade'
  surface-bright: '#f8f9fd'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f3f7'
  surface-container: '#edeef2'
  surface-container-high: '#e7e8ec'
  surface-container-highest: '#e1e2e6'
  on-surface: '#191c1f'
  on-surface-variant: '#444654'
  inverse-surface: '#2e3134'
  inverse-on-surface: '#eff1f5'
  outline: '#747686'
  outline-variant: '#c4c5d7'
  surface-tint: '#2c50d9'
  primary: '#2248d1'
  on-primary: '#ffffff'
  primary-container: '#4263eb'
  on-primary-container: '#f5f3ff'
  inverse-primary: '#b9c3ff'
  secondary: '#6437dc'
  on-secondary: '#ffffff'
  secondary-container: '#7d55f7'
  on-secondary-container: '#fffbff'
  tertiary: '#49577c'
  on-tertiary: '#ffffff'
  tertiary-container: '#616f96'
  on-tertiary-container: '#f3f4ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dde1ff'
  primary-fixed-dim: '#b9c3ff'
  on-primary-fixed: '#001356'
  on-primary-fixed-variant: '#0035be'
  secondary-fixed: '#e7deff'
  secondary-fixed-dim: '#cdbdff'
  on-secondary-fixed: '#1f005f'
  on-secondary-fixed-variant: '#4e13c7'
  tertiary-fixed: '#dae2ff'
  tertiary-fixed-dim: '#b7c6f2'
  on-tertiary-fixed: '#0a1a3d'
  on-tertiary-fixed-variant: '#38466b'
  background: '#f8f9fd'
  on-background: '#191c1f'
  surface-variant: '#e1e2e6'
typography:
  display-hero:
    fontFamily: Manrope
    fontSize: 56px
    fontWeight: '800'
    lineHeight: 64px
    letterSpacing: -0.03em
  display-hero-mobile:
    fontFamily: Manrope
    fontSize: 36px
    fontWeight: '800'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Manrope
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Manrope
    fontSize: 26px
    fontWeight: '700'
    lineHeight: 34px
    letterSpacing: -0.015em
  headline-md:
    fontFamily: Manrope
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
    letterSpacing: -0.015em
  headline-sm:
    fontFamily: Manrope
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-lg:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.02em
  numeric-metric:
    fontFamily: Manrope
    fontSize: 28px
    fontWeight: '800'
    lineHeight: 32px
    letterSpacing: -0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.5rem
  space-sm: 0.75rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style
The design system delivers an intelligent, competitive, and refined environment that bridges serious learning with the pulse of high-stakes gaming. It rejects childish gamification tropes—such as cartoonish skeuomorphism or chaotic neon clutter—in favor of an architectural, tactile, and modern visual language. 

The aesthetic is characterized by high typographic clarity, generous negative space, crisp micro-borders, and tactile interaction surfaces. Surfaces feature soft, ambient elevation paired with subtle 1px delineations, creating distinct card-based units that frame trivia content with elegance and urgency. Micro-interactions are deliberate and crisp, evoking precision, focus, and intellectual momentum.

## Colors
The palette balances institutional trust with energetic visual cues. 

- **Primary Interactive (#4263EB):** Drives primary actions, progression states, and active quiz selections.
- **Secondary Accent (#7950F2):** Designates special events, power-ups, master-level tracks, and streak states.
- **Surface Deep / Navy Tier (#152447, #0A1733):** Provides foundational authority for dark mode panels, elevated hero banners, high-contrast leaderboard ribbons, and structural headers.
- **Background & Canvas (#F7F8FC, #FFFFFF):** Clean, neutral foundational surfaces designed to reduce visual fatigue over extended trivia sessions.
- **Support & Feedback:**
  - Success (#16A36A): Correct answer selection, score multipliers, rank increases.
  - Warning (#F4B740) & Gold (#E9B949): Ticking time thresholds, streak milestones, podium placements.
  - Error (#E5484D): Failed answers, critical countdown alerts, expired lifelines.
  - Borders (#E7EAF2): Crisp, uniform 1px structural framing across all card components.
  - Text: Primary `#182230` for deep legibility; Secondary `#667085` for meta-labels and supporting metadata.

## Typography
Typographic scale relies on pairing **Manrope** for authoritative, geometric display surfaces and **Inter** for sustained readability within high-density quiz mechanics and data tables. 

All real-time counters, countdown timers, rank indices, and dynamic scores must employ tabular lining numbers (`font-variant-numeric: tabular-nums` or `tnum`) to eliminate spatial shifting during rapid updates. Headlines prioritize strict negative tracking to preserve compositional tension and visual polish.

## Layout & Spacing
The layout follows an 8-point spatial rhythm governing internal component padding, layout gaps, and macro-structural canvases. 

- **Desktop (1024px+):** Fluid 12-column grid capped at a maximum container width of `1280px` (`max-w-7xl`), centered with `margin: 2rem` and `gutter: 1.5rem`.
- **Tablet (768px - 1023px):** 8-column layout with `1.5rem` gutters and adaptive card spans (e.g., standard stat modules drop from 4 columns to 2 columns).
- **Mobile (Below 768px):** Single-column layout with `gutter-mobile: 1rem` and `margin-mobile: 1rem`. Quiz option matrices shift from side-by-side grids to vertical, full-width touch lists with a minimum touch target height of 52px.

## Elevation & Depth
Elevation is achieved through layered tonal surfaces and low-opacity, ambient shadows, avoiding heavy drops.

- **Flat/Subsurface:** Canvas color `#F7F8FC` with zero elevation.
- **Card Base (Level 1):** Background `#FFFFFF`, 1px solid `#E7EAF2`, shadow: `0 1px 3px 0 rgba(10, 23, 51, 0.04), 0 1px 2px -1px rgba(10, 23, 51, 0.02)`.
- **Card Interactive / Hover (Level 2):** 1px solid `#D8DCE8`, shadow: `0 8px 16px -4px rgba(15, 23, 42, 0.06), 0 4px 6px -2px rgba(15, 23, 42, 0.03)`, subtle `translateY(-2px)` transition.
- **Modal & Floating Overlays (Level 3):** Background `#FFFFFF`, shadow: `0 20px 25px -5px rgba(10, 23, 51, 0.1), 0 8px 10px -6px rgba(10, 23, 51, 0.05)`, backed by a high-blur backdrop (`backdrop-blur-md bg-navy-950/40`).

## Shapes
Geometry is unified around refined, modern radii between 14px and 22px (`rounded-xl` to `rounded-2xl` in Tailwind parameters).

- Standard interactive cards, leaderboard wrappers, and modular containers: `rounded-2xl` (16px to 20px).
- Quiz answer choice blocks and interactive panels: `rounded-xl` (14px to 16px).
- Badges, status markers, chips, and timer rings: `rounded-full` (pill shape).
- Form fields and input bars: `rounded-xl` (12px to 14px).

## Components

### Quiz Buttons & Answer Tiles
- **Structure:** Full-width block layouts, minimum 56px height, internal padding of `1rem 1.25rem`. 
- **Resting:** Background `#FFFFFF`, border `1.5px solid #E7EAF2`, text `#182230`. Includes an indexed badge (A, B, C, D) on the left (`#F7F8FC` with text `#667085`).
- **Hover/Focus:** Border shifts to `#4263EB`, background tinted with `#F0EDFF`/20.
- **Selected State:** Border `2px solid #4263EB`, background `#F0EDFF`, index badge filled with `#4263EB` with white text.
- **Correct State:** Border `2px solid #16A36A`, background `#DCFCE7`, text `#0F5132`.
- **Incorrect State:** Border `2px solid #E5484D`, background `#FEE2E2`, text `#842029`.

### Badges & Category Chips
- **Chips:** Pill-shaped (`rounded-full`), padding `0.375rem 0.875rem`, border `1px solid transparent`.
  - Secondary/Lavender Chip: Background `#F0EDFF`, text `#7950F2`, font weight 600.
  - Active Filter Chip: Background `#152447`, text `#FFFFFF`.
- **Difficulty Badges:** Small caps, tracking `0.05em`, fontSize `11px`, padding `0.25rem 0.625rem`.
  - Easy: Background `#E6F4EA`, text `#137333`.
  - Medium: Background `#FEF7E0`, text `#B06000`.
  - Hard: Background `#FCE8E6`, text `#C5221F`.

### Timers & HUD Elements
- Circular SVG countdown track with dynamic stroke transitions (Primary Blue $\rightarrow$ Warning Amber $\rightarrow$ Error Red under 5s).
- Metric numerals centered with tabular figure alignment (`font-variant-numeric: tabular-nums`).

### Leaderboard Rows
- Card style with internal layout: Rank index $\rightarrow$ Avatar (40px, rounded-full) $\rightarrow$ User metadata (Name & Title) $\rightarrow$ Score display.
- Podium highlights: Top 3 utilize subtle metallic accent borders (Gold: `#E9B949`, Silver: `#94A3B8`, Bronze: `#D97706`).

### Input Fields
- Height 48px, background `#FFFFFF`, border `1px solid #E7EAF2`, `rounded-xl`.
- Focus state: `border-[#4263EB]` with `ring-4 ring-[#4263EB]/10`. Placeholder in `#98A2B3`.