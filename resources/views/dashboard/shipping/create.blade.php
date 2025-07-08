<x-backend.dashboard title="Create Shipping">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new Shipping</h1>
        <a class="btn btn-primary" href="{{ route('admin.shipping.index') }}"><i class="fas fa-long-arrow-alt-left"></i>
            All Shippings</a>

    </div>


    <div class="card">
        <div class="card-body">
            <form id="create-form">
                @csrf
                <div class="mb-3">
                    @include('dashboard.shipping._form')
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
                formData.append('country', $('#country').val());
                formData.append('amount', $('#amount').val());

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.shipping.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message || 'Shipping created successfully');
                        $('#create-form')[0].reset();

                        $('#country').removeClass('is-invalid');
                        $('#country_error').text('');

                        $('#amount').removeClass('is-invalid');
                        $('#amount_error').text('');
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
