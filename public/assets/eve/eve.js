function fill(Value, search = "search", display = "display", Current = "tag:") {
    let inputField = document.getElementById(search);
    let cursorPosition = getCursorPosition(inputField);
    deleteCharactersBeforePosition(inputField, cursorPosition, Current.length);

    $("#" + search).val($("#" + search).val() + Value);
    $("#" + display).hide();
    $("#" + search).focus();
}

function getCursorPosition(inputField) {
    if (inputField.selectionStart) {
        return inputField.selectionStart;
    } else if (document.selection) {
        inputField.focus();
        let range = document.selection.createRange();
        range.moveStart("character", -inputField.value.length);
        return range.text.length;
    }
    return 0;
}

function deleteCharactersBeforePosition(inputField, position, numberOfCharacters) {
    let currentValue = inputField.value;
    let newValue = currentValue.substring(0, position - numberOfCharacters) + currentValue.substring(position);
    inputField.value = newValue;
    inputField.setSelectionRange(position - numberOfCharacters, position - numberOfCharacters);
}

function checkImages() {
    const images = document.querySelectorAll(".img2check");
    let count = 0;

    images.forEach((img) => {
        img.onerror = () => {
            console.log("Error loading " + img.src);
            changeImageSrc(img, "assets/img/missing.png");
            removeClass(img, "h-full");
            removeClass(img, "w-auto");
            addClass(img, "w-full");
            addClass(img, "h-auto");
        };
        img.onload = () => {
            console.log(img.src + " loaded successfully");
        };
    });

    const safeOnly = getCookieValue("safeOnly");
    const filter = (safeOnly == 1) ? "both" : "none";
    const blacklist = stringToArray(getCookieValue("blacklist"));

    // Leaves space for an option for only one of these both two?
    images.forEach((img) => {
        let parent = img.parentNode;
        switch (filter) {
            case "questionable":
                if (
                    parent.tagName === "A" &&
                    parent.getAttribute("title").includes("rating:questionable")
                ) {
                    img.setAttribute("formerSrc", img.src);
                    img.src = "assets/img/hidden.png";
                    count++;
                }
                break;
            case "explicit":
                if (
                    parent.tagName === "A" &&
                    parent.getAttribute("title").includes("rating:explicit")
                ) {
                    img.setAttribute("formerSrc", img.src);
                    img.src = "assets/img/hidden.png";
                    count++;
                }
                break;
            case "both":
                if (
                    parent.tagName === "A" &&
                    (parent.getAttribute("title").includes("rating:explicit") ||
                        parent.getAttribute("title").includes("rating:questionable"))
                ) {
                    img.setAttribute("formerSrc", img.src);
                    img.src = "assets/img/hidden.png";
                    count++;
                }
                break;
            default:
                break;
        }
        if (stringContainsWord(parent.getAttribute("title"), blacklist) && img.getAttribute("src") !== "assets/img/hidden.png") {
            img.setAttribute("formerSrc", img.src);
            img.src = "assets/img/hidden.png";
            count++;
        }
    });

    modifyHiddenImages();

    if (count > 0) {
        let div = document.getElementById("image-replacement-message-div");
        removeClass(div, "hidden");
        let element = document.getElementById("image-replacement-message");
        element.style.display = "block";
        let posts = count === 1 ? "post" : "posts";
        element.textContent = "Show " + count + " " + posts + ".";
        element.setAttribute("main", "Show " + count + " " + posts + ".");
        element.setAttribute("alt", "Hide " + count + " " + posts + ".");
        element.onclick = showImages;
    }
}

function modifyHiddenImages() {
    const hiddenImages = document.querySelectorAll('img[src="assets/img/hidden.png"]');

    hiddenImages.forEach(img => {
        if (img.classList.contains("h-full") && img.classList.contains("w-auto")) {
            // img.setAttribute("altClass", img.classList.value);
            img.classList.remove("h-full", "w-auto");
            img.classList.add("w-full");
        }
    });
}

function showImages() {
    const images = document.querySelectorAll(".img2check");
    let element = document.getElementById("image-replacement-message");
    toggleText("image-replacement-message", element.getAttribute("main"), element.getAttribute("alt"));

    images.forEach((img) => {
        if (img.hasAttribute("formerSrc")) {
            const formerSrc = img.getAttribute("formerSrc");
            img.setAttribute("store", img.src);
            img.setAttribute("src", formerSrc);
            img.setAttribute("formerSrc", img.getAttribute("store"));
            img.removeAttribute("store");

            // if (img.hasAttribute("altClass")) {
            //     img.setAttribute("class", img.getAttribute("altClass"));
            // }
        }
    });
}

function decodeString(encodedString) {
    return decodeURIComponent(encodedString);
}

function toggleText(id, text1, text2) {
    const element = document.getElementById(id);
    const currentText = element.textContent;

    if (currentText === text1) {
        element.textContent = text2;
    } else {
        element.textContent = text1;
    }
}

function stringContainsWord(str, words) {
    if (!Array.isArray(words)) {
        words = [words];
    }

    for (let i = 0; i < words.length; i++) {
        const word = decodeString(words[i]);
        const regex = new RegExp(`\\b${word}\\b`, 'i');
        if (regex.test(str)) {
            return true;
        }
    }

    return false;
}

function changeImageSrc(imgElement, newSrc) {
    imgElement.src = newSrc;
}

function removeClass(element, className) {
    element.classList.remove(className);
}

function addClass(element, className) {
    element.classList.add(className);
}

function changeAttribute(elementID, attributeName, attributeValue) {
    let element = document.getElementById(elementID);
    element.setAttribute(attributeName, attributeValue);
}

function stringToArray(str) {
    return str.split(' ');
}

function toggleDiv(id) {
    const div = document.getElementById(id);
    const isHidden = div.classList.contains("hidden");

    div.classList.remove(isHidden ? "hidden" : "block");
    div.classList.add(isHidden ? "block" : "hidden");
}

function getCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    let cookieArr = document.cookie.split(";");

    // Loop through the array elements
    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");

        /* Removing whitespace at the beginning of the cookie name
           and compare it with the given string */
        if (name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }

    // Return null if cookie not found
    return null;
}

function getCookieValue(cookieName) {
    const cookieValue = document.cookie.match('(^|[^;]+)\\s*' + cookieName + '\\s*=\\s*([^;]+)');
    return cookieValue ? cookieValue.pop() : '';
}

/* Now perform all actions that should be performed */

checkImages();