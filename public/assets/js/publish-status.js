function updatePublishStatus(selector, routePrefix) {
    $(document).on("change", selector, function () {
        const value = parseInt($(this).val(), 10);
        const slug = $(this).data("slug");

        if (!routePrefix || !slug) {
            console.error("Route prefix or slug is missing.");
            return;
        }

        $.ajax({
            method: "PUT",
            url: `${routePrefix}/${slug}`,
            data: {
                is_published: value,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                Swal.fire(
                    "Updated!",
                    "Status updated successfully.",
                    "success"
                );
            },
            error: function () {
                Swal.fire(
                    "Error!",
                    "Something went wrong. Please try again.",
                    "error"
                );
            },
        });
    });
}
