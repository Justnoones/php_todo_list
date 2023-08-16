$(document).ready(_=>{
    $.map($(".bg-danger"), function (val) {
        if (!val.nextElementSibling.classList.contains("bg-success")) {
            val.nextElementSibling.classList.add("bg-danger");
            val.nextElementSibling.classList.add("bg-opacity-50");
        }
    })
})

$(".form-check-input").click((e)=>{
    $id = e.target.id;
    if (e.target.checked) {
        $check = 1;
        if (e.target.parentElement.parentElement.parentElement.classList.contains("bg-danger")) {
            e.target.parentElement.parentElement.parentElement.classList.remove("bg-danger");
        }
        e.target.parentElement.parentElement.parentElement.classList.add("bg-success");
        e.target.parentElement.parentElement.parentElement.classList.add("bg-opacity-50");
    } else if (!e.target.checked) {
        $check = 0;
        e.target.parentElement.parentElement.parentElement.classList.remove("bg-success");
        e.target.parentElement.parentElement.parentElement.classList.remove("bg-opacity-50");
        if (e.target.parentElement.parentElement.parentElement.previousElementSibling.classList.contains("bg-danger")) {
            e.target.parentElement.parentElement.parentElement.classList.add("bg-danger");
            e.target.parentElement.parentElement.parentElement.classList.add("bg-opacity-50");
        }
    }
    $.ajax({
        type : "post",
        url : "done_update.php",
        data : {
            check : $check,
            id : $id
        },
    })
});

$(".change-check").mousedown(e=>{
    $target  = e.target.parentElement.parentElement.previousElementSibling.previousElementSibling.id;
    $text = e.target.innerHTML;
    $value = e.target.value;
    $expire_name = e.target.parentElement.firstElementChild.name;

    if ($text == "All" || $value == "all") {
        $("#"+$target).text("Status - All");
    } else if ($text == "Done" || $value == "done") {
        $("#"+$target).text("Status - Done");
    } else if ($text == "Not Done" || $value == "not_done") {
        $("#"+$target).text("Status - Not Done");
    } else if ($text == "Ascending Order ( Date )" || $value == "ascending_date") {
        $("#"+$target).text("Ascending Order By - Date");
    } else if ($text == "Descending Order ( Date )" || $value == "descending_date") {
        $("#"+$target).text("Descending Order By - Date");
    } else if ($text == "Ascending Order ( Title )" || $value == "ascending_title") {
        $("#"+$target).text("Ascending Order By - Title");
    } else if ($text == "Descending Order ( Title )" || $value == "descending_title") {
        $("#"+$target).text("Descending Order By - Title");
    } else if (($text == "All" || $value == "all") && $expire_name == "expired") {
        $("#"+$target).text("Deadline - All");
    } else if ($text == "Expired" || $value == "expired") {
        $("#"+$target).text("Deadline - Expired");
    } else if ($text == "Not Expired" || $value == "not_expired") {
        $("#"+$target).text("Deadline - Not Expired");
    } else if ($text == "Date Less" || $value == "date_less") {
        $("#"+$target).text("Deadline - Date Less");
    }
});

$(".child-4").click(e=>{
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

        if (result.isConfirmed) {
            $id = e.target.id;
            $.ajax({
                type : "POST",
                url : "./destory.php",
                data : {
                    id :$id 
                }
            })
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
          e.target.parentElement.parentElement.classList.add("d-none");
        } else {
            console.log("cancled");
        }
      })
})