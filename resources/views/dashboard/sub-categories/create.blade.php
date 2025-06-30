<x-backend.dashboard title="Create subCategory">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new subCategory</h1>
        <a class="btn btn-primary" href="{{ route('admin.sub-categories.index') }}"><i
                class="fas fa-long-arrow-alt-left"></i>
            All Sub Categories</a>

    </div>


    <div class="card">
        <div class="card-body">
            <form id="create-form" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    @include('dashboard.sub-categories._form')
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                    Save</button>
            </form>
        </div>
    </div>



    @push('js')
        <script>
            $('#create-form').submit(function(event) {
                event.preventDefault();

                let formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('active', $('#active').is(':checked') ? 1 : 0);
                formData.append('image', $('#image')[0].files[0]);
                formData.append('category_id', $('#category_id').val());

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.sub-categories.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Sub Category created successfully');
                        $('#create-form')[0].reset();
                        $('.prev-img').attr('src', "{{ asset('backend/img/prev.jpg') }}");
                        $('#name').removeClass('is-invalid');
                        $('#name_error').text('');

                        $('#category_id').removeClass('is-invalid');
                        $('#category_id_error').text('');

                        $('#image_error').text('');
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

                            if (errors.category_id) {
                                $('#category_id').addClass('is-invalid');
                                $('#category_id_error').text(errors.category_id[0]);
                            } else {
                                $('#category_id').removeClass('is-invalid');
                                $('#category_id_error').text('');
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
