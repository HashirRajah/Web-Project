//after dom is loaded
$(document).ready(function(){
    //get flagged comments every 5 seconds
    getFlaggedComments();
    setInterval(getFlaggedComments, 10000);
    //handle ban comment
    $(document).on("click", ".ban", function() {
        let o_id = $(this).parent().parent().siblings().children(".order-id").val();
        let f_id = $(this).parent().parent().siblings().children(".food-id").val();
        let usrname = $(this).parent().parent().siblings(".username").text();
        //comment info
        let comment = {
            order_id: o_id,
            food_id: f_id,
            username: usrname,
        };
        banComment(comment);
    });
    //handle accept comment
    $(document).on("click", ".accept", function() {
        let o_id = $(this).parent().parent().siblings().children(".order-id").val();
        let f_id = $(this).parent().parent().siblings().children(".food-id").val();
        let usrname = $(this).parent().parent().siblings(".username").text();
        //comment info
        let comment = {
            order_id: o_id,
            food_id: f_id,
            username: usrname,
        };
        acceptComment(comment);
    });

});

//api url
const URL = "http://localhost/Web-Project/back-end/Admin/api/review";
//functions
function getFlaggedComments() {
    $.ajax({
        url: URL, 
        accepts: "application/json",
        method: "GET",
        cache: false, 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        if(data.data !== "no-data"){
            let html = ``;
            $.each(data.data, function(i, flaggedReview){
                html += `
                <tr>
                    <td class="username" >${flaggedReview.username}</td>
                    <td>${flaggedReview.comment}</td>
                    <td>
                        <svg height="25" width="25">
                            <circle class="accept" cx="12.5" cy="12.5" r="10" stroke="black" stroke-width="3" fill="GreenYellow" />
                        </svg>
                    </td>
                    <td>
                        <svg height="25" width="25">
                            <circle class="ban" cx="12.5" cy="12.5" r="10" stroke="black" stroke-width="3" fill="Tomato" />
                        </svg>
                    </td>
                    <td style="display: none"><input class="order-id" type="hidden" name="order-id" value="${flaggedReview.order_id}" /></td>
                    <td style="display: none"><input class="food-id" type="hidden" name="food-id" value="${flaggedReview.food_id}" /></td>
                </tr>
                `;
            });
            //
            $("#number-of-flagged-reviews").html("");
            $("#number-of-flagged-reviews").removeClass("bg-warning")
            //add content to table
            $("table#flagged-reviews tbody").html(html);
        } else {
            $("table#flagged-reviews tbody").html("");
            //
            html = "No flagged reviews.";
            $("#number-of-flagged-reviews").addClass("bg-warning fs-4 lead text-white").html(html);
        }
    });
};

//ban comment
function banComment(comment) {
    $.ajax({
        url: URL,
        data: {
            order_id: comment.order_id,
            food_id: comment.food_id,
            username: comment.username,
            operation: "ban"
        },
        accepts: "application/json",
        method: "PUT",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.message === "comment-banned"){
            html = "Comment Banned";
            $("#message").addClass("bg-success fs-4 lead text-white").html(html);
            getFlaggedComments();
        } else {
            html = "Unexpected error<br />Comment could not be banned.";
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};
//accept comment
function acceptComment(comment) {
    $.ajax({
        url: URL,
        data: {
            order_id: comment.order_id,
            food_id: comment.food_id,
            username: comment.username,
            operation: "accept"
        },
        accepts: "application/json",
        method: "PUT",
        cache: false, 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.message === "comment-accepted"){
            html = "Comment Accepted";
            $("#message").addClass("bg-success fs-4 lead text-white").html(html);
            getFlaggedComments();
        } else {
            html = "Unexpected error<br />Comment could not be accepted.";
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};


