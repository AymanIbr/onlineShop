<x-backend.dashboard title="Edit Shipping">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Edit Shipping</h1>

        <a class="btn btn-primary" href="{{ route('admin.shipping.index') }}"><i class="fas fa-long-arrow-alt-left"></i>
            All Shipping</a>
    </div>


    <div class="card">
        <div class="card-body">
            <form id="update-form">
                @csrf
                <div class="mb-3">
                    @include('dashboard.shipping._form')
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>



    @push('js')
        <script>
            $('#update-form').submit(function(event) {
                event.preventDefault();

                let formData = new FormData();
                formData.append('_method', 'put');
                formData.append('country', $('#country').val());
                formData.append('amount', $('#amount').val());

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.shipping.update', $shipping->id) }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Shipping updated successfully');
                        window.location.href = "{{ route('admin.shipping.index') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.country) {
                                $('#country').addClass('is-invalid');
                                $('#country_error').text(errors.country[0]);
                            } else {
                                $('#country').removeClass('is-invalid');
                                $('#country_error').text('');
                            }

                            if (errors.amount) {
                                $('#amount').addClass('is-invalid');
                                $('#amount_error').text(errors.amount[0]);
                            } else {
                                $('#amount').removeClass('is-invalid');
                                $('#amount_error').text('');
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
