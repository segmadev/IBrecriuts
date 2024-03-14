document.addEventListener('turbo:load', loadServicesData);

function loadServicesData() {

    let defaultDocumentImageUrl = $('#defaultDocumentImageUrl').val();
    if (!$('#addServicesDescriptionQuillData').length &&
        !$('#editServicesDescriptionQuillData').length) {
        return;
    }
    window.addServicesDescriptionQuill = new Quill(
        '#addServicesDescriptionQuillData', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['clean'],
                ],
                keyboard: {
                    bindings: {
                        tab: 'disabled',
                    }
                }
            },
            placeholder: Lang.get('messages.employer_menu.enter_description'),
            theme: 'snow',
            });

    window.editServicesDescriptionQuill = new Quill(
        '#editServicesDescriptionQuillData', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['clean'],
                ],
                keyboard: {
                    bindings: {
                        tab: 'disabled',
                    }
                    }
                },
                placeholder: Lang.get('messages.employer_menu.enter_description'),
                theme: 'snow',
            });

    listenClick('.services-edit-btn', function (event) {
        // if (ajaxCallIsRunning) {
//            return;
//        }
        ajaxCallInProgress();
        let servicesId = $(event.currentTarget).attr('data-id');
        renderServicesData(servicesId);
    });

    function renderServicesData (servicesId) {
        $.ajax({
            url: route('services.edit', servicesId),
            type: 'GET',
            success: function (result) {
                if (result.success) {
                    let element = document.createElement('textarea');
                    element.innerHTML = result.data.name;
                    $('#servicesId').val(result.data.id);
                    $('#editCustomerName').val(element.value);
                    if (isEmpty(result.data.services_image_url)) {
                        $('#editPreviewImage').css('background-image',
                            'url("' + defaultDocumentImageUrl + '")');
                    } else {
                        $('#editPreviewImage').css('background-image',
                            'url("' + result.data.services_image_url + '")');
                    }
                    element.innerHTML = result.data.description;
                    editServicesDescriptionQuill.root.innerHTML = element.value;
                    $('#editServicesModal').appendTo('body').modal('show');
                    ajaxCallCompleted();
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    };

    // $(document).on('click', '.delete-btn', function (event) {
    //     let servicesId = $(event.currentTarget).attr('data-id');
    //     swal({
    //             title: Lang.get('messages.common.delete') + ' !',
    //             text: Lang.get('messages.common.are_you_sure_want_to_delete') + '"' + Lang.get('messages.services.services') + '" ?',
    //             type: 'warning',
    //             showCancelButton: true,
    //             closeOnConfirm: false,
    //             showLoaderOnConfirm: true,
    //             confirmButtonColor: '#6777ef',
    //             cancelButtonColor: '#d33',
    //             cancelButtonText: Lang.get('messages.common.no'),
    //             confirmButtonText: Lang.get('messages.common.yes'),
    //         },
    //         function () {
    //             window.livewire.emit('deleteServices', servicesId);
    //         });
    // });
    //
    // document.addEventListener('delete', function () {
    //     swal({
    //         title: Lang.get('messages.common.deleted') + ' !',
    //         text: Lang.get('messages.services.services') + Lang.get('messages.common.has_been_deleted'),
    //         type: 'success',
    //         confirmButtonColor: '#6777ef',
    //         timer: 2000,
    //     });
    // });

    listenHiddenBsModal('#addServicessModal', function () {
        resetModalForm('#addServicesForm', '#validationErrorsBox');
        addServicesDescriptionQuill.setContents([{ insert: '' }]);
        // $('#previewImage').attr('src', defaultDocumentImageUrl);
        $('#previewImage').
            css('background-image', 'url("' + defaultDocumentImageUrl + '")');

    });
    
    listenChange('#customerImage', function () {
        if (isValidFile($(this), '#validationErrorsBox')) {
            displayPhoto(this, '#previewImage');
        }
    });

    listenChange('#editCustomerImage', function () {
        if (isValidFile($(this), '#editValidationErrorsBox')) {
            displayPhoto(this, '#editPreviewImage');
        }
    });
}

listenClick('.services-show-btn', function (event) {
    // if (ajaxCallIsRunning) {
//            return;
//        }
    ajaxCallInProgress();
    let showServicesId = $(event.currentTarget).attr('data-id');
    $.ajax({
        url: route('services.show', showServicesId),
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#showCustomerName').html('');
                $('#showServicesDescription').html('');
                $('#documentUrl').html('');

                $('#showCustomerName').append(result.data.name);
                if (isEmpty(result.data.services_image_url)) {
                    $('#documentUrl').hide();
                    $('#noDocument').show();
                } else {
                    $('#noDocument').hide();
                    $('#documentUrl').show();
                    $('#documentUrl').
                        attr('src', result.data.services_image_url);
                }
                let element = document.createElement('textarea');
                element.innerHTML = (!isEmpty(result.data.description))
                    ? result.data.description
                    : 'N/A';
                $('#showServicesDescription').append(element.value);
                $('#showServicesModal').appendTo('body').modal('show');
                ajaxCallCompleted();
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenClick('.addServicesModal', function () {
    $('#addServicesModal').appendTo('body').modal('show');
});

listenClick('.services-delete-btn', function (event) {
    var deleteServicesId = $(event.currentTarget).attr('data-id');
    deleteItem(route('services.destroy', deleteServicesId), Lang.get('messages.services'));
});
listenHiddenBsModal('#editServicesModal', function () {
    resetModalForm('#editServicesForm', '#editValidationErrorsBox');
    // $('#editForm')[0].reset();
});
// let source = $('#actionTemplate')[0].innerHTML;
// window.actionTemplate = Handlebars.compile(source);
listenSubmit('#addServicesForm', function (e) {
    e.preventDefault();
    let addServicesEditorContent = addServicesDescriptionQuill.root.innerHTML;

    if (addServicesDescriptionQuill.getText().trim().length === 0) {
        displayErrorMessage(Lang.get('messages.flash.description_required'));
        return false;
    }
    let input = JSON.stringify(addServicesEditorContent);
    $('#services_desc').val(input.replace(/"/g, ""));

    processingBtn('#addServicesForm', '#servicesSaveBtn', 'loading');
    // if ($('#customerName').val().length > 50) {
    //     displayErrorMessage('Customer Name may not be greater than 50 character.');
    //     setTimeout(function () {
    //         processingBtn('#addServicesForm', '#servicesSaveBtn');
    //     }, 1000)
    //     return false;
    // }
    $.ajax({
        url: route('services.store'),
        type: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#addServicessModal').modal('hide');
                livewire.emit('refreshDatatable');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#addServicesForm', '#servicesSaveBtn');
            $('#addServicesModal').modal('toggle');
        },
    });
});

listenSubmit('#editServicesForm', function (event) {
    event.preventDefault();
    let editServicesEditorContent = editServicesDescriptionQuill.root.innerHTML;

    if (editServicesDescriptionQuill.getText().trim().length === 0) {
        displayErrorMessage(Lang.get('messages.flash.description_required'));
        return false;
    }
    let input = JSON.stringify(editServicesEditorContent);
    $('#services_edit_desc').val(input.replace(/"/g, ""));
    processingBtn('#editServicesForm', '#servicesEditBtn', 'loading');
    if ($('#editCustomerName').val().length > 50) {
        displayErrorMessage(
            'Customer Name may not be greater than 50 character.');
        setTimeout(function () {
            processingBtn('#editServicesForm', '#servicesEditBtn');
        }, 1000)
        return false;
    }
    const updateServicesId = $('#servicesId').val();
    $.ajax({
        url: route('services.update', updateServicesId),
        type: 'POST',
        data: new FormData($(this)[0]),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#editServicesModal').modal('hide');
                livewire.emit('refreshDatatable');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            processingBtn('#editServicesForm', '#servicesEditBtn');
        },
    });
});
