/**
 * Kinetic Noir — Tailwind design tokens (fuente única para el build local).
 * Fuente: css/DESIGN.md
 */
module.exports = {
    colors: {
        secondary: '#DFFF00',
        'on-secondary': '#0D0D0E',
        'secondary-container': '#E8FFB3',
        'on-secondary-container': '#2A2D00',
        'secondary-fixed': '#F0FF80',
        'secondary-fixed-dim': '#DFFF00',
        'on-secondary-fixed': '#0D0D0E',
        'on-secondary-fixed-variant': '#5C6200',

        background: '#F4F4F6',
        surface: '#FFFFFF',
        'surface-bright': '#FFFFFF',
        'surface-dim': '#E8E8EC',
        'surface-container-lowest': '#FFFFFF',
        'surface-container-low': '#F4F4F6',
        'surface-container': '#E8E8EC',
        'surface-container-high': '#DCDCE2',
        'surface-container-highest': '#CFCFD6',
        'surface-variant': '#E8E8EC',
        'surface-tint': '#919094',

        'on-background': '#12131A',
        'on-surface': '#12131A',
        'on-surface-variant': '#46464A',
        outline: '#919094',
        'outline-variant': '#C7C6CA',

        primary: '#12131A',
        'on-primary': '#F4F4F6',
        'primary-container': '#E8E8EC',
        'on-primary-container': '#12131A',
        'primary-fixed': '#F4F4F6',
        'primary-fixed-dim': '#E2E1EB',
        'on-primary-fixed': '#12131A',
        'on-primary-fixed-variant': '#46464A',
        'inverse-primary': '#C8C6C7',

        tertiary: '#33343C',
        'on-tertiary': '#E2E1EB',
        'tertiary-container': '#1E1F26',
        'on-tertiary-container': '#C7C6CA',
        'tertiary-fixed': '#E2E1EB',
        'tertiary-fixed-dim': '#C8C6C9',
        'on-tertiary-fixed': '#12131A',
        'on-tertiary-fixed-variant': '#47464A',

        'inverse-surface': '#12131A',
        'inverse-on-surface': '#E2E1EB',

        error: '#BA1A1A',
        'on-error': '#FFFFFF',
        'error-container': '#FFDAD6',
        'on-error-container': '#93000A',
    },

    borderRadius: {
        DEFAULT: '0',
        sm: '0',
        md: '0',
        lg: '0',
        xl: '0',
        '2xl': '0',
        '3xl': '0',
        full: '9999px',
    },

    spacing: {
        unit: '4px',
        'gutter-mobile': '16px',
        'gutter-desktop': '24px',
        'margin-mobile': '20px',
        'margin-desktop': '64px',
        'container-max-width': '1440px',
    },

    fontFamily: {
        'display-lg': ['Anybody', 'sans-serif'],
        'display-lg-mobile': ['Anybody', 'sans-serif'],
        'headline-md': ['Anybody', 'sans-serif'],
        'headline-sm': ['Anybody', 'sans-serif'],
        'body-lg': ['Hanken Grotesk', 'sans-serif'],
        'body-md': ['Hanken Grotesk', 'sans-serif'],
        'label-md': ['JetBrains Mono', 'monospace'],
        'label-sm': ['JetBrains Mono', 'monospace'],
    },

    fontSize: {
        'display-lg': ['80px', { lineHeight: '88px', fontWeight: '800', letterSpacing: '-0.04em' }],
        'display-lg-mobile': ['36px', { lineHeight: '40px', fontWeight: '700', letterSpacing: '-0.02em' }],
        'headline-md': ['32px', { lineHeight: '38px', fontWeight: '600', letterSpacing: '-0.01em' }],
        'headline-sm': ['24px', { lineHeight: '32px', fontWeight: '600', letterSpacing: '-0.01em' }],
        'body-lg': ['18px', { lineHeight: '28px', fontWeight: '400' }],
        'body-md': ['16px', { lineHeight: '24px', fontWeight: '400' }],
        'label-md': ['14px', { lineHeight: '16px', letterSpacing: '0.05em', fontWeight: '700' }],
        'label-sm': ['12px', { lineHeight: '16px', letterSpacing: '0.1em', fontWeight: '500' }],
    },
};
