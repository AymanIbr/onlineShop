<x-backend.dashboard title="Create Category">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new Category</h1>
        <a class="btn btn-primary" href="{{ route('admin.categories.index') }}"><i class="fas fa-long-arrow-alt-left"></i>
            All Categories</a>

    </div>


    <div class="card">
        <div class="card-body">
            <form id="create-form">
                @csrf
                <div class="mb-3">
                    @include('dashboard.categories._form')
                </div>
                {{-- <button type="button"  onclick="store()" class="btn btn-success"><i class="fas fa-save"></i> --}}
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                    Save</button>
            </form>
        </div>
    </div>



    @push('js')
        {{-- <script>
            function store() {
                let formData = new FormData();
                formData.append('name', document.getElementById('name').value);
                formData.append('active', document.getElementById('active').checked ? 1 : 0);
                formData.append('image', document.getElementById('image').files[0]);
                // formData.append('_token', '{{ csrf_token() }}');
                axios.post('{{ route('admin.categories.store') }}', formData)
                    .then(function(response) {
                        // handle success
                        toastr.success(response.data.message);
                        document.getElementById('create-form').reset();
                        document.querySelector('.prev-img').src = "{{ asset('backend/img/prev.jpg') }}";

                    })
                    .catch(function(error) {
                        if (error.response && error.response.status === 422) {
                            toastr.error(error.response.data.message);
                        } else {
                            toastr.error("Something went wrong. Please try again.");
                        }
                    });
            }
        </script> --}}

        <script>
            $('#create-form').submit(function(event) {
                event.preventDefault();

                let formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('active', $('#active').is(':checked') ? 1 : 0);
                formData.append('image', $('#image')[0].files[0]);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.categories.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Category created successfully');
                        $('#create-form')[0].reset();
                        $('.prev-img').attr('src', "{{ asset('backend/img/prev.jpg') }}");
                        $('#name').removeClass('is-invalid');
                        $('#name_error').text('');
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

                            // if (errors.active) {
                            //     $('#active').addClass('is-invalid');
                            //     $('#status_error').text(errors.active[0]);
                            // } else {
                            //     $('#active').removeClass('is-invalid');
                            //     $('#status_error').text('');
                            // }

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

            // // drop zone
            // $(document).ready(function() {
            //     Dropzone.autoDiscover = false;

            //     new Dropzone("#category-dropzone", {
            //         url: "",
            //         paramName: "file",
            //         maxFiles: 1,
            //         acceptedFiles: "image/*",
            //         headers: {
            //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //         },
            //         success: function(file, response) {
            //             $('#image_path').val(response.path);
            //             toastr.success("Image uploaded successfully");
            //         },
            //         error: function(file, response) {
            //             console.error(response);
            //         }
            //     });
            // });
        </script>
    @endpush

</x-backend.dashboard>
