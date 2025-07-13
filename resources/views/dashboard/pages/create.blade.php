<x-backend.dashboard title="Create Page">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Add New Page</h1>
        <a class="btn btn-primary" href="{{ route('admin.pages.index') }}">
            <i class="fas fa-long-arrow-alt-left"></i> All Pages
        </a>
    </div>

    <!-- Card Form -->
    <div class="card">
        <div class="card-body">
            <form id="create-form">
                @csrf

                <div class="mb-3">
                    @include('dashboard.pages._form')
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            $('#create-form').submit(function(event) {
                event.preventDefault();
                tinymce.triggerSave();

               let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.pages.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Page created successfully');
                        $('#create-form')[0].reset();
                        $('#name').removeClass('is-invalid');
                        $('#name_error').text('');
                        $('#content').removeClass('is-invalid');
                        $('#content_error').text('');
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

                            if (errors.content) {
                                $('#content').addClass('is-invalid');
                                $('#content_error').text(errors.content[0]);
                            } else {
                                $('#content').removeClass('is-invalid');
                                $('#content_error').text('');
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
