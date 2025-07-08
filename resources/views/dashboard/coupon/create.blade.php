<x-backend.dashboard title="Create Coupon">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new Coupon</h1>
        <a class="btn btn-primary" href="{{ route('admin.coupons.index') }}"><i class="fas fa-long-arrow-alt-left"></i>
            All Coupons</a>

    </div>


    <div class="card">
        <div class="card-body">
            <form id="create-form">
                @csrf
                {{-- <div class="mb-3"> --}}
                @include('dashboard.coupon._form')
                {{-- </div> --}}
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                    Save</button>
            </form>
        </div>
    </div>



    @push('js')
        <script>
            $('#create-form').submit(function(event) {
                event.preventDefault();
                // tinymce.triggerSave();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.coupons.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Coupon created successfully');
                        
                        $('#create-form')[0].reset();
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback.d-block').text('');
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
        </script>
    @endpush

</x-backend.dashboard>
