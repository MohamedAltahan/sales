$(document).ready(function(){




// // update_image is the id of the element
// $(document).on('click','#update_image',function(e){
//     e.preventDefault();
// //photo is the id of the new added code
// // The length property of an empty string is 0
//     if(!$("#photo").length){
//         //oldimage is the id of the container that contains image elements
//         $("#oldimage").html('<br> <input type="file" name="photo" id="photo">');
//         $("#update_image").hide();
//         $("#cancel_update_image").show();
//     }
// // in order to not do auto submit return false
//     return false;
// });

// $(document).on('click','#cancel_update_image',function(e){
//     e.preventDefault();

//         //oldimage is the id of the container that contains image elements
//         $("#oldimage").html('');
//         $("#update_image").show();
//         $("#cancel_update_image").hide();

// // in order to not do auto submit return false
//     return false;
// });

$(document).on('click','.are_you_sure',function(e){

    var res = confirm("هل انت متاكد ؟");
    if(res)
    {
        return true;
    }
    else{
        return false;
    }
});
});

