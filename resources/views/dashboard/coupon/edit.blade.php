<x-backend.dashboard title="Edit Coupon">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Edit Coupon</h1>
        <a class="btn btn-primary" href="{{ route('admin.coupons.index') }}">
            <i class="fas fa-long-arrow-alt-left"></i> All Coupons
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="update-form">
                @csrf
                @method('PUT')
                {{-- <div class="mb-3"> --}}
                    @include('dashboard.coupon._form')
                {{-- </div> --}}
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            $('#update-form').submit(function(event) {
                event.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.coupons.update', $coupon->id) }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Coupon updated successfully');
                        window.location.href = "{{ route('admin.coupons.index') }}";
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
