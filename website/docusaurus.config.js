/** @type {import('@docusaurus/types').DocusaurusConfig} */
module.exports = {
    title: "eluceo/ical",
    tagline: "iCalendar Generator for PHP",
    url: "https://ical.poerschke.nrw",
    baseUrl: "/",
    onBrokenLinks: "throw",
    onBrokenMarkdownLinks: "warn",
    favicon: "img/favicon.ico",
    organizationName: "markuspoerschke", // Usually your GitHub org/user name.
    projectName: "ical", // Usually your repo name.
    themeConfig: {
        navbar: {
            title: "eluceo/ical",
            items: [
                {
                    to: "docs/",
                    activeBasePath: "docs",
                    label: "Docs",
                    position: "left",
                },
                {
                    href: "https://github.com/markuspoerschke/ical",
                    label: "GitHub",
                    position: "right",
                },
            ],
        },
        footer: {
            style: "dark",
            links: [
                {
                    title: "Docs",
                    items: [
                        {
                            label: "Getting Started",
                            to: "docs/",
                        },
                    ],
                },
                {
                    title: "Support and Community",
                    items: [
                        {
                            label: "Raise a question",
                            to: "https://github.com/markuspoerschke/iCal/discussions/categories/q-a",
                        },
                        {
                            label: "Report a bug",
                            to: "https://github.com/markuspoerschke/iCal/issues",
                        },
                    ],
                },
                {
                    title: "More",
                    items: [
                        {
                            label: "GitHub",
                            href: "https://github.com/markuspoerschke/ical",
                        },
                        {
                            label: "Imprint",
                            href: "https://markus.poerschke.nrw/imprint/",
                        },
                    ],
                },
            ],
            copyright: `Copyright (c) 2012-2021 Markus Poerschke, Published under MIT License`,
        },
        prism: {
            additionalLanguages: ["php"],
            theme: require("prism-react-renderer/themes/nightOwlLight"),
            darkTheme: require("prism-react-renderer/themes/oceanicNext"),
        },
    },
    presets: [
        [
            "@docusaurus/preset-classic",
            {
                blog: false,
                docs: {
                    sidebarPath: require.resolve("./sidebars.js"),
                    editUrl:
                        "https://github.com/markuspoerschke/ical/edit/2.x/website/",
                },
                theme: {
                    customCss: require.resolve("./src/css/custom.css"),
                },
            },
        ],
    ],
    plugins: [
        [
            "docusaurus-plugin-ackee",
            {
                domainId: "23cbb93b-ce0b-4f58-bca4-6caa0bc939ee",
                server: "https://ackee.poerschke.nrw",
            },
        ],
    ],
};
