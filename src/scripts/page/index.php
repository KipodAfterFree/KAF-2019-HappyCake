<?php

$name = null;

if (count($_GET) > 0)
    $name = key($_GET);

?>
    <!DOCTYPE html>
    <!--
     Copyright (c) 2019 Nadav Tasher
     https://github.com/NadavTasher/BaseTemplate/
    -->
    <html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="description" content="<?php
        if ($name !== null)
            echo "Info about " . htmlspecialchars($name);
        else
            echo "Missing parameter";
        ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes, minimal-ui"/>
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#dae4ed"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="apple-mobile-web-app-title" content="Happy Cake!"/>
        <title><?php
            if ($name !== null)
                echo "@" . htmlspecialchars($name);
            else
                echo "U dun goofed";
            ?></title>
        <noscript></noscript>
        <style>
            /**
     * Copyright (c) 2019 Nadav Tasher
     * https://github.com/NadavTasher/BaseTemplate/
     **/

            html {
                /* Overflow */
                overflow-x: hidden;
                /* Flex */
                display: flex;
                flex-direction: column;
                /* Alignment */
                justify-content: center;
                justify-items: center;
                align-content: center;
                align-items: center;
                /* Positioning */
                position: fixed;
                /* Sides */
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                /* Sizing */
                height: 100%;
                width: 100%;
            }

            body {
                /* Sizing */
                width: 100%;
                /* Background */
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                background-attachment: fixed;
                background-repeat: no-repeat;
            }

            textarea {
                text-align: left !important;
                text-align-last: left !important;
            }

            [text = ""], [text = true], a, p, [input = ""], [input = true], button, input, select, textarea, [row = ""], [row = true], [column = ""], [column = true], div, body {
                /* WebKit */
                -webkit-appearance: none;
                /* Display */
                display: flex;
                flex-direction: column;
                /* Text */
                color: black;
                font-size: large;
                font-family: Arial, ArialHebrew, sans-serif;
                /* Text Alignment */
                text-align: center;
                text-align-last: center;
                /* Minimal Sizing */
                min-height: fit-content;
            }

            [text = ""], [text = true], a, p {
                flex-flow: wrap;
                height: auto;
            }

            [text = ""], [text = true], a, p, [input = ""], [input = true], button, input, select, textarea {
                /* Positioning */
                margin: 1vh;
                padding: 1vh;
                /* Alignment */
                justify-content: center;
                justify-items: center;
                align-content: center;
                align-items: stretch;
                /* Shaping */
                border-radius: 1vh;
                border-color: transparent;
            }

            [input = ""], [input = true], button, input, select, textarea {
                transition-duration: 0.2s;
                background-color: #ddddee;
            }

            [input = ""]:hover, [input = true]:hover, button:hover, input:hover, select:hover, textarea:hover {
                background-color: #9999aa;
            }

            [row = ""], [row = true], [column = ""], [column = true], div, body {
                /* Alignment */
                justify-content: center;
                align-content: center;
                /* Positioning */
                margin: 0;
                padding: 0;
            }

            [column = ""], [column = true] {
                /* Flex */
                flex-direction: column;
                /* Alignment */
                align-items: stretch;
            }

            [row = ""], [row = true] {
                /* Flex */
                flex-direction: row;
                /* Alignment */
                align-items: center;
            }
        </style>
        <script>
            /**
             * Copyright (c) 2019 Nadav Tasher
             * https://github.com/NadavTasher/BaseTemplate/
             **/

            /* API */

            /**
             * This function is responsible for API calls between the frontend and the backend.
             * @param endpoint The backend PHP file to be reached
             * @param api The API which this call associates with
             * @param action The action to be executed
             * @param parameters The parameters for the action
             * @param callback The callback for the API call, contains success, result and error
             * @param APIs The API parameters for the API call (for API layering)
             */
            function api(endpoint = null, api = null, action = null, parameters = null, callback = null, APIs = {}) {
                let form = new FormData();
                form.append("api", JSON.stringify(hook(api, action, parameters, APIs)));
                fetch(endpoint, {
                    method: "post",
                    body: form
                }).then(response => {
                    response.text().then((result) => {
                        if (callback !== null && api !== null && action !== null) {
                            let json = JSON.parse(result);
                            if (api in json) {
                                if ("success" in json[api] && "result" in json[api]) {
                                    callback(json[api]["success"] === true, json[api]["result"]);
                                } else {
                                    callback(false, null, "API parameters not found");
                                }
                            } else {
                                callback(false, null, "API not found");
                            }
                        }
                    });
                });
            }

            /**
             * This function compiles the API call hook.
             * @param api The API to associate
             * @param action The action to be executed
             * @param parameters The parameters for the action
             * @param APIs The API parameters for the API call (for API layering)
             * @returns {FormData} API call hook
             */
            function hook(api = null, action = null, parameters = null, APIs = {}) {
                if (!(api in APIs)) {
                    if (api !== null && action !== null && parameters !== null) {
                        APIs[api] = {
                            action: action,
                            parameters: parameters
                        };
                    }
                }
                return APIs;
            }

            /**
             * This function pops up installation instructions for Safari users.
             * @param title App's Name
             */
            function instruct(title = null) {
                let agent = window.navigator.userAgent.toLowerCase();
                let devices = ["iphone", "ipad", "ipod"];
                let safari = false;
                for (let i = 0; i < devices.length; i++) {
                    if (agent.includes(devices[i])) safari = true;
                }
                if ((safari && !("standalone" in window.navigator && window.navigator.standalone))) {
                    let div = make("div");
                    let text = make("p");
                    let share = make("img");
                    let then = make("p");
                    let add = make("img");
                    row(div);
                    text.innerText = "To add " + ((title === null) ? ("\"" + document.title + "\"") : title) + ", ";
                    share.src = "resources/svg/icons/safari/share.svg";
                    then.innerText = "then";
                    add.src = "resources/svg/icons/safari/add.svg";
                    text.style.fontStyle = "italic";
                    then.style.fontStyle = "italic";
                    text.style.maxHeight = "5vh";
                    share.style.maxHeight = "4vh";
                    then.style.maxHeight = "5vh";
                    add.style.maxHeight = "4vh";
                    div.appendChild(text);
                    div.appendChild(share);
                    div.appendChild(then);
                    div.appendChild(add);
                    popup(div, 0, "#ffffffee");
                }
            }

            /**
             * This function prepares the web page (loads ServiceWorker, HTML).
             * @param callback Function to be executed when loading finishes
             */
            function prepare(callback = null) {
                // Register worker
                if ("serviceWorker" in navigator)
                    navigator.serviceWorker.register("worker.js").then();
                // Load layouts
                fetch("layouts/template.html", {
                    method: "get"
                }).then(response => {
                    response.text().then((template) => {
                        fetch("layouts/app.html", {
                            method: "get"
                        }).then(response => {
                            response.text().then((app) => {
                                document.body.innerHTML = template.replace("<!--App Body-->", app);
                                if (callback !== null)
                                    callback()
                            });
                        });
                    });
                });
            }

            /* Visuals */

            /**
             * This function removes all children of given view.
             * @param v View
             */
            function clear(v) {
                let view = get(v);
                while (view.firstChild) {
                    view.removeChild(view.firstChild);
                }
            }

            /**
             * This function checks if a view exists.
             * @param v View
             * @returns {boolean} View exists
             */
            function exists(v) {
                return get(v) !== undefined;
            }

            /**
             * This function returns the view by its ID or by it's own value.
             * @param v View
             * @returns {HTMLElement} View
             */
            function get(v) {
                return isString(v) ? document.getElementById(v) : v;
            }

            /**
             * This function hides the given view.
             * @param v View
             */
            function hide(v) {
                get(v).style.display = "none";
            }

            /**
             * This function creates a new view by its type, contents and classes.
             * @param type View type
             * @param content View contents
             * @param classes View classes
             * @returns {HTMLElement} View
             */
            function make(type, content = null, classes = []) {
                let made = document.createElement(type);
                if (content !== null) {
                    if (!isString(content)) {
                        if (isArray(content)) {
                            for (let i = 0; i < content.length; i++) {
                                made.appendChild(content[i]);
                            }
                        } else {
                            made.appendChild(content);
                        }
                    } else {
                        made.innerText = content;
                    }
                }
                for (let c = 0; c < classes.length; c++)
                    made.classList.add(classes[c]);
                return made;
            }

            /**
             * This function recursively sets the viewed view to be the given view.
             * @param target View
             */
            function page(target) {
                let temporary = get(target);
                while (temporary.parentNode !== document.body && temporary.parentNode !== document.body) {
                    view(temporary);
                    temporary = temporary.parentNode;
                }
                view(temporary);
            }

            /**
             * This function shows the given view.
             * @param v View
             */
            function show(v) {
                get(v).style.removeProperty("display");
            }

            /**
             * This function shows the given view while hiding it's brothers.
             * @param v View
             */
            function view(v) {
                let element = get(v);
                let parent = element.parentNode;
                for (let n = 0; n < parent.children.length; n++) {
                    hide(parent.children[n]);
                }
                show(element);
            }

            /**
             * This function returns the visibillity state of the given view.
             * @param v View
             * @returns {boolean} Visible
             */
            function visible(v) {
                return (get(v).style.getPropertyValue("display") !== "none");
            }

            /* Animations */

            const LEFT = false;
            const RIGHT = !LEFT;
            const IN = true;
            const OUT = !IN;

            /**
             * This function animates the given view's property, while jumping from stop to stop every length amount of time.
             * @param v View
             * @param property View's style property to animate
             * @param stops Value stops
             * @param length Length of each animation stop
             * @param callback Function to run after animation is finished
             */
            function animate(v, property = "left", stops = ["0px", "0px"], length = 1, callback = null) {
                let view = get(v);
                let interval = null;
                let next = () => {
                    view.style[property] = stops[0];
                    stops.splice(0, 1);
                };
                let loop = () => {
                    if (stops.length > 0) {
                        next();
                    } else {
                        clearInterval(interval);
                        view.style.removeProperty("transitionDuration");
                        view.style.removeProperty("transitionTimingFunction");
                        if (callback !== null) callback();
                    }
                };
                next();
                interval = setInterval(loop, length * 1000);
                setTimeout(() => {
                    view.style.transitionDuration = length + "s";
                    view.style.transitionTimingFunction = "ease";
                    loop();
                }, 0);
            }

            /**
             * This function slides the given view in or out of frame with given direction.
             * @param v View
             * @param motion Type of motion (In / Out)
             * @param direction Direction of motion (Left / Right)
             * @param length Length of animation
             * @param callback Function to run after animation is finished
             */
            function slide(v, motion = IN, direction = RIGHT, length = 0.2, callback = null) {
                let view = get(v);
                let style = getComputedStyle(view);
                let edge = (direction === RIGHT ? 1 : -1) * screen.width;
                let current = isNaN(parseInt(style.left)) ? 0 : parseInt(style.left);
                let origin = current === 0 && motion === IN ? edge : current;
                let destination = motion === IN ? 0 : edge;
                if (getComputedStyle(view).position === "static" ||
                    getComputedStyle(view).position === "sticky")
                    view.style.position = "relative";
                animate(view, "left", [origin + "px", destination + "px"], length, callback);
            }

            /* Attributes */

            /**
             * This function makes the given view a column.
             * @param v View
             */
            function column(v) {
                get(v).setAttribute("column", true);
                get(v).setAttribute("row", false);
            }

            /**
             * This function makes the given view an input.
             * @param v View
             */
            function input(v) {
                get(v).setAttribute("input", true);
            }

            /**
             * This function makes the given view a row.
             * @param v View
             */
            function row(v) {
                get(v).setAttribute("row", true);
                get(v).setAttribute("column", false);
            }

            /**
             * This function makes the given view a text.
             * @param v View
             */
            function text(v) {
                get(v).setAttribute("text", true);
            }

            /* Interface */

            /**
             * This function sets the functions to be called when the user is performing gestures.
             * @param up Function to run after an Up gesture
             * @param down Function to run after a Down gesture
             * @param left Function to run after a Left gesture
             * @param right Function to run after a Right gesture
             * @param upgoing Function to run while an Up gesture is gestured
             * @param downgoing Function to run while a Down gesture is gestured
             * @param leftgoing Function to run while a Left gesture is gestured
             * @param rightgoing Function to run while a Rigjt gesture is gestured
             */
            function gestures(up = null, down = null, left = null, right = null, upgoing = null, downgoing = null, leftgoing = null, rightgoing = null) {
                let touchX, touchY, deltaX, deltaY;
                document.ontouchstart = (event) => {
                    touchX = event.touches[0].clientX;
                    touchY = event.touches[0].clientY;
                };
                document.ontouchmove = (event) => {
                    deltaX = touchX - event.touches[0].clientX;
                    deltaY = touchY - event.touches[0].clientY;
                    if (Math.abs(deltaX) > Math.abs(deltaY)) {
                        if (deltaX > 0) {
                            if (leftgoing !== null) leftgoing();
                        } else {
                            if (rightgoing !== null) rightgoing();
                        }
                    } else {
                        if (deltaY > 0) {
                            if (upgoing !== null) upgoing();
                        } else {
                            if (downgoing !== null) downgoing();
                        }
                    }

                };
                document.ontouchend = () => {
                    if (Math.abs(deltaX) > Math.abs(deltaY)) {
                        if (deltaX > 0) {
                            if (left !== null) left();
                        } else {
                            if (right !== null) right();
                        }
                    } else {
                        if (deltaY > 0) {
                            if (up !== null) up();
                        } else {
                            if (down !== null) down();
                        }
                    }
                    touchX = null;
                    touchY = null;
                };
            }

            /**
             * This function pops up a popup at the bottom of the screen.
             * @param contents The content to be displayed (View / Text)
             * @param timeout The time before the popup dismisses (0 - Forever, null - Default)
             * @param color The background color of the popup
             * @param onclick The click action for the popup (null - Dismiss)
             * @returns {function} Dismiss callback
             */
            function popup(contents, timeout = null, color = null, onclick = null) {
                let div = make("div");
                column(div);
                input(div);
                let dismiss = () => {
                    if (div.parentElement !== null) {
                        div.onclick = null;
                        animate(div, "opacity", ["1", "0"], 0.5, () => {
                            div.parentElement.removeChild(div);
                        });
                    }
                };
                div.onclick = (onclick !== null) ? onclick : dismiss;
                div.style.position = "fixed";
                div.style.bottom = "0";
                div.style.left = "0";
                div.style.right = "0";
                div.style.margin = "1vh";
                div.style.padding = "1vh";
                div.style.height = "6vh";
                if (color !== null)
                    div.style.backgroundColor = color;
                if (isString(contents)) {
                    div.appendChild(make("p", contents));
                } else {
                    div.appendChild(contents);
                }
                animate(div, "opacity", ["0", "1"], 0.5, () => {
                    if (timeout > 0 || timeout === null) {
                        setTimeout(() => {
                            dismiss();
                        }, (timeout === null ? 2 : timeout) * 1000);
                    }
                });
                document.body.appendChild(div);
                return dismiss;
            }

            /* Utils */

            /**
             * This function returns whether the given parameter is an array.
             * @param a Parameter
             * @returns {boolean} Is an array
             */
            function isArray(a) {
                return a instanceof Array;
            }

            /**
             * This function returns whether the given parameter is an object.
             * @param o Parameter
             * @returns {boolean} Is an object
             */
            function isObject(o) {
                return o instanceof Object && !isArray(o);
            }

            /**
             * This function returns whether the given parameter is a string.
             * @param s Parameter
             * @returns {boolean} Is a string
             */
            function isString(s) {
                return (typeof "" === typeof s || typeof '' === typeof s);
            }

            /**
             * This function lets the user pick a file, then calls callback with the result.
             * @param callback Function to run after file pick
             * @param read Whether to read the file
             */
            function upload(callback = null, read = false) {
                let selector = make("input");
                selector.type = "file";
                selector.style.display = "none";
                document.body.appendChild(selector);
                selector.oninput = () => {
                    selector.parentElement.removeChild(selector);
                    if (selector.files.length > 0) {
                        let file = selector.files[0];
                        if (callback !== null) {
                            if (read) {
                                let reader = new FileReader();
                                reader.onload = (result) => {
                                    callback(file, result.target.result);
                                };
                                reader.readAsText(file);
                            } else {
                                callback(file, null);
                            }
                        }


                    }
                };
                selector.click();
            }

            /**
             * This function downloads a file.
             * @param file File's name
             * @param data File's contents
             * @param type File's mime-type
             * @param encoding File's encoding
             */
            function download(file, data, type = "text/plain", encoding = "utf8") {
                let link = document.createElement("a");
                link.download = file;
                link.href = "data:" + type + ";" + encoding + "," + data;
                link.click();
            }
        </script>
        <script>

        </script>
    </head>
    <body column>
    <p style="font-size: 6vh">Developer pages</p>
    <?php

    $result = lookup($name, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "info/database.json")));

    if ($result[0]) {
        echo "<p>" . htmlspecialchars($name) . "'s developer page</p>";
        echo "<p>" . htmlspecialchars($result[1]) . "</p>";
    } else {
        echo "<p>The developer pages for \"" . htmlspecialchars($name) . "\" were not found.</p>";
    }

    function lookup($name, $database)
    {
        $temp = $database;
        for ($i = 0; $i < strlen($name); $i++) {
            $search = $name[$i];
            if (isset($temp->$search)) {
                $temp = $temp->$search;
            } else {
                return [false, null, $i];
            }
        }
        if (isset($temp->{"@"}))
            return [true, $temp->{"@"}, $i];
        return [false, null, $i];
    }

    ?>
    <a href="../../">Back home</a>
    </body>
    </html>
<?php
if ($result[0] === false) {
    echo "<!-- failed after " . $result[2] . " rounds-->";
} else {
    echo "<!-- OK -->";
}
?>