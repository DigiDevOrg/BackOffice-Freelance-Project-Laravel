@extends('layouts/contentNavbarLayout')

@section('title', 'Service settings - Service')

@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Service Settings /</span> Settings
    </h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                        Service</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('pages/account-settings-notifications') }}"><i
                            class="bx bx-bell me-1"></i> Notifications</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('pages/account-settings-connections') }}"><i
                            class="bx bx-link-alt me-1"></i> Connections</a></li>
            </ul>

            <div class="card mb-4">
                <form id="formEditService" method="POST" action="{{ route('update.service', ['id' => $service->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('storage/public/assets/img/service/' . $service->image) }}" alt="user-avatar"
                                class="d-block rounded" height="100" width="100" id="uploadedAvatar" />

                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="image" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input class="form-control" type="text" id="title" name="title"
                                    value="{{ $service->title }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ $service->description }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input class="form-control" type="text" id="price" name="price"
                                    value="{{ $service->price }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="delivery_time" class="form-label">Delivery Time</label>
                                <input class="form-control" type="text" id="delivery_time" name="delivery_time"
                                    value="{{ $service->delivery_time }}" />
                            </div>
                            <div class="mb-3 col-md-6">

                                <label for="category" class="form-label">Category</label>
                                <select class="select2 form-select" id="category" name="category">
                                    <option value="">Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="attachment">Attachments</label>
                                <input type="file" class="form-control" name="attachments[]" id="attachment" multiple>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="attachment-list" class="form-label">Attachment</label>

                                <select class="select2 form-select" id="attachment-list" name="attachments[]">7
                                    <option value="">Select an Attachment</option>
                                    @foreach ($service->attachments as $attachment)
                                        <option value="{{ $attachment->filename }}">
                                            {{ $attachment->filename }}

                                        </option>
                                    @endforeach
                                </select>
                                <div id="action-buttons" class="attachment-actions">

                                    <a id="download-button" style="display: none"
                                        href="{{ asset('storage/public/files/' . $attachment->filename) }}"
                                        download>Download</a>
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <a id="delete-button" style="display: none">Delete</a>
                                </div>

                            </div>


                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <a href="{{ route('edit-service', ['id' => $service->id]) }}"
                                class="btn btn-outline-secondary">Cancel</a>
                        </div>

                    </div>
                    <!-- /Account -->
                </form>
            </div>
            <div class="card">
                <h5 class="card-header">Delete Service</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your Service?</h6>
                            <p class="mb-0">Once you delete your Service, there is no going back. Please be certain.</p>
                        </div>
                    </div>
                    <form action="{{ route('service.destroy', $service->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                id="accountActivation" />
                            <label class="form-check-label" for="accountActivation">I confirm my Service
                                deactivation</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">Delete Service</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        const select = document.getElementById('attachment-list');
        const downloadButton = document.getElementById('download-button');

        select.addEventListener('change', () => {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption) {
                // Get the value (attachment filename) from the selected option
                const value = selectedOption.value;

                // Construct the full URL to the file
                const fileUrl = "{{ asset('storage/public/files/') }}" + '/' + value;

                // Set the href attribute of the download button
                downloadButton.setAttribute('href', fileUrl);

                // Display the download button
                downloadButton.style.display = 'inline';
            } else {
                // Hide the download button when no option is selected
                downloadButton.style.display = 'none';
            }
        });

        const deleteButton = document.getElementById('delete-button');
        select.addEventListener('change', () => {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption) {
                console.log(selectedOption.value);
                deleteButton.style.display = 'inline';
                const value = selectedOption.value;
                deleteButton.addEventListener('click', () => {
                    // Assuming 'value' contains the filename to be deleted
                    const value = selectedOption.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');
                    console.log(csrfToken);
                    fetch(`/deleteAttachment/${value}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
                            },
                        })
                        .then(response => {
                            if (response.status === 200) {

                                console.log('Attachment deleted successfully');
                            } else {
                                console.log(response)
                                console.error('Error deleting attachment');
                            }
                        })
                        .catch(error => {
                            console.error('An error occurred:', error);
                        });
                });

            } else {
                // Hide the download button when no option is selected
                downloadButton.style.display = 'none';
            }
        });
    </script>


@endsection
