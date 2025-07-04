<x-backend.dashboard title="Edit Category">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Edit Category</h1>

        <a class="btn btn-primary" href="{{ route('admin.categories.index') }}"><i class="fas fa-long-arrow-alt-left"></i>
            All Categories</a>
    </div>


    <div class="card">
        <div class="card-body">
            <form id="update-form">
                @csrf
                <div class="mb-3">
                    @include('dashboard.categories._form')
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
                {{-- <button onclick="update({{ $category->id }},'{{ $redirect ?? true }}')" type="button"
                    class="btn btn-success"><i class="fas fa-save"></i> Update</button> --}}
            </form>
        </div>
    </div>



    @push('js')
        <script>
            // function update(id, redirect) {
            //     let formData = new FormData();
            //     formData.append('_method', 'put');
            //     formData.append('name', document.getElementById('name').value);
            //     formData.append('active', document.getElementById('active').checked ? 1 : 0);
            //     // formData.append('_token', '{{ csrf_token() }}');
            //     if (document.getElementById('image').files[0] != undefined) {
            //         formData.append('image', document.getElementById('image').files[0]);
            //     }

            //     axios.post('{{ route('admin.categories.update', $category->id) }}', formData)
            //         .then(function(response) {
            //             // handle success
            //             toastr.success(response.data.message);
            //             if (redirect) {
            //                 window.location.href = "/admin/dashboard/categories";
            //             }

            //         })
            //         .catch(function(error) {
            //             if (error.response && error.response.status === 422) {
            //                 toastr.error(error.response.data.message);
            //             } else {
            //                 toastr.error("Something went wrong. Please try again.");
            //             }
            //         });
            // }


            $('#update-form').submit(function(event) {
                event.preventDefault();

                let formData = new FormData();
                formData.append('_method', 'put');
                formData.append('name', $('#name').val());
                formData.append('active', $('#active').is(':checked') ? 1 : 0);
                formData.append('show_home', $('#show_home').is(':checked') ? 1 : 0);
                if ($('#image')[0].files[0]) {
                    formData.append('image', $('#image')[0].files[0]);
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.categories.update', $category->id) }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Category updated successfully');
                        window.location.href = "{{ route('admin.categories.index') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#name').addClass('is-invalid');
                                $('#name_error').text(errors.name[0]);
                            } else {
                                $('#name').removeClass('is-invalid');
                                $('#name_error').text('');
                            }

                            if (errors.image) {
                                $('#image_error').text(errors.image[0]);
                            } else {
                                $('#image_error').text('');
                            }
                        } else {
                            toastr.error("Something went wrong. Please try again.");
                            console.log(xhr.responseText);
                        }
                    }
                });
            });
        </script>
    @endpush
</x-backend.dashboard>
