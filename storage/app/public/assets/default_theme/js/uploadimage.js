    $(document).on('change', '.img_upload', function(objEvent) {
        var objFormData = new FormData();
        // GET FILE OBJECT
        var objFile = $(this)[0].files[0];
        var csrf = $('meta[name="csrf-token"]').attr('content');
        objFormData.append('_token', csrf)
        objFormData.append('imgfile', objFile);
        var img_number = $(this).attr('data-number')
        const imageContainer = $("#result_img"+img_number);
        imageContainer.html('<div class="d-inline-flex align-items-center text-start text-primary"><div class="spinner-border ms-auto me-2" role="status" aria-hidden="true"></div><strong>Mengunggah...</strong></div>')
        $.ajax({
            url: "<?= url('/api/storeimage'); ?>",
            type: 'POST',
            contentType: false,
            data: objFormData,
            //JQUERY CONVERT THE FILES ARRAYS INTO STRINGS.SO processData:false
            processData: false,
            success: function (response) {
                var url = response.data.file_url;
                imageContainer.html("<div class='mt-2'>Gambar : <a target='_blank' href="+url+"><span>Lihat Gambar</span></a> | <a href='javascript:void(0)' class='text-danger btn-delimg' data-number="+img_number+"><span>Hapus</span></a></div>")
                $('#img_url'+img_number).val(response.data.file_name)
            },
            error: function (error) {
                alert(error.responseJSON.message)
                imageContainer.empty()
            }
        }); 
    });

    $(document).on('click', '.btn-delimg', function() {
        var img_number = $(this).attr('data-number')
        $("#result_img"+img_number).empty()
        $('#img_url'+img_number).val(null)
    });