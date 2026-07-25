/*
|--------------------------------------------------------------------------
| Gallery Viewer
| Part 6B-1B-1
|--------------------------------------------------------------------------
| Features
| - Zoom In
| - Zoom Out
| - Mouse Wheel Zoom
| - Reset Zoom
| - Keyboard Shortcuts
| - Smooth CSS Transform
|--------------------------------------------------------------------------
*/

const image = document.getElementById("viewerImage");

const imageWrapper = document.getElementById("imageWrapper");

const zoomInBtn = document.getElementById("zoomIn");

const zoomOutBtn = document.getElementById("zoomOut");

const zoomResetBtn = document.getElementById("zoomReset");

/*
|--------------------------------------------------------------------------
| Viewer State
|--------------------------------------------------------------------------
*/

let scale = 1;

let minScale = 1;

let maxScale = 5;

let translateX = 0;

let translateY = 0;

/*
|--------------------------------------------------------------------------
| Apply Transform
|--------------------------------------------------------------------------
*/

function updateTransform()
{
    clampTranslation();

    image.style.transform =
        `translate(${translateX}px, ${translateY}px) scale(${scale})`;

    zoomResetBtn.innerHTML =
        Math.round(scale * 100) + "%";
}

/*
|--------------------------------------------------------------------------
| Reset Position
|--------------------------------------------------------------------------
*/

function resetPosition()
{
    translateX = 0;

    translateY = 0;

    updateTransform();
}

/*
|--------------------------------------------------------------------------
| Reset Zoom
|--------------------------------------------------------------------------
*/

function resetZoom()
{
    scale = 1;

    resetPosition();
}

/*
|--------------------------------------------------------------------------
| Zoom In
|--------------------------------------------------------------------------
*/

function zoomIn(step = 0.20)
{
    if(scale >= maxScale)
    {
        return;
    }

    scale += step;

    if(scale > maxScale)
    {
        scale = maxScale;
    }

    updateTransform();
}

/*
|--------------------------------------------------------------------------
| Zoom Out
|--------------------------------------------------------------------------
*/

function zoomOut(step = 0.20)
{
    if(scale <= minScale)
    {
        return;
    }

    scale -= step;

    if(scale < minScale)
    {
        scale = minScale;
    }

    if(scale === 1)
    {
        translateX = 0;

        translateY = 0;
    }

    updateTransform();
}

/*
|--------------------------------------------------------------------------
| Toolbar
|--------------------------------------------------------------------------
*/

zoomInBtn.addEventListener("click", function(){

    zoomIn();

});

zoomOutBtn.addEventListener("click", function(){

    zoomOut();

});

zoomResetBtn.addEventListener("click", function(){

    resetZoom();

});

/*
|--------------------------------------------------------------------------
| Mouse Wheel Zoom
|--------------------------------------------------------------------------
*/

imageWrapper.addEventListener("wheel", function(e){

    e.preventDefault();

    if(e.deltaY < 0)
    {
        zoomIn(0.10);
    }
    else
    {
        zoomOut(0.10);
    }

});

/*
|--------------------------------------------------------------------------
| Double Click
|--------------------------------------------------------------------------
*/

imageWrapper.addEventListener("dblclick", function(){

    if(scale === 1)
    {
        scale = 2;
    }
    else
    {
        scale = 1;

        translateX = 0;

        translateY = 0;
    }

    updateTransform();

});

/*
|--------------------------------------------------------------------------
| Keyboard
|--------------------------------------------------------------------------
*/

document.addEventListener("keydown", function(e){

    switch(e.key)
    {
        case "+":
        case "=":

            zoomIn();

        break;

        case "-":

            zoomOut();

        break;

        case "0":

            resetZoom();

        break;

        case "ArrowLeft":

            let prev = document.querySelector(".nav-left");

            if(prev)
            {
                window.location = prev.href;
            }

        break;

        case "ArrowRight":

            let next = document.querySelector(".nav-right");

            if(next)
            {
                window.location = next.href;
            }

        break;

        case "Escape":

            history.back();

        break;
    }

});

