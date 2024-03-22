

$(document).ready(function () {

    var l = localStorage.getItem('token');
    var id;
    var t="welcome"
    
    $("#btn-submit").click(
        function update(e) {
            e.preventDefault();
            
                
            $.ajax({
    
                type: "post",
                url: "./php/profile_update.php",
                dataType: "json",
                data: { "uId": id, "age": $("#age").val(), "username": $("#username").val(),"phonenumber": $("#phonenumber").val(),"dob": $("#dob").val()},
                success: function (response) {
    
                 
                    console.log(response)
                    if (response["status"] == 200) {
                        $("#welcome").val(t);
                        $("#username").val(response['users']['name']);
                        $("#age").val(response['users']['age']);
                        $("#phonenumber").val(response['users']['phonenumber']);
                        $("#dob").val(response['users']['dob']);
                        $("#1username").text(response['users']['name']);
                    }
                    else {
                        alert("Login again");
    
                    }
                }
            });
        }


        
    ); 
    if(l){
        $.ajax({
    
            type: "post",
            url: "./php/profile.php",
            dataType: "json",
            data: { "token": l, "age": $("#age").val(), "username": $("#username").val(),"phonenumber": $("#phonenumber").val(),"dob": $("#dob").val()},
            success: function (response) {
                console.log(response)

                if (response["status"] == 200) {
                        id=response['uId'];
                        console.log(id);
                        $("#welcome").val(t);
                        $("#username").val(response['users']['name']);
                        $("#age").val(response['users']['age']);
                        $("#phonenumber").val(response['users']['phonenumber']);
                        $("#dob").val(response['users']['dob']);
                        $("#1username").text(response['users']['name']);
                }
                else {
                    alert("Login again");

                }
            }
        });
    }
    
    $("#logout").click(function(){
        alert("Are u sure");
        if(l){
            localStorage.removeItem('token');
        }
        window.location.replace("./login.html");
    }); 
    


});