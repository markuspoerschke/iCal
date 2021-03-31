import "./styles.scss";
const hljs = require("highlight.js/lib/core");
hljs.registerLanguage("php", require("highlight.js/lib/languages/php"));
hljs.registerLanguage(
    "plaintext",
    require("highlight.js/lib/languages/plaintext")
);
hljs.registerLanguage("bash", require("highlight.js/lib/languages/bash"));
hljs.registerLanguage("json", require("highlight.js/lib/languages/json"));
const ackeeTracker = require("ackee-tracker");

document.addEventListener("DOMContentLoaded", (event) => {
    // code highlight
    document.querySelectorAll("pre code").forEach((block) => {
        hljs.highlightBlock(block);
    });

    document.body.innerHTML = document.body.innerHTML.replace(
        /✖/g,
        '<i class="fas fa-times"></i>'
    );
    document.body.innerHTML = document.body.innerHTML.replace(
        /✔/gi,
        '<i class="fas fa-check"></i>'
    );

    document
        .querySelectorAll("h2[id], h3[id], h4[id], h5[id], h6[id]")
        .forEach((headline) => {
            headline.innerHTML = `<a href="#${headline.id}" class="anchor"><i class="fas fa-hashtag"></i></a> ${headline.innerHTML}`;
        });

    ackeeTracker
        .create({
            server: "https://ackee.poerschke.nrw/",
            domainId: "23cbb93b-ce0b-4f58-bca4-6caa0bc939ee",
        })
        .record();
});
