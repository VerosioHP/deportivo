tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            "colors": {
                "surface-bright": "#fbf9f8",
                "secondary": "#8e4c31",
                "tertiary-fixed": "#e5e2de",
                "surface-container": "#efeded",
                "surface": "#fbf9f8",
                "surface-variant": "#e4e2e2",
                "on-tertiary-fixed-variant": "#474744",
                "background": "#fbf9f8",
                "secondary-container": "#ffa988",
                "on-primary": "#ffffff",
                "outline-variant": "#c5c6ce",
                "on-secondary-container": "#793c22",
                "on-surface": "#1b1c1c",
                "on-secondary": "#ffffff",
                "error": "#ba1a1a",
                "surface-container-lowest": "#ffffff",
                "surface-container-low": "#f5f3f3",
                "surface-tint": "#505f79",
                "inverse-on-surface": "#f2f0f0",
                "secondary-fixed": "#ffdbce",
                "on-secondary-fixed-variant": "#71361c",
                "primary": "#05152b",
                "tertiary-container": "#2a2a28",
                "surface-dim": "#dbd9d9",
                "primary-fixed-dim": "#b8c7e5",
                "on-surface-variant": "#44474d",
                "on-error": "#ffffff",
                "on-primary-fixed-variant": "#394760",
                "error-container": "#ffdad6",
                "on-tertiary": "#ffffff",
                "on-primary-fixed": "#0c1c32",
                "on-background": "#1b1c1c",
                "secondary-fixed-dim": "#ffb599",
                "primary-fixed": "#d5e3ff",
                "on-primary-container": "#8291ad",
                "inverse-surface": "#303030",
                "inverse-primary": "#b8c7e5",
                "surface-container-highest": "#e4e2e2",
                "outline": "#75777e",
                "tertiary": "#151614",
                "on-secondary-fixed": "#370e00",
                "tertiary-fixed-dim": "#c8c6c2",
                "primary-container": "#1b2a41",
                "on-tertiary-fixed": "#1c1c19",
                "on-tertiary-container": "#92918d",
                "on-error-container": "#93000a"
            },
            "borderRadius": {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            "spacing": {
                "margin-mobile": "20px",
                "gutter-desktop": "32px",
                "margin-desktop": "64px",
                "gutter-mobile": "16px",
                "container-max-width": "1280px",
                "unit": "8px"
            },
            "fontFamily": {
                "headline-md": ["Playfair Display"],
                "display-lg-mobile": ["Playfair Display"],
                "headline-sm": ["Playfair Display"],
                "display-lg": ["Playfair Display"],
                "body-lg": ["DM Sans"],
                "label-sm": ["DM Sans"],
                "body-md": ["DM Sans"],
                "label-md": ["DM Sans"]
            },
            "fontSize": {
                "headline-md": ["32px", {
                    "lineHeight": "40px",
                    "fontWeight": "500"
                }],
                "display-lg-mobile": ["32px", {
                    "lineHeight": "40px",
                    "fontWeight": "600"
                }],
                "headline-sm": ["24px", {
                    "lineHeight": "32px",
                    "fontWeight": "500"
                }],
                "display-lg": ["48px", {
                    "lineHeight": "56px",
                    "letterSpacing": "-0.02em",
                    "fontWeight": "600"
                }],
                "body-lg": ["18px", {
                    "lineHeight": "28px",
                    "fontWeight": "400"
                }],
                "label-sm": ["12px", {
                    "lineHeight": "16px",
                    "letterSpacing": "0.08em",
                    "fontWeight": "700"
                }],
                "body-md": ["16px", {
                    "lineHeight": "24px",
                    "fontWeight": "400"
                }],
                "label-md": ["14px", {
                    "lineHeight": "20px",
                    "letterSpacing": "0.05em",
                    "fontWeight": "500"
                }]
            }
        },
    },
}