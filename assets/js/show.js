$(".submit-class").click(e=>{
    $id = e.target.id;
    if (e.target.checked) {
        $check = 1;
    } else if (!e.target.checked) {
        $check = 0;
    }
    $.ajax({
        type : "post",
        url : "done_update.php",
        data : {
            check : $check,
            id : $id
        },
    })
})

$(".delete-btn").click(e=>{
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
            $id = e.target.id.substr(6);
            $.ajax({
                type : "POST",
                url : "./destory.php",
                data : {
                    id :$id 
                }
            })
            Swal.fire({
                title: 'Deleted!',
                text: 'Your task has been deleted.',
                showConfirmButton: false,
              })
            console.log($id);
            window.location.replace("./index.php");
        } else {
            console.log("cancled");
        }
    })
})