/*
|--------------------------------------------------------------------------
| Prevent Image Drag
|--------------------------------------------------------------------------
*/

image.addEventListener("dragstart", function(e){

    e.preventDefault();

});

/*
|--------------------------------------------------------------------------
| Initial Render
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Drag / Pan Support
|--------------------------------------------------------------------------
*/

let isDragging = false;

let startX = 0;

let startY = 0;

let initialTranslateX = 0;

let initialTranslateY = 0;

/*
|--------------------------------------------------------------------------
| Clamp Panning
|--------------------------------------------------------------------------
*/

function clampTranslation()
{
    if(scale <= 1)
    {
        translateX = 0;
        translateY = 0;
        return;
    }

    const rect = imageWrapper.getBoundingClientRect();

    const maxX = ((rect.width * scale) - rect.width) / 2;

    const maxY = ((rect.height * scale) - rect.height) / 2;

    translateX = Math.max(
        -maxX,
        Math.min(maxX, translateX)
    );

    translateY = Math.max(
        -maxY,
        Math.min(maxY, translateY)
    );
}

/*
|--------------------------------------------------------------------------
| Mouse Down
|--------------------------------------------------------------------------
*/

imageWrapper.addEventListener("mousedown", function(e){

    if(scale <= 1)
    {
        return;
    }

    isDragging = true;

    imageWrapper.classList.add("dragging");

    startX = e.clientX;

    startY = e.clientY;

    initialTranslateX = translateX;

    initialTranslateY = translateY;

});

/*
|--------------------------------------------------------------------------
| Mouse Move
|--------------------------------------------------------------------------
*/

window.addEventListener("mousemove", function(e){

    if(!isDragging)
    {
        return;
    }

    translateX =
        initialTranslateX +
        (e.clientX - startX);

    translateY =
        initialTranslateY +
        (e.clientY - startY);

    clampTranslation();

    updateTransform();

});

/*
|--------------------------------------------------------------------------
| Mouse Up
|--------------------------------------------------------------------------
*/

window.addEventListener("mouseup", function(){

    isDragging = false;

    imageWrapper.classList.remove("dragging");

});

/*
|--------------------------------------------------------------------------
| Mouse Leave
|--------------------------------------------------------------------------
*/

window.addEventListener("mouseleave", function(){

    isDragging = false;

    imageWrapper.classList.remove("dragging");

});

/*
|--------------------------------------------------------------------------
| Cursor
|--------------------------------------------------------------------------
*/

imageWrapper.addEventListener("mouseenter", function(){

    if(scale > 1)
    {
        imageWrapper.style.cursor = "grab";
    }

});

imageWrapper.addEventListener("mouseleave", function(){

    imageWrapper.style.cursor = "default";

});

/*
|--------------------------------------------------------------------------
| Keep Cursor Updated
|--------------------------------------------------------------------------
*/

const originalZoomIn = zoomIn;

zoomIn = function(step = 0.20){

    originalZoomIn(step);

    if(scale > 1)
    {
        imageWrapper.style.cursor = "grab";
    }

};

const originalZoomOut = zoomOut;

zoomOut = function(step = 0.20){

    originalZoomOut(step);

    if(scale <= 1)
    {
        imageWrapper.style.cursor = "default";
    }

};

const originalResetZoom = resetZoom;

resetZoom = function(){

    originalResetZoom();

    imageWrapper.style.cursor = "default";

};

updateTransform();

/*
|--------------------------------------------------------------------------
| PART 6C-1B-3A
|--------------------------------------------------------------------------
| Download Modal
|--------------------------------------------------------------------------
*/

let downloadModal =
    new bootstrap.Modal(
        document.getElementById("downloadModal")
    );

const downloadButton =
    document.getElementById("downloadButton");

