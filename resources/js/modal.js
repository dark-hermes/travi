$('.delete-confirm').on('click', function(){
    var form = $(this).parent();
    Swal.fire({
        customClass: {
            container: 'my-swal'
        },
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
});
