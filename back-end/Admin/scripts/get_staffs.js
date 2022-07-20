$(document).ready(function(){
    //
    getStaffs();
    //complete an order
    $(document).on("click", ".delete-staff", function() {
        let username = $(this).parent().parent().siblings(".staff-username").text();
        //
        deleteStaff(username);
    });
});
//functions
function getStaffs() {
    //api url
    let URL = "http://localhost/Web-Project/back-end/Admin/api/staff";
    $.ajax({
        url: URL, 
        accepts: "application/json",
        method: "GET", 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        if(data.staff_details !== "no-data"){
            let html = ``;
            $.each(data.staff_details, function(i, staffs){
                html += `
                <tr>
                    <td class="staff-username" >${staffs.username}</td>
                    <td>
                        ${staffs.first_name}
                    </td>
                    <td>
                        ${staffs.last_name}
                    </td>
                    <td>${staffs.email}</td>
                    <td>
                        ${staffs.phone_number}
                    </td>
                    <td>
                        <svg height="25" width="25">
                            <circle class="delete-staff" cx="12.5" cy="12.5" r="10" stroke="black" stroke-width="3" fill="red" />
                        </svg>
                    </td>
                </tr>
                `;
            });
            $("#staff-count").removeClass("bg-warning");
            $("#staff-count").html("");
            //add content to table
            $("table#staffs tbody").html(html);
        } else {
            $("table#staffs tbody").html("");
            //
            html = "No Staffs.";
            $("#staff-count").addClass("bg-warning fs-4 lead text-white").html(html);
        }
    });
};
//
function deleteStaff(username) {
    let URL = "http://localhost/Web-Project/back-end/Admin/api/staff";
    $.ajax({
        url: URL,
        data: {
            username: username
        },
        accepts: "application/json",
        method: "DELETE", 
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.message === "Delete successful"){
            html = "Delete completed";
            $("#message").addClass("bg-success fs-4 lead text-white").html(html);
            getStaffs();
        } else {
            html = "Unexpected error<br />Staff could not be deleted.";
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
}
