---
name: Kinetic Noir
colors:
  surface: '#12131a'
  surface-dim: '#12131a'
  surface-bright: '#383940'
  surface-container-lowest: '#0c0e14'
  surface-container-low: '#1a1b22'
  surface-container: '#1e1f26'
  surface-container-high: '#282a31'
  surface-container-highest: '#33343c'
  on-surface: '#e2e1eb'
  on-surface-variant: '#c7c6ca'
  inverse-surface: '#e2e1eb'
  inverse-on-surface: '#2f3037'
  outline: '#919094'
  outline-variant: '#46464a'
  surface-tint: '#c8c6c7'
  primary: '#c8c6c7'
  on-primary: '#313031'
  primary-container: '#0d0d0e'
  on-primary-container: '#7c7a7b'
  inverse-primary: '#5f5e5f'
  secondary: '#c6c6c8'
  on-secondary: '#2f3132'
  secondary-container: '#454749'
  on-secondary-container: '#b4b5b7'
  tertiary: '#c8c6c9'
  on-tertiary: '#303033'
  tertiary-container: '#0d0d10'
  on-tertiary-container: '#7b7a7e'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#e5e2e3'
  primary-fixed-dim: '#c8c6c7'
  on-primary-fixed: '#1c1b1c'
  on-primary-fixed-variant: '#474647'
  secondary-fixed: '#e2e2e4'
  secondary-fixed-dim: '#c6c6c8'
  on-secondary-fixed: '#1a1c1d'
  on-secondary-fixed-variant: '#454749'
  tertiary-fixed: '#e4e1e5'
  tertiary-fixed-dim: '#c8c6c9'
  on-tertiary-fixed: '#1b1b1e'
  on-tertiary-fixed-variant: '#47464a'
  background: '#12131a'
  on-background: '#e2e1eb'
  surface-variant: '#33343c'
typography:
  display-lg:
    fontFamily: Anybody
    fontSize: 80px
    fontWeight: '800'
    lineHeight: 88px
    letterSpacing: -0.04em
  headline-lg:
    fontFamily: Anybody
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 52px
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Anybody
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Anybody
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 38px
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Hanken Grotesk
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Hanken Grotesk
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-caps:
    fontFamily: JetBrains Mono
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.1em
  button:
    fontFamily: Anybody
    fontSize: 14px
    fontWeight: '700'
    lineHeight: 16px
    letterSpacing: 0.05em
spacing:
  unit: 4px
  gutter: 24px
  margin-desktop: 64px
  margin-mobile: 20px
  container-max: 1440px
---

## Brand & Style

The design system is engineered for a premium sports retail experience, blending high-performance utility with a sophisticated "Arctic Sport" aesthetic. The brand personality is disciplined, elite, and fast. It targets an audience that views athleticism as a lifestyle rather than a hobby, demanding a UI that feels as precise as the gear it showcases.

The visual direction utilizes **Minimalism** with a **Tech-Noir** edge. This is achieved through expansive deep-space canvases, high-contrast typography, and a deliberate absence of decorative clutter. The emotional response is one of focus and momentum—mimicking the "flow state" of a professional athlete. By prioritizing whitespace and aggressive typographic scales, the design system ensures that product photography remains the focal point while the interface provides a high-speed, frictionless navigational experience.

## Colors

This design system employs a "Tech-Noir" palette to establish a premium, high-contrast environment.

*   **Primary (Base):** A deep charcoal-black (#0D0D0E) serves as the main background, creating an infinite depth that allows product colors to pop.
*   **Secondary (Content):** Off-white (#F4F4F6) and cool greys are used for primary text and surfaces to maintain high legibility and a "clean" technical feel.
*   **Accent (Kinetic):** "Electric Volt" (#DFFF00) is the sole high-energy color. It is reserved for critical calls to action, performance indicators, and active states, symbolizing movement and energy.
*   **Surface:** Subdued greys (#27272A) are used for UI containers and card backgrounds to provide subtle separation from the primary base without breaking the dark aesthetic.

## Typography

Typography is the primary driver of the system's "speed" aesthetic. 

**Headlines** use *Anybody*, a variable font set to a heavy weight and an italic slant. This creates an aggressive, forward-leaning visual rhythm. The scale is intentionally oversized to communicate power.

**Body Text** uses *Hanken Grotesk*, selected for its modern, geometric precision and high readability in digital interfaces. It remains neutral to balance the expressive headlines.

**Technical Data** (sizes, SKUs, performance specs) uses *JetBrains Mono*. This monospaced font reinforces the "tech" aspect of "Tech-Noir," suggesting engineering and data-driven performance. 

Always use uppercase for labels and buttons to maintain a structured, authoritative tone.

## Layout & Spacing

The design system follows a strict **8px grid system** for vertical rhythm and a **12-column fluid grid** for horizontal layout. 

*   **Desktop:** 12 columns with 24px gutters. Large 64px outer margins provide "breathing room" that elevates the premium feel.
*   **Mobile:** 4 columns with 16px gutters and 20px outer margins.
*   **Philosophy:** Use generous "macro-spacing" (64px+) between sections to prevent the UI from feeling like a standard e-commerce grid. Internal "micro-spacing" should be tight (8px, 12px) to keep related data points connected, mimicking technical blueprints.

## Elevation & Depth

To maintain the "Tech-Noir" aesthetic, avoid traditional drop shadows. Depth is achieved through **Tonal Layering** and **Low-Contrast Outlines**.

*   **Base Layer:** The primary background (#0D0D0E).
*   **Surface Layer:** Modals and cards use a slightly lighter grey (#18181B) with a subtle 1px border (#27272A).
*   **Active State:** Use a 1px solid border of "Electric Volt" or a subtle outer glow with the accent color to indicate selection or focus.
*   **Glassmorphism:** For overlays like navigation bars or quick-view panels, use a backdrop blur (20px) with a 60% opacity fill of the primary color. This maintains the dark atmosphere while allowing the "Arctic" colors of the photography to bleed through.

## Shapes

The shape language is **Sharp (0)**. 

To evoke feelings of precision, speed, and technical engineering, all UI elements (buttons, inputs, cards) feature 0px border radii. This architectural approach distinguishes the brand from more casual, "soft" lifestyle competitors. 

Diagonal cuts (45-degree chamfers) may be used sparingly on secondary buttons or tag elements to further emphasize the geometric, "high-performance" aesthetic.

## Components

*   **Buttons:** Primary buttons are solid "Electric Volt" with black text. Secondary buttons are transparent with a 1px off-white border. All buttons use the `button` typographic style and have 0px corner radius.
*   **Cards:** Product cards are borderless with a slight tonal shift on hover. Images should be shot on dark or monochromatic backgrounds to blend seamlessly into the UI.
*   **Inputs:** Minimalist bottom-border only or a 1px dark grey stroke. Focus state is indicated by the bottom border turning "Electric Volt."
*   **Chips/Tags:** Used for "New Arrival" or "Performance Tech." These use the monospaced `label-caps` font, styled as small rectangular blocks with high-contrast fills (Black/White).
*   **Navigation:** A persistent, ultra-thin top bar. Use the `label-caps` font for nav items to maintain a technical, streamlined look.
*   **Price Points:** Always displayed in a larger weight of the body font or a medium weight of the headline font, never italicized, to ensure immediate clarity.