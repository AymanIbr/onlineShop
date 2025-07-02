<x-backend.dashboard title="Edit Product">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Edit Product</h1>

        <a class="btn btn-primary" href="{{ route('admin.products.index') }}"><i class="fas fa-long-arrow-alt-left"></i>
            All Products</a>
    </div>


    <div class="card">
        <div class="card-body">
            <form id="update-form">
                @csrf
                <div class="mb-3">
                    @include('dashboard.products._form')
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>



    @push('js')
        <script>
            $('#update-form').submit(function(event) {
                event.preventDefault();

                let formData = new FormData(this);
                formData.append('_method', 'put');

                const imageInput = document.querySelector('input[name="image"]');
                if (imageInput && imageInput.files.length > 0) {
                    formData.append('image', imageInput.files[0]);
                }


                const galleryInput = document.querySelector('input[name="gallery[]"]');
                if (galleryInput && galleryInput.files.length > 0) {
                    if (!formData.has('gallery[]')) {
                        for (let i = 0; i < galleryInput.files.length; i++) {
                            formData.append('gallery[]', galleryInput.files[i]);
                        }
                    }
                }


                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.products.update', $product->id) }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Product updated successfully');
                        window.location.href = "{{ route('admin.products.index') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback.d-block').text('');

                            for (let field in errors) {
                                let errorField = $(`#${field}`);
                                let errorMsg = errors[field][0];

                                if (errorField.length) {
                                    errorField.addClass('is-invalid');
                                    $(`#${field}_error`).text(errorMsg);
                                } else {
                                    toastr.error(errorMsg);
                                }
                            }
                        } else {
                            toastr.error("Something went wrong. Please try again.");
                            console.log(xhr.responseText);
                        }
                    }
                });
            });

            $("#category_id").change(function() {
                let categoryId = $(this).val();

                $.ajax({
                    url: `/get-subcategories/${categoryId}`,
                    method: 'GET',
                    success: function(response) {
                        const subSelect = $('#sub_category_id');
                        subSelect.empty();
                        subSelect.append('<option value=""> Select SubCategory </option>');

                        response.forEach(sub => {
                            subSelect.append(`<option value="${sub.id}">${sub.name}</option>`);
                        });
                    },
                    error: function(xhr) {
                        console.log("Something Went Wrong");
                    }
                });
            });
        </script>
    @endpush
</x-backend.dashboard>
