function load() {
    let elements = document.getElementsByTagName("a");
    for (let e = 0; e < elements.length; e++) {
        if (elements[e].innerText.startsWith("@")) {
            elements[e].setAttribute("tag", "");
            elements[e].setAttribute("content", "");
            elements[e].setAttribute("href", "scripts/page/?n=" + elements[e].innerText.substring(1));
        }
    }
}

