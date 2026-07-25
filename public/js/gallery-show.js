/*
|--------------------------------------------------------------------------
| Download Counter
|--------------------------------------------------------------------------
*/

document.addEventListener("click",function(e){

    if(!e.target.closest(".download-photo")){

        return;

    }

    let btn=e.target.closest(".download-photo");

    fetch(

        "/gallery/photo/"+

        btn.dataset.id+

        "/download",

        {

            method:"POST",

            headers:{

                "X-CSRF-TOKEN":

                document

                .querySelector(

                    'meta[name="csrf-token"]'

                )

                .content

            }

        }

    )

    .then(r=>r.json())

    .then(data=>{

        document.getElementById(

            "downloads"+btn.dataset.id

        ).innerHTML=data.downloads;

    });

});

/*
|--------------------------------------------------------------------------
| Share
|--------------------------------------------------------------------------
*/

document.addEventListener("click",function(e){

    if(!e.target.closest(".share-photo")){

        return;

    }

    let url=

    e.target.closest(".share-photo")

    .dataset.url;

    if(navigator.share){

        navigator.share({

            url:url

        });

    }

    else{

        navigator.clipboard.writeText(url);

        alert(

            "Image URL copied."

        );

    }

});