tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            "colors": {
                "on-background": "#1b1c1c",
                "primary-container": "#1b2a41",
                "surface-bright": "#fbf9f8",
                "surface-tint": "#505f79",
                "on-tertiary-fixed-variant": "#474744",
                "surface-container": "#efeded",
                "on-surface": "#1b1c1c",
                "error": "#ba1a1a",
                "outline": "#75777e",
                "on-tertiary-fixed": "#1c1c19",
                "secondary-fixed": "#ffdbce",
                "surface-container-highest": "#e4e2e2",
                "inverse-primary": "#b8c7e5",
                "surface-dim": "#dbd9d9",
                "surface-container-lowest": "#ffffff",
                "surface-variant": "#e4e2e2",
                "on-secondary-fixed": "#370e00",
                "background": "#fbf9f8",
                "primary-fixed": "#d5e3ff",
                "on-tertiary-container": "#92918d",
                "on-surface-variant": "#44474d",
                "outline-variant": "#c5c6ce",
                "surface-container-low": "#f5f3f3",
                "on-tertiary": "#ffffff",
                "tertiary": "#151614",
                "on-primary": "#ffffff",
                "inverse-on-surface": "#f2f0f0",
                "secondary-container": "#ffa988",
                "on-secondary-fixed-variant": "#71361c",
                "secondary": "#8e4c31",
                "error-container": "#ffdad6",
                "surface-container-high": "#eae8e7",
                "on-error": "#ffffff",
                "on-primary-fixed": "#0c1c32",
                "on-primary-container": "#8291ad",
                "primary-fixed-dim": "#b8c7e5",
                "on-secondary": "#ffffff",
                "on-error-container": "#93000a",
                "on-primary-fixed-variant": "#394760",
                "tertiary-container": "#2a2a28",
                "on-secondary-container": "#793c22",
                "secondary-fixed-dim": "#ffb599",
                "surface": "#fbf9f8",
                "inverse-surface": "#303030",
                "tertiary-fixed-dim": "#c8c6c2",
                "primary": "#05152b",
                "tertiary-fixed": "#e5e2de"
            },
            "borderRadius": {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            "spacing": {
                "margin-mobile": "20px",
                "container-max-width": "1280px",
                "unit": "8px",
                "margin-desktop": "64px",
                "gutter-mobile": "16px",
                "gutter-desktop": "32px"
            },
            "fontFamily": {
                "body-lg": ["DM Sans"],
                "label-md": ["DM Sans"],
                "label-sm": ["DM Sans"],
                "display-lg-mobile": ["Playfair Display"],
                "body-md": ["DM Sans"],
                "headline-sm": ["Playfair Display"],
                "display-lg": ["Playfair Display"],
                "headline-md": ["Playfair Display"]
            },
            "fontSize": {
                "body-lg": ["18px", {
                    "lineHeight": "28px",
                    "fontWeight": "400"
                }],
                "label-md": ["14px", {
                    "lineHeight": "20px",
                    "letterSpacing": "0.05em",
                    "fontWeight": "500"
                }],
                "label-sm": ["12px", {
                    "lineHeight": "16px",
                    "letterSpacing": "0.08em",
                    "fontWeight": "700"
                }],
                "display-lg-mobile": ["32px", {
                    "lineHeight": "40px",
                    "fontWeight": "600"
                }],
                "body-md": ["16px", {
                    "lineHeight": "24px",
                    "fontWeight": "400"
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
                "headline-md": ["32px", {
                    "lineHeight": "40px",
                    "fontWeight": "500"
                }]
            }
        },
    },
}