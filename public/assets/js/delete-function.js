function deleteAction(buttonClass, routePrefix) {
    $(document).on("click", buttonClass, function (e) {
        e.preventDefault();

        const slug = $(this).data("slug");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#FF0000",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/${routePrefix}/${slug}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        Swal.fire(
                            "Deleted!",
                            "The item has been deleted.",
                            "success"
                        );
                        $(`${buttonClass}[data-slug="${slug}"]`)
                            .closest("tr")
                            .fadeOut();
                    },
                    error: function () {
                        Swal.fire(
                            "Error!",
                            "Something went wrong. Please try again.",
                            "error"
                        );
                    },
                });
            }
        });
    });
}
