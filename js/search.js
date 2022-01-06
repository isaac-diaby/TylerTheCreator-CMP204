$(document).ready(function () {
    // Hide/Show the results section on init
    let results = $("#searchResults");
    $("#searchBtn").click(function (e) {
        e.preventDefault();
        // get input var
        let searchTerm = cleanInput($("#searchInput").val());
        // get the matching songs from the DB as populated templates from the php server
        $.get("api/search.php", `s=${searchTerm}`)
            .done((data) => {
                if (data) {
                    results.find(".spotlight").empty();
                    results.find(".spotlight").append(`${data}`)
                    results.show();
                } else {
                    results.hide();
                    showStatusToast("No Result", "error")
                }
            })
            .fail((err) => {
                showStatusToast(err.responseText, "error")
            })
    });
})
/**
 * Check the Database if you already liked a if not it will add your like else it will delete it
 * @param {int} songID 
 */
function toggleLike(el, songID) {
    $.post("api/toggleLike.php", `id=${songID}`)
        .done((data) => {
            // Use Jquery to manipulate DOM, so it looks like its live reloaded
            let likeCounterEl = $(el).parent().parent().find("ul li:nth-child(2) strong")
            let likeCounter = parseInt(likeCounterEl.text());
            let likedSongsEl = $("#songsLiked > .spotlight");

            // The whole song card Ref
            let wholeSongCardEl = $(el).parent().parent().parent()

            if (data.includes("Liked")) {
                // Change DOM to reflect the like.
                $(el).find(".bi").removeClass("bi-heart")
                $(el).find(".bi").addClass("bi-heart-fill")

                likeCounterEl.text(likeCounter + 1) // incr the likes

                // Add song to  "liked" Section
                if (likedSongsEl.find(`#${wholeSongCardEl.attr('id')}`).length == 0) {
                    wholeSongCardEl.clone().appendTo(likedSongsEl)
                }

            }
            else if (data.includes("Unliked")) {
                // Change DOM to reflect the unlike.
                $(el).find(".bi").removeClass("bi-heart-fill")
                $(el).find(".bi").addClass("bi-heart")

                likeCounterEl.text(likeCounter - 1) // decr the likes
                // remove song to  "liked" Section
                likedSongsEl.find(`#${wholeSongCardEl.attr('id')}`).remove()
            }
            showStatusToast(data, "success")
        })
        .fail((err) => {
            showStatusToast(err.responseText, "error")
        })
}