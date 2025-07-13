<x-front.layout title="My Profile">
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('profile') }}">My Account</a>
                        </li>
                        <li class="breadcrumb-item">Settings</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-11">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-3">
                        @include('front.parts.sidebar')
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                            </div>
                            <div class="card-body p-4">

                                <form method="POST" action="{{ route('profile.update') }}" id="update-profile-form">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $user->name) }}" placeholder="Enter Your Name"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email) }}" placeholder="Enter Your Email"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone"
                                            value="{{ old('phone', $user->phone) }}" placeholder="Enter Your Phone"
                                            class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" cols="30" rows="5" placeholder="Enter Your Address"
                                            class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-dark">Update</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#update-profile-form').on('submit', function(e) {
                    e.preventDefault();

                    let form = $(this);
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('profile.update') }}",
                        method: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function() {
                            form.find('.is-invalid').removeClass('is-invalid');
                            form.find('.invalid-feedback').remove();
                        },
                        success: function(response) {
                            toastr.success(response.message || 'Profile updated successfully');
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                $.each(errors, function(field, messages) {
                                    let input = form.find('[name="' + field + '"]');
                                    input.addClass('is-invalid');
                                    input.after('<span class="invalid-feedback d-block">' +
                                        messages[0] + '</span>');
                                });
                            } else {
                                toastr.error('Something went wrong. Please try again.');
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</x-front.layout>