const downloadOptions =
    document.getElementById("downloadOptions");

/*
|--------------------------------------------------------------------------
| Open Download Modal
|--------------------------------------------------------------------------
*/

downloadButton.addEventListener(

    "click",

    function(){

        downloadOptions.innerHTML =

        `
        <div class="text-center p-5">

            <div class="spinner-border text-primary">

            </div>

            <div class="mt-3">

                Loading download options...

            </div>

        </div>
        `;

        downloadModal.show();

        loadDownloadOptions();

    }

);

/*
|--------------------------------------------------------------------------
| Load Download Sizes
|--------------------------------------------------------------------------
*/

async function loadDownloadOptions()
{

    try{

        const response = await fetch(

            downloadOptionsUrl

        );

        const data = await response.json();

        renderDownloadOptions(data);

    }

    catch(error){

        downloadOptions.innerHTML =

        `
        <div class="alert alert-danger">

            Unable to load download options.

        </div>
        `;

    }

}
/*
|--------------------------------------------------------------------------
| Render Download Options
|--------------------------------------------------------------------------
*/

function renderDownloadOptions(data)
{

    let html = "";

    html += createDownloadCard(

        "Original",

        "Full Resolution",

        data.original

    );

    html += createDownloadCard(

        "Large",

        "Large Image",

        data.large

    );

    html += createDownloadCard(

        "Medium",

        "Medium Image",

        data.medium

    );

    html += createDownloadCard(

        "Small",

        "Small Image",

        data.small

    );

    html += createDownloadCard(

        "Thumbnail",

        "Preview",

        data.thumbnail

    );

    downloadOptions.innerHTML = html;

}
/*
|--------------------------------------------------------------------------
| Download Card
|--------------------------------------------------------------------------
*/

function createDownloadCard(
    title,
    description,
    url
)
{
    return `

    <div

        class="download-card"

        data-url="${url}">

        <div>

            <div class="download-title">

                <i class="fa fa-image text-primary"></i>

                ${title}

            </div>

            <div class="download-meta">

                ${description}

            </div>

        </div>

        <button

            class="btn btn-primary">

            <i class="fa fa-download"></i>

            Download

        </button>

    </div>

    `;
}
/*
|--------------------------------------------------------------------------
| Click Download Card
|--------------------------------------------------------------------------
*/

document.addEventListener(

    "click",

    function(e){

        const card =

        e.target.closest(

            ".download-card"

        );

        if(!card){

            return;

        }

        startDownload(

            card.dataset.url

        );

    }

);
/*
|--------------------------------------------------------------------------
| Start Download
|--------------------------------------------------------------------------
*/

let downloadInProgress = false;

function startDownload(url)
{
    if(downloadInProgress)
    {
        return;
    }

    downloadInProgress = true;

    /*
    |--------------------------------------------------------------------------
    | Disable Buttons
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".download-card button")
        .forEach(function(button){

            button.disabled = true;

            button.innerHTML =

                '<span class="spinner-border spinner-border-sm"></span> Downloading...';

        });

    /*
    |--------------------------------------------------------------------------
    | Close Modal
    |--------------------------------------------------------------------------
    */

    downloadModal.hide();

    /*
    |--------------------------------------------------------------------------
    | Update Counter
    |--------------------------------------------------------------------------
    */


function incrementDownloadCounter()
{
    let counter = document.getElementById(
        "downloadCount"
    );

    if(!counter)
    {
        return;
    }

    let value = parseInt(counter.innerHTML);

    if(isNaN(value))
    {
        value = 0;
    }

    counter.innerHTML = value + 1;
}
/*
|--------------------------------------------------------------------------
| Reset Download Buttons
|--------------------------------------------------------------------------
*/

function resetDownloadButtons()
{
    document.querySelectorAll(".download-card button")

        .forEach(function(button){

            button.disabled = false;

            button.innerHTML =

                '<i class="fa fa-download"></i> Download';

        });

}

